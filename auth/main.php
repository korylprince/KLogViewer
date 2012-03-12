<?php
//Make sure that either logout or sessionID is set. Deletes cookie and forwards to index
if(!isset($_COOKIE['sessionID']) or isset($_GET['logout'])) {
    $cookiepath = explode('/auth',$_SERVER['REQUEST_URI']);
    setcookie('logout', True, time()+3600,$cookiepath[0]);
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=../">';
    return 0;
}
else {
    //Get sessionID from cookie
    $options['sessionID'] = $_COOKIE['sessionID'];
}
//Call library
require('options.php');
require('authlib.php');
$login = authenticate(null,null,$types,$options);
//echo json_encode($login);return 0;//debug
//If user does not authenticate delete cookie and forward to index
if($login['Login'] != "True"){
    $cookiepath = explode('/auth',$_SERVER['REQUEST_URI']);
    setcookie('logout', True, time()+3600,$cookiepath[0]);
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=../">';
    return 0;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo shell_exec('hostname -f'); ?> - Logs</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="../list.js"></script>
        <script type="text/javascript" src="../jquery.cookie.js"></script>
        <link href="../main.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="topform">
            <select id="logselect"><?php
foreach ($validTypes as $validType) {
    echo '<option value="'.$validType['name'].'">'.$validType['description'].'</option>';
}
?></select><div id="ajaxloader"><img src="../ajax.gif" alt="Loading..." /></div>
            Search: <input id="searchtext" type="text"  onkeypress="if(event.keyCode==13){$('#searchsubmit').trigger('click');}" /><button id="searchsubmit">Submit</button>
            Lines: <select id="lines"><?php
$key = $lineValues['default'];
foreach ($lineValues as $value) {
    if ($value == $key) {
        echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
    }
    else {
        echo '<option value="'.$value.'">'.$value.'</option>';
    }
}
?></select>
            <span id="autotext" title="Click to toggle AutoRefresh">AutoRefresh:</span> <select id="autoselect"><?php
$key = $refreshValues['default'];
foreach ($refreshValues as $value) {
    if ($value == $key) {
        echo '<option value="'.$value.'" selected="selected">'.$value.' sec</option>';
    }
    else {
        echo '<option value="'.$value.'">'.$value.' sec</option>';
    }
}
?></select>
            <button id="logoutbutton">Logout</button>
        </div>
        <pre id="content"></pre>
        <div id="footer">
            <span id="linenumber"></span><span id="info"><?php echo $footer.shell_exec('hostname -f'); ?></span><span id="searchnumber"></span>
        </div>
    </body>
</html>
