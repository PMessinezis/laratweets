# Laratweets

Laratweets is a simple web application using Laravel 6 that relies on Twitter oAuth for user authentication and subsequently displays the twitter timeline of the authenticated user.

To install for dev : 

`git clone git@github.com:PMessinezis/laratweets.git` 

If you have docker installed on your system, you can `cd` into app directory and either update Twitter Consumer Api keys inside `.env.dev` (see also [Twitter API Setup](#twitter) below) and run :

`./run.sh` 

or use command line arguments to set the keys, e.g. :

```
./run.sh -e TWITTER_CONSUMER_API_KEY=BTcdkdh59IcCvj9qMVhX0c7fp \
         -e TWITTER_CONSUMER_API_SECRET_KEY=YAQM6IbgMuJ7hJc8vEOV4vlfj48siHE5zTd8v5fO75sAnjj8Fq
 ```

`./run.sh` will build locally the docker image and will run it using an sqlite database inside the container, listening at http://localhost:8888 .

If you just want to run it, without cloning, you can use the published docker image :

`pmessinezis/laratweets:latest` 

If you want to overide default database engine, you can use `docker run` command line arguments to override DB_xxxx variables. In any case you need to define the Twitter API keys (see [Twitter API Setup](#twitter))

Example `docker run` command : 

```
docker run --env-file env.mysql  --network devnet  -p 8000:8000  -d pmessinezis/laratweets:latest
```

and example contents of `env.mysql`

```
DB_CONNECTION=mysql
DB_HOST=mysqlserver
DB_PORT=3306
DB_DATABASE=laratweets
DB_USERNAME=laratweets
DB_PASSWORD=some_password

TWITTER_CONSUMER_API_KEY=BTcdkfjW9IcCvj9qMVhX0c7fp
TWITTER_CONSUMER_API_SECRET_KEY=YAQM6IbgMu9errc8vEOV4vSNtQkNrHE5zTd8v5fO75sAnjj8Fq

WEB_PORT=8000
APP_URL=http://localhost:8000
TWITTER_OAUTH_CALLBACK=http://localhost:8000/login/twitter/callback
```

The example implies that you have setup a docker network named `devnet` where a container with hostname `mysqlserver` provides a mysql server listening on port `3306`, and on that mysql server you have already created a database named `laratweets` and created a corresponding user `laratweets` with password `some_password`.

Note that in order to override the web app listening port, you need to : 
- set the `WEB_PORT` variable (it is used by the `docker-entrypoint.sh` script to fire `php artisan serve` on the requested port), 
- adjust `APP_URL` and `TWITTER_OAUTH_CALLBACK`, and 
- use the `-p` argument when calling `docker run` 

## Twitter API setup <a name="twitter"></a>

In **_every_** case, regardless if you run it locally, inside a vscode .devcontainer, using local docker image or the published ones, you need to override the `TWITTER_CONSUMER_API_KEY` and `TWITTER_CONSUMER_API_SECRET_KEY` variables, either setting them directly inside `.env` or `.env.dev` files or via `docker run` arguments. The values that are pushed in github are dummy values. In order to create valid values, you need to go to  https://developer.twitter.com/en/apps and set up a Twitter App and a `CONSUMER API KEY` and a `CONSUMER API SECRET KEY` respectively. Also, in the Twitter App you will need to register under `Callback URL` the one set via `TWITTER_OAUTH_CALLBACK` variable.
