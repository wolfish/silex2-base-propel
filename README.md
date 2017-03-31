# Silex 2 - clean #

**This is port from Silex 1.3 - many elements still need re-implementation**

(**REQUIRES PHP >= 7.0**) 

Use this for any Silex 2 project, this package comes with:

- Propel 2 (use `./p` command)
- Twig
- Swiftmailer
- Security provider
- Translation provider

## How to start

1. Configure `propel.yml.dist` with your database credentials
2. Copy/rename it to `propel.yml`
3. Run `./p config:convert`
4. Create database model:

#### Option 1 - Build schema.xml
  - Edit `propel/Config/schema.xml` to your database model
  - Run `./p model:build` to generate classes in `propel` dir
  - Run `./p sql:build` to generate SQL in `generated-sql` dir
  - **Check if generated SQL is ok**
  - Run `./p sql:insert` to create tables in DB
  
#### Option 2 - Create schema from existing database
  - Run `./p database:reverse` to create XML file in `generated-reversed-database` dir
  - Check generated XML schema, add behaviors etc.
  - Move it to `propel/Config/schema.xml`
  - Run `./p model:build` to generate classes in `propel` dir
  
**Remove all `generated*` dirs after using, as they are not required**

4. Configure `config.rb` to your needs if you are using SASS
5. Edit `src/controller/Services.php`:
  - Add your twig extensions here (or do it later)
  - Change default language in `locale_fallback`
  - Add your xliff translation files if required (example Polish translation provided, create other similar to it)
  - Uncomment and change Query classes for user model for Security and User services (read comments in file)
  - ^ *above not required if you don't need user control* ^
6. Create structure of files in `src` dir as you require with this guideance:
  - Put controllers in `src/controller` and views in `src/view`
  - It's recommended to create directories for views like for `frontendController.php` it could be `src/view/frontend/myView.html.twig`
7. Add your controllers in `web/index.php`
