<?php
//AUTH OPTIONS//
/*type - ldap_ad (Active Directory), al (Access List - JSON encoded file with usernames), dl(Deny List - JSON encoded file with usernames), password_file (JSON encoded file with username / password hash), session (Use PHP sessions to only allow login session), admincheck (returns an admin flag if administrator is username) */
/* session, dl, and al(absence of username) take precedence over others. You should put these first. */
$types = array('password_file','session'); # Can be any of the allowed options or a group of them. Required.
$options['auths_location'] = ''; #path to authentication library file location. Default is '' or in the same directory as this file.

/* ldap_ad */
$options['ldap_ad_server'] = 'server.example.com'; #If using ldap_ad login this is the server to authenticate to. Required for ldap_ad.
$options['ldap_ad_port'] = 389; #Port to use for ldap_ad authentication. Default 389 if not specified.
$options['ldap_ad_domain'] = 'example.com'; #Domain name authenticating to. Required for ldap_ad.
$options['ldap_ad_data'] = array('cn', 'givenname'); #If using ldap_ad specify what data should be fetched from ad.
$options['ldap_ad_allowed_groups'] = array('CN=Allowed Group,OU=Goups,DC=example,DC=com'); #If using ldap_ad, specify groups allowed to log in. Can be multiple groups. Not required.
$options['ldap_ad_disallowed_groups'] = array('CN=Disallowed Group,OU=Goups,DC=example,DC=com'); #If using ldap_ad, specify groups not allowed to log in. Can be multiple groups. Not required

/* al */
$options['al_location'] = 'al.list'; #Location of file containing Access List. Can be relative or absolute path. Required for al.

/* dl */
$options['dl_location'] = 'dl.list'; #Location of file containing Deny List. Can be relative or absolute path. Required for dl.

/* password_file */
$options['password_file_location'] = 'users.list'; #Location of file containing user/password pairs. Can be relative or absolute path. Required for password_file.

/* session */
$options['noSessionTime'] = 0; #Do not put a time limit on the session login. Not recommended. 0 for false, any other value for true. Invalidates sessionTime.
$options['sessionTime'] = (10 * 60); #Number of seconds the session for a user will remain active. Default is (10 * 60) or ten minutes if not specified.
$options['sessionLibrary'] = 'session_lib.php'; #Optional session functions to use instead of default PHP sessions.

/* Password Salting and Hashing*/
$options['passwordSalt'] = '$at-least-14-characters!'; #A string to use for password salting. Recommended.
$options['hashFunction'] = 'md5'; #Specify the hashing function for passwords. Must return a hash value. Default is md5.

//LOG VIEWER OPTIONS//
/*
For simple log files add an entry like:
array('name'=>'<shortname>','description'=>'<Description>','form'=>array('log','<log location>'))
If you want to create a custom command use:
array('name'=>'<shortname>','description'=>'<Description>','form'=>array('<line command>'))
The <line command> is the command that will show a given amount of lines of whatever output you want. "<lines>" will be replaced by the user given amount of lines. If you include "<search>" in this command it will be replaced by a user given search. 
*/
$validTypes = array(
    array('name'=>'dns','description'=>'DNS','form'=>array('dig axfr example.com|grep -v TXT|tail -n <lines> |grep -i "<search>"')),
    array('name'=>'dnslog','description'=>'DNS Log','form'=>array('log','/var/log/bind.log')),
    array('name'=>'dhcp','description'=>'DHCP Log','form'=>array('log','/var/log/dhcp.log'))
);
//Define what times you want in refresh times
$refreshValues = array(1,5,10);
//Define what line counts you want - highest value is the most the server will allow.
$lineValues = array(10,50,100,1000);
//Text to put in the footer
$footer = 'Sample Footer Text - ';
?>
