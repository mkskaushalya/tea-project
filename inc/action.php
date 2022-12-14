<?php
session_start();
include "connect.php";
include "functions.php";

// if(isset($_SESSION['user_id'])){
// 	header("Location: index.php?l=s");
// }

// print_r($_POST);


if(isset($_POST['login'])){
  // logout();
	$username = $_POST['username'];
	$password = $_POST['password'];
  // echo $uname." ".$password;
  $user_data = login($username, $password, $conn);
  if(isset($user_data['login'])){
    $_SESSION['user_data'] = $user_data;
    if($_SESSION['user_data']['login']){
      header("Location: ../index.php?login_sucess");
    }else{
      $_SESSION['msg'] = $user_data['msg'];
      header("Location: ../login.php?error=wc");
    }
  }else{
    $_SESSION['msg'] = $user_data['error'];
    echo $user_data['error'];
    header("Location: ../login.php?error=wc");
  }

}elseif(isset($_POST['signup'])){
  // echo "signup";
// ====================signup===============

  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
	$username = $_POST['username'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
	$password = $_POST['password'];
  $signup_data = signup($firstname, $lastname, $username, $email, $phone, $password, $conn);
  print_r($signup_data);
  $_SESSION['signup_data'] = $signup_data;
  if($signup_data['signup']){
    header("Location: ../login.php?registeration-success");
  }else{
    $_SESSION['msg'] = $signup_data['msg'];
    header("Location: ../signup.php?error");
  }
  
}elseif(isset($_POST['sell'])){
  // echo "sell";
// ====================signup===============

  $title = $_POST['title'];
  $price = $_POST['price'];
	$description = $_POST['description'];
  $quantity = $_POST['quantity'];
	$type = $_POST['type'];
  $userid = $_SESSION['user_data']['user_id'];
  $sell_data = sell($title, $price, $description, $quantity, $type, $userid, $conn);
  print_r($sell_data);
  $_SESSION['sell_data'] = $sell_data;
  if($sell_data['sell']){
    header("Location: ../sell.php?item-add-success");
  }else{
    $_SESSION['msg'] = $sell_data['msg'];
    header("Location: ../sell.php?error");
  }
  
}else{

  // header("Location: ../index.php?page=login&error=wk");
}

if(isset($_GET['logout'])){
  logout();
}

?>