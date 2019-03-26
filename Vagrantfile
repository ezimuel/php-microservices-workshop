# Vagrant configuration for Microservices PHP workshop
# @author Enrico Zimuel (enrico.zimuel@elastic.co)

VAGRANTFILE_API_VERSION = '2'

$script = <<SCRIPT
# Fix for Temporary failure resolving 'archive.ubuntu.com'
echo "nameserver 8.8.8.8" | sudo tee /etc/resolv.conf > /dev/null

# Install dependencies
sudo add-apt-repository ppa:ondrej/php
apt-get update
apt-get install -y git curl sqlite3 php7.3-cli php7.3-dev php7.3-sqlite3 php7.3-xml php7.3-zip php7.3-mbstring httpie openjdk-11-jdk bash-completion
yes "n" | pecl install swoole
echo "extension=swoole.so" > /etc/php/7.3/mods-available/swoole.ini
ln -s /etc/php/7.3/mods-available/swoole.ini /etc/php/7.3/cli/conf.d/20-swoole.ini

if [ -e /usr/local/bin/composer ]; then
    /usr/local/bin/composer self-update
else
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

cd /home/vagrant/php-microservices-workshop
sudo -u vagrant composer install --no-progress --no-suggest
sqlite3 data/db/users.sqlite < data/db/users.sql
chmod +x vendor/bin

# Install ElasticSearch
cd /home/vagrant
curl -s -L -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-6.6.2.tar.gz
tar -xf elasticsearch-6.6.2.tar.gz
rm elasticsearch-6.6.2.tar.gz
chown vagrant:vagrant elasticsearch-6.6.2 -R
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'bento/ubuntu-18.04'
  config.vm.network "forwarded_port", guest: 8080, host: 8088
  config.vm.synced_folder ".", "/home/vagrant/php-microservices-workshop", id: "vagrant-root",
     owner: "vagrant",
     group: "vagrant",
     mount_options: ["dmode=777,fmode=666"]
  config.vm.provision 'shell', inline: $script

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "2048"]
    vb.customize ["modifyvm", :id, "--name", "php-microservices-workshop"]
  end
end
