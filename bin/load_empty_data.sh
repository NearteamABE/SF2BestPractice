#! /usr/bin/env sh

php app/console doctrine:database:drop --force --verbose &&
php app/console doctrine:database:create --verbose &&
php app/console doctrine:schema:create --verbose &&
mysql -uroot -proot lf_bo < installer/sql/referentiel_data.sql &&
mysql -uroot -proot lf_bo < installer/sql/initDatabase.sql;

