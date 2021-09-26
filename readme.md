## Первый запуск

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Создание новой сущности
```
php bin/console make:entity
php bin/console make:migration
```

## Запуск сервера для разработки

`symfony server:start`