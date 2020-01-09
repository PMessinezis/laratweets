docker ps | grep laratweets && docker stop laratweets || echo laratweets not running
docker ps -all | grep laratweets && docker rm laratweets || echo laratweets does not exist
docker build . -t laratweets
docker run -p 8888:8888 --rm --name laratweets  $@ -d laratweets
docker ps | grep laratweets