FROM ubuntu

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV TZ=UTC

RUN apt update && apt install -y  \
  curl \
  nginx \
  php8.1 \
  php8.1-ctype \
  php8.1-curl \
  php8.1-dom \
  php8.1-fpm \
  php8.1-gd \
  php8.1-intl \
  php8.1-mbstring \
  php8.1-mysqli \
  php8.1-tokenizer \
  php8.1-opcache \
  php8.1-phar \
  php8.1-xml \
  php8.1-xmlreader \
  php8.1-pdo \
  wget \
  nodejs \
  yarn \
  postgresql-client \
  supervisor \
  mysql-client

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer


# Postgresql CLient
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#Ccopy files And mout volumes
COPY --chown=www-data . /usr/share/nginx/celobat
VOLUME /usr/share/nginx/celobat



RUN chmod +x /usr/share/nginx/celobat/docker/entrypoint.sh


#Config Nginx And socket
COPY ./docker/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

RUN chgrp -R www-data /usr/share/nginx/celobat/storage/


#Start APP
EXPOSE 80
ENTRYPOINT ["sh", "/usr/share/nginx/celobat/docker/entrypoint.sh"]
