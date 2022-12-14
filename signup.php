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
        <h2>Signup</h2>
        <div class="item">
            <input type="text" name="firstname" placeholder="First Name" required autocomplete="off" <?php if(isset($_SESSION['signup_data'])){echo "value='" .$_SESSION['signup_data']['firstname'] . "'";}?>>
            <input type="text" name="lastname" placeholder="Last Name" required autocomplete="off" <?php if(isset($_SESSION['signup_data'])){echo "value='" .$_SESSION['signup_data']['lastname'] . "'";}?>>
            <input type="email" name="email" placeholder="Email" required autocomplete="off" <?php if(isset($_SESSION['signup_data'])){echo "value='" .$_SESSION['signup_data']['email'] . "'";}?>>
            <input type="tel" name="phone" placeholder="Phone Number" required autocomplete="off" <?php if(isset($_SESSION['signup_data'])){echo "value='" .$_SESSION['signup_data']['phone'] . "'";}?>>
            <input type="text" name="username" placeholder="Username" required autocomplete="off" <?php if(isset($_SESSION['signup_data'])){echo "value='" .$_SESSION['signup_data']['username'] . "'";}?>>
            <input type="password" name="password" placeholder="Password" required autocomplete="off">
        </div>
        <button type="submit" name="signup">Signup</button>
    </form>
</section>




<?php

?>

