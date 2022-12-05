FROM nginx:latest

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV TZ=UTC

#Set WorkDir
WORKDIR /usr/share/nginx/celobat

# Env Key & base pakadge
RUN apt-get update \
    && apt-get install -y gnupg gosu mysql\* curl ca-certificates zip curl lsb-release unzip git sqlite3 libcap2-bin libpng-dev python2 python3-pip \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update

# PHP
RUN apt-get install -y php8.1-cli php8.1-dev \
       php8.1-pgsql php8.1-sqlite3 \
       php8.1-curl php8.1-memcached\
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap php8.1-readline \
       php8.1-msgpack php8.1-igbinary php8.1-ldap php8.1-fpm \
       php8.1-redis

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

#mysql-client \
RUN apt-get install -y wget


## yarn and node
RUN curl -sL https://deb.nodesource.com/setup_19.x | bash - \
  && apt-get install -y nodejs \
  && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
  && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
  && apt-get update \
  && apt-get install -y yarn

# Postgresql CLient
RUN apt-get install -y postgresql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Set php version
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1
RUN update-alternatives --set php /usr/bin/php8.1

#Ccopy files And mout volumes
COPY . /usr/share/nginx/celobat
COPY --chown=www-data . /usr/share/nginx/celobat
VOLUME /usr/share/nginx/celobat


#Config Nginx And socket
COPY ./docker/default.conf /etc/nginx/conf.d/default.conf
#COPY ./docker/www.conf /etc/php/8.1/fpm/pool.d/www.conf
#Start APP
EXPOSE 80
ENTRYPOINT ["/usr/share/nginx/celobat/docker/entrypoint.sh"]
