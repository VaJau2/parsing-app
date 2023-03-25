# Parsing App

Тестовый REST API проект для парсинга площадки лотов\торгов

## Установка

1. Запустить контейнеры `./vendor/bin/sail up`
2. Установить все миграции `./vendor/bin/sail php artisan migrate`


# API

### - Получение списка торгов

`GET /api/auctions/`

### - Получение торга

`GET /api/auctions/?number=[номер торга]`
