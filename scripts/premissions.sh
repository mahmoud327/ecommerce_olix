#!/bin/bash

EXPECTED_ARGS=3
E_BADARGS=65

if [ $# -ne $EXPECTED_ARGS ]
then
echo "Usage: $0 username group root_dir_name"
  exit $E_BADARGS
fi


user=$1
group=$2
dir=$3

cd ..
chown -R $user:$group $dir/
find $dir/ -type f -exec chmod 664 {} \;
find $dir/ -type d -exec chmod 775 {} \;
cd $dir/
chgrp -R $group storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
php artisan optimize:clear
php artisan storage:link
composer update

php artisan migrate
php artisan optimize
