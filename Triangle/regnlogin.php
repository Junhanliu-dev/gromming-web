<?php  
$filename = 'test.xml';
session_start();
if(isset($_SESSION['loggedin']))
{
    header("Location:index.html");
    exit;
}    
else if (isset($_POST['register']) && isset($_POST['email']) != 0 && isset($_POST['password']) != 0 && isset($_POST['userType']) != 0) 
{
	if (strlen($_POST['email']) != 0 && strlen($_POST['password']) != 0 && strlen($_POST['userType']) != 0)
	{	  
		$getEmail = $_POST['email'];
		$getPassword = $_POST['password'];
		$getUserType = $_POST['userType'];
		if (!file_exists($filename)) 
		{
			$dom = new DOMDocument('1.0', 'UTF-8');  
			$dom->formatOutput = true;  
			$rootelement = $dom->createElement( "Accounts" );  
			$account = $dom->createElement( "Account" ); 
			$id = $dom->createElement( "Id" , "0"); 
			$type = $dom->createElement( "Type", $getUserType);
			$email = $dom->createElement( "Email" , $getEmail);
			$password = $dom->createElement( "Password" , $getPassword);
		
			$account->appendChild($id);
			$account->appendChild($type);
			$account->appendChild($email);
			$account->appendChild($password);
			$rootelement->appendChild($account);  
			
			$dom->appendChild($rootelement);  

			$dom->save($filename);
			
			echo 'Register Success, please waiting in 5 sec';
			$_SESSION['loggedin'] = 0;
			$_SESSION['type'] = $getUserType;
			header("refresh:5;url=RegiInfoPage.html");
			exit;
		}
		else 
		{
			$isRegst = false;
			
			$docRead = new DOMDocument();  
			$docRead->formatOutput = true;  
			$docRead->load($filename);
			
			$root = $docRead->getElementsByTagName( "Accounts" );
			$root = $root->item(0);
			
			$accounts = $docRead->getElementsByTagName( "Account" );
						
			foreach( $accounts as $account )
			{
				$email = $account->getElementsByTagName( "Email" );
				$email = $email->item(0)->nodeValue;
				if ($email == $getEmail)
				{
					echo 'Email Already Used!!!';
					$isRegst = true;
					break;
				}
			}
			
			if( !$isRegst )
			{
				$currentId = count($accounts);
				
				$account = $docRead->createElement( "Account" ); 
				$id = $docRead->createElement( "Id" , $currentId); 
				$type = $docRead->createElement( "Type", $getUserType);
				$email = $docRead->createElement( "Email" , $getEmail);
				$password = $docRead->createElement( "Password" , $getPassword);
				
				$account->appendChild($id);
				$account->appendChild($type);
				$account->appendChild($email);
				$account->appendChild($password);
				$root->appendChild($account);  
				
				$docRead->save($filename);
				
				$_SESSION['loggedin'] = $currentId;
				$_SESSION['type'] = $getUserType;
				echo 'Register Success, please waiting in 5 sec';
				header("refresh:5;url=RegiInfoPage.html");
				exit;
			}
			else
			{
				echo 'Register Fail!!!';
				header("refresh:5;url=index.html");
				exit;
			}
		}
	}
	else
	{
		echo 'Account information not correct! please waiting in 5 sec';
		header("refresh:5;url=index.html");
		exit;
	}
}
else if (isset($_POST['confirm']) && isset($_POST['email']) != 0 && isset($_POST['password']) != 0 && isset($_POST['userType']) != 0) 
{
	if (strlen($_POST['email']) != 0 && strlen($_POST['password']) != 0 && strlen($_POST['userType']) != 0)
	{
		$getEmail = $_POST['email'];
		$getPassword = $_POST['password'];
		$getUserType = $_POST['userType'];
		$id;
		if (file_exists($filename)) 
		{
			$isLogin = false;
			$docRead = new DOMDocument();  
			$docRead->load($filename);
			

			$root = $docRead->getElementsByTagName( "Accounts" );
			$root = $root->item(0);
			
			$accounts = $docRead->getElementsByTagName( "Account" );
			
			//new change
			foreach( $accounts as $account )
			{
				$email = $account->getElementsByTagName( "Email" );
				$email = $email->item(0)->nodeValue;
				
				$password = $account->getElementsByTagName( "Password" );
				$password = $password->item(0)->nodeValue;
				
				$userType = $account->getElementsByTagName( "Type" );
				$userType = $userType->item(0)->nodeValue;
				
				if ($email == $getEmail && $password == $getPassword && $userType == $getUserType)
				{
					$isLogin = true;
					$id = $account->getElementsByTagName( "Id" );
					$id = $id->item(0)->nodeValue;
					break;
				}
			}
			
			if ( $isLogin )
			{
				if ($getUserType == "customer")
				{
					echo 'Hi customer! Login Success, please waiting in 5 sec';
					$_SESSION['loggedin'] = $id;
					$_SESSION['type'] = $getUserType;
					header("refresh:5;url=customerPage.html");
					exit;
				}
				else if ($getUserType == "grommer")
				{
					echo 'Hi grommer! Login Success, please waiting in 5 sec';
					$_SESSION['loggedin'] = $id;
					$_SESSION['type'] = $getUserType;
					header("refresh:5;url=groomerPage.html");
					exit;
				}
				else
				{
					echo 'Login with user type fail, please waiting in 5 sec';
					header("refresh:5;url=index.html");
					exit;
				}
			}
			else
			{
				echo 'Login Fail, please waiting in 5 sec';
				header("refresh:5;url=index.html");
				exit;
			}
		}
		//
		else
		{
			echo 'Login Fail, please waiting in 5 sec';
			header("refresh:5;url=index.html");
			exit;
		}
	}
	else
	{
		echo 'Account information not correct! please waiting in 5 sec';
		header("refresh:5;url=index.html");
		exit;
	}
}
else
{
	echo 'Account information not correct! please waiting in 5 sec';
	header("refresh:5;url=index.html");
	exit;
}

?> 

