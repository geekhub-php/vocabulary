Geekhub PHP HomeWork#14: Symfony Vocabulary Application - Translations
=

####EER Diagram:

https://docs.google.com/drawings/d/1gXIQH6vCcoeqFa2ess2fpVgOADpIkfmPAOGW7HD2LCs/edit?usp=sharing

####Setup:

Note: Before continue, install Node.js.

```bash
$ git clone -b hw14-andrey-lukashenko https://github.com/AndreyLuka/geekhub-php-vocabulary.git
$ cd geekhub-php-vocabulary
$ composer install
$ php bin/console doctrine:fixtures:load
``` 


Homework 14: Vocabulary
==========

1. Створити мильтимовну систему, де можна було б додавати різні слова для вивчення мов.
2. Кількість мов - 5
3. Мінімальна кількість слів - 1000
4. Юзер логіниться в систему у вибрану одну з 5 локалей системи
5. Бачить список доданих слів у кожній з 5 мов.
6. Юзер може додавати нові слова у систему.
7. Юзер можу додати/видаляти/редагувати будь які слова у власний wishlist
