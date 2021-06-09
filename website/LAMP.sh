#!/bin/bash
echo "Welcome to Francky's Lamp Stack all in one script"

sudo apt update
sudo apt upgrade

sudo ufw allow ssh
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable

sudo apt install apache2
sudo apt install php7.4 php7.4-mysql php-common php7.4-cli php7.4-json php7.4-common php7.4-opcache libapache2-mod-php7.4
sudo systemctl restart apache2
echo '<?php phpinfo(); ?>' | sudo tee -a /var/www/html/phpinfo.php > /dev/null
sudo apt install mariadb-server mariadb-client
sudo mysql_secure_installation

sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl
sudo phpenmod mbstring
sudo echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf
sudo systemctl restart apache2

echo "CREATE USER 'username'@'localhost' IDENTIFIED  BY 'password';"
echo "GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost' WITH GRANT OPTION;"
echo "exit"

sudo mysql
