# Slim 3 Skeleton

This is a simple skeleton project fork from akrabat/slim3-skeleton that includes scaffold tool, migrations,auth,Twig, Flash messages, eloquent ORM and Monolog.

## Create your project:

    $ composer create-project -n -s dev mrcoco/slim3-eloquent-skeleton my-app

### Run it:

1. `$ cd my-app`
2. Change database setting `app\setting.php`
3. `$ vendor/davedevelopment/phpmig/bin/phpmig migrate`
4. `$ php -S 0.0.0.0:8888 -t public public/index.php`
5. Browse to http://localhost:8888

## Key directories

* `app`: Application code
* `app/src`: All class files within the `App` namespace
* `app/templates`: Twig template files
* `cache/twig`: Twig's Autocreated cache files
* `log`: Log files
* `public`: Webserver root
* `vendor`: Composer dependencies

## Key files

* `public/index.php`: Entry point to application
* `app/settings.php`: Configuration
* `app/dependencies.php`: Services for Pimple
* `app/middleware.php`: Application middleware
* `app/routes.php`: All application routes are here
* `app/src/Action/HomeAction.php`: Action class for the home page
* `app/templates/home.twig`: Twig template file for the home page

## CLI Tools
* Currently there are 3 supported commands:
* `php cli.php create:action MyActionClassName`
* `php cli.php create:middleware MyMiddlewareClassName`
* `php cli.php create:model MyModelClassName`
* `php cli.php create:scaffold MyModuleName`


## Migration
*  migrate all data
* php cli.php migrate

* Confirmation of status
* php cli.php status

* Creating // migration file
* php cli.php generate [MigrationName]

* //Execution of migration
* php cli.php migration

* // I one Back
* php cli.php rollback

* // Return all
* php cli.php rollback -t 0

* // Go back to the time of completion of the specified MigrationID
* php cli.php rollback -t [MigrationID]

* // Only specified MigrationID the migration / roll back
* php cli.php [up | down] [MigrationID]

### Demo User:

1. `admin` username: `admin@slim.dev` password: `password` 
2. `moderator` username: `moderator@slim.dev` password: `password` 
3. `user` username: `user@slim.dev` password: `password` 
