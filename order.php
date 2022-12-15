<?php
include "inc/head.php";
if(isset($_SESSION['user_data'])){
	

?>
<section class="sellitem" style="padding-top: 100px;">
<?php  
// Error bar include
include "inc/error-bar.php";
?>
<table>
<tr>
    <th>ID</th>
    <th>Seller</th>
    <th>Item</th>
    <th>Unit Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Date</th>
    <th>Time</th>
    <th>Edit</th>
    <th>Delete</th>

</tr>
<?php 

echo oderTable($_SESSION['user_data']['user_id'], $conn);

echo "</table>";
}else{
    $_SESSION['msg'] = "Please Login or Signup";
    header("Location: ../login.php?error");
}


?>



</section>
