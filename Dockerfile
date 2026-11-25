FROM node:20-slim AS fe
RUN apt-get update && apt-get install -y git && rm -rf /var/lib/apt/lists/*
WORKDIR /src
RUN git clone --depth 1 https://github.com/Abdelrhmannali/chess-e-commerce-store.git repo
COPY translations.js /src/repo/chess-e-commerce-store/src/utils/translations.js
WORKDIR /src/repo/chess-e-commerce-store
RUN perl -0pi -e 's/\s*\{authMode === "login" && \(\s*<div className="beidaq-auth-demo">.*?<\/div>\s*\)\}//s' src/components/AccountPage.jsx \
 && ! grep -q beidaq-auth-demo-text src/components/AccountPage.jsx
RUN npm ci && VITE_API_URL=/api npm run build

FROM php:8.4-cli
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions intl zip bcmath pcntl pdo_sqlite
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN git clone --depth 1 https://github.com/Abdelrhmannali/chess-e-commerce-store.git /tmp/repo \
 && cp -r /tmp/repo/Chess /app && rm -rf /tmp/repo
COPY CatalogSeeder.php /app/database/seeders/CatalogSeeder.php
WORKDIR /app
RUN composer install --optimize-autoloader --no-interaction
COPY --from=fe /src/repo/chess-e-commerce-store/dist/ /app/public/
COPY products/ /app/public/products/
RUN mv /app/public/index.html /app/public/spa.html
COPY router.php /app/router.php
COPY start.sh /app/start.sh
RUN chmod +x /app/start.sh && useradd -m -u 1000 user 2>/dev/null; chown -R 1000:1000 /app
USER 1000
ENV PHP_CLI_SERVER_WORKERS=4 APP_ENV=production APP_DEBUG=false DB_CONNECTION=sqlite DB_DATABASE=/tmp/database.sqlite
EXPOSE 10000
CMD ["/app/start.sh"]
