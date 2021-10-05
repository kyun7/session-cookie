<?php 

session_start();

// hapus session 
$_SESSION = []; 
session_unset();
session_destroy();


// hapus cookie 
setcookie('info', '', time() - 3600);
setcookie('key', '', time() - 3600);


// kembalikan user ke halaman login
header("Location:login.php");
exit;

 ?>