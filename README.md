Symfony test task
=====

## Установка

После загрузки кода настроить 

**Настроить parameters.yml** 

в файле  app/config/parameters.yml ввести данные подключаемой базы данных


**Загрузить Composer dependencies**

при наличии установленного composer  выполнить:
```
composer install
```
или при наличии composer.phar выполнить:
```
php composer.phar install
```

**Настройка базы данных**

выполнить:

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

если возникли проблемы при установке базы данных, 
необходимо ее удалить (`doctrine:database:drop --force`) 
и повторить операции выше.

**Запуск**

Можете воспользоваться встроенным сервером Symfony

```
php bin/console server:run
```
Тогда сайт будет доступен по адресу `http://localhost:8000`