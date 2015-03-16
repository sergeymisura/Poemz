
ln -s /usr/bin/nodejs /usr/bin/node

rm -rf /var/www
ln -s /vagrant/website-new /var/www

ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

rm /etc/apache2/sites-enabled/000-default.conf
cp /vagrant/vagrant/config/apache-site.conf /etc/apache2/sites-enabled/000-default.conf

# set the apache run user to vagrant to avoid permission issues
sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=vagrant/' /etc/apache2/envvars
sed -i 's/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=vagrant/' /etc/apache2/envvars
# "hard" restart, forces the user change
apache2ctl stop
while pgrep apache2 &>/dev/null; do sleep 0.1; done
apache2ctl start

echo "create database poemz" | mysql -uroot -pdevdb
echo "create user 'poemz'@'%' identified by 'devdb' " | mysql -uroot -pdevdb
echo "grant all privileges on poemz.* to 'poemz'@'%'" | mysql -uroot -pdevdb
mysql -upoemz -pdevdb < /vagrant/vagrant/config/dev-db.sql

cp /vagrant/vagrant/config/yii-config.php /vagrant/website-new/protected/config/local.php

#pushd /vagrant/website-new/protected
#php yii.php db/deltas
#popd

rm /etc/mysql/my.cnf
cp /vagrant/vagrant/config/mysql.conf /etc/mysql/my.cnf
chmod 0644 /etc/mysql/my.cnf

service mysql restart
