<?php 
error_reporting(E_ALL);
 define( 'varovalka', true );

  
  require "config.env";
  require"dbcon.php";
  
// zastartaj 
session_start();
 
// preglej če je up ze prijavljen, ce ni ga preusmeri 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
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
<div class="page-header">
        <h1>Zdravo, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Dobrodošli na moji strani.</h1>
    <p>
        
        <a href="logout.php" class="btn btn-danger">Odjava</a>
        <a href="welcome.php" class="btn btn-success">Izpis is API</a>
    </p>
</div>
    <br>
    <h2>Izpis iz baze podakov</h2>
    <table class="table table-striped">
    <?php

		$sql = "SELECT * FROM imdb WHERE deleted_at is NULL";
$result = $link->query($sql);
if ($result->num_rows > 0) {
?>
<tr>
    <td><h4>ID:</h4></td>
    <td><h4>Ime:</h4></td>
    <td><h4>Priimek:</h4></td>
    <td><h4>Kraj:</h4></td>
    <td><h4>Žanri:</h4></td>
    <td><h4>Ocena:</h4></td>
    <td><h4>Filmi:</h4></td>
    <td><h4>Nagrade:</h4></td>
    <td><h4>Nazdnje posodobljeno:</h4></td>
    <td><h4>Ustvarjeno:</h4></td>
   
</tr>
<?php
while($row = $result->fetch_assoc()) {
    echo "<tr><td>" 
        . $row["id"]. "</td><td>" 
        . $row["ime"] . "</td><td>"
        . $row["priimek"] . "</td><td>"
        . $row["kraj"] . "</td><td>"
        . $row["zanri"] . "</td><td>"
        . $row["ocena"] . "</td><td>"
        . $row["filmi"] . "</td><td>"
        . $row["nagrade"] . "</td><td>"
        . $row["updated_at"] . "</td><td>"
        . $row["created_at"]. "</td></td>";
        echo "<td><button> <a href=\"vec.php?id=" .$row['id']."\">Več podatkov:</a></button></td>";
         echo "<td><button> <a href=\"izbris.php?id=" .$row['id']."\">&#128686;</a></button></td>";
}
    echo "</table>";
} else { echo "0 results"; }

?>
</table>
<div class="wrapper">
            <h3>Dodaj novega igralca:</h3>
            <form action="dbcon.php"  method="post" autocomplete="off">
                <label for="ime">
                    <div  class="form-group">
                </label>
                <input type="text" name="Ime" placeholder="Ime:" id="Ime" required>
                <label for="Ime">
                    </div>
                    <div class="form-group">
                </label>
                <input type="text" name="Priimek" placeholder="Priimek:" id="Priimek" required>
                <label for="Priimek">
                    </div>
                    <div  class="form-group">
                </label>
                <input type="text" name="Kraj" placeholder="Kraj:" id="Kraj" required>
                <label for="Kraj">
                    </div>
                    <div  class="form-group">
                </label>
                <input type="text" name="Zanri" placeholder="Žanri:" id="Zanri" required>
                <label for="Zanri">
                    </div>
                    <div class="form-group">
                </label>
                <input type="text" name="Ocena" placeholder="Ocena:" id="Ocena" required>
                <label for="Oceana">
                    </div>
                    <div  class="form-group">
                </label>
                 <input type="text" name="Filmi" placeholder="Filmi:" id="Filmi" required>
                <label for="Filmi">
                    </div>
                    <div  class="form-group">
                </label>
                <input type="text" name="Nagrade" placeholder="Nagrade:" id="Nagrade" required>
                <label for="Nagrade">
                    </div>
                    <div  class="form-group">
                </label>
                <input class="btn btn-primary" type="submit" value="submit" name="save">
                    </div>
        </label>
    </table>
    </form>
    <?php
    if(isset($_POST['update']))
    {
          $id = $_POST['id'];
          $ime = $_POST['ime'];
          $priimek = $_POST['priimek'];
          $kraj = $_POST['kraj'];
          $zanri = $_POST['zanri'];
          $ocena = intval($_POST['ocena']);
          $filmi = $_POST['filmi'];
          $nagrade = $_POST['nagrade'];

           
   
   $query = "UPDATE `imdb` SET `ime`='".$ime."', `priimek`='".$priimek."', `kraj`='".$kraj."', `zanri`='".$zanri."', `ocena`='".$ocena."', `filmi`='".$filmi."', `nagrade`='".$nagrade."' WHERE `id` = $id";
   
   $result = mysqli_query($link, $query);
   
   if($result)
   {
       echo 'uspešno posodobljeno';
   }else{
       printf("Error message: %s\n", mysqli_error($link));
   }
   mysqli_close($link);
}

?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <input type="text" name="id" required placeholder="ID Osebe za posodobitev:"><br><br>
            <input type="text" name="ime" required placeholder="Ime:"><br><br>
            <input type="text" name="priimek" required placeholder="Priimek:"><br><br>
            <input type="text" name="kraj" required placeholder="Kraj:"><br><br>
            <input type="text" name="zanri" required placeholder="Zanri:"><br><br>
            <input type="number" name="ocena" required placeholder="Ocena:"><br><br>
            <input type="text" name="filmi" required placeholder="Filmi:"><br><br>
            <input type="text" name="nagrade" required placeholder="Nagrade:"><br><br>

            <input  class="btn btn-primary" type="submit" name="update" value="Popsodobi podatke">

        </form>

                   <div  class="form-group">
 <iframe src="https://giphy.com/embed/exnY8mKcVb6I8" width="280" height="250" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/troll-meme-exnY8mKcVb6I8">Submit if u dare!</a></p>
                   </div>
            
        </div>
            
        
</body>
</html>


