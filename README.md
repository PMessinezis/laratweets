Laratweets is a test app that uses Twitter OAuth authentication and subsequently displays authenticated user's twitter timeline.

To install for dev and run 

`git clone git@github.com:PMessinezis/laratweets.git` 

If you have docker installed cd into app directory and run

`./run.sh` 

which builds the docker image and runs it, listening at http://localhost:8888 .

If you don't have docker installed, then execute following steps :

`composer install` 

followed by 

`npm run dev`.

Copy `.env.example` to `.env` and update following entries inside `.env` :

DB_CONNECTION=mysql

DB_HOST=mariadb

DB_PORT=3306

DB_DATABASE=database_name   

DB_USERNAME=database_username

DB_PASSWORD=database_user_password

TWITTER_CLIENT_ID=twitter_consumer_api_key

TWITTER_SECRET=twitter_consumer_api_key_secret

TWITTER_CALLBACK=_your_host_address_/login/twitter/callback e.g. http://localhost:8000/login/twitter/callback

Create the database and the username with the corresponding password in mysql server and give full privileges to the user on the database.

Initialize your app key with :

`php artisan key:generate` 

Initialize database with 

`php artisan migrate`

Start the app with 

`php artisan serve -p 8000` 

