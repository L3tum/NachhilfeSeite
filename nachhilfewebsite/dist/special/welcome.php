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

    <div class="row">
        <div class="small-12 columns">
            <h1 class="text-center">Willkommen bei der Nachhilfe des Gymnasiums Lohmar !</h1>
        </div>
    </div>
    
    <form data-abide novalidate id="login-form" method="post">
        <div class="row">
    
            <div class="small-12 medium-6 columns small-centered">
                <label>Vorname
                    <input name="vorname" type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß ]{1,20}$">
                    <span class="form-error">
                        Der Vorname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                    </span>
                </label>
    
                <label>Nachname
                    <input name="nachname" type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß ]{1,20}$">
                    <span class="form-error">
                        Der Nachname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                    </span>
                </label>
    
                <label>Passwort
                    <input name="passwort" type="password" required>
                    <span class="form-error">
                        Das Passwortfeld darf nicht leer sein.
                    </span>
                </label>
    
                <button class="button" type="submit" value="Submit">Submit</button>
            </div>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>


    <script src="<?php echo $root?>assets/js/app.js"></script>

  </body>
</html>