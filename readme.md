# SongBird

SongBird is a simple CMS built using Symfony. The process of building this CMS is documented in [Practical Symfony 2.7 book](http://bernardpeh.gitbooks.io/practical-symfony-2-7/)

I created this project to:

* illustrate the power of rapid development with Symfony.

* share the process of creating SongBird to anyone who wants to learn Symfony. 

* kickstart more complex Symfony projects with this bundle.

* have fun! 
 
## Installation

* Make sure you have [vagrant](https://www.vagrantup.com/downloads.html), [virtualbox](https://www.virtualbox.org/wiki/Downloads) and [git](https://git-scm.com) **installed**

* If you are on Windows OS install [NFS support plugin](https://github.com/GM-Alex/vagrant-winnfsd)

* Clone this repository

```
# say you want to clone this dir under your home dir.
cd ~
git clone git@github.com:bernardpeh/songbird.git
```

* run vagrant (for the first time it should take up to 20-30 mins depending on your internet connnection) 

```
cd songbird
vagrant up
```

* update the db credentials

```
# in songbird/app/config/parameters.yml
database_name: songbird
database_user: songbird
database_password: songbird
```

* add IP of your VM to your host file

```
192.168.56.111 songbird.dev  www.songbird.dev
```

* Open up browser and go to https://songbird.dev/app_dev.php/app/example
