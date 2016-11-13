#! /usr/bin/env bash


sudo usermod -a -G www-data vagrant

sudo apt-get update
sudo apt-get install -y apache2 php7.0 php7.0-zip libapache2-mod-php7.0 mcrypt php7.0-mcrypt php-mbstring phpunit php7.0-curl


sudo a2enmod rewrite

echo "<VirtualHost *:80>
  ServerName stravatistik.dev
  DocumentRoot /home/vagrant/stravatistik/public
  <Directory /home/vagrant/stravatistik/public>
    AllowOverride all
    Require all granted
  </Directory>
</VirtualHost>" > /etc/apache2/sites-available/stravatistik.dev.conf

sudo a2ensite stravatistik.dev

sudo /etc/init.d/apache2 restart
