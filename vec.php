<?php
error_reporting(E_ALL);
 define( 'varovalka', true );

  require "config.env";
  require"dbcon.php";

session_start();

  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>database</title>
	<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php	
    $sql = "SELECT * FROM imdb INNER JOIN nekineki ON imdb.id=nekineki.id_osebe WHERE id = ?";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {
?>
	<tr>
    <td><h4>Kraji:</h4></td>
    <td><h4>Nepremicnine:</h4></td>
<?php
    while($row = $result->fetch_assoc()) {
    echo "<tr><td>" 
        . $row["kraji"]. "</td><td>" 
        . $row["nepremicnine"] . "</td><td>";
}
    echo "</table>";
} else { echo "0 results"; }
}
?>
 </label>
 	<div>
    <button  class="btn btn-primary" type="submit" value="nazaj" name="nazaj"><a href="data_base.php">nazaj</a></button>
    </div>
    </label>
</body>
</html>