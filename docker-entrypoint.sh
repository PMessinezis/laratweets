[[ -z $WEB_PORT ]]  && export WEB_PORT=8888
php artisan migrate
php artisan optimize
php artisan serve --host=0.0.0.0 --port=$WEB_PORT
