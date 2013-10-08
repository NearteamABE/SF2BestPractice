#! /usr/bin/env sh

php app/console doctrine:database:drop --force --verbose &&
php app/console doctrine:database:create --verbose &&
php app/console doctrine:schema:create --verbose &&
php app/console doctrine:fixtures:load;
#mysql -uroot -proot lf_bo < installer/sql/initDatabase.sql;

