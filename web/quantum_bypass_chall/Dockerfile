# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy web files into container
COPY quantum_bypass/ /var/www/html/

# Expose port 80
EXPOSE 80


# Enable Apache mod_rewrite and mod_headers (if needed for PHP apps)
RUN a2enmod rewrite headers

# Set recommended Apache settings for dev
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set permissions (optional, for dev)
RUN chown -R www-data:www-data /var/www/html

# Start Apache
CMD ["apache2-foreground"]
