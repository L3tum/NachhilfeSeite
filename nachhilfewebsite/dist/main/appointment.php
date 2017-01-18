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
       * Date: 11.01.2017
       * Time: 00:09
       */
      
      include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
      include_once __DIR__ . "/../assets/php/dbClasses/Raum.php";
      include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
      include_once __DIR__ . "/../assets/php/dbClasses/AngebotenesFach.php";
      
      $current_user = Benutzer::get_logged_in_user();
      $others = $current_user->get_all_connections_single();
      
      $offered_subjects = AngebotenesFach::get_offered_subjects();
      $rooms = Raum::get_all_rooms();
      
      ?>
      
      <div class="row main">
          <div class="small-12 columns">
              <form id="appointment-form">
                  <table>
                      <thead>
                      <tr>
                          <th>An</th>
                          <th>Fach</th>
                          <th>Datum</th>
                          <th>Zeit</th>
                          <th>Raum</th>
                          <th>Abschicken</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>
                              <select name="idUser" id="idUser">
                                  <option value="no">Nichts</option>
                                  <?php
                                  foreach ($others as $other) {
                                      echo "<option value='{$other['ID']}'>{$other['vorname']} {$other['name']}</option>";
                                  }
                                  ?>
                              </select>
                          </td>
                          <td>
                              <select name="idSubject" id="idSubject">
                                  <option value="no">Nichts</option>
                                  <?php
                                  foreach ($offered_subjects as $subject) {
                                      echo "<option value='{$subject->idFach}'>{$subject->name}</option>";
                                  }
                                  ?>
                              </select>
                          </td>
                          <td>
                              <input type="date" id="datetime_app" name="datetime_app">
                          </td>
                          <td>
                              <input type="time" id="time_app" name="time_app">
                          </td>
                          <td>
                              <select name="idRoom" id="idRoom">
                                  <option value="no">Nichts</option>
                                  <?php
                                  foreach ($rooms as $room) {
                                      echo "<option value='{$room->raumNummer}'>{$room->raumNummer}</option>";
                                  }
                                  ?>
                              </select>
                          </td>
                          <td>
                              <button class="button success" type="submit" id="submit" name="Submit">Abschicken</button>
                          </td>
                      </tr>
                      </tbody>
                  </table>
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