FROM dunglas/frankenphp

# Copier le fichier VERSION pour l'inclure dans l'image
#COPY VERSION /app/VERSION

# Ajouter des labels avec les informations de build
#ARG BUILD_DATE
#ARG VCS_REF
#ARG VERSION
#LABEL org.label-schema.build-date=$BUILD_DATE \
#      org.label-schema.name="CLARA" \
#      org.label-schema.description="CLARA - Candidatures et Liaisons Académiques pour la Réussite des Apprenants" \
#      org.label-schema.version=$VERSION \
#      org.label-schema.vcs-ref=$VCS_REF \
#      org.label-schema.vcs-url="https://github.com/clara-app/clara" \
#      org.label-schema.schema-version="1.0"

# Installation des extensions PHP nécessaires pour MySQL et autres dépendances Symfony
RUN install-php-extensions \
    pdo_mysql \
    mysqli \
    intl \
    zip \
    gd \
    opcache \
    apcu \
    xdebug

# Configuration PHP pour les uploads
RUN echo "upload_max_filesize = 12M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 15M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Installer Composer (méthode officielle depuis https://getcomposer.org/download/)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified' . PHP_EOL; } else { echo 'Installer corrupt' . PHP_EOL; unlink('composer-setup.php'); exit(1); }" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    composer --version


# Définir le répertoire de travail
WORKDIR /app

# Créer les dossiers nécessaires et définir les permissions
RUN mkdir -p var/cache var/log && \
    chmod -R 777 var/

# Exposer les ports HTTP et HTTPS
EXPOSE 80

# Commande par défaut
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]