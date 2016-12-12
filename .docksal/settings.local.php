<?php

#######################
# Add this to the end of your settings.php
# and copy this file to /site/default
#
# Load local settings file if it exists.
# $local_conf_file_path = __DIR__ . '/settings.local.php';
# if (file_exists($local_conf_file_path)) {
#   require($local_conf_file_path);
# }
########################


# in your PHP code:
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

# Docker DB connection settings.
$db_url = "mysql://user:user@db/default";

# File system settings.
$conf['file_temporary_path'] = '/tmp';
# Workaround for permission issues with NFS shares in Vagrant
$conf['file_chmod_directory'] = 0777;
$conf['file_chmod_file'] = 0666;

# Reverse proxy configuration (Drude's vhost-proxy)
$conf['reverse_proxy'] = TRUE;
$conf['reverse_proxy_addresses'] = array($_SERVER['REMOTE_ADDR']);
// HTTPS behind reverse-proxy
if (
  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' &&
  !empty($conf['reverse_proxy']) && in_array($_SERVER['REMOTE_ADDR'], $conf['reverse_proxy_addresses'])
) {
  $_SERVER['HTTPS'] = 'on';
  // This is hardcoded because there is no header specifying the original port.
  $_SERVER['SERVER_PORT'] = 443;
}
