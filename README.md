# drude-d6-starter
Create a Drupal 6 site in Drude (https://github.com/blinkreaction/drude)

Use case: Migrating D6 sites to D8

- Current Drupal 6 version 6.38
- Assumes a working drude environment

## Instructions - Clean Site
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
2. Remove the existing contents of /docroot and replace with your D6 project. You can cd to docroot ant `git pull` 
3. Create /sites/default/files and copy existing files if needed
2. Copy /settings-setup/settings.local.php to /docroot/sites/default/settings.local.php
3. Edit your settings.php file & add this to the end:


    $local_conf_file_path = __DIR__ . '/settings.local.php';
    if (file_exists($local_conf_file_path)) {
     require($local_conf_file_path);
    }

 
You should now be able to `dsh up` and install drupal as above. 
 
#### Getting the legacy site's database 

Current use case uses backupmigrate module, install & enable module on local site. Backup existing site -> Download -> Restore on local

 

