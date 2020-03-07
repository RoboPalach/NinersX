# NinersX - Web project
### Instalation

Requirements
- Mysql 8.0
- Symfony 5.0^
- Edit .env file
```shell
composer install
bin/console doctrine:table:create
bin/console doctrine migration:migrate
bin/console doctrine:fixtures:load
symfony server:run
```
### Prepare for Deploy
Deploy process si easy but tricky. I spent a lot of time with it. It works with Symfony 5 and Wedos NoLimit hosting.

``` 
composer install
composer require symfony/dotenv
composer require symfony/apache-pack
```
Using flex
```export APP_ENV=prod```
Without flex
```export SYMFONY_ENV=prod```
Check if .env APP_ENV=prod, if not change it.

```
composer install --no-dev --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

#### Edit to meet Server rules
We are almost there. Now you need to create .htaccess file in project root eg. on the public, src etc. level with this content
```
RewriteEngine On
RewriteRule (.*) public/$1 [L]
```
Its because wedos looking for index in /www but symfony index is in /www/public. You can edit default symfony index to route requests to this url but it's not necessary because Symfony index handles the same thing as wedos do.

Next open .htaccess in /public and delete/comment 
```
<IfModule mod_negotiation.c>
    Options -MultiViews
</IfModule>
```
Lots of shared hosting banning this feature.

The last thing needs to do is edit /vendor/symfony/http-kernel/Kernel.php. You are looking for _putenv_ here. Delete or comment it. 

Dont forgot to change .env DB connection setting.

#### Upload
It's all. Now upload
```
bin
config
public
src
templates
translation
vendor
.env
composer.json
.htaccess
```
and create var directory on your ftp server. Some "class not found errors" or 500 can be caused by bad file transfer. Don't forget to check the size of the file, it shouldn't be 0.
### Subdomains
If you want to run any web app on a subdomain on wedos, you can. Wedos NoLimit granted 3 subdomains free. To create subdomains simply create a folder in /www/subdom/<Name of you subdomain> and deploy the project as you do with the main domain.
