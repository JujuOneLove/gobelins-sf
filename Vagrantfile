# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "debian/stretch64"
  config.vm.network "private_network", ip: "192.168.70.15"

  config.vm.provider "virtualbox" do |vb|
      vb.customize [
        "modifyvm", :id,
        "--memory", "2048",
        "--cpus", "4"
      ]
  end

  config.vm.synced_folder ".", "/vagrant", type: "nfs", mount_options:['nolock,vers=3,udp,noatime,actimeo=1']
  config.vm.provision :shell, path: "vagrant/bootstrap.sh"
end
