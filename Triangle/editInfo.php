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
		$account = null;
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
			if($account->getElementsByTagName( "Name" )->length == 0 && 
			$account->getElementsByTagName( "Home" )->length == 0 &&
			$account->getElementsByTagName( "Address" )->length == 0 &&
			$account->getElementsByTagName( "Phone" )->length == 0)
			{
				$name = $docRead->createElement( "Name", $getName);
				$home = $docRead->createElement( "Home" , $getHome);
				$adress = $docRead->createElement( "Address" , $getAdr);
				$phone = $docRead->createElement( "Phone" , $getPhone);


				
				$account->appendChild($name);
				$account->appendChild($home);
				$account->appendChild($adress);
				$account->appendChild($phone);
				
								
				if($_POST['editDog'] == "addDog")
				{
					if (strlen($_POST['editDogName']) != 0 && strlen($_POST['editBreed']) != 0 && strlen($_POST['editBirth']) != 0)
					{
						
						$dogs = $account->getElementsByTagName( "Dog" );
						$currentDogsId = count($dogs); 
						
						$dog = $docRead->createElement( "Dog" ); 
						$dogId = $docRead->createElement( "DogId", $currentDogsId);
						$dogName = $docRead->createElement( "DogName", $_POST['editDogName']);
						$dogBreed = $docRead->createElement( "Breed" , $_POST['editBreed']);
						$dogBirth = $docRead->createElement( "Birth" , $_POST['editBirth']);
						$dog->appendChild($dogId);
						$dog->appendChild($dogName);
						$dog->appendChild($dogBreed);
						$dog->appendChild($dogBirth);
						$account->appendChild($dog);
					}
				}
				else
				{
					if (strlen($_POST['editDogName']) != 0 && strlen($_POST['editBreed']) != 0 && strlen($_POST['editBirth']) != 0)
					{
						$dogId = $_POST['editDog'];
						$dogs = $account->getElementsByTagName( "Dog" );
						
						$isDog = false;
						$dog = null;
						
						
						foreach( $dogs as $tempdog )
						{
							$tempDogId = $tempdog->getElementsByTagName( "DogId" );
							$tempDogId = $tempDogId->item(0)->nodeValue;
							if ($tempDogId == $dogId)
							{
								$dog = $tempdog;
								$isDog = true;
								break;
							}
						}
						

						if ( $isDog )
						{
							$dog->getElementsByTagName("DogName")->item(0)->nodeValue = $_POST['editDogName']; 
							$dog->getElementsByTagName("Breed")->item(0)->nodeValue = $_POST['editBreed']; 
							$dog->getElementsByTagName("Birth")->item(0)->nodeValue = $_POST['editBirth']; 
						}

						
					}					
					else
					{
						echo 'Dog information not correct! please waiting in 5 sec';
						header("refresh:5;url=AddEditPage.html");
						exit;
					}
				}
				
				
				

				
				$docRead->save($filename);
				

				echo 'Save New Information Success, please waiting in 5 sec';
				header("refresh:5;url=customerPage.html");
				exit;
			}
			else
			{
				
				$account->getElementsByTagName("Name")->item(0)->nodeValue = $getName;
				$account->getElementsByTagName("Home")->item(0)->nodeValue = $getHome; 
				$account->getElementsByTagName("Address")->item(0)->nodeValue = $getAdr; 
				$account->getElementsByTagName("Phone")->item(0)->nodeValue = $getPhone; 
								
				if($_POST['editDog'] == "addDog")
				{
					if (strlen($_POST['editDogName']) != 0 && strlen($_POST['editBreed']) != 0 && strlen($_POST['editBirth']) != 0)
					{
						
						$dogs = $account->getElementsByTagName( "Dog" );
						$currentDogsId = count($dogs); 
						
						$dog = $docRead->createElement( "Dog" ); 
						$dogId = $docRead->createElement( "DogId", $currentDogsId);
						$dogName = $docRead->createElement( "DogName", $_POST['editDogName']);
						$dogBreed = $docRead->createElement( "Breed" , $_POST['editBreed']);
						$dogBirth = $docRead->createElement( "Birth" , $_POST['editBirth']);
						$dog->appendChild($dogId);
						$dog->appendChild($dogName);
						$dog->appendChild($dogBreed);
						$dog->appendChild($dogBirth);
						$account->appendChild($dog);
					}
				}
				else
				{
					if (strlen($_POST['editDogName']) != 0 && strlen($_POST['editBreed']) != 0 && strlen($_POST['editBirth']) != 0)
					{
						$dogId = $_POST['editDog'];
						$dogs = $account->getElementsByTagName( "Dog" );
						
						$isDog = false;
						$dog = null;
						
						
						foreach( $dogs as $tempdog )
						{
							$tempDogId = $tempdog->getElementsByTagName( "DogId" );
							$tempDogId = $tempDogId->item(0)->nodeValue;
							if ($tempDogId == $dogId)
							{
								$dog = $tempdog;
								$isDog = true;
								break;
							}
						}
						

						if ( $isDog )
						{
							$dog->getElementsByTagName("DogName")->item(0)->nodeValue = $_POST['editDogName']; 
							$dog->getElementsByTagName("Breed")->item(0)->nodeValue = $_POST['editBreed']; 
							$dog->getElementsByTagName("Birth")->item(0)->nodeValue = $_POST['editBirth']; 
						}

						
					}					
					else
					{
						echo 'Dog information not correct! please waiting in 5 sec';
						header("refresh:5;url=AddEditPage.html");
						exit;
					}
				}
				
				$docRead->save($filename);
				

				echo 'Edit Information Success, please waiting in 5 sec';
				header("refresh:5;url=customerPage.html");
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
		header("refresh:5;url=AddEditPage.html");
		exit;
	}
}
else if (isset($_POST['skip'])) 
{
	echo 'Skip Success, please waiting in 5 sec';
	header("refresh:5;url=customerPage.html");
	exit;
}
?>