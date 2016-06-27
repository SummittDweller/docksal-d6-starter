# drude-d6-starter
Create a Drupal 6 site in Drude (https://github.com/blinkreaction/drude)

- Current Drupal 6 version 6.38
- Assumes a working drude environment
- Use case: Migrating D6 sites to D8

## Why do I need this. What does it do?

The Drude Project currently has example projects for Drupal 7 and Drupal 8 located [here](https://github.com/blinkreaction/drude), but Drupal 6 is missing. If you're involved in D6 to D7 migrations this project will allow you to easily configure and run multiple D6 projects side-by-side on your system with D7 and D8 projects. Through the magic that is Drude / Vagrant / Docker / VirtualBox all your environments are separate.

### The Nitty Gritty

The stock Drude environment only needs a couple of tweaks to run D6. Here's what we did:

#### Customizations to .drude/etc/php5/php.ini

Mbstring needed some tweaking. This was added:
```
mbstring.http_input = pass
mbstring.http_output = pass
mbstring.internal_encoding = pass
```
#### settings.local.php file added

A settings.local.php file was added, and code was added to settings.php to call it. In addition to the standard things that are done in the blinkreaction local settings sample file we tune down error_reporting and adjust the $db_url to use drude environment variables for the db and db credentials:

```
# in your PHP code:
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

$database =  getenv('DB_1_ENV_MYSQL_DATABASE');
$username =  getenv('DB_1_ENV_MYSQL_USER');
$password = getenv('DB_1_ENV_MYSQL_PASSWORD');
$host = getenv('DB_1_PORT_3306_TCP_ADDR');

$db_url = "mysql://$username:$password@$host/$database";
```

## Instructions - Create a New Clean Drupal 6 Site
Instructions for creating "my-drupal6-site.drude" on Windows using babun

####First get the files and get docker-compose.yml configured:

    cd /c/projects
    mkdir my-drupal7-site
    cd my-drupal7-site
    git clone https://github.com/davekopecek/drude-d6-starter.git .
    # Set the DOMAIN_NAME in docker-compose.yml Use your favorite editor or SED:
    sed -i 's/drude-d6-starter/my-drupal6-site/' docker-compose.yml

####Next add the domain to your local machine's HOSTS file:

    192.168.10.10   my-drupal6-site.drude

####Then - Fire up Drude 

    dsh up

####Finally - Install Drupal

Since drush won't site-install on Drupal 6 we've got to go old-school.  Point your browser to `http://your-drupal6-site.drush/install.php` and party like it's 2008

## Instructions - Pull an existing Drupal 6 site into Drude.

#### Setup

1. Clone the project, configure docker-compose.yml and add the domain to your hosts file using instructions above.
2. Remove the existing contents of /docroot and replace with your D6 project. You can cd to docroot and `git pull` your legacy project into /docroot 
3. Create /sites/default/files and copy existing files if needed
2. Copy /settings-setup/settings.local.php to /docroot/sites/default/settings.local.php
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
If you pulled your legacy site into /docroot you now have a git project in a git project. You may want to add /docroot to the .gitignore of the drude-d6-starter project. If you love pain and mental anquish you can do something with git submodules.  
 

