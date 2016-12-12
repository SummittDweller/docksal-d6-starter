# docksal-d6-starter
Create a Drupal 6 site in Docksal (https://github.com/docksal/docksal)

- Current Drupal 6 version 6.38
- Use case: Migrating D6 sites to D8

## Why do I need this? What does it do?

The Docksal Project currently has example projects for Drupal 7 and Drupal 8 located [here](https://github.com/docksal/docksal, but Drupal 6 is missing. If you're involved in D6 migrations this project will allow you to easily configure and run multiple D6 projects side-by-side on your system with D7 and D8 projects. Through the magic that is Docksal / Docker / VirtualBox all your environments are separate.

### The Nitty Gritty

The stock Docksal environment only needs a couple of tweaks to run D6. Here's what we did:

#### Customizations to .docksal/etc/php/php.ini

Mbstring needed some tweaking. This was added:
```
mbstring.http_input = pass
mbstring.http_output = pass
mbstring.internal_encoding = pass
```
#### settings.local.php file added

A settings.local.php file was added, and code was added to settings.php to call it. In addition to the standard things that are done in the blinkreaction local settings sample file we tune down error_reporting and adjust the $db_url to use docksal environment variables for the db credentials:

```
# in your PHP code:
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

# Docker DB connection settings.
$db_url = "mysql://user:user@db/default";
```

## Instructions - Create a New Clean Drupal 6 Site
Instructions for creating "drupal6.docksal" on Windows using babun

####Add the domain to your local machine's HOSTS file:

    192.168.64.100   drupal6.docksal

####Then - Fire up Docksal

    fin up

#####Install Drupal from Scratch

Since drush won't site-install on Drupal 6 we've got to go old-school.  Point your browser to `http://your-drupal6-site.drush/install.php` and party like it's 2008

#####...Or Install from Back

A D6 backup is provided in the `/data` directory. This backup was created with `fin bs` (BackStop Command ) Restore using `fin slb` (Start from last backup):

````
    fin slb
````

#####Optionally modify your project VIRTUAL_HOST and SITE_DOMAIN

Edit VIRTUAL_HOST and SITE_DOMAIN in ./docksal/docksal.env to customize local url:

````
    # Set the VIRTUAL_HOST and SITE_DOMAIN in ./docksal/docksal.env Use your favorite editor or SED:
    # To create myproject.docksal
    # sed -i 's/drupal6/myproject/' docksal.env
````

## Instructions - Pull an existing Drupal 6 site into Docksal.

#### Setup

1. Clone the project, configure docker-compose.yml and add the domain to your hosts file using instructions above.
2. Remove the existing contents of /docroot and replace with your D6 project. You can cd to docroot and `git pull` your legacy project into /docroot
3. Create /sites/default/files and copy existing files if needed
2. Copy /settings-setup/settings.local.php to /docroot/sites/default/settings.local.php
```
cp settings-setup/settings.local.php ./docroot/sites/default/settings.local.php
```
3. Edit your settings.php file & add this to the end:
```
$local_conf_file_path = __DIR__ . '/settings.local.php';
if (file_exists($local_conf_file_path)) {
require($local_conf_file_path);
}
```

You should now be able to `dsh up` and install drupal as above.

#### Getting the legacy site's database

All our D6 sites use the backupmigrate module. We just install & enable module on local site. Backup existing site -> Download -> Restore on local. You can also setup a drush alias and sql-sync.

#### Legacy Site GIT issues
If you pulled your legacy site into /docroot you now have a git project in a git project. You may want to add /docroot to the .gitignore of the drupal6 project. If you love pain and mental anquish you can do something with git submodules.

## What's next?

This project just begs for an init script. A normal docksal init can re-provision the whole machine. Since `drush site-install` doesn't work in d6 there's still going to be a manual install, but post install there's a ton of repetitive stuff that gets done on a migration-source site. If anybody has any bright ideas...

## TODO

Project still relies on drude/blinkreaction images (blinkreaction/drupal-apache:2.2-stable) These should be switched to the docksal images ( docksal/apache:2.2-stable )

