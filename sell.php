<?php
include "inc/head.php";
if(isset($_SESSION['user_data'])){
	

?>

<section class="login">
<?php  
// Error bar include
include "inc/error-bar.php";
?>
    <form action="inc/action.php" method="post">
        <h2>Sell Product</h2>
        <div class="item">

            <input type="text" name="title" placeholder="Title" required autocomplete="off" <?php if(isset($_SESSION['sell_data'])){echo "value='" .$_SESSION['sell_data']['title'] . "'";}?>>
            <input type="text" name="price" placeholder="Price" required autocomplete="off" <?php if(isset($_SESSION['sell_data'])){echo "value='" .$_SESSION['sell_data']['price'] . "'";}?>>
            <input type="text" name="description" placeholder="Description" required autocomplete="off" <?php if(isset($_SESSION['sell_data'])){echo "value='" .$_SESSION['sell_data']['description'] . "'";}?>>
            <input type="number" name="quantity" placeholder="Quantity" required autocomplete="off" <?php if(isset($_SESSION['sell_data'])){echo "value='" .$_SESSION['sell_data']['quantity'] . "'";}?>>
            <select name="type" id="" required autocomplete="off" placeholder="Description">
                
                <?php echo productType($conn)['print_data']; ?>                
            </select>
        </div>
        <button type="submit" name="sell">Add Item</button>
    </form>
</section>

<section class="sellitem">

<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Price</th>
    <th>Description</th>
    <th>Quantity</th>
    <th>Type</th>
    <th>Date</th>
    <th>Time</th>
    <th>Edit</th>
    <th>Delete</th>

</tr>
<?php 

echo addItemTable($_SESSION['user_data']['user_id'], $conn);

echo "</table>";
}else{
    $_SESSION['msg'] = "Please Login or Signup";
    header("Location: ../login.php?error");
}


?>



</section>
