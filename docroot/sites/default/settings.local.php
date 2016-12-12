<?php
# in your PHP code:
# ini_set('display_errors', '0');     # don't show any errors...
# error_reporting(E_ALL | E_STRICT);  # ...but do log them

ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 'Off');

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

$conf['securepages_enable'] = 0;


