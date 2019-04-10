<?php
session_start();
session_destroy();
echo 'Logout Success, please waiting in 5 sec';
header("refresh:5;url=index.html");
exit;
?>