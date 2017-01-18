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

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=10, user-scalable=0"/>
  </head>
  <body>

    
    <header class="title-bar">
    
    
      <div class="title-bar-left">
        <button class="menu-icon show-for-small-only" type="button" data-open="off-canvas"></button>
    
        <span class="title-bar-title">Nachhilfe Gymnasium Lohmar</span>
      </div>
      <div class="title-bar-right">
      </div>
    
    </header>
    

      <div class="off-canvas position-left reveal-for-smallmedium" id="off-canvas" data-off-canvas>
         <ul class="menu main vertical">
         
             <?php
             $root = ConfigStrings::get("root");
             ?>
         
             <li><a href="<?php echo $root?>home">Home</a></li>
             <li><a href="<?php echo $root?>suche">Suche</a></li>
             <li><a href="<?php echo $root?>user/<?php echo Benutzer::get_logged_in_user()->idBenutzer?>/view">Profil</a></li>
             <li><a href="<?php echo $root?>notifications">Nachrichten</a></li>
         
             <?php
         
             if(Benutzer::get_logged_in_user()->has_permission('termine')) {
                 echo "<li><a href='{$root}termine'>Termine</a></li>";
             }
             if(Benutzer::get_logged_in_user()->has_permission('giveClasses') || Benutzer::get_logged_in_user()->has_permission('takeClasses')) {
                 echo "<li><a href='{$root}tuition'>Nachhilfe</a></li>";
             }
             if(Benutzer::get_logged_in_user()->has_permission('administration')) {
                 echo "<li><a href='{$root}admin'>Administration</a></li>";
             }
             ?>
             <li><a href="<?php echo $root?>logout">Logout</a></li>
         </ul>
      </div>
      <div class="off-canvas-content" data-off-canvas-content>
      <?php
      /**
       * Created by PhpStorm.
       * User: Tom
       * Date: 10.01.2017
       * Time: 18:47
       */
      
      include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
      include_once __DIR__ . "/../assets/php/dbClasses/Berechtigung.php";
      
      $allrights = Berechtigung::get_all_rights();
      ?>
      
      <div class="row main" data-equalizer data-equalize-on="medium">
      
          <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>
      
              <h2>Rolle hinzufügen</h2>
      
              <form data-abide novalidate id="rolle-add-form" method="post">
                  <div class="row">
                      <div class="small-12-centered medium-6-centered columns">
                          <label>Name
                              <input name="name" id="name" type="text" required
                                     pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                              <span class="form-error">
                                  Der Name muss gesetzt sein und nicht mehr als 25 Zeichen enthalten!
                              </span>
                          </label>
                          <label>Beschreibung
                              <input name="beschreibung" id="beschreibung" type="text" required>
                              <span class="form-error">
                                  Die Beschreibung muss gesetzt sein!
                              </span>
                          </label>
                          <table>
                              <thead>
                              <tr>
                                  <th>ID</th><th>Name</th><th>Besitzt</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($allrights as $allright){
                                      echo "<tr><td class='alert'>{$allright->idBerechtigung}</td><td class='alert'>{$allright->name}</td><td><button class='tablebutton alert' name='rollenAddingButton' value='{$allright->idBerechtigung}'>Besitzt</button></td></tr>";
                              }
                              ?>
                              </tbody>
                          </table>
                          <button class="button warning" type="submit" name="placeholderpls">Submit</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      
      
      </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>

    <script src="<?php echo $root?>assets/js/app.js"></script>

  </body>
</html>