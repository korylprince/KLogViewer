<?php
//Make sure all parameters are set.
if (!isset($_POST['type']) or !isset($_POST['search']) or !isset($_POST['lines']) or !isset($_POST['sessionID'])) {
    echo '{"Parameters are wrong.",0,0}';
    return 1;
}
//Get sessionID from post and authenticate
$options['sessionID'] = $_POST['sessionID'];
require_once('options.php');
include('authlib.php');
$login = authenticate(null,null,$types,$options);
//echo json_encode($login);return 0;//debug
//If user does not authenticate send JSON that says so
if($login['Login'] != "True"){
    echo '{"Login":"User not Authenticated."}';
    return 0;
}
//Array for logs you wish to show
$validTypes = array(
    # type:[all command, given lines command]
    'dns'=>array('dig axfr bullardisd.net|grep -v TXT|grep -i "<search>"','dig axfr bullardisd.net|grep -v TXT|tail -n <lines> |grep -i "<search>"'),
    'dnslog'=>array('cat /var/log/bind.log|grep -i "<search>"|sed -n \'1!G;h;$p\'','tail -n <lines> /var/log/bind.log |grep -i "<search>"|sed -n \'1!G;h;$p\''),
    'dhcp'=>array('cat /var/log/dhcp.log|grep -i "<search>"|sed -n \'1!G;h;$p\'','tail -n <lines> /var/log/dhcp.log |grep -i "<search>"|sed -n \'1!G;h;$p\'')
);

//Note: tail specifies the number of lines, grep does the searching (-i makes it case insensitve and -v means everything but - I didn't want TXT entries showing up), and the sed command reverses the text (so that newest entries are at the top)

//Function that does the heavy lifting
function showLog($type,$search,$lines,$validTypes) {
    //Make sure lines is all or actually a number
    if ($lines != 'all' and !is_numeric($lines)) {
        echo '{"Parameters are wrong.",0,0}';
        return 1;
    }
    //Make sure type is one that really exists
    if (array_key_exists($type,$validTypes)) {
        if ($type == 'all') {
            //If all use the first command and only search for <search>
            $cmd = str_replace('<search>',escapeshellcmd($search),$validTypes[$type][0]);
        }
        else {
            //If lines are specified use second command and search for <search> and <lines>
            $cmd = str_replace('<search>',escapeshellcmd($search),$validTypes[$type][1]);
            $cmd = str_replace('<lines>',$lines,$cmd);
        }
    }
    //If they try some strange parameters
    else {
        echo '{"Parameters are wrong.",0,0}';
        return 1;
    }
    //Execute the command and get the return
    $text = shell_exec($cmd);
    //If search was given then encase the search with spans. Find the line and possibly the search counts.
    if ($search != '') {
        $text = str_ireplace($search,'<span class="searched">'.$search.'</span>',$text);
        echo json_encode(array($text,count(preg_split('/\n|\r/', trim($text))),substr_count($text, $search)));
    }
    else {
        echo json_encode(array($text,count(preg_split('/\n|\r/', trim($text))),0));
    }
}
//Actually run the function.
showLog($_POST['type'],$_POST['search'],$_POST['lines'],$validTypes);
?>
