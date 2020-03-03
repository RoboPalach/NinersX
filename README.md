# NinersX - Web project
### Instalation

Prerequirements
- Mysql 8.0
- Symfony 5.0^
```shell
composer install
bin/console doctrine:table:create
bin/console doctrine migration:migrate
bin/console doctrine:fixtures:load
symfony server:run
```

