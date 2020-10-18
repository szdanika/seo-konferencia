<style>
body{	
		background-image: url('hatterszurk.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
	}
	table, th, td {
  border: 1px solid black;
}
</style>
<?php
	$fp = Fopen("emberekszama.txt", "r");
	$emberekszama = fread($fp, filesize("emberekszama.txt"));
	Fclose($fp);
	$szam1 = rand(1,10);
	$szam2 = rand(1,10);
	$vegsoszam = $szam1 + $szam2;
	session_start();
	$_SESSION['veletlenszam'] = $vegsoszam;
	PRINT_R($_SESSION);
	if($_SESSION['elrontotta'] == 'igen' && $_SESSION['demarjo'] == 'nem')
	{// ez lesz az amit akkor fog látni a felhasználó ha rosszul adot meg adatot.
	echo"hát ezt elbasztad öcskös";
	echo"
			<form method='POST' action='feldolgozas.php' target='megjelenito' enctype='multipart/form-data'>
				<input type='text' name='nev' placeholder='kérem a nevet' value='";echo $_SESSION['elronttotnev']; echo"'> <br><br>
				<input type='date' name='szuletes' value='";echo $_SESSION['elrontottszuletes']; echo"'><a> (születési dátum)</a><br><br>
				<input type='email' name='email' value='";echo $_SESSION['elrontottemail']; echo"'placeholder='kérem a(z) email címet'>"; if($_SESSION['vanilyen'] == 'vanilyen') echo "ilyen emailel már regiszráltak"; echo"<br><br>
				<input type='number' name='teloszam' value='";echo $_SESSION['elrontottteloszam']; echo"' placeholder='kérem a telefonszámot'><br><br>
				<input type='text' name='munkahelynev' value='"; echo $_SESSION['elrontottmunkahelynev']; echo"' placeholder='kérem a munkahely nevét'><br><br>
				<input type='text' name='munkahelybeoszt' value='"; echo $_SESSION['elrontottmunkahelybeoszt']; echo"' placeholder='Kérem a munkakörét'><br><br>
				<input type='file' name='kep'><a>Kérek egy arcképet, mely a rendezvényre szóló belépőkártyán fog majd szerepelni. </a><br><br>
				<input type='number' name='valasz' placeholder='"; echo $szam1 . "+" . $szam2. " = ?" . "'><br><br>
				<input type='submit' value='beküldés'>
				
			</form>
			<iframe name='megjelenito'></iframe>
				";
	}
	else
	{
		if($_SESSION['voltemar'] != 'igen' && $emberekszama !=120)
		{//ez lesz az első amit látni fog a felhasználó
				echo $emberekszama;
			echo"
			<form method='POST' action='feldolgozas.php' target='megjelenito' enctype='multipart/form-data'>
				<input type='text' name='nev' placeholder='kérem a nevet'> <br><br>
				<input type='date' name='szuletes'><a> (születési dátum)</a><br><br>
				<input type='email' name='email' placeholder='kérem a(z) email címet'><br><br>
				<input type='number' name='teloszam' placeholder='kérem a telefonszámot'><br><br>
				<input type='text' name='munkahelynev' placeholder='kérem a munkahely nevét'><br><br>
				<input type='text' name='munkahelybeoszt' placeholder='Kérem a munkakörét'><br><br>
				<input type='file' name='kep'><a>Kérek egy arcképet, mely a rendezvényre szóló belépőkártyán fog majd szerepelni. </a><br><br>
				<input type='number' name='valasz' placeholder='"; echo $szam1 . "+" . $szam2. " = ?" . "'><br><br>
				<input type='submit' value='beküldés'>
			</form>
			<iframe name='megjelenito'></iframe>
				";
		}
		else
		{
			if($emberekszama == 120) //ide kerülnek azok amiket ki akarunk írni ha már 120 jelentkeztek
			{
				echo"<h4 color=white> Sorrey brutha de te már nem jelentkezhetel mert túl sokan vannak!</h4>";
			}
			else 
			{
				if($_SESSION['admine'] == "igen") // ide kerül majd az adminfelületre érkezők
				{
					echo"Üdvözöllek az admin oldalon jófiu";
					echo"Összesen ennyien regisztráltak eddig : " . $emberekszama;
					echo"eddigi jelentkezők adatai :<br><br><br>";
					$fp = Fopen("osszesadat.txt", "r");
					$osszes = Fread($fp, filesize("osszesadat.txt"));
					$sorok = explode('?', $osszes);
					$nagysag = count($osszes);
					$i = 0;
					echo"<table>
							<tr>
								<th>Név 1</th>
								<th>email 2</th>
								<th>teloszám  3</th>
								<th>munkahelynév 4</th>
								<th>Születési dátum 6</th>
							</tr>	
					
					";
					while($i < $nagysag)
					{
						$jelenlegisor = explode(';', $sorok[$i]);
						echo"<tr>
								<td>"; echo $jelenlegisor[0]; echo" </td>
								<td>"; echo $jelenlegisor[1]; echo" </td>
								<td>"; echo $jelenlegisor[2]; echo" </td>
								<td>"; echo $jelenlegisor[3]; echo" </td>
								<td>"; echo $jelenlegisor[5]; echo" </td>
							 </tr>	
								";
						
						
						$i++;
					}
					echo"</table>";
				}
				else //ide kerülnek azok az infók amiket adat megadás után akarunk láttatni
				{
					echo"<h4 color=white> Kösszi a jelentkezést tetty</h4>";
				}
			}
		}
	}
?>