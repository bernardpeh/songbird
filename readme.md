# SongBird

SongBird is a simple CMS built using Symfony. The process of building this CMS is documented in the [Practical Symfony 2.7 book](http://bernardpeh.gitbooks.io/practical-symfony-2-7/)

I created this project to:

* Illustrate the power of rapid development with Symfony.

* Share the process of a simple CMS with anyone who wants to dive into Symfony. 

* Kickstart more complex Symfony projects with this bundle.

* Have fun! 
 
## Installation

* Fork SongBird's Repository

Login in github and fork [songbird repo](https://github.com/bernardpeh/songbird)

```
# say you want to clone your new repo under your home dir.
cd ~
git clone git@github.com:your_username/songbird.git
```

* run vagrant

```
cd songbird
# now we are going to bring up the virtual machine. This should take up to 15 to 30 mins depending on your internet connnection
vagrant up
```

* Install the dependencies

```
composer udpate

# when prompted for database credentials
database_name: songbird
database_user: songbird
database_password: songbird
```

* add IP of your VM to your host file

```
192.168.56.111 songbird.dev  www.songbird.dev
```

* Open up browser and go to https://songbird.dev/app_dev.php/app/example. If you see the word "homepage", your installation is successful.

Detailed installation can be read [here](http://bernardpeh.gitbooks.io/practical-symfony-2-7/content/chapter3.html).
