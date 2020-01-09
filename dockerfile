FROM ubuntu as laratweets
ENV DEBIAN_FRONTEND=noninteractive

# Or your actual UID, GID on Linux if not the default 1000
RUN echo B
ARG USERNAME=coder
ARG USER_UID=1000
ARG USER_GID=$USER_UID
ARG PHP_VER=7.2
ENV TZ=Europe/London
SHELL ["/bin/bash" , "-c"]
RUN apt-get update
RUN apt-get -y install --no-install-recommends apt-utils dialog 2>&1 

#install PHP
RUN apt-get install -y php${PHP_VER}-cli 
RUN php -v
RUN apt-get install -y php${PHP_VER}-mbstring 
RUN apt-get install -y php${PHP_VER}-zip 
RUN apt-get install -y php${PHP_VER}-xml
RUN apt-get install -y php${PHP_VER}-curl
RUN apt-get install -y php${PHP_VER}-sqlite3

#install git
RUN apt-get -y install curl git openssl unzip zip

#install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# SETUP USER
RUN apt-get install -y sudo
RUN groupadd --gid $USER_GID $USERNAME 
RUN useradd -s /bin/bash --uid $USER_UID --gid $USER_GID -m $USERNAME 
RUN echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME 
RUN chmod 0440 /etc/sudoers.d/$USERNAME 

#install nodejs/npm
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

#install git
RUN apt-get -y install iproute2 procps lsb-release

#install php-mysql and mysql client
RUN apt-get -y install php${PHP_VER}-mysql mysql-client 

# SETUP WORKDIR
RUN mkdir /workspace
WORKDIR /workspace
RUN chmod -R 777 /root 
RUN chown -R $USERNAME /root
RUN chmod -R 777 /workspace 
RUN chown -R $USERNAME /workspace

USER $USERNAME:$USERNAME
RUN sudo chown -R $USERNAME /workspace

COPY . /workspace

RUN sudo chmod -R 777 /workspace/public
RUN sudo chmod -R 777 /workspace/storage
RUN sudo chmod -R 777 /workspace/bootstrap/cache

RUN composer install

RUN npm install

RUN npm run dev

RUN cp .env.dev .env

RUN php artisan key:generate

RUN sudo touch database/database.sqlite

RUN sudo chown -R $USERNAME:$USERNAME database
RUN sudo chmod -R 777 database

RUN ls -la database

RUN php artisan migrate

EXPOSE 8888

ENTRYPOINT ["bash" , "-c" , " php artisan serve --host=0.0.0.0 --port=8888"] 