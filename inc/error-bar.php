<?php
if(isset($_SESSION['user_data']['msg']) && $_SESSION['user_data']['msg'] != null){
?>
<p class="errorbar">111<?php echo $_SESSION['user_data']['msg']; ?></p>

<?php
unset($_SESSION['user_data']['msg']);

}elseif(isset($_SESSION['msg']) && $_SESSION['msg'] != null){
?>   
<p class="errorbar"><?php echo $_SESSION['msg']; ?></p>
<?php

unset($_SESSION['msg']);


}
?>

