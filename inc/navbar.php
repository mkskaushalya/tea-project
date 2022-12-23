<nav>
    <div class="left">
        <div class="logo"><img src="img/logo.png" alt=""></div>
        <div class="brand">Tea Management System</div>
    </div>
    <div class="right">
        <ul>
            <a href="index.php">
                <li>Home</li>
            </a>
            <a href="#">
                <li>About</li>
            </a>
            <a href="#">
                <li>Contact</li>
            </a>
            <?php
            if(isset($_SESSION['user_data'])){
                ?>
            <a href="sell.php">
                <li>Sell</li>
            </a>
            <a href="order.php">
                <li>Orders</li>
            </a>
            <a href="profile.php">
                <li><?php echo $_SESSION['user_data']['firstname'] ?></li>
            </a>
            <a href="inc/action.php?logout">
                <li>Logout</li>
            </a>
            <?php
            }else{
            ?>
            <a href="login.php">
                <li>Login</li>
            </a>
            <a href="signup.php">
                <li>Signup</li>
            </a>
            <?php }
            ?>
            
        </ul>
    </div>
</nav>