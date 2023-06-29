FROM devopsfnl/image:php-8.2-npx

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install
RUN npm install
RUN npm run build
