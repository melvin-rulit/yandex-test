FROM php:8.3-fpm-bookworm

# Устанавливаем нужные пакеты
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sudo \
    libsqlite3-dev \
    mariadb-client \
    libsodium-dev \
    libc-client-dev \
    libkrb5-dev \
    libzip-dev \
    libpq-dev \
    nano \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем Node.js 20.x (необходим для Vite 7 / laravel-vite-plugin)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && node -v && npm -v

# Устанавливаем PHP расширения
RUN docker-php-ext-install \
    sockets \
    sodium \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    soap \
    zip \
    mysqli \
    pdo_mysql \
    dom # Добавляем поддержку DOM

# Настраиваем и ставим IMAP
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Запускаем PHP-FPM и Laravel команду
CMD php-fpm -D && php artisan reverb:start --host=0.0.0.0 --port=8080
