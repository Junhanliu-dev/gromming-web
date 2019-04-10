<?php  
session_start();
$loginFlag = false; 
if(isset($_SESSION['loggedin']))
{
	$accId = $_SESSION['loggedin'];  
	$accType = $_SESSION['type'];
	$loginFlag = true;
	echo "var accountId="."'$accId';";   
	echo "var accountType="."'$accType';";  
	echo "var loginFlag="."'$loginFlag';";   
}
else
{
	echo "var loginFlag="."'$loginFlag';";   
}
?>  