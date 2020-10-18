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
	
	$kep = $_FILES['kep'];
	print_R($_FILES);
	
	
	
	
	
	
if($_POST['valasz'] == $_SESSION['veletlenszam'] && $_POST['nev'] != NULL && $_POST['email'] != NULL &&
	$_POST['teloszam'] != NULL && $_POST['munkahelynev'] != NULL && $_POST['munkahelybeoszt'] != NULL &&
	$_POST['szuletes'] != NULL && $vanilyen == false && $kep['type'] == "image/jpeg")
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
		include("C:/xampp/htdocs/dani/seo/fdf/fpdf.php");
		$pdf = new FPDF('P','mm',array(90,55));  
		$pdf->AddPage();
		$mentett ="./adatok/" . $_POST['email']. ".pdf";
		//keppel való foglalkozás
		
		
		$filename = $_FILES['kep'];
		$idnev = $filename['tmp_name'];
		$cel = './adatok/'. $_POST['email'] . ".jpeg";
		move_uploaded_file($idnev, $cel);
		$forras = imagecreatefromjpeg($cel);
		$fx = imagesx($forras);
		$fy = imagesy($forras);
		$truecuc = imagecreatetruecolor(120,120);
		if($fx > 650 ||$fy > 650)
		{
			if($fx > 650)
				$cx = 650;
			if($fy > 650)
				$cy = 650;
			
			imagecopyresampled($truecuc , $forras, 0, 0, 0, 0, $cx, $cy, $fx, $fy);
			imagejpeg($forras, $cel);
		}
		
		
		
		
		
		
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
		$pdf->Image($cel,0,50, 650,650);
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
		
		$fp = Fopen("osszesadat.txt", "r");
		$adatok = fread($fp, filesize("osszesadat.txt"));
		fclose($fp);
		$fp = Fopen("osszesadat.txt", "w");
		$sor = $_POST['nev'] . ";". "\n" . $_POST['email']. ";" ."\n". $_POST['teloszam'] . ";" ."\n" . $_POST['munkahelynev'] .
		";" ."\n". $_POST['munkahelybeoszt'] . ";"."\n" . $_POST['szuletes'] . ";"."\n" . date("Y-m-d") . ";"."\n" . $ipcim . ";" . "?";
		fwrite($fp, $sor);
		
		
		
		
		
		
		
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
		if($_POST['nev'] == 'admin')
		{$_SESSION['admine'] = "igen";
			$_SESSION['elronttota'] = 'nem';
			$_SESSION['demarjo'] = 'igen';
					$_SESSION['voltemar'] = 'igen';
		}
	else
	{
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
		
	}
?> 
<script>
	parent.location.href = parent.location.href;
</script>


