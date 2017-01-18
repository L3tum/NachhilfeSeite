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
      
      include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
      
      if (isset($user_to_show_id)) {
          $user = Benutzer::get_by_id($user_to_show_id);
      }
      
      $connections = $user->get_tutiution_connections(Benutzer::get_logged_in_user());
      $connections_key_array = Array();
      foreach ($connections as $connection) {
          $connections_key_array[Fach::get_by_id($connection->idFach)->name] = true;
      }
      
      $anfragen = $user->get_anfragen(Benutzer::get_logged_in_user()->idBenutzer);
      $anfragen_key_array = Array();
      foreach ($anfragen as $anfrage) {
          $anfragen_key_array[Fach::get_by_id($anfrage->idFach)->name] = true;
      }
      
      $user_is_me = Benutzer::get_logged_in_user()->idBenutzer == $user->idBenutzer;
      ?>
      
      <div class="row main" data-equalizer data-equalize-on="medium">
      
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
      
              <div class="row">
                  <div class="small-12 columns">
                      <h2>Profil</h2>
      
                      <?php
                      if ($user->has_permission("takeClasses") && !empty($connections)) {
                          echo '<div class="data-label">
                          <p>Du nimmst bei dieser Person Nachhilfe!</p>
                          </div>';
                      }
                      ?>
      
                      <div class="data-label">
                          <p>Name: <?php echo $user->vorname . " " . $user->name ?></p>
                      </div>
      
                      <div class="data-label">
                          <p>Rolle: <?php echo $user->get_role() ?></p>
                      </div>
      
      
                      <div class="data-label">
                          <?php
      
                          if (!empty($connections) || (Benutzer::get_logged_in_user()->has_permission("showCredentials")) || $user_is_me) {
                              $number = $user->telefonnummer;
                              echo "<p>Telefonnummer: {$number}</p>";
                          } else {
                              echo '<p>Telefonnummer: <span
                                  class="blur">02246 0101010101</span>
                          </p>';
                          }
                          ?>
      
      
                      </div>
      
                      <div class="data-label">
                          <?php
      
                          if (!empty($connections) || (Benutzer::get_logged_in_user()->has_permission("showCredentials")) || $user_is_me) {
                              $email = $user->email;
                              echo "<p>Email: {$email}</p>";
                          } else {
                              echo '<p>Email: <span
                                  class="blur">hierist@wirklichnix.de</span>
                              </p>';
                          }
                          ?>
                      </div>
      
                      <?php
      
                      if (empty($connections) && !(Benutzer::get_logged_in_user()->has_permission("showCredentials")) && !$user_is_me) {
      
                          echo '<p>Du kannst die Email und die Telefonnummer eines Nutzers nur sehen, wenn du ihm Nachhilfe gibst oder
                          bei ihm Nachhilfe nimmst!</p>';
                      }
                      ?>
      
      
                  </div>
      
      
                  <div class="small-12 columns">
      
                      <div class="row">
                          <div class="small-12 columns">
                              <?php if ($user->has_permission("giveClasses") && count($user->get_offered_subjects()) > 0) {
                                  echo "<h3 > Fächer: </h3 >";
                              }
                              ?>
                          </div>
                      </div>
      
                      <div class="row">
      
      
                          <?php
                          if ($user->has_permission("giveClasses")) {
                              $isnot = false;
                              foreach ($user->get_offered_subjects() as $subject) {
                                  $name = $subject->name;
      
                                  //Check if verbindung
                                  if (isset($connections_key_array[$name])) {
                                      echo
                                      "<div class=\"small-6 medium-12 large-4 columns\">
                                    <div class=\"data-label alert\">
                                      <p class=\"center\">$name</p>
                                    </div>
                                  </div>";
                                  } //Check if Anfrage
                                  else if (isset($anfragen_key_array[$name])) {
                                      echo
                                      "<div class=\"small-6 medium-12 large-4 columns\">
                                    <div class=\"data-label secondary\">
                                      <p class=\"center\">$name</p>
                                    </div>
                                  </div>";
                                  } //Button for Anfrage
                                  else if (!$user_is_me) {
                                      $isnot = true;
                                      echo
                                      "<div class=\"small-6 medium-12 large-4 columns\">
                                    <p type=\"button\" id={$subject->idFach} name='fachButton' class='labelled success center'>
                                    {$name}
                                    </p>
                                  </div>";
                                  } else {
                                      echo
                                      "<div class=\"small-6 medium-12 large-4 columns\">
                                    <div class=\"data-label\">
                                      <p class=\"center\">$name</p>
                                    </div>
                                  </div>";
                                  }
                              }
      
                              if (!empty($connections)) {
      
                                  echo "<div class=\"small-12 columns\"><p>In den rot markierten Fächern nimmst du bei dieser Person, oder gibst du dieser Person, Nachhilfe!</p></div>";
                              }
                              if (!empty($anfragen)) {
                                  echo "<div class=\"small-12 columns\"><p>In den blau markierten Fächern hast du bereits eine Anfrage gesendet oder empfangen!</p></div>";
                              }
                              if ($isnot) {
                                  echo "<div class=\"small-12 columns\"><p>Die grün markierten Felder kannst du anklicken, um Nachhilfe in diesem Fach anzufragen!</p></div>";
                              }
                          }
                          ?>
      
                      </div>
                  </div>
      
      
                  <div class="small-12 columns">
      
                      <div class="row">
                          <div class="small-12 columns">
                              <?php if ($user->has_permission("giveClasses") && count($user->get_offered_classes()) > 0) {
                                  echo "<h3 > Stufen: </h3 >";
                              }
                              ?>
                          </div>
                      </div>
      
                      <div class="row">
      
      
                          <?php
                          if ($user->has_permission("giveClasses")) {
                              foreach ($user->get_offered_classes() as $class) {
                                  $name = $class->name;
                                  echo
                                  "<div class=\"small-4 columns\">
                                    <div class=\"data-label\">
                                      <p class=\"center\">$name</p>
                                    </div>
                                  </div>";
                              }
                          }
                          ?>
      
                      </div>
                  </div>
      
                  <div class="small-12 columns">
      
                      <div class="row">
                          <div class="small-12 columns">
                              <?php
                              if($user->has_permission("giveClasses") && count($user->get_all_qualifications()) > 0) {
                                  echo "<h3> Qualifikationen: </h3>";
                              }
                              ?>
                          </div>
                      </div>
                      <div class="row">
      
      
                          <?php
                          $quals = $user->get_all_qualifications();
                          if(isset($quals) && count($quals) > 0) {
                              foreach ($quals as $qual) {
                                  $name = $qual->name;
                                  echo
                                  "<div class=\"small-6 columns\">
                                    <div class=\"data-label\">
                                      <p class=\"center\">$name</p>
                                    </div>
                                  </div>";
                              }
                          }
                          ?>
      
                      </div>
                  </div>
      
              </div>
          </div>
      
      
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
      
              <h2>Aktionen</h2>
      
              <?php
              if ($user_is_me || Benutzer::get_logged_in_user()->has_permission("showProfileExtended")) {
                      echo '        
              <div class="row actions">
                  <div class="small-12 columns">
                      <a href="' . ConfigStrings::get("root") . "user/" . $user->idBenutzer . "/edit" . '" class="button success" type="submit" value="Submit">Profil bearbeiten</a>
                  </div>
              </div>';
                  }
                  if($user_is_me){
                  echo '        
              <div class="row actions">
                  <div class="small-12 columns">
                      <a href="' . ConfigStrings::get("root") . "notifications" . '" class="button" type="submit" value="Submit">Nachhilfeanfragen aufrufen</a>
                  </div>
              </div>';
              }
      
      
      
              if (!($user_is_me)) {
      
                  echo '
              <div class="row actions">
                  <div class="small-12 columns">
                      <a href="' . ConfigStrings::get("root"). "user/" . $user->idBenutzer . "/chatMessagesTo/" . Benutzer::get_logged_in_user()->idBenutzer .  '" class="button" type="submit" value="Submit">Nachricht senden</a>
                  </div>
              </div>';
      
                  if ($user->has_permission("giveClasses")) {
      
                      echo '
              <div class="row actions">
                  <div class="small-12 columns">
                          <a id="nachhilfeAnfragenButton" class="button" type="submit" value="Submit">Nachhilfe anfragen</a>
                  </div>
              </div>
                              <input type="hidden" id="user_to_show" value="' . $user->idBenutzer . '"/>';
                  }
      
                  echo '
                  
              <div class="row actions">
                  <div class="small-12 columns">
                      <a class="button alert" type="submit" name="' . $user->idBenutzer . '" id="alerting">Nutzer melden</a>
                  </div>
              </div>';
      
                  if (Benutzer::get_logged_in_user()->has_permission("blockUser")) {
                      if($user->is_blocked() == "1" || $user->is_blocked() == "true") {
                          echo '
                            <div class="row actions">
                              <div class="small-12 columns">
                                <a id="unblockUserButton" class="button alert" type="submit" value="Submit">Benutzer entblocken</a>
                              </div>
                            </div>';
                      }
                      else{
                          echo '
                            <div class="row actions">
                              <div class="small-12 columns">
                                <a id="blockUserButton" class="button alert" type="submit" value="Submit">Benutzer blockieren</a>
                              </div>
                             </div>';
                      }
                  }
      
      
              }
      
              ?>
      
      
          </div>
      
          <?php
          if (Benutzer::get_logged_in_user()->has_permission("getUserPDFReports") ) {
      
              $givenButton = "";
              $takenButton = "";
              if($user->has_permission("giveClasses")) {
                  $givenButton = '<button type="submit" name="action" value="given" class="button" type="submit">PDF für gegebene Stunden generieren</button>';
              }
              if($user->has_permission("takeClasses")) {
                  $takenButton = '<button type="submit" name="action" value="taken" class="button" >PDF für genommene Stunden generieren</a>';
              }
      
              $currYear = date("Y");
      
              echo "
                  <div class='small-12 smallmedium-12 medium-6 columns'>
                    <h2>PDF</h2>
                    <form data-abide novalidate id='show-pdf-form' method='post'>
                      <input id='pdf-year' style='width:100px' type='number' min='2010' max='2200' value={$currYear}>
                      <input id='pdf-user' type='hidden' name='idBenutzer' value='{$user->idBenutzer}'>
                      
                      {$givenButton}{$takenButton}
                    </form>
                  <div>
              ";
          }
          ?>
      
          </div>
      </div>
      
      
      
      </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>

    <script src="<?php echo $root?>assets/js/app.js"></script>

  </body>
</html>