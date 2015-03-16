# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "aauthor/trusty64"

  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "forwarded_port", guest: 3306, host: 3307, auto_correct: true

  config.vm.provider "virtualbox" do |vb|
  	vb.name="Poemz"
  end

  config.vm.hostname = "poemz"

  config.vm.provision "shell", path: "vagrant/install.sh"
  config.vm.provision "shell", path: "vagrant/config.sh"
  config.vm.provision "shell", path: "vagrant/startup.sh", run: "always"
end
