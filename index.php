<?php
// začni
session_start();

// preglej če je user že logeran in preusmeri na welcom.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome");
    exit;
}

// use congig.php
require_once "config.env";

// def. var
$username = $password = "";
$username_err = $password_err = "";

// process form
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // check if user feald is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Vnesi uporabniško ime!.";
    } else{
        $username = trim($_POST["username"]);
    }

    // check if pwr feald is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Vnesi Geslo!.";
    } else{
        $password = trim($_POST["password"]);
    }

    // prepare stmt
    if(empty($username_err) && empty($password_err)){
        // pripravi
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);


            $param_username = $username;


            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);


                if(mysqli_stmt_num_rows($stmt) == 1){
                   
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            session_start();


                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;


                            header("location: welcome.php");
                        } else{

                            $password_err = "Geslo ni veljavno.";
                        }
                    }
                } else{

                    $username_err = "Nobeno uporabniško ime ni najdeno.";
                }
            } else{
                echo "Oops! Nekaj je šlo narobem poiskusi kasneje.";
            }


            mysqli_stmt_close($stmt);
        }
    }


    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Prijava</h2>
        <p>Za prijavo izpolni.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Uporabniško ime</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Geslo</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Še nimaš računa? <a href="register">Registriraj se zdaj</a>.</p>
        </form>
         <p>Za prijavo je potrebna registracija</p>
    
          <p>&copy; 2020 By Miiha</p>
    </div>
   
</body>
</html>
