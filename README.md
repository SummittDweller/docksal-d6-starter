# drude-d6-starter
Create a Drupal 6 environment in Drude https://github.com/blinkreaction/drude

- Current Drupal 6 environment 6.38
- Assumes a working drude environment

## Instructions - Clean Site
Instructions for creating "my-drupal6-site" on Windows using babun

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
