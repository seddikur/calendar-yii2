## yii2 calendar

Календарь (разработка)


# Порядок установки проекта

* Запуск Docker `` docker compose up -d ``
* Переход в контейнер  `` docker-compose exec -it php bash ``
* Запуск установки расширений yii2 `` composer install ``
* Запуск миграций `` php yii migrate ``
* Запуск скрипта для создания пользователей  ``php yii user/create-users``

Скрипт создаст:
* Пользователя с ролью админ (логин / пароль): admin / 12345
* Пользователей с ролью менеджер (логин / пароль): manager1 / 12345 , manager2 / 12345
* Пользователей с ролью юзер (логин / пароль): user1 / 12345 , user2 / 12345

https://github.com/Apress/pro-php-jquery/tree/master



