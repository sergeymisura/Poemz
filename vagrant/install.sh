debconf-set-selections <<< 'mysql-server mysql-server/root_password password devdb'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password devdb'
apt-get update
apt-get install -y apache2
apt-get install -y -q mysql-server mysql-client
apt-get install -y php5 php5-gd php5-mcrypt php5-mysql php5-curl
apt-get install -y nodejs npm
apt-get install -y openjdk-7-jre
apt-get install normalize-audio libav-tools

ln -s /usr/bin/nodejs /usr/bin/node
npm install -g less
