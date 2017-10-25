FROM php:apache
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/
COPY config/ /usr/local/etc/php/
COPY www/ /var/www/html/
RUN chmod 777 /var/www/html/upload
