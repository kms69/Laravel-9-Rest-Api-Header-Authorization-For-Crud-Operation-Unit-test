### installation

##### First step

 `composer install` 

##### Second step
The Passport service provider registers its own database migration directory with the framework, so you should migrate your database after installing the package. The Passport migrations will create the tables your application needs to store clients and access tokens:

`php artisan migrate`

Next, you should run the passport:install command. This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens:

`php artisan passport:install`
### Test
Third step run the phpunit test command
`./vendor/bin/phpunit`