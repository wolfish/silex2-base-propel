<?php

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

class ManageUserCommand extends Command {

    public function configure()
    {
        $this->setName('manage:user')
            ->setDescription("
Use this to create/modify/delete users\n
  ./bin/console ACTION LOGIN\n
  Available ACTION's:\n
    - create (creates new user)
    - delete (deletes existing user)
    - enable (sets existing user as active - enable login)
    - disable (sets existing user as inactive - disable login)
    - passwd (resets password for existing user)\n\n
  Examples:\n
    ./bin/console manage:user create admin@example.com
    - creates new user with login admin@example.com
    (you will be prompted for password)\n\n
    ./bin/console manage:user passwd admin@example.com
    - resets password for login admin@example.com
    (you will be prompted for password)\n\n
                  "
            )
            ->addArgument('action', InputArgument::REQUIRED, 'create/passwd/delete/disable/enable')
            ->addArgument('username', InputArgument::REQUIRED, 'user email used as login');
    }

    private function checkUserExists(OutputInterface $output, $username, $failExists = true)
    {
        $exists = MyUserQuery::create()->findOneByEmail($username);

        if ($failExists && $exists instanceof MyUser) {
            $output->writeln('<error>User "' . $username . '" already exists!</error>');
            exit;
        }

        if (!$failExists && !$exists instanceof MyUser) {
            $output->writeln('<error>User "' . $username . '" does not exists!</error>');
            exit;
        }

        return $exists;
    }

    private function getPasswordFromUser(InputInterface $input, OutputInterface $output, $questionString)
    {
        $app = $this->getSilexApplication();
        $helper = $this->getHelper('question');

        $question = new Question($questionString);
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $question);

        $encoder = $app['security.default_encoder'];
        return $encoder->encodePassword($password, '');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        switch ($input->getArgument('action')) {

            case 'create':
                if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    $output->writeln('<error>Login have to be valid email address</error>');
                    exit;
                }

                $this->checkUserExists($output, $username);

                $password = $this->getPasswordFromUser(
                    $input,
                    $output,
                    'Please provide password for user: '
                );

                $user = new MyUser();
                $user->setEmail($username);
                $user->setPassword($password);
                $user->setRoles('ROLE_ADMIN');
                $user->save();

                $output->writeln('<info>User created</info>');
                break;

            case 'delete':
                $exists = $this->checkUserExists($output, $username, false);
                $exists->delete();
                $output->writeln('<info>User deleted</info>');
                break;

            case 'passwd':
                $exists = $this->checkUserExists($output, $username, false);

                $password = $this->getPasswordFromUser(
                    $input,
                    $output,
                    'Please provide new password: '
                );

                $exists->setPassword($password);
                $exists->save();

                $output->writeln('<info>Password reset</info>');
                break;

            case 'enable':
                $exists = $this->checkUserExists($output, $username, false);
                $exists->setIsActive(1);
                $exists->save();
                $output->writeln('<info>User activated</info>');
                break;

            case 'disable':
                $exists = $this->checkUserExists($output, $username, false);
                $exists->setIsActive(0);
                $exists->save();
                $output->writeln('<info>User deactivated</info>');
                break;

            default:
                $output->writeln('<question>Available actions are:</question>');
                $output->writeln('create : <comment>create new user</comment>');
                $output->writeln('delete : <comment>delete existing user</comment>');
                $output->writeln('passwd : <comment>reset password for user</comment>');
                $output->writeln('enable : <comment>enable user (allow login)</comment>');
                $output->writeln('disable : <comment>disable user (disallow login)</comment>');
                break;

        }

    }

}

