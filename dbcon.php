<?php
require_once 'config.env';
if(isset($_POST['save']))

{	 
	 $Ime = $_POST['Ime'];
	 $Priimek = $_POST['Priimek'];
	 $Kraj = $_POST['Kraj'];
	 $Zanri = $_POST['Zanri'];
	 $Filmi = $_POST['Filmi'];
	 $Ocena = intval($_POST['Ocena']);
	 $Nagrade = $_POST['Nagrade'];
	
	 $sql = ("INSERT INTO imdb (ime, priimek, kraj, zanri, filmi, ocena, nagrade)
	  VALUES  ( '$Ime', '$Priimek', '$Kraj', '$Zanri', '$Filmi', '$Ocena', '$Nagrade')");
	 if (mysqli_query($link, $sql)) {
		
		header('location: data_base.php');
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($link);
	 }
	 mysqli_close($link);
}


?>

