# SongBird

![songbird cms](http://practicalsymfony.com/wp-content/uploads/2015/06/chapter_20_screenshot.png)

SongBird is a simple CMS built using Symfony. The process of building this CMS is documented in [Rapid Application Development With Symfony 2](http://practicalsymfony.com) website.

I created this project to:

* Illustrate the power of rapid development with Symfony.

* Share the process of a simple CMS with anyone who wants to dive into Symfony. 

* Kickstart more complex Symfony projects with this application.

* Have fun! 


## Installation

Refer to the [installation chapter](http://practicalsymfony.com/chapter-3-creating-the-dev-environment/)

To skip through everything and see the final product, run

```
# clone the repo
git clone git@github.com:bernardpeh/songbird.git
cd songbird
# setup vagrant. Have a coffee break.
vagrant up
cd www/songbird
composer update
bower update
gulp
# install fixtures
./scripts/resetapp
./scripts/assetsinstall
```

Depending on your OS, add the vm IP to your host file

```
songbird.dev 192.168.56.111
```

Now visit songbird.dev and you should see the website.

