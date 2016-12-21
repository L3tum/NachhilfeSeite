<ul class="menu main vertical">

    <?php

    ConfigStrings::set("basepath", "nachhilfewebsite/dist");
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $root = "http://$host$uri/";
    ?>

    <li><a href="<?php echo $root?>home">Home</a></li>
    <li><a href="<?php echo $root?>suche">Suche</a></li>
    <li><a href="<?php echo $root?>user/<?php echo Benutzer::get_logged_in_user()->idBenutzer?>/view">Profil</a></li>
    <li><a href="<?php echo $root?>nachrichten">Nachrichten</a></li>

    <?php

    if(Benutzer::get_logged_in_user()->has_permission('termine')) {
        echo '<li><a href="$roottermine">Termine</a></li>';
    }
    if(Benutzer::get_logged_in_user()->has_permission('nachhilfe')) {
        echo '<li><a href="$rootnachhilfe">Nachhilfe</a></li>';
    }
    if(Benutzer::get_logged_in_user()->has_permission('administration')) {
        echo '<li><a href="$rootadmin">Administration</a></li>';
    }
    ?>
    <li><a href="<?php echo $root?>logout">Logout</a></li>
</ul>