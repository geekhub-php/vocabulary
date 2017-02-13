#!/usr/bin/env bash
clear

echo "1 - install"
echo "2 - run tests"
echo "3 - exit"

read Keypress

case "$Keypress" in
1) echo "installing";
    script_dir=$(dirname $0)
    cd $script_dir
    composer install
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
    php bin/console doctrine:fixtures:load
    gulp


;;
2) echo "";
    script_dir=$(dirname $0)
    cd $script_dir
    ./bin/console d:f:l --no-interaction
    phpunit ./tests/
;;
3) exit 0
;;
esac

exit 0