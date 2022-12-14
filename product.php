<?php
include "inc/head.php";
?>

<section class="product" style="padding-top:100px;">

<?php

echo Product(1, $conn)['print_data'];

?>

</section>