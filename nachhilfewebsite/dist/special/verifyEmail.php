<?php

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$root = "http://$host$uri/";
ConfigStrings::set("root", $root);
?>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf8"/>
    <title>Foundation for Sites</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.ttf">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


    <link rel="stylesheet" href="<?php echo $root?>assets/css/app.css">
  </head>
  <body>

    
    <?php
        include_once __DIR__ . "/../assets/php/general/Route.php";
        include_once __DIR__ . "/../assets/php/general/Connection.php";
        $secret = "52df1c3b0748b09539d64a781fda";
        $email = openssl_decrypt ( $hash , "aes-256-ofb" , $secret);
    
    $stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
    $user = $stmt->fetch();
    
    if($user) {
        if($user->emailActivated == true) {
            $message = "Die Email-Adresse wurde bereits bestätigt!";
        }
        else {
            $stmt = Connection::$PDO->prepare("UPDATE benutzer SET emailActivated = TRUE WHERE idBenutzer = :id");
            $stmt->bindParam(':id', $user->idBenutzer);
            if($stmt->execute()) {
                $message = "Die Email-Adresse wurde erfolgreich bestätigt!";
            }
        }
    }
    else {
        $message = "Link nicht korrekt!";
    }
    ?>
    
    <div class="row">
        <div class="small-12 columns small-centered">
            <h1 class="text-center"><?php echo $message ?></h1>
        </div>
    </div>
    
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>


    <script src="<?php echo $root?>assets/js/app.js"></script>

  </body>
</html>