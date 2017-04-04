<ul class="menu main vertical">

    <?php
    $request = $_SERVER['REQUEST_URI'];
    $root = ConfigStrings::get("root");
    ?>

    <li <?php if(strlen($request) == 1) echo "class='selected'" ?>><a href="<?php echo $root?>home">Home</a></li>
    <li <?php if(strpos($request, 'suche') !== false) echo "class='selected'" ?>><a href="<?php echo $root?>suche">Suche</a></li>
    <li <?php if(strpos($request, 'user') !== false) echo "class='selected'" ?>><a href="<?php echo $root?>user/<?php echo Benutzer::get_logged_in_user()->idBenutzer?>/view">Profil</a></li>
    <li <?php if(strpos($request, 'notifications') !== false) echo "class='selected'" ?>><a href="<?php echo $root?>notifications">Nachrichten</a></li>

    <?php

    if(Benutzer::get_logged_in_user()->has_permission('termine')) {
        $isTrue = "";
        if(strpos($request, 'termine') !== false){
            $isTrue = "class='selected'";
        }
        echo "<li $isTrue><a href='{$root}termine'>Termine</a></li>";
    }
    if(Benutzer::get_logged_in_user()->has_permission('giveClasses') || Benutzer::get_logged_in_user()->has_permission('takeClasses')) {
        $isTrue = "";
        if(strpos($request, 'tuition') !== false){
            $isTrue = "class='selected'";
        }
        echo "<li $isTrue><a href='{$root}tuition'>Nachhilfe</a></li>";
    }
    if(Benutzer::get_logged_in_user()->has_permission('administration')) {
        $isTrue = "";
        if(strpos($request, 'admin') !== false){
            $isTrue = "class='selected'";
        }
        echo "<li $isTrue><a href='{$root}admin'>Administration</a></li>";
    }
    $isTrue = "";
    if((strpos($request, 'goodcredits') !== false) || (strpos($request, 'credits') !== false)){
        $isTrue = "class='selected'";
    }
    echo "<li $isTrue><a href='{$root}goodcredits'>Credits</a></li>";
    ?>
    <li><a href="<?php echo $root?>logout">Logout</a></li>
</ul>