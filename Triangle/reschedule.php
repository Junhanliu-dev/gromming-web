<?php  
$filename = 'test.xml';
session_start();
if(!isset($_SESSION['loggedin']))
{
	echo 'No Session';
    header("refresh:5;url=index.html");
    exit;
}
else if (isset($_POST['confirmReschedual'])) 
{
	if (strlen($_POST['SelectReschedualAppoinment']) != 0 && strlen($_POST['ReschedualTime']) != 0 && strlen($_POST['ReschedualDate']) != 0)
	{
		$getId = $_SESSION['loggedin'];
		$getApponId = $_POST['SelectReschedualAppoinment'];
		$getTime = $_POST['ReschedualTime'];
		$getDate = $_POST['ReschedualDate'];
		
		$isRegst = false;
		$isAppon = false;
		
		$docRead = new DOMDocument();  
		$docRead->formatOutput = true;  
		$docRead->load($filename);
		
		$root = $docRead->getElementsByTagName( "Accounts" );
		$root = $root->item(0);
		
		$accounts = $docRead->getElementsByTagName( "Account" );
		$account = null;
		
		$Times = $docRead->getElementsByTagName( "Time" );
		$Dates = $docRead->getElementsByTagName( "Date" );
		
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
		
		$userAppoinments = $account->getElementsByTagName( "Appointment" );
		$appointment = null;
		
		foreach( $userAppoinments as $tempappon )
		{
			$tempApponId = $tempappon->getElementsByTagName( "AppointmentId" );
			$tempApponId = $tempApponId->item(0)->nodeValue;
			if ($tempApponId == $getApponId)
			{
				$appointment = $tempappon;
				$isAppon = true;
				break;
			}
		}
		
		for ($i = 0; $i < count($Times); $i++)
		{
			$tempTime = $Times->item($i)->nodeValue;
			$tempDate = $Dates->item($i)->nodeValue;
			
			if ($tempTime == $getTime && $tempDate == $getDate)
			{
				$isRegst = false;
				break;
			}
		}
		
		$d = $_POST['ReschedualDate'];
		$t = $_POST['ReschedualTime'];
		date_default_timezone_set("Australia/Melbourne");
		$apponDT = strtotime(date("y-m-".$d." ".$t.":s"));
		$nowDT = strtotime("now");
		$isLater = false;
		
		if ($apponDT>$nowDT)
		{
			$isLater = true;
		}
		
		if( $isRegst && $isAppon && $isLater )
		{
			$appointment->getElementsByTagName("Time")->item(0)->nodeValue = $getTime; 
			$appointment->getElementsByTagName("Date")->item(0)->nodeValue = $getDate; 
			$docRead->save($filename);
			
			echo 'Reschedule Success, please waiting in 5 sec';
			header("refresh:5;url=customerPage.html");
			exit;
		}	
		else
		{
			echo 'Your reschedule appointment information is not correct.';
			header("refresh:5;url=customerPage.html");
			exit;
		}
	}
	else
	{
		echo 'Your reschedule appointment information is not correct.';
		header("refresh:5;url=customerPage.html");
		exit;
	}
}
else if (isset($_POST['CancelAppointment'])) 
{
	if (strlen($_POST['SelectReschedualAppoinment']) != 0)
	{
		$getId = $_SESSION['loggedin'];
		$getApponId = $_POST['SelectReschedualAppoinment'];
		
		$isRegst = false;
		$isAppon = false;
		
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
		
		$userAppoinments = $account->getElementsByTagName( "Appointment" );
		$appointment = null;
		
		foreach( $userAppoinments as $tempappon )
		{
			$tempApponId = $tempappon->getElementsByTagName( "AppointmentId" );
			$tempApponId = $tempApponId->item(0)->nodeValue;
			if ($tempApponId == $getApponId)
			{
				$appointment = $tempappon;
				$isAppon = true;
				break;
			}
		}
		
		if( $isAppon && $isRegst )
		{
			$appointment->getElementsByTagName("Cancel")->item(0)->nodeValue = "YES"; 
			$docRead->save($filename);
			
			echo 'Cancel Success, please waiting in 5 sec';
			header("refresh:5;url=customerPage.html");
			exit;
		}
		else
		{
			echo 'Your reschedule appointment information is not correct.';
			header("refresh:5;url=customerPage.html");
			exit;
		}
		
	}
	else
	{
		echo 'Your reschedule appointment information is not correct.';
		header("refresh:5;url=customerPage.html");
		exit;
	}
}
else if (isset($_POST['ReschedualBack'])) 
{
	header('Location: customerPage.html');
	exit;
}
?>