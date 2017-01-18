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
      
      include_once __DIR__ . "/../assets/php/dbClasses/Chatnachricht.php";
      
      $sender = Benutzer::get_by_id($id_sender);
      $reciever = Benutzer::get_by_id($id_reciever);
      //http://localhost/nachhilfewebsite/dist/user/4/viewMessagesTo/1
      if(($reciever->idBenutzer != Benutzer::get_logged_in_user()->idBenutzer) || !$sender || !$reciever) {
          Route::redirect_to_root();
      
      }
      
      $messages = Chatnachricht::get_all_messages_between($id_sender, $id_reciever);
      ?>
      
      
      <div class="row main" data-equalizer data-equalize-on="medium">
      
          <div class="small-12 smallmedium-12 medium-8 columns result-boxes medium-centered" data-equalizer-watch>
      
              <div class="row">
                  <div class="small-12 columns">
                      <h2>Nachrichten mit <?php echo $sender->vorname . " " . $sender->name?></h2>
                  </div>
              </div>
              <div class="row">
                  <div class="small-12 columns">
                      <form data-abide novalidate id="send-message-form" method="post">
                          <input name="reciever" value="<?php echo $sender->idBenutzer ?>" type="hidden">
                          <textarea name="content" placeholder="Nachricht.."></textarea>
                          <button class="button" type="submit" value="Submit">Nachricht senden</button>
                      </form>
                  </div>
              </div>
      
              <div class="row chat-messages">
      
                  <div class="small-12 columns">
      
                      <div class="row chat-messages">
                      <?php
      
                      foreach($messages as $message) {
      
                          $date = date('H:i', strtotime(str_replace('-','/', $message->datum))) . ":";
      
                          if($message->idEmpfänger ==  Benutzer::get_logged_in_user()->idBenutzer) {
      
                              echo "
                              <div class='columns small-8 float-right'>
                              <div class='data-label'>
                              <p class='message-content'>{$date}</p>
                              <p class='message-content'>{$message->inhalt}</p>
                              </div>
                              </div>
                              ";
                          }
                          else {
      
                              echo "
                              <div class='columns small-8 float-left'>
                              <div class='data-label'>
                              <p class='message-content'>{$date}</p>
                              <p class='message-content'>{$message->inhalt}</p>
                              </div>
                              </div>
                              ";
      
                          }
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