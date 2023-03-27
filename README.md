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

### - Парсинг внешних данных

`POST /api/parse?page=[страница]`

---

### Команда для запуска парсинга через терминал:
`./vendor/bin/sail php artisan app:parse-auctions {--page=1}`
