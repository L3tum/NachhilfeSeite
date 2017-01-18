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
              <div class="row">
                  <div class="small-12 columns">
                      <h2 class="text-left">Suche</h2>
                  </div>
      
                  <div class="small-12 columns">
                      <form data-abide novalidate id="search-form" method="post">
      
      
                          <div class="row no-padding right">
                              <div class="small-12 columns no-padding right">
                                  <div class="small-7 columns">
                                      <label>Sortierung
                                          <select name="sort">
                                              <option value="no">Keine Sortierung</option>
                                              <option
                                                  value="Vorname" <?php if (isset($sorting_sel) && $sorting_sel == 'Vorname') {
                                                  echo "selected='selected'";
                                              } ?>>Vorname
                                              </option>
                                              <option value="Name" <?php if (isset($sorting_sel) && $sorting_sel == 'Name') {
                                                  echo "selected='selected'";
                                              } ?>>Nachname
                                              </option>
                                              <option value="Fach <?php if (isset($sorting_sel) && $sorting_sel == 'Fach') {
                                                  echo "selected='selected'";
                                              } ?>">Fach
                                              </option
                                              <option value="Stufe <?php if (isset($sorting_sel) && $sorting_sel == 'Stufe') {
                                                  echo "selected='selected'";
                                              } ?>">Stufe
                                              </option>
                                          </select>
                                      </label>
                                  </div>
                                  <div class="small-5 columns">
                                      <label>Alphabetisch
                                          <select name="ascDesc">
                                              <option value="asc" <?php if(isset($ascDesc_sel) && $ascDesc_sel == 'asc'){ echo "selected='selected'";} ?>>Aufsteigend</option>
                                              <option value="desc" <?php if(isset($ascDesc_sel) && $ascDesc_sel == 'desc'){ echo "selected='selected'";} ?>>Absteigend</option>
                                          </select>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
      
                              <div class="small-12 medium-6 columns small-centered">
                                  <br>
                                  <label>Vorname
                                      <input name="vorname" type="text" placeholder="Max" <?php if (isset($vorname_sel)) {
                                          echo "value='" . $vorname_sel . "'";
                                      } ?>>
                                      <span class="form-error">
                                          Der Vorname ist invalid!
                                      </span>
                                  </label>
      
                                  <label>Nachname
                                      <input name="nachname" type="text" placeholder="Mustermann"<?php if (isset($name_sel)) {
                                          echo "value='" . $name_sel . "'";
                                      } ?>>
                                      <span class="form-error">
                                          Der Nachname ist invalid!
                                      </span>
                                  </label>
      
                                  <div class="row">
                                      <div class="large-12 columns">
                                          <label>Stufen
                                              <select name="stufen">
                                                  <option value="hallo">Keine Stufe</option>
                                                  <?php
                                                  $stmt = Connection::$PDO->prepare("SELECT * FROM stufe");
                                                  $stmt->execute();
                                                  $stufen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
                                                  foreach ($stufen AS $stufe) {
                                                      echo "<option value={$stufe->idStufe} ";
                                                      if (isset($stufe_sel) && $stufe_sel == $stufe->idStufe) {
                                                          echo "selected='selected'";
                                                      }
                                                      echo "> {$stufe->name}</option>";
                                                  }
                                                  ?>
                                              </select>
                                          </label>
                                      </div>
                                  </div>
      
                                  <div class="row">
                                      <div class="large-12 columns">
                                          <label>Fächer
                                              <select name="faecher">
                                                  <option value="hallo">Kein Fach</option>
                                                  <?php
                                                  $stmt = Connection::$PDO->prepare("SELECT * FROM fach");
                                                  $stmt->execute();
                                                  $faecher = $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
      
                                                  foreach ($faecher AS $fach) {
                                                      echo "<option value={$fach->idFach} ";
                                                      if (isset($fach_sel) && $fach_sel == $fach->idFach) {
                                                          echo "selected='selected'";
                                                      }
                                                      echo "> {$fach->name}</option>";
                                                  }
                                                  ?>
                                              </select>
                                          </label>
                                      </div>
                                  </div>
      
                                  <div class="row">
                                      <div class="large-12 columns">
                                          <label>Rollen
                                              <select id="rollen" name="rollen">
                                                  <option value="hallo">Keine Rolle</option>
                                                  <?php
                                                  $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
                                                  $stmt->execute();
                                                  $rollen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
                                                  foreach ($rollen AS $rolle) {
                                                      echo "<option value={$rolle->idRolle} ";
                                                      if (isset($rolle_sel) && $rolle_sel == $rolle->idRolle) {
                                                          echo "selected='selected'";
                                                      }
                                                      echo "> {$rolle->name}</option>";
                                                  }
                                                  ?>
                                              </select>
                                          </label>
      
                                          <button class="button" type="submit" value="Submit">Suche starten</button>
                                      </div>
      
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
      
      
          </div>
      
          <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
      
              <div class="row">
                  <div class="small-12 columns">
                      <h2 class="text-left">Ergebnisse</h2>
                  </div>
              </div>
      
              <div class="row">
      
                  <div class="small-12 columns result-boxes">
                      <div class="result-boxes-inner search" id="search-results">
      
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