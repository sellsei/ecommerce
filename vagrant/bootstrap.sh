#!/bin/bash

sudo apt-get update
sudo sh -c 'DEBIAN_FRONTEND=noninteractive apt-get -o Dpkg::Options::="--force-confnew" --force-yes -fuy dist-upgrade'

sudo apt-get -y install curl build-essential python-software-properties git
sudo echo "mysql-server mysql-server/root_password password root" | debconf-set-selections
sudo echo "mysql-server mysql-server/root_password_again password root" | debconf-set-selections
sudo apt-get -y install mysql-server mysql-client php5 php5-dev apache2 libapache2-mod-php5 php5-curl php5-gd \
     php5-mcrypt php5-mysql php5-imap php-apc php5-xdebug php-pear supervisor pkg-config xvfb nodejs nodejs-legacy \
     npm firefox default-jdk

sudo a2enmod rewrite
sudo a2enmod headers

sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/sites-available/000-default.conf
sudo sed -i "s/var\/www\/html/var\/www\/vagrant\/web/g" /etc/apache2/sites-available/000-default.conf
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini
sudo sed -i "s/short_open_tag = .*/short_open_tag = Off/" /etc/php5/apache2/php.ini
sudo sed -i "s/short_open_tag = .*/short_open_tag = Off/" /etc/php5/cli/php.ini
sudo sed -i "s/;date.timezone =/date.timezone =\"Europe\/London\"/" /etc/php5/apache2/php.ini
sudo sed -i "s/;date.timezone =/date.timezone =\"Europe\/London\"/" /etc/php5/cli/php.ini

sudo service apache2 restart

sudo curl https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "Installing yuicompressor"
wget https://github.com/yui/yuicompressor/releases/download/v2.4.8/yuicompressor-2.4.8.jar
sudo mkdir /var/www/vagrant/bin
sudo mv -v yuicompressor-2.4.8.jar /var/www/vagrant/bin/yuicompressor.jar

echo "Installing bower"
sudo npm -g install bower

echo "Installing php-cs-fixer"
sudo curl http://get.sensiolabs.org/php-cs-fixer.phar -o /usr/local/bin/php-cs-fixer
sudo chmod a+x /usr/local/bin/php-cs-fixer
sudo php-cs-fixer self-update