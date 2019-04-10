<?php  
$filename = 'test.xml';
session_start();
if(!isset($_SESSION['loggedin']))
{
	echo 'No Session';
    header("refresh:5;url=index.html");
    exit;
} 
else if (isset($_POST['appointmentConfirm'])) 
{
	if (strlen($_POST['AppointmentdogSelect']) != 0 && strlen($_POST['Service']) != 0 && strlen($_POST['selectDate']) != 0 && strlen($_POST['selectTime']) != 0 && strlen($_POST['content']) != 0)
	{
		$getId = $_SESSION['loggedin'];
		$dogId = $_POST['AppointmentdogSelect'];
		$getServ = $_POST['Service'];
		$getDate = $_POST['selectDate'];
		$getTime = $_POST['selectTime'];
		$getDescri = $_POST['content'];
		
		$isRegst = false;
		
		$docRead = new DOMDocument();  
		$docRead->formatOutput = true;  
		$docRead->load($filename);
		
		$root = $docRead->getElementsByTagName( "Accounts" );
		$root = $root->item(0);
		
		$accounts = $docRead->getElementsByTagName( "Account" );
		$account = null;
		
		$Times = $docRead->getElementsByTagName( "Time" );
		$Dates = $docRead->getElementsByTagName( "Date" );
		$Cancels = $docRead->getElementsByTagName( "Cancel" );

		
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
		
		$getAponDog = $dog->getElementsByTagName("DogName");
		$getAponDog = $getAponDog->item(0)->nodeValue;
		
		for ($i = 0; $i < count($Times); $i++)
		{
			$tempTime = $Times->item($i)->nodeValue;
			$tempDate = $Dates->item($i)->nodeValue;
			$tempCancel = $Cancels->item($i)->nodeValue;
			
			if ($tempTime == $_POST['selectTime'] && $tempDate == $_POST['selectDate'] && $tempCancel == "NO")
			{
				$isRegst = false;
				break;
			}
		}
		
		$d = $_POST['selectDate'];
		$t = $_POST['selectTime'];
		date_default_timezone_set("Australia/Melbourne");
		$apponDT = strtotime(date("y-m-".$d." ".$t.":s"));
		$nowDT = strtotime("now");
		$isLater = false;
		
		if ($apponDT>$nowDT)
		{
			$isLater = true;
		}
		
		
		if( $isRegst && $isDog && $isLater )
		{
			if($account->getElementsByTagName( "Name" )->length != 0 && 
			$account->getElementsByTagName( "Home" )->length != 0 &&
			$account->getElementsByTagName( "Address" )->length != 0 &&
			$account->getElementsByTagName( "Phone" )->length != 0)
			{
				$appons = $account->getElementsByTagName( "Appointment" );
				$currentApponId = count($appons); 
				
				$Apon = $docRead->createElement( "Appointment" );
				
				$ApponId = $docRead->createElement( "AppointmentId", $currentApponId);
				$AponDog = $docRead->createElement( "DogName", $getAponDog);
				$Serv = $docRead->createElement( "Service" , $getServ);
				$Date = $docRead->createElement( "Date" , $getDate);
				$Time = $docRead->createElement( "Time" , $getTime);
				$Descri = $docRead->createElement( "Comment" , $getDescri);
				$Cancel = $docRead->createElement( "Cancel" , "NO");
				$SentEmail = $docRead->createElement( "SentEmail" , "NO");
				
				$Apon->appendChild($ApponId);
				$Apon->appendChild($AponDog);
				$Apon->appendChild($Serv);
				$Apon->appendChild($Date);
				$Apon->appendChild($Time);
				$Apon->appendChild($Descri);
				$Apon->appendChild($Cancel);
				$Apon->appendChild($SentEmail);
				$account->appendChild($Apon);
				
				$docRead->save($filename);
				
				echo 'Appointment Register Success! please waiting in 5 sec';
				header("refresh:5;url=customerPage.html");
				exit;
			}
			else
			{
				echo 'You have to register your information before making appointment.';
				header("refresh:5;url=AddEditPage.html");
				exit;
			}
		}
		else
		{
			echo 'Your appointment information is not correct.';
			header("refresh:5;url=customerPage.html");
			exit;
		}
	}
	else
	{
		echo 'Your appointment information is not correct.';
		header("refresh:5;url=customerPage.html");
		exit;
	}
}
else if (isset($_POST['appointmentCancle']))
{
		header('Location: customerPage.html');
		exit;
}
?>