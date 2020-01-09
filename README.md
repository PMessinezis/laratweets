# Laratweets

Laratweets is a test app that uses Twitter OAuth authentication and subsequently displays authenticated user's twitter timeline.

To install for dev and run 

`git clone git@github.com:PMessinezis/laratweets.git` 

If you have docker installed cd into app directory and run

`./run.sh` 

which builds the docker image and runs it using an sqlite database inside the container, listening at http://localhost:8888 (see also [Twitter API Setup](#twitter) below).

If you just want to run it, you can use the public docker images :

`pmessinezis/laratweets:latest` (it uses eloquent) or 
`pmessinezis/laratweets:doctrine`

If you want to overide default database engine, you can run it using `docker run` command line arguments to override DB_xxxx variables.

Example run command : 

`docker run --rm  --name laratweets --env-file env.mysql  --network devnet  -p 8000:8000  -d pmessinezis/laratweets:doctrine`

and example env.mysql

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

which assumes that you have setup a docker network named `devnet` where a container with hostname `mysqlserver` serves a mysql server listening on port `3306`, and you have already created a database named `laratweets` and created corresponding user `laratweets` with password `some_password`.

Note that in order to override the web app listening port, you must set both the `WEB_PORT` variable, adjust `APP_URL` and `TWITTER_OAUTH_CALLBACK`, and use the `-p` argument when calling `docker run` 

## Twitter API setup <a name="twitter"></a>

In **_every_** case, regardless if you run it locally, inside a vscode .devcontainer, using local docker image or the published ones, you need to override the `TWITTER_CONSUMER_API_KEY` and `TWITTER_CONSUMER_API_SECRET_KEY` variables, either setting them inside `.env` file or via `docker run` arguments. The values pushed in github are dummy values. In order to create valid values, you need to go to  https://developer.twitter.com/en/apps and set up a Twitter App and a `CONSUMER API KEY` and a `CONSUMER API SECRET KEY` respectively. Also, in the Twitter App you will need to register under `Callback URL` the one set via `TWITTER_OAUTH_CALLBACK` variable.



