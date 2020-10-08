<?php
error_reporting(E_ALL);
 define( 'varovalka', true );

  
  require "config.env";
  require"dbcon.php";
 

    $delete = $link->prepare( "UPDATE imdb SET deleted_at=now() WHERE id = ?");
    $delete->bind_param("i", $_GET['id'] );
    $delete->execute();
    

    $_SESSION['message'] = array(
      'text' => 'Uspešno izbrisani podatki',
      'type' => 'success'
    );

    // rederect 
    header("location: data_base.php");

    ?>
