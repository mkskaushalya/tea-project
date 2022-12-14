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
        <h2>Login</h2>
        <div class="item">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required autocomplete="off">
        </div>
        <button type="submit" name="login">Login</button>
    </form>

</section>




<?php

?>

