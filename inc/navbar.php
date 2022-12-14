<nav>
    <div class="left">
        <div class="logo">Tea</div>
        <div class="brand">Management System</div>
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