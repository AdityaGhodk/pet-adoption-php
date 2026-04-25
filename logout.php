<?php
session_start();
session_destroy();
header('Location: /pet-adoption/login.php');
exit;
?>
