<?php
include "inc/head.php";
if(isset($_SESSION['user_data'])){
	
if(isset($_POST['buy'])){
    $product_id = $_POST['buy'];
    $query = "SELECT * FROM product WHERE id='$product_id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){//check entered value in database
        if($result && mysqli_num_rows($result) > 0)	{//have data
            $product_data = mysqli_fetch_assoc($result);
            $type = $product_data['type'];
            $query2 = "SELECT * FROM producttype WHERE id='$type' LIMIT 1";
            $result2 = mysqli_query($conn, $query2);
            if($result2)	{
                if($result2 && mysqli_num_rows($result2) > 0)	{
                $userdata = mysqli_fetch_assoc($result2);
                $productname = $userdata['name'];
                $image = $userdata['image'];
                }
      }
          ?>

          <section class="buy">
          <?php  
// Error bar include
include "inc/error-bar.php";
?>
            <form action="inc/action.php" method="post">
                <h2>Buy Product</h2>
                <input type="hidden" name="sellerid" value="<?php echo  $product_data['userid']; ?>">
                <table>                    
                    <tr><th>Product Name</th><td><?php echo  $product_data['title']; ?></td></tr>
                    <tr><th>Product Type</th><td><?php echo  $productname; ?></td></tr>
                    <tr><th>Description</th><td><?php echo  $product_data['description']; ?></td></tr>
                    <tr><th>Unit Price</th><td><?php echo  "Rs. ".$product_data['price']."/="; ?></td></tr>
                    <tr><th>Quantity</th><td><input type="hidden" name="quantity" value="<?php echo  $_POST['quantity']; ?>"><?php echo  $_POST['quantity']; ?></td></tr>
                    <tr><th>Total</th><td><?php echo  "Rs. ".$product_data['price']*$_POST['quantity']."/="; ?></td></tr>
                    <tr><td colspan="2" style="border-top:none;"><button type="submit" name="placeoder" value="<?php echo  $product_data['id']; ?>">Place Order</button></td></tr>
                </table>
                
                
            </form>
          </section>


<?php
        }
else{
            echo "No Product Found!";
        }
    }else{
        echo "Database Error";
    }
    
    
}else{
    ?><section class="buy"><?php 
    // Error bar include
include "inc/error-bar.php";

        ?>  <form action="index.php" style="border: none;">
                <table>                    
                    <tr><td colspan="2" style="border-top:none;"><a href="index.php"><button style="background-color:#7c7;">Go Home Page</button></a></td></tr>
                </table></form>
       </section><?php 

}

}else{
    $_SESSION['msg'] = "Please Login or Signup";
    header("Location: ../login.php?error");
}

?>