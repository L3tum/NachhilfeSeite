
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foundation for Sites</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.ttf">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css" rel="stylesheet">
    <link href="cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/app.css">

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
         
             <li><a href="home">Home</a></li>
             <li><a href="suche">Suche</a></li>
             <li><a href="profil">Profil</a></li>
             <li><a href="nachrichten">Nachrichten</a></li>
         
             <?php
         
             if(Benutzer::get_logged_in_user()->has_permission('termine')) {
                 echo '<li><a href="termine">Termine</a></li>';
             }
             if(Benutzer::get_logged_in_user()->has_permission('nachhilfe')) {
                 echo '<li><a href="nachhilfe">Nachhilfe</a></li>';
             }
             if(Benutzer::get_logged_in_user()->has_permission('administration')) {
                 echo '<li><a href="admin">Administration</a></li>';
             }
             ?>
             <li><a href="logout">Logout</a></li>
         </ul>
      </div>
      <div class="off-canvas-content" data-off-canvas-content>
      <h2>Aktionen</h2>
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button" type="submit" value="Submit">Suchen</button>
          </div>
      </div>
      
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button" type="submit" value="Submit">Benachrichtigungen</button>
          </div>
      </div>
      
      
      <?php
      if(Benutzer::get_logged_in_user()->get_role() == "Administrator") {
      
      }
      ?>
      
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button" type="submit" value="Submit">Profil betrachten</button>
          </div>
      </div>
      
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button" type="submit" value="Submit">Profil bearbeiten</button>
          </div>
      </div>
      
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button alert" type="submit" value="Submit">Administration</button>
          </div>
      </div>
      
      <div class="row actions">
          <div class="small-12 columns">
              <button class="button alert " type="submit" value="Submit">Nutzer melden</button>
          </div>
      </div>
      </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/1.0.0/anime.min.js"></script>

    <script src="assets/js/app.js"></script>

  </body>
</html>