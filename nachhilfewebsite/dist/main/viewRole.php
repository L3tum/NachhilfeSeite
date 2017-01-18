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
       * Date: 07.01.2017
       * Time: 01:00
       */
      
      include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
      include_once __DIR__ . "/../assets/php/dbClasses/Berechtigung.php";
      
      $rolle = Rolle::get_by_id($idRole);
      $rights = $rolle->get_rechte();
      $allrights = Berechtigung::get_all_rights();
      
      $rights_key_array = Array();
      foreach ($rights as $allright) {
          $rights_key_array[$allright->idBerechtigung] = true;
      }
      
      ?>
      
      <div class="row main" data-equalizer data-equalize-on="medium">
      
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
      
              <div class="row">
                  <div class="small-12 columns">
                      <h2>Rolle</h2>
                      <?php
                      echo "<div class='data-label'><p>Name: {$rolle->name}</p></div>";
                      echo "<div class='data-label'><p>Beschreibung: {$rolle->beschreibung}</p></div><br>";
      
                      echo "<a class='button secondary' href='".ConfigStrings::get('root')."role/".$rolle->idRolle."/edit'>Rolle bearbeiten</a><br>";
      
                      echo "<p>Die rot markierten Rechte besitzt diese Rolle NICHT!</p>";
                      echo "<p>Die grün markierten Rechte besitzt diese Rolle!</p>"
                      ?>
                      <table>
                          <thead>
                          <tr>
                              <th>Berechtigungs-ID</th>
                              <th>Name</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($allrights as $allright) {
                              if (array_key_exists($allright->idBerechtigung, $rights_key_array)) {
                                  echo "<tr><td><p class='success'>{$allright->idBerechtigung}</p></td><td><p class='success'>{$allright->name}</p></td></tr>";
                              } else {
                                  echo "<tr><td><p class='alert'>{$allright->idBerechtigung}</p></td><td><p class='alert'>{$allright->name}</p></td></tr>";
                              }
                          }
                          ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>

    <script src="<?php echo $root?>assets/js/app.js"></script>

  </body>
</html>