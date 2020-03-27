
#!/bin/sh

#  Script.sh
#
#
#  Created by mutasem elayyoub ddkits.com
#

php artisan cache:clear
php artisan key:generate
php artisan make:auth -n
php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan db:seed
chmod -R 777 storage
 
