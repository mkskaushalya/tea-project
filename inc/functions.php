<?php
function login($username, $password, $conn) {
      //read from database
      $query = "SELECT * FROM users WHERE username='$username' OR email='$username' OR phone='$username' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if($result)	{
        if($result && mysqli_num_rows($result) > 0)	{
          $user_data = mysqli_fetch_assoc($result);
          if($user_data['password'] === $password){
            return array("login" => true, "user_id" => $user_data['id'], "firstname" => $user_data['firstname'], "lastname" => $user_data['lastname'], "username" => $user_data['username'], "email" => $user_data['email'], "phone" => $user_data['phone'],"usertype" => $user_data['usertype'], "reg_date" => $user_data['registration'], "last_login" => $user_data['lastlogin'], 'status'=>$user_data['status']);
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

function signup($firstname, $lastname, $username, $email, $phone, $password, $conn){
  $signup = null;
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
      $signup = false;
    }else{
      $sqlq = "INSERT INTO users(firstname, lastname, username, email, phone, password, status) VALUES('$firstname', '$lastname', '$username', '$email', '$phone', '$password', 1);";
      // echo $sqlq;
      if ($conn->query($sqlq) === TRUE) {//record added
        $msg = "New user record created successfully<br>Registeration Successfull!..<br>Now you can login in our system";
        $signup = true;

      }else{
        $errormsg = "No record found...<br>";
        $signup = false;
      }

    }
  }else{
    $msg = "Database Error";
    $signup = false;

  }
  return array("status" => true, "signup" =>  $signup, "errormsg" => $errormsg, "msg" => $msg,"username" => $username, "email" => $email, "phone" => $phone);
}




?>