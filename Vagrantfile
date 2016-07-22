box = 'ubuntu/trusty64'
hostname = 'mrcoffer.vagrant'
ip = '192.168.13.10'
cpus = 2
memory = 2048

Vagrant.configure(2) do |config|
    config.vm.box = box
    config.vm.hostname = hostname
    config.vm.network "private_network", ip: ip

    config.vm.provider :virtualbox do |vb|
        vb.cpus = cpus
        vb.name = hostname
        vb.memory = memory
    end
    
    # Run the Ansible 'provision' playbook upon provisioning
    # this Vagrant instance.
    config.vm.provision :ansible do |ansible|
        ansible.playbook = "build/ansible/provision.yaml"
    end
end
