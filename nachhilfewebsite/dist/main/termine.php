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
       * Time: 20:43
       */
      
      include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
      include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";
      
      $user = Benutzer::get_logged_in_user();
      
      if ($user->has_permission("giveClasses")) {
          $appointments1 = $user->get_all_appointments_as_teacher(0);
          $appointments3 = $user->get_all_appointments_as_teacher(1);
      }
      if ($user->has_permission("takeClasses")) {
          $appointments2 = $user->get_all_appointments_as_pupil(0);
          $appointments4 = $user->get_all_appointments_as_pupil(1);
      }
      $today = date("d.m.Y H:i:s");
      ?>
      
      <div class="row main">
          <div class="medium-12 columns result-boxes">
              <div class="row">
                  <div class="small-12 columns">
                      <h2 class="text-left">Anstehende Termine</h2>
                  </div>
              </div>
              <div class="result-boxes-inner appointments">
                  <br>
                  <a class="button success" href="<?php echo ConfigStrings::get("root") . "appointment" ?>">Termin
                      vereinbaren</a>
                  <br>
                  <table id="tableTermine">
                      <thead>
                      <tr>
                          <th>Lehrer</th>
                          <th>Schüler</th>
                          <th>Datum</th>
                          <th>Raum</th>
                          <th>Bestätigt(Schüler)</th>
                          <th>Bestätigt(Lehrer)</th>
                          <th>Termin Akzeptiert</th>
                          <?php
                          if ($user->has_permission("takeClasses")) {
                              echo "<th>Du Musst Diese Stunde Bezahlen</th>";
                          }
                          ?>
                          <th>Absagen</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $set = false;
                      if (isset($appointments1) && !empty($appointments1)) {
                          $set = true;
                          foreach ($appointments1 as $appointment) {
                              $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
      
                              if ($date < $today && $appointment['akzeptiert'] == 0) {
                                  Stunde::deleteStunde($appointment['idStunde']);
                                  Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  continue;
                              }
      
                              echo "<tr><td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                              if ($appointment['bestaetigtSchueler'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='alert'>Nein</td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
      
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($appointment['lehrerVorgeschlagen'] == 0 && $appointment['akzeptiert'] == 0) {
                                  echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check no-margin-bottom'></i></button>";
                                  echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x no-margin-bottom'></i></button></div></div></td>";
                              } else if ($appointment['akzeptiert'] == 0) {
                                  echo "<td class='alert'>Nein</td>";
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 1 && $appointment['bestaetigtSchueler'] == 1) {
                                  echo "<td>Termin hat bereits stattgefunden</td>";
                              } else {
                                  echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td></tr>";
                              }
                          }
                      } else if (!isset($appointments2) || empty($appointments2)) {
                          $set = true;
                          echo "<tr><td>Nichts</td></tr>";
                      }
                      if (isset($appointments2) && !empty($appointments2)) {
                          foreach ($appointments2 as $appointment) {
                              $connection = Verbindung::is_first_connection($appointment['idVerbindung'], Benutzer::get_logged_in_user()->idBenutzer);
                              $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                              if ($date < $today && $appointment['akzeptiert'] == 0) {
                                  Stunde::deleteStunde($appointment['idStunde']);
                                  Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  continue;
                              }
                              echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                              if ($appointment['bestaetigtSchueler'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
      
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='alert'>Nein</td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($appointment['lehrerVorgeschlagen'] == 1 && $appointment['akzeptiert'] == 0) {
                                  echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check'></i></button>";
                                  echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x'></i></button></div></div></td>";
                              } else if ($appointment['akzeptiert'] == 0) {
                                  echo "<td class='alert'>Nein</td>";
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($connection) {
                                  echo "<td class='success'>Nein</td>";
                              } else {
                                  echo "<td class='warning'>Ja</td>";
                              }
      
                              echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td></tr>";
                          }
                      } else if (!$set) {
                          echo "<tr><td>Nichts</td></tr>";
                      }
                      ?>
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="medium-12 columns result-boxes">
              <div class="row">
                  <div class="small-12 columns">
                      <h2 class="text-left">Abgelaufene Termine</h2>
                  </div>
              </div>
              <div class="result-boxes-inner appointments">
                  <br>
                  <table id="tableTermine">
                      <thead>
                      <tr>
                          <th>Lehrer</th>
                          <th>Schüler</th>
                          <th>Datum</th>
                          <th>Raum</th>
                          <th>Bestätigt(Schüler)</th>
                          <th>Bestätigt(Lehrer)</th>
                          <th>Termin Akzeptiert</th>
                          <?php
                          if ($user->has_permission("takeClasses")) {
                              echo "<th>Du Musst Diese Stunde Bezahlen</th>";
                          }
                          ?>
                          <th>Absagen</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $set = false;
                      if (isset($appointments3) && !empty($appointments3)) {
                          $set = true;
                          foreach ($appointments3 as $appointment) {
                              $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
      
                              if ($date < $today && $appointment['akzeptiert'] == 0) {
                                  Stunde::deleteStunde($appointment['idStunde']);
                                  Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  continue;
                              }
      
                              echo "<tr><td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                              if ($appointment['bestaetigtSchueler'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='alert'>Nein</td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
      
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($appointment['lehrerVorgeschlagen'] == 0 && $appointment['akzeptiert'] == 0) {
                                  echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check no-margin-bottom'></i></button>";
                                  echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x no-margin-bottom'></i></button></div></div></td>";
                              } else if ($appointment['akzeptiert'] == 0) {
                                  echo "<td class='alert'>Nein</td>";
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 1 && $appointment['bestaetigtSchueler'] == 1) {
                                  echo "<td>Termin hat bereits stattgefunden</td>";
                              } else {
                                  echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td></tr>";
                              }
                          }
                      } else if (!isset($appointments4) || empty($appointments4)) {
                          $set = true;
                          echo "<tr><td>Nichts</td></tr>";
                      }
                      if (isset($appointments4) && !empty($appointments4)) {
                          foreach ($appointments4 as $appointment) {
                              $connection = Verbindung::is_first_connection($appointment['idVerbindung'], Benutzer::get_logged_in_user()->idBenutzer);
                              $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                              if ($date < $today && $appointment['akzeptiert'] == 0) {
                                  Stunde::deleteStunde($appointment['idStunde']);
                                  Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!");
                                  continue;
                              }
                              echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                              if ($appointment['bestaetigtSchueler'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
      
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
                              if ($appointment['bestaetigtLehrer'] == 0) {
                                  if ($date < $today) {
                                      echo "<td class='alert'>Nein</td>";
                                  } else {
                                      echo "<td class='alert'>Datum nicht abgelaufen</td>";
                                  }
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($appointment['lehrerVorgeschlagen'] == 1 && $appointment['akzeptiert'] == 0) {
                                  echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check'></i></button>";
                                  echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x'></i></button></div></div></td>";
                              } else if ($appointment['akzeptiert'] == 0) {
                                  echo "<td class='alert'>Nein</td>";
                              } else {
                                  echo "<td class='success'>Ja</td>";
                              }
      
                              if ($connection) {
                                  echo "<td class='success'>Nein</td>";
                              } else {
                                  echo "<td class='warning'>Ja</td>";
                              }
      
                              echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td></tr>";
                          }
                      } else if (!$set) {
                          echo "<tr><td>Nichts</td></tr>";
                      }
                      ?>
                      </tbody>
                  </table>
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