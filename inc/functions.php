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
            return array("error" => "Wrong Credentials!");
          }
        }else{
          return array("error" => "Wrong Credentials!");
        }
      }
}

function logout(){
  if (isset($_SESSION['user_data'])){
    session_destroy();
      foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
      }
      header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
      header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}

function signup($firstname, $lastname, $username, $email, $phone, $password, $conn){
  $signup = null;
  $msg = null;
  $query = "SELECT * FROM users WHERE (email='$email' OR username='$username' OR phone='$phone')";
	$result = mysqli_query($conn, $query);
  if($result){//check entered value in database
    if($result && mysqli_num_rows($result) > 0)	{//have account
      $user_data = mysqli_fetch_assoc($result);
      if ($user_data['phone'] == $phone) {
        $msg .= "-"."That phone number taken. Try another."."<br>";
      }
      if ($user_data['email'] == $email) {
        $msg .= "-"."That email address taken. Try another."."<br>";
      }
      if ($user_data['username'] == $username) {
        $msg .= "-"."That username taken. Try another."."<br>";
      }
      $signup = false;
    }else{
      $sqlq = "INSERT INTO users(firstname, lastname, username, email, phone, password, status) VALUES('$firstname', '$lastname', '$username', '$email', '$phone', '$password', 1);";
      // echo $sqlq;
      if ($conn->query($sqlq) === TRUE) {//record added
        $msg = "New user record created successfully<br>Registeration Successfull!..<br>Now you can login in our system";
        $signup = true;
      }else{
        $msg = "No record found...<br>";
        $signup = false;
      }

    }
  }else{
    $msg = "Database Error";
    $signup = false;

  }
  return array("firstname" => $firstname, "lastname" => $lastname, "status" => true, "signup" =>  $signup, "msg" => $msg,"username" => $username, "email" => $email, "phone" => $phone);
}

function productType($conn){
  
  $query = "SELECT * FROM producttype";
  $query_run = mysqli_query($conn, $query);
  $print_data = "";    
  if(mysqli_num_rows($query_run) > 0){
    $record = false;
    foreach($query_run as $items){
        $print_data .='<option value="'. $items['id'] .'">';
        $print_data .= $items['name'];
        $print_data .='</option>';
        $record = true;
    }
  }
  return array("record" => $record, 'print_data' => $print_data);
}


function sell($title, $price, $description, $quantity, $type, $userid, $conn){
  $sell = null;
  $msg = null;
  $query = "INSERT INTO users(userid,	title,	price,	description, quantity,	status,	type) VALUES('$userid', '$title', '$price', '$description', '$quantity',  1, $type);";
      // echo $sqlq;
      if ($conn->query($sqlq) === TRUE) {//record added
        $msg = "New user record created successfully<br>Registeration Successfull!..<br>Now you can login in our system";
        $signup = true;
      }else{
        $msg = "No record found...<br>";
        $signup = false;
      }

    }
  }else{
    $msg = "Database Error";
    $signup = false;

  }
  return array("firstname" => $firstname, "lastname" => $lastname, "status" => true, "signup" =>  $signup, "msg" => $msg,"username" => $username, "email" => $email, "phone" => $phone);
}
?>