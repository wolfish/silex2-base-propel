# Silex 2 - with Propel 2 #
(**REQUIRES PHP >= 7.0**) 

## What is this?
Use this for any Silex 2 project, this package comes with:

- Propel 2 (use `./p` command)
- Twig
- Swiftmailer
- Translation provider
- Security provider (configured users from database)
- Forms provider (with CSRF protection)
- Console provider (with some helpful tools)
- Some small examples

## What is it good for?
I'm using this as start-base for small to medium custom applications, to hold onto some
semantics between my projects and to not have to configure everything from scratch.

If you have experience with Symfony framework or Silex itself and you love Propel ORM
like me, then you probably will find it useful for building some webapps without all the
pain of configuring services, preparing stuff, etc.

## How to start?
1. Download latest release and unpack it in your project dir
2. Run `composer install` (if you don't have composer [go get it](https://getcomposer.org/download/))

### Configuring database (Propel)
1. Configure `propel.yml.dist` with your database credentials
2. Copy/rename it to `propel.yml`
3. Run `./p config:convert`

### Configuring schema (Propel)
##### Option 1 - Build your database from schema.xml
  1. Edit `propel/Config/schema.xml` to your database model
  2. Run `./p model:build` to generate classes in `propel` dir
  3. Run `./p sql:build` to generate SQL in `generated-sql` dir
  4. **Check if generated SQL is ok**
  5. **WARNING by default Propel is generating DROP on every table it's going to create, so if you have any existing tables CHECK THE GENERATED SQL!**
  6. Run `./p sql:insert` to create tables in DB
  
##### Option 2 - Create schema.xml from existing database
  1. Run `./p database:reverse` to create XML file in `generated-reversed-database` dir
  2. Check generated XML schema, add behaviors etc.
  3. Copy `my_user` table from existing example schema in `propel/Config/schema.xml` to your newly generated schema
  (if you don't have `my_user` table in your database add it by following steps of **Option 1**, or manually)
  4. Move it to `propel/Config/schema.xml`
  5. Run `./p model:build` to generate classes in `propel` dir
  
*Remove all `generated*` dirs after using Propel commands, as they are not required*


### Configuring services
1. Configure `config.rb` to your needs if you are using SASS
2. Add your Twig extensions in `src/library/Twig.php` (some extensions are already built-in)

3. Set your localisation settings in `src/library/Services.php`
  - Change default language in `locale_fallback`
  - Add your xliff translation files if required (example Polish translation provided, create other similar to it)
  - All language files are located in `src/translation/`

### Configuring users & security
1. By default whole path `/admin` is secured only for users with ROLE_ADMIN
2. You can set the firewall as you wish in `src/library/Services.php`
3. Security is configured to use `UserProvider` model that provides users from table `my_user` with use of Propel. 
If you want to use different user table or make other changes - edit it in `src/library/UserProvider.php`
4. You can create/modify new users with encoded passwords using command `manage:user` (run `./bin/console help manage:user` for more info)

**(this command works only with default `my_user` table!)**

### Start working
1. Create structure of files in `src` dir as you require with this guideance:
  - Put controllers in `src/controller` and views in `src/view/ControllerName/`
  - It's recommended to create directories for views like for `frontendController.php` it could be `src/view/Frontend/myView.html.twig`
2. Add your controllers in `web/index.php`
3. You can enable/disable debug mode in `web/index.php` (enabled as default)

