<?php
  //Sample Login Script
  if (isset($_POST['options'])) {
      if (in_array('sessionLogout', $_POST['options'])) {
          $options['sessionLogout'] = true;
      }
  }
  //sessionLogout is a special option that will deauthenticate the sessionID
  if (isset($_POST['sessionID'])) {
      $options['sessionID'] = $_POST['sessionID'];
  }
  //SessionID is a special option that will allow login with the correct sessionID
  if (isset($options['sessionLogout']) || isset($_POST['sessionID'])) {
      $username = $password = null;
  } else {
      if (!isset($_POST['username'])) {
          dieWithError('username does not exist!', 2);
      }
      if (!isset($_POST['password'])) {
          dieWithError('password does not exist!', 3);
      }
      $username = $_POST['username'];
      $password = $_POST['password'];
  }
  require_once('options.php');
  include('authlib.php');
  $login = authenticate($username, $password, $types, $options);
  echo json_encode($login);
  return 1;
  function dieWithError($string, $errorCode)
  {
      $returnArray = array('login' => 'Error', 'errorCode' => $errorCode);
      echo json_encode($returnArray);
      die("");
  }
?>
