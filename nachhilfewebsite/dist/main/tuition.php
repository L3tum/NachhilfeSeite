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
      if(Benutzer::get_logged_in_user()->has_permission("giveClasses")) {
          $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfelehrer = :id");
          $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
          $stmt->execute();
          $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
      
      }
      else if(Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
          $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfenehmer = :id");
          $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
          $stmt->execute();
          $connections2 = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
      }
      else {
          Route::redirect_to_root();
      
      }
      ?>
      
      <div class="row main" data-equalizer data-equalize-on="medium">
      
          <div class="small-12 smallmedium-12 medium-7 columns small-centered" data-equalizer-watch>
      
              <div class="row">
                  <div class="small-8 columns">
                      <h2>Nachhilfe</h2>
                      </div>
                  <div class="small-12 columns">
      
      
                      <?php
                      if(isset($connections) && !empty($connections)) {
                          echo '<h4>Du gibst Nachhilfe für:</h4>';
                          foreach ($connections as $connection) {
      
      
                              $otherUser = Benutzer::get_by_id($connection->idNachhilfenehmer);
                              $userpath =  $root . "user/" . $connection->idNachhilfenehmer . "/view";
                              $fach = Fach::get_by_id($connection->idFach);
      
                              echo "<div class='result-box tution'>
      
                              <div class='row no-padding left'>
      
                                  <div class='small-8 columns'>
      
                                      <div class='row'>
                                          <div class='small-8 columns notification-header no-padding right'>
                                              <a href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a>
                                          </div>
      
                                      </div>
      
                                  </div>
      
                                  <div class='small-2 columns'>
                                    <p class='float-right'>{$fach->name}</p>
                                  </div>
                                  
                                  <div class='small-2 columns'>            
                                   <form data-abide novalidate class='tuition-end-form' method='post'>
                                          <input type='hidden' name='idFach' value='" . $connection->idFach . "'>
                                          <input type='hidden' name='idNehmer' value='" . $otherUser->idBenutzer . "'>
                                          <button class='button alert small no-margin-bottom' type='submit'>Beenden</button>
                                    </form>
                   
                                  </div>
                              </div>
      
                          </div>";
                          }
                      }
      
                      if(isset($connections2) && !empty($connections2)) {
                          echo '<h4>Du nimmst Nachhilfe bei:</h4>';
                          foreach ($connections2 as $connection) {
      
                              $otherUser = Benutzer::get_by_id($connection->idNachhilfelehrer);
                              $userpath =  $root . "user/" . $connection->idNachhilfelehrer . "/view";
                              $fach = Fach::get_by_id($connection->idFach);
      
                              echo "<div class='result-box tution'>
      
                              <div class='row no-padding left'>
      
                                  <div class='small-8 columns'>
      
                                      <div class='row'>
                                          <div class='small-8 columns notification-header no-padding right'>
                                              <a href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a>
                                          </div>
                                      </div>
      
                                  </div>
      
                                  <div class='small-2 columns'>            
                                    <p class='float-right'>{$fach->name}</p>
                   
                                  </div>
                                  
                                  <div class='small-2 columns'>            
                                    <form data-abide novalidate class='tuition-end-form' method='post'>
                                          <input type='hidden' name='idFach' value='" . $connection->idFach . "'>
                                          <input type='hidden' name='idGeber' value='" . $otherUser->idBenutzer . "'>
                                          <button class='button alert small no-margin-bottom' type='submit'>Beenden</button>
                                    </form>
                   
                                  </div>
                              </div>
      
                          </div>";
                          }
                      }
      
                      if((!isset($connections2) || empty($connections2)) && (!isset($connections) || empty($connections))) {
                          echo '<h3>Bisher keine Verbindungen!</h3>';
                      }
      
      
                      ?>
      
                  </div>
      
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