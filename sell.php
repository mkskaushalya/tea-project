<?php
include "inc/head.php";
if(isset($_SESSION['user_data'])){
	header("Location: index.php?msg=already-logged");
}
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




<?php 

?>

