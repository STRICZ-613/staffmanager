<?php
session_start();
session_destroy();
header('Location: /staffmanager/auth/login.php');
exit();
?>