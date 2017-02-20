Geekhub PHP HomeWork#16: Symfony Vocabulary Application - Tests
=

####EER Diagram:

https://docs.google.com/drawings/d/1gXIQH6vCcoeqFa2ess2fpVgOADpIkfmPAOGW7HD2LCs/edit?usp=sharing

####Setup:

Setup database in "app/config/parameters.yml".

Note: Before continue, install Node.js.<br>
Note 2: "composer install" runs commands "npm i" and "./node_modules/.bin/bower install"

```bash
$ git clone -b hw16-andrey-lukashenko https://github.com/AndreyLuka/geekhub-php-vocabulary.git
$ cd geekhub-php-vocabulary
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load
``` 

####Default users:
login: admin<br>
password: admin

login: user<br>
password: user

Homework 14: Vocabulary
==========

1. Створити мильтимовну систему, де можна було б додавати різні слова для вивчення мов.
2. Кількість мов - 5
3. Мінімальна кількість слів - 1000
4. Юзер логіниться в систему у вибрану одну з 5 локалей системи
5. Бачить список доданих слів у кожній з 5 мов.
6. Юзер може додавати нові слова у систему.
7. Юзер можу додати/видаляти/редагувати будь які слова у власний wishlist
