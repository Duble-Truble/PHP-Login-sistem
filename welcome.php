<?php
 define( 'varovalka', true );

  include_once './shared.php';
// zastartaj 
session_start();
 
// preglej če je up ze prijavljen, ce ni ga preusmeri 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Zdravo, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Dobrodošli na moji strani.</h1>
    </div>
    <p>
        
        <a href="logout.php" class="btn btn-danger">Odjava</a>
        <a href="data_base.php" class="btn btn-success">Baza podatkov</a>
    </p>

    <br>

    <?php
             $rawData = file_get_contents( 'http://students.b2.eu/udelezenec71/api/users.php' );

  $Osebe = json_decode( $rawData, true );


?>
<h1>izpis API</h1>
<table class="table table-striped">
  <?php foreach ( $Osebe as $i => $uporabnik ) : ?>
    <tr>
      <td><?= $i + 1; ?></td>
      <td><?= $uporabnik['ime']; ?></td>
      <td><?= $uporabnik['priimek']; ?></td>
      <td><a href="http://students.b2.eu/udelezenec71/welcome.php?vec=<?= $uporabnik['id'] ?>"><button name="vec">Več podatkov</button></a></td> 
       <?php 

 if(isset($_GET['vec']) && $_GET['vec'] ==$uporabnik['id']) :
    $raw = file_get_contents(getUserURL(intval( $_GET['vec'])));
    $uporabnik = json_decode($raw, true)['data'];
  ?>
  </tr>
  <tr>
  <td>
<table class="table">
    <tr>
       <tr><h3>Vsi podatki o osebi</h3></tr>
       <td><h4>Ime:</h4><?= $uporabnik['ime']; ?></td>
       <td><h4>Priimek:</h4><?= $uporabnik['priimek']; ?></td>
       <td><h4>Email:</h4><?= $uporabnik['email']; ?></td>
       <td><h4>Naslov:</h4><?= $uporabnik['ulica']; ?></td>
       <td><h4>Poštna Številka:</h4><?= $uporabnik['postna_st']; ?></td>
       <td><h4>Kraj:</h4><?= $uporabnik['posta']; ?></td>           
    </tr>
</table>
    </td>
      <?php endif; ?>
      <?php endforeach; ?>
    </tr>
</table>
</body>
</html>

