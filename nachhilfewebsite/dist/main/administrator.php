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
      <div class="row main" data-equalizer data-equalize-on="medium">
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
              <h2>Aktionen</h2>
              <div class="row actions">
                  <div class="small-12 columns">
              <?php
              if (Benutzer::get_logged_in_user()->has_permission("registerNewUser")) {
                  echo "<a id='register_new_user' class='button' type='submit' value='Submit'>Registriere neuen Benutzer</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("addNewSubject")) {
                  echo "<a id='add_subject' class='button' type='submit' value='Submit'>Füge ein Fach hinzu</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("deleteSubject")) {
                  echo "<a id='del_subject' class='button alert' type='submit' value='Submit'>Lösche ein Fach</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("addNewYear")) {
                  echo "<a id='add_year' class='button' type='submit' value='Submit'>Füge ein Schuljahr hinzu</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("deleteYear")) {
                  echo "<a id='del_year' class='button alert' type='submit' value='Submit'>Lösche Schuljahr</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllRoles")) {
                  echo "<a id='show_roles' class='button' type='submit' value='Submit'>Zeige alle Rollen</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllConnections")) {
                  echo "<a id='show_connections' class='button' type='submit' value='Submit'>Zeige alle Nachhilfeverbindungen</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showPendingHours")) {
                  echo "<a id='show_pending_hours' class='button' type='submit' value='Submit'>Zeige alle ausstehenden Stunden</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllHours")) {
                  echo "<a id='show_all_hours' class='button' type='submit' value='Submit'>Zeige alle Stunden</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllFreeRooms")) {
                  echo "<a id='show_free_rooms' class='button success' type='submit' value='Submit'>Zeige alle freien Räume</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllTakenRooms")) {
                  echo "<a id='show_taken_rooms' class='button' type='submit' value='Submit'>Zeige alle gebuchten Räume</a><br>";
              }
              if (Benutzer::get_logged_in_user()->has_permission("showAllComplaints")) {
                  echo "<a id='show_complaints' class='button warning' type='submit' value='Submit'>Zeige alle Beschwerden</a><br>";
              }
              ?>
      
                  </div>
      
              </div>
          </div>
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
              <h2>Ergebnisse</h2>
              <div class="result-boxes-inner" id="results" name="results">
      
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