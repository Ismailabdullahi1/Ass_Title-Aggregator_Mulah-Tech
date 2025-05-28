FROM php:8.1-apache

# Enable mod_rewrite (optional, good for routing)
RUN a2enmod rewrite

# Copy all files to Apache's root directory
COPY . /var/www/html/

# Optional: Set correct permissions
RUN chown -R www-data:www-data /var/www/html
