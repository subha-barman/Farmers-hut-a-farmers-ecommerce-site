<?php

session_start();

session_unset();

session_destroy();

// header("location:../BuyerPortal2/bhome.php");
header("location:../index.php");

exit();

?>