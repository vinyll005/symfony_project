FROM php:8-apache

RUN apt-get update

# ====================================
# Сначала устанавливаем базовые пакеты
# ====================================

RUN apt-get install -fyqq \
    curl \
    wget \
    cron \
    nano \
    unzip

# ====================================
# Затем, используя скрипт он вендора PHP устанавливаем расширения PHP
# ====================================

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions gd mysqli opcache zip imap intl ldap pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite
# ====================================
# Запускаем CRON
# ====================================

COPY start.sh /root/start.sh
# На случай если start.sh был создан в Windows
RUN sed -i -e 's/\r$//' /root/start.sh
CMD ["/root/start.sh"]

# Указываем рабочую директорию (необязательно?)
#WORKDIR /www/html

