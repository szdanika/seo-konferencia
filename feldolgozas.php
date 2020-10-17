<?php
	session_start();
	//PRINT_R($_POST);
	$fp = Fopen("voltemailok.txt", "r");
	$sor = fread($fp, filesize("voltemailok.txt"));
	$emailok = $sor;
	Fclose($fp);
	$tomb = explode(';', $sor);
	$vanilyen = false;
	for($i = 0; $i < count($tomb); $i++)
	{
		if($tomb[0] == $_POST['email'])
			$vanilyen = true;
	}
	
	
	
	
	
	
	
	
if($_POST['valasz'] == $_SESSION['veletlenszam'] && $_POST['nev'] != NULL && $_POST['email'] != NULL &&
	$_POST['teloszam'] != NULL && $_POST['munkahelynev'] != NULL && $_POST['munkahelybeoszt'] != NULL &&
	$_POST['szuletes'] != NULL && $vanilyen == false)
	{//ez akkor fog megtörténni ha minden jó
	
	
		$ipcim = $_SERVER['REMOTE_ADDR'] ;
		$_SESSION['voltemar'] = 'igen';
		$_SESSION['probanev'] = $_POST['nev'];
		$_SESSION['elronttota'] = 'nem';
		$_SESSION['demarjo'] = 'igen';
		echo"elvileg jo";
		;
		if($_POST['nev'] == "admin") // megnézem hogy admin e ha igen akkor nem írja le az infóját
		{
			$_SESSION['admine'] = "igen";
		}
		else
		{ //ha nem admin akkor le ír mindent
		//pdf létrehozása
		include("E:/programok/xampp/htdocs/hf/seo_konferencia/fdf/fpdf.php");
		$pdf = new FPDF('P','mm',array(90,55));  
		$pdf->AddPage();
		$mentett ="./adatok/" . $_POST['email']. ".pdf";
		
		$pdf->AddFont('Arial' , ''   , 'arial.php'  );   
		$pdf->AddFont('Arial' , 'B'  , 'arialb.php' );    
		$pdf->AddFont('Arial' , 'BI' , 'arialbi.php');   
		$pdf->AddFont('Arial' , 'I'  , 'ariali.php' );  
		$pdf->SetAutoPageBreak(0) ;
		$pdf->SetFont('Arial','B', 12);
		$pdf->SetXY(40,64);
		$pdf->Text(0,10,"SEO Konferencia");
		$pdf->Text(0,20,"2020.13.40.");
		$pdf->Text(0,30,$_POST['nev']);
		$pdf->Text(0,40,$_POST['munkahelynev']);
		
		$pdf->Output( $mentett , 'F' ); 
	
	
	
	
	
		echo " ".$_POST['nev'] . "<br> " .$_POST['email'] . "<br> " . $_POST['teloszam']. "<br> " . $_POST['munkahelynev']. "<br> " .$_POST['munkahelybeoszt'] . "<br> " . $_POST['szuletes']. "<br> "; 
		$fp = Fopen("voltemailok.txt", "w");
		$sor = $_POST['email'] . ';' . "\n" . $emailok;
		fwrite($fp, $sor);
		fclose($fp);
		
		$fp = Fopen("adatok/" . $_POST['email'] . ".txt", "w");
		$beleiras = $_POST['nev'] . ";". "\n" . $_POST['email']. ";" ."\n". $_POST['teloszam'] . ";" ."\n" . $_POST['munkahelynev'] .
		";" ."\n". $_POST['munkahelybeoszt'] . ";"."\n" . $_POST['szuletes'] . ";"."\n" . date("Y-m-d") . ";"."\n" . $ipcim . ";";
		fwrite($fp , $beleiras);
		fclose($fp);
		$fp = Fopen("emberekszama.txt", "r");
		$emberekszama = fread($fp, filesize("emberekszama.txt"));
		Fclose($fp);
		$fp = Fopen("emberekszama.txt","w");
		Fwrite($fp, $emberekszama+1);
		Fclose($fp);
		}
		
		//email küldés
		/*$to = $_POST['email'];
		$subject = 'Köszönjük hogy jelentkeztél!';
		$message = $nev . ' Köszönjük hogy jelentkezet a konferenciára. Jelentkezésedet eltároluk.';
		$header='From: danikaszab@gmail.com' . "\r\n" . 'Reply-To: danikaszab@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $header);*/		
		
		
	}
	else
	{//ha valami bibi van
		$_SESSION['elronttotnev'] = $_POST['nev'];
		$_SESSION['elrontottszuletes'] = $_POST['szuletes'];
		$_SESSION['elrontottemail'] = $_POST['email'];
		$_SESSION['elrontottteloszam'] = $_POST['teloszam'];
		$_SESSION['elrontottmunkahelynev'] = $_POST['munkahelynev'];
		$_SESSION['elrontottmunkahelybeoszt'] = $_POST['munkahelybeoszt'];
		$_SESSION['elrontotta'] = 'igen';
		$_SESSION['demarjo'] = 'nem';
		echo"ebasztál valamit!";
		$_SESSION['vanilyen'] = 'nincs';
		if($vanilyen = true)
			$_SESSION['vanilyen'] = 'vanilyen';
		
	}
?> 
<script>
	parent.location.href = parent.location.href;
</script>

