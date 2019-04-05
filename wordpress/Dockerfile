FROM php:7.2-apache

# install the PHP extensions we need
RUN set -ex; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y \
		unzip \
		libjpeg-dev \
		libpng-dev \
	; \
	\
	docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr; \
	docker-php-ext-install gd mysqli opcache zip; \
	\
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual;

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini
# https://codex.wordpress.org/Editing_wp-config.php#Configure_Error_Logging
RUN { \
		echo 'error_reporting = 4339'; \
		echo 'display_errors = Off'; \
		echo 'display_startup_errors = Off'; \
		echo 'log_errors = On'; \
		echo 'error_log = /dev/stderr'; \
		echo 'log_errors_max_len = 1024'; \
		echo 'ignore_repeated_errors = On'; \
		echo 'ignore_repeated_source = Off'; \
		echo 'html_errors = Off'; \
	} > /usr/local/etc/php/conf.d/error-logging.ini

RUN a2enmod rewrite expires

ARG WORDPRESS_DIR=/var/www/html
ENV WORDPRESS_VERSION 5.1.1
ENV WORDPRESS_SHA1 f1bff89cc360bf5ef7086594e8a9b68b4cbf2192

RUN set -ex; \
	curl -o wordpress.tar.gz -fSL "https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz"; \
	echo "$WORDPRESS_SHA1 *wordpress.tar.gz" | sha1sum -c -; \
# upstream tarballs include ./wordpress/ so this gives us /usr/src/wordpress
	tar -xzf wordpress.tar.gz -C /usr/src/; \
	rm wordpress.tar.gz; \
	chown -R www-data:www-data /usr/src/wordpress


RUN cp -R /usr/src/wordpress/. $WORDPRESS_DIR

ADD --chown=www-data:www-data "https://downloads.wordpress.org/plugin/edunext-openedx-integrator.1.9.0.zip" $WORDPRESS_DIR/wp-content/plugins/
ADD --chown=www-data:www-data "https://downloads.wordpress.org/plugin/advanced-custom-fields.5.7.12.zip" $WORDPRESS_DIR/wp-content/plugins/
ADD --chown=www-data:www-data "https://downloads.wordpress.org/plugin/elementor.2.5.14.zip" $WORDPRESS_DIR/wp-content/plugins/
ADD --chown=www-data:www-data "https://downloads.wordpress.org/plugin/classic-editor.1.4.zip" $WORDPRESS_DIR/wp-content/plugins/

RUN unzip -d $WORDPRESS_DIR/wp-content/plugins/ '/var/www/html/wp-content/plugins/*.zip'; \
	rm $WORDPRESS_DIR/wp-content/plugins/*.zip; \
	ls $WORDPRESS_DIR/wp-content/plugins/

RUN rm -rf $WORDPRESS_DIR/wp-content/plugins/akismet; \
    rm $WORDPRESS_DIR/wp-content/plugins/hello.php

RUN chown -R www-data:www-data $WORDPRESS_DIR

COPY ./wp-config.php $WORDPRESS_DIR/

VOLUME $WORDPRESS_DIR


CMD ["apache2-foreground"]