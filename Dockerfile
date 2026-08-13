# Use official PHP image with Apache
FROM php:7.4-apache

# Set working directory
WORKDIR /var/www/html

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/<Directory \/var\/www\/html>/<Directory \/var\/www\/html>\n    AllowOverride All/' /etc/apache2/apache2.conf

# Copy application files to container
COPY . /var/www/html/

# Create data directory for JSON storage
RUN mkdir -p /var/www/html/data && \
    chmod 777 /var/www/html/data

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod 777 /var/www/html/data

# Render injects a $PORT env var at runtime and routes traffic to it.
# Apache's config supports ${VAR} expansion from the process environment,
# so point Listen and the VirtualHost at ${PORT} instead of a hardcoded 80.
# The ENV default below only matters for local `docker run` without -e PORT.
ENV PORT=80
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
