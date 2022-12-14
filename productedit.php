<?php
include "inc/head.php";
if(isset($_SESSION['user_data'])){

if(isset($_POST['productedit'])){

    $productid = $_POST['productedit'];
    $userid = $_SESSION['user_data']['user_id'];
    $query = "SELECT * FROM product WHERE id=$productid AND userid=$userid LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result)	{
    if($result && mysqli_num_rows($result) > 0)	{
        $product_data = mysqli_fetch_assoc($result);    
    
        // print_r($product_data);
    ?>
    <section class="login">
    <?php  
    // Error bar include
    include "inc/error-bar.php";
    ?>
        <form action="inc/action.php" method="post">
            <h2>Edit Product</h2>
            <div class="item">
                <input type="text" name="title" placeholder="Title" required autocomplete="off" <?php echo "value='" .$product_data['title'] . "'";?>>
                <input type="text" name="price" placeholder="Price" required autocomplete="off" <?php echo "value='" .$product_data['price'] . "'";?>>
                <input type="text" name="description" placeholder="Description" required autocomplete="off" <?php echo "value='" .$product_data['description'] . "'";?>>
                <input type="number" name="quantity" placeholder="Quantity" required autocomplete="off" <?php echo "value='" .$product_data['quantity'] . "'";?>>
                <select name="type" id="" required autocomplete="off" placeholder="Description">                    
                    <?php echo productType($conn)['print_data']; ?>                
                </select>
            </div>
            <button type="submit" name="updateproduct" value="<?php echo $productid; ?>">Edit Item</button>
        </form>
    </section>
    
    
    
    
    <?php
    unset($_POST['update']);

    }else{
        echo array("error" => "Database Error");
    }
    }
}else{
    header('Location: '.$_SERVER['HTTP_REFERER']);

}
    ?>
    



<?php
}
?>