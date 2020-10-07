<?php

// vključi config file
require_once "config.env";

// definicije
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// proceseranje
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // username
    if(empty(trim($_POST["username"]))){
        $username_err = "Prosimo vnesite uporabniško ime.";
    } else{
        // pripravi stmt
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            
            $param_username = trim($_POST["username"]);

            // poskušaj izvesti
            if(mysqli_stmt_execute($stmt)){
                /*shrani rezultat*/
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "To uporabniško ime je že zasedeno!.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Nekaj je šlo narobe, poiskusite kasneje .";
            }

            // zapri
            mysqli_stmt_close($stmt);
        }
    }

    // preveri pwr
    if(empty(trim($_POST["password"]))){
        $password_err = "Prosim vnesite geslo.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Geslo mora imeti vsaj 6 znakov.";
    } else{
        $password = trim($_POST["password"]);
    }

    // potrdi pwr
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Prosim preveri geslo.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Geslo se ne ujema.";
        }
    }

    // preveri napake pred vpisom v db
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // pripravi ins_stmt
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // združi
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // nastavi parametre
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // za HASHA kodo

            // izvedba
            if(mysqli_stmt_execute($stmt)){
                // povezava
                header("location: index.php");
            } else{
                echo "Nekaj je šlo narobe, poiskusite kasneje.";
            }

            // zapri stmt
            mysqli_stmt_close($stmt);
        }
    }

    // zapri povezavo
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LevGuoUAAAAACNytWgRRG5UG87l1KJW72Av966x"></script>
</head>
<body>
    <div>
        
    </div>
    <div class="wrapper">
        <h2>Registracija</h2>
        <p>Za registracijo izpolni sledeča polja.</p>
        <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Uporabniško ime</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Geslo</label>
                <input autocomplete="off" type="password" name="password" class="form-control" id="pass" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Ponovi geslo</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
                <input type="hidden" id="token" name="token">
            </div>
            <p>Si že registreran? <a href="index">Prijavi se tukaj</a>.</p>
        </form>
    </div>
</body>
 <script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LevGuoUAAAAACNytWgRRG5UG87l1KJW72Av966x', {action: 'homepage'}).then(function(token) {
       console.log(token);
       document.getElementById("password"). value = token;
    });
});
</script>
</html>
