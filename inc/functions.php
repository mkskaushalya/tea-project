<?php

function login($username, $password, $conn) {
      //read from database
      $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if($result)	{
        if($result && mysqli_num_rows($result) > 0)	{
          $user_data = mysqli_fetch_assoc($result);
          // echo $user_data['username'];
          // echo $user_data['password'];
          // echo $user_data['id'];
          if($user_data['password'] === $password){
            // session_start();
            // $_SESSION['user_id'] = $user_data['user_id'];
            // $user_id = $user_data['id'];
            // echo "Login Success!";
            return array("login" => true, "user_id" => $user_data['id'], "username" => $user_data['username'], "email" => $user_data['email'], "phone" => $user_data['phone'],"usertype" => $user_data['usertype'], "reg_date" => $user_data['reg_date'], "last_login" => $user_data['last_login'], 'status'=>$user_data['status']);
            // header("Location: ../index.php?page=login&login_sucess");

            
          }else{
            header("Location: ../index.php?page=login&error=wc");
          }
        }else{
        header("Location: ../index.php?page=login&error=wc");


        }
      }      
}

function logout(){
  if (isset($_SESSION['user_data'])){
    session_destroy();
      foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
      }
      header("location: ../index.php");
    }else{
      header("location: ../index.php");
    }
}

function register($username, $email, $phone, $password, $OTPcode, $conn){
  $register = null;
  $errormsg = null;
  $msg = null;
  $query = "SELECT * FROM users WHERE (email='$email' OR username='$username' OR phone='$phone')";
	$result = mysqli_query($conn, $query);
  if($result){//check entered value in database
    if($result && mysqli_num_rows($result) > 0)	{//have account
      $user_data = mysqli_fetch_assoc($result);
      if ($user_data['phone'] == $phone) {
        $errormsg .= "-"."That phone number taken. Try another."."<br>";
      }
      if ($user_data['email'] == $email) {
        $errormsg .= "-"."That email address taken. Try another."."<br>";
      }
      if ($user_data['username'] == $username) {
        $errormsg .= "-"."That username taken. Try another."."<br>";
      }
      $register = false;
    }else{
      $sqlq = "INSERT INTO users (username, email, phone, password, OTP, status) VALUES('$username', '$email', '$phone', '$password', '$OTPcode', 0);";
      // echo $sqlq;
      if ($conn->query($sqlq) === TRUE) {//record added
        $msg = "New user record created successfully<br>Registeration Successfull!..<br>Now you can login in our system";
        $register = true;

      }else{
        $errormsg = "No record found...<br>";
        $register = false;
      }

    }
  }else{
    $msg = "Database Error";
    $register = false;

  }

  return array("status" => true, "register" =>  $register, "errormsg" => $errormsg, "msg" => $msg,"username" => $username, "email" => $email, "phone" => $phone, 'OTP' => $OTPcode);
}




?>