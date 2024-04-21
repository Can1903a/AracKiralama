<?php
session_start();
session_destroy();
header("Location: /AracKiralama/index.php");
exit();
?>