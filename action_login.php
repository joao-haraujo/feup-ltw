<?php
session_start();

include_once('database/connection.php');
include_once('database/get_users.php');

if(userExists($_POST['uname'],$_POST['psw'])){
  $_SESSION['loggedin'] = true;
  echo 'logou';
}
else{
  echo 'n logou';
}
  // header('Location: HomePage.php');
 ?>