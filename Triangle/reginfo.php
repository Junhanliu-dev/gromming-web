<?php  
$filename = 'test.xml';
session_start();
if(!isset($_SESSION['loggedin']))
{
	echo 'No Session';
    header("refresh:5;url=index.html");
    exit;
} 
else if (isset($_POST['submit'])) 
{
	if (strlen($_POST['editName']) != 0 && strlen($_POST['editHome']) != 0 && strlen($_POST['editAddress']) != 0 && strlen($_POST['editPhone']) != 0)
	{	  
		$getId = $_SESSION['loggedin'];
		$getName = $_POST['editName'];
		$getHome = $_POST['editHome'];
		$getAdr = $_POST['editAddress'];
		$getPhone = $_POST['editPhone'];
		
		$isRegst = false;
		
		$docRead = new DOMDocument();  
		$docRead->formatOutput = true;  
		$docRead->load($filename);
		
		$root = $docRead->getElementsByTagName( "Accounts" );
		$root = $root->item(0);
		
		$accounts = $docRead->getElementsByTagName( "Account" );
		$account;
		foreach( $accounts as $tempaccount )
		{
			$id = $tempaccount->getElementsByTagName( "Id" );
			$id = $id->item(0)->nodeValue;
			if ($id == $getId)
			{
				$account = $tempaccount;
				$isRegst = true;
				break;
			}
		}
		
		if( $isRegst )
		{
			
			$name = $docRead->createElement( "Name", $getName);
			$home = $docRead->createElement( "Home" , $getHome);
			$adress = $docRead->createElement( "Address" , $getAdr);
			$phone = $docRead->createElement( "Phone" , $getPhone);
			
			$account->appendChild($name);
			$account->appendChild($home);
			$account->appendChild($adress);
			$account->appendChild($phone);

			$root->appendChild($account);  
			
			$docRead->save($filename);
			
			$accType = $_SESSION['type'];
			
			if ($accType == "customer")
			{
				echo 'Register Information Success, please waiting in 5 sec';
				header("refresh:5;url=customerPage.html");
				exit;
			}
			else if ($accType == "grommer")
			{
				echo 'Register Information Success, please waiting in 5 sec';
				header("refresh:5;url=groomerPage.html");
				exit;
			}

		}
		else
		{
			echo 'Register Fail!!! please waiting in 5 sec';
			header("refresh:5;url=index.html");
			exit;
		}
		
	}
	else
	{
		echo 'Account information not correct! please waiting in 5 sec';
		header("refresh:5;url=RegiInfoPage.html");
		exit;
	}
}
else if (isset($_POST['skip'])) 
{
	$accType = $_SESSION['type'];
	if ($accType == "customer")
	{
		echo 'Skip Success, please waiting in 5 sec';
		header("refresh:5;url=customerPage.html");
		exit;
	}
	else if ($accType == "grommer")
	{
		echo 'Skip Success, please waiting in 5 sec';
		header("refresh:5;url=groomerPage.html");
		exit;
	}
}
?>