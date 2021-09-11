
1. Install PHP (https://www.digitalocean.com/community/tutorials/how-to-install-php-7-4-and-set-up-a-local-development-environment-on-ubuntu-20-04)
```
sudo apt install php7.4
```
2. Install PHP plugins
```
sudo apt-get install -y php7.4-curl php7.4-dom php7.4-mbstring php7.4-intl php7.4-gd php7.4-mysql php7.4-xml php7.4-zip php7.4-json
```
3. Install composer (https://getcomposer.org/download/)
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
4. Move composer to bin
```
sudo mv composer.phar /usr/local/bin/composer
```
5. Install yarn
```
sudo npm install -g yarn
```
6. Clone repository
```
# Assuming that /var/www/html is the webserver's document root
git clone https://github.com/owncloud/core.git /var/www/html/core

# Set the user and group to the webserver user and group
sudo chown -R www-data:www-data /var/www/html/core/

# Set read/write permissions on the directory
sudo chmod o+rw -R /var/www/html/core/
```
7. Makefile
```
cd /var/www/html/core && make
```
