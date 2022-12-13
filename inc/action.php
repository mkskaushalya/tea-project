<?php
include "connect.php";
include "functions.php";
session_start();
// if(isset($_SESSION['user_id'])){
// 	header("Location: index.php?l=s");
// }

print_r($_POST);

if(isset($_POST['login'])){
  logout();
	$username = $_POST['lusername'];
	$password = $_POST['lpassword'];
  // echo $uname." ".$password;
  $user_data = login($username, $password, $conn);
  $_SESSION['user_data'] = $user_data;
  if($_SESSION['user_data']['login']){
     header("Location: ../index.php?page=account&login_sucess");
  }

}elseif(isset($_POST['register'])){
  // echo "register";
// ====================Register===============
	$username = $_POST['rusername'];
  $email = $_POST['remail'];
  $phone = $_POST['phone'];
	$password = $_POST['rpassword'];
  $OTPcode = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
  $register_data = register($username, $email, $phone, $password,$OTPcode, $conn);
  print_r($register_data);
  $_SESSION['register_data'] = $register_data;
  
}else{

  // header("Location: ../index.php?page=login&error=wk");
}

if(isset($_GET['logout'])){
  logout();
}

?>