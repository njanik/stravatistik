# -*- mode: ruby -*-
# vi: set ft=ruby :


Vagrant.configure(2) do |config|
  config.vm.box = "geerlingguy/ubuntu1604"

  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "private_network", ip: "10.10.10.100"
  config.vm.synced_folder ".", "/home/vagrant/stravatistik",owner: "www-data", group: "www-data", mount_options: ["dmode=775,fmode=774"]

  config.vm.provider "virtualbox" do |vb|
      vb.gui = false
      vb.memory = "1024"
  end

  config.vm.provision "shell", path: "provision.sh"

end
