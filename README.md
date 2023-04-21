## Бекенд для dictionary

### Установка

Прописать в файле `.env` переменные окружения

    APP_PORT=
    DB_HOST=
    OXFORD_DICTIONARY_APP_KEY=
    OXFORD_DICTIONARY_APP_ID=

Запуск контейнеров

    ./dc up -d

Установить зависимости

    ./composer install

Запустить миграции

    ./php artisan migrate

Команда для заполнения базы данных из Oxford Dictionary API

    ./php artisan app:import-dictionar
