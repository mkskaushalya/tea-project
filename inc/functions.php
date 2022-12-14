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
      header('Location: ../index.php');
    }else{
      header('Location: ../index.php');
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
  $query = "INSERT INTO product(userid,	title,	price,	description, quantity,	status,	type, image) VALUES('$userid', '$title', '$price', '$description', '$quantity',  1, $type, 'img/tea-leaf.jpg');";
  if ($conn->query($query) === TRUE) {//record added
    $msg = "New Item aded successfully";
    $sell = true;
  }else{
    $msg = "Database Error";
    $sell = false;
  }
  return array("query" => $query, "sell" => $sell, "title" => $title, "price" => $price, "description" =>  $description, "msg" => $msg,"quantity" => $quantity, "type" => $type);
}

function buy($sellerid, $userid, $productid, $quantity, $conn){
  $buy = null;
  $msg = null;
  $query = "INSERT INTO sell(sellerid, buyerid,	itemid, quantity,	status) VALUES('$sellerid', '$userid', '$productid', '$quantity',  1);";
  if ($conn->query($query) === TRUE) {//record added
    $msg = "Order Placed Successfull...";
    $buy = true;
  }else{
    $msg = "Database Error";
    $buy = false;
  }
  return array("query" => $query, "buy" => $buy, 'msg' => $msg);
}

function Product($type, $conn){  
  $query = "SELECT * FROM product WHERE type='$type' AND status=1";
  $query_run = mysqli_query($conn, $query);
  $print_data = "";
  if(mysqli_num_rows($query_run) > 0){
    $record = false;
    foreach($query_run as $items){
        $print_data .='<div class="card"><form action="buy.php" method="post"><h3>'. $items['title'] .'</h3>';
        $print_data .='<div class="image">';
        $print_data .='<img src="'. $items['image'] .'" alt="">';
        $print_data .='</div>';
        $print_data .='<div class="price">';
        $print_data .='<span>Rs. '. $items['price'] .'</span>';
        $print_data .='</div>';
        $print_data .='<div class="quantity">';
        $print_data .='<label for="quantity">Quantity : </label>';
        $print_data .='<input type="number" name="quantity" id="quantity" min="1" value="1" max="'. $items['quantity'] .'" required>';
        $print_data .='</div>';
        $print_data .='<p>Type: '. $items['type'] .'<br>';
        $print_data .= $items['description'].'</p>';
        $print_data .='<button type="submit" name="buy" value="'. $items['id'] .'">Buy</button>';
        $print_data .='</form>';
        $print_data .='</div>';
        $record = true;
    }
  }else{
    $record = false;
    $print_data = "Items not available.";
  }
  return array("record" => $record, 'print_data' => $print_data);
}


function addItemTable($userid, $conn){
  $query = "SELECT * FROM product WHERE userid=$userid AND status=1 ORDER BY datetime DESC";
  $query_run = mysqli_query($conn, $query);
  $tbody = "";
  if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $items){
      $id = $items['id'];
      $title = $items['title'];
      $price = $items['price'];
      $description = $items['description'];
      $quantity = $items['quantity'];
      $type = $items['type'];
      $query2 = "SELECT * FROM producttype WHERE id='$type' LIMIT 1";
      $result2 = mysqli_query($conn, $query2);
      if($result2)	{
        if($result2 && mysqli_num_rows($result2) > 0)	{
          $userdata = mysqli_fetch_assoc($result2);
          $productname = $userdata['name'];
          $image = $userdata['image'];
        }
      }
      $adedtime = strtotime($items['datetime']);
      $tbody .= '<tr>';
      $tbody .= '<td>'.$id.'</td><td>'.$title.'</td><td>'.$price.'</td><td>'.$description.'</td><td>'.$quantity.'</td><td>'.$productname.'</td><td>'.date("Y-m-d", $adedtime).'</td><td>'.date("H:i:s", $adedtime).'</td><td><form action="productedit.php" method="post"><button type="submit" class="edit" value="'.$id.'" name="productedit">Edit</button></form></td><td><form action="inc/action.php" method="post" onsubmit="return confirm ('."'Are you sure?'".')"><button class="delbutton" type="submit" value="'.$id.'" name="productdelete">Delete</button></form></td>';
      $tbody .= '</tr>';
  
    }
  return $tbody;

  }else{
    return "<tr><td colspan='10'>No Data.</td></tr>";
}
}

function oderTable($userid, $conn){
  $query = "SELECT * FROM sell WHERE buyerid=$userid AND status=1 ORDER BY date DESC";
  $query_run = mysqli_query($conn, $query);
  $tbody = "";
  if(mysqli_num_rows($query_run) > 0){
    foreach($query_run as $items){
      $id = $items['id'];
      $sellerid = $items['sellerid'];
      $query2 = "SELECT * FROM users WHERE id='$sellerid' LIMIT 1";
      $result2 = mysqli_query($conn, $query2);
      if($result2)	{
          if($result2 && mysqli_num_rows($result2) > 0)	{
          $userdata = mysqli_fetch_assoc($result2);
          $sellername = $userdata['firstname']." ".$userdata['lastname'];
          }else{
            $sellername = "Anonymous";
          }
      }else{
        $sellername = "Database Error";
      }

      $productid = $items['itemid'];
      $query3 = "SELECT * FROM product WHERE id='$productid' LIMIT 1";
      $result3 = mysqli_query($conn, $query3);
      if($result3)	{
          if($result3 && mysqli_num_rows($result3) > 0)	{
          $productdata = mysqli_fetch_assoc($result3);
          $producttitle = $productdata['title'];
          $type = $productdata['type'];
          $query4 = "SELECT * FROM producttype WHERE id='$type' LIMIT 1";
          $result4 = mysqli_query($conn, $query4);
          if($result4)	{
            if($result4 && mysqli_num_rows($result4) > 0)	{
              $userdata = mysqli_fetch_assoc($result4);
              $productname = $userdata['name'];
              $image = $userdata['image'];
            }else{
              $productname = "No Product Name";
            }
          }else{
            $productname = "Database Error";
          }

          }else{
            $producttitle = "No Title";
          }
      }else{
        $sellername = "Database Error";
      }
      $quantity = $items['quantity'];
      $price = $productdata['price'] * $items['quantity'];      
      $adedtime = strtotime($items['date']);
      $tbody .= '<tr>';
      $tbody .= '<td>'.$id.'</td><td>'.$sellername.'</td><td>'.$producttitle.'</td><td>'.$productdata['price'].'</td><td>'.$quantity.'</td><td>'.$price.'</td><td>'.date("Y-m-d", $adedtime).'</td><td>'.date("H:i:s", $adedtime).'</td><td><form action="inc/action.php" method="post" onsubmit="return confirm ('."'Are you sure?'".')"><button class="delbutton" type="submit" value="'.$id.'" name="oderdelete">Delete</button></form></td>';
      $tbody .= '</tr>';
  
    }
  return $tbody;

  }else{
    return "<tr><td colspan='9'>No order data found...</td></tr>";
}
}





function deleteProduct($productid, $conn){
    $sql = "UPDATE product SET status=0, removeddate=NOW() WHERE id='$productid' LIMIT 1";
    if ($conn->query($sql) === TRUE) {
      return true;
    }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


function updateProduct($productid, $title, $price, $description, $quantity, $type, $conn){
  $sql = "UPDATE product SET title='$title', price='$price', description='$description', quantity='$quantity', type='$type' WHERE id='$productid' LIMIT 1";
  if ($conn->query($sql) === TRUE) {
    return true;
  }
  else {
      return "Error: " . $sql . "<br>" . $conn->error;
      header('Location: '.$_SERVER['HTTP_REFERER']);
  }
}






function deleteOrder($oderid, $conn){
  $sql = "UPDATE sell SET status=0, removed_date=NOW() WHERE id='$oderid' LIMIT 1";
  if ($conn->query($sql) === TRUE) {
    return true;
  }
  else {
      return "Error: " . $sql . "<br>" . $conn->error;
      header('Location: '.$_SERVER['HTTP_REFERER']);
  }
}

?>
