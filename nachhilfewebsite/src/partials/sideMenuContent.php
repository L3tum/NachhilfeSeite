<ul class="menu main vertical">

    <?php
    $root = ConfigStrings::get("root");
    ?>

    <li><a href="<?php echo $root?>home">Home</a></li>
    <li><a href="<?php echo $root?>suche">Suche</a></li>
    <li><a href="<?php echo $root?>user/<?php echo Benutzer::get_logged_in_user()->idBenutzer?>/view">Profil</a></li>
    <li><a href="<?php echo $root?>nachrichten">Nachrichten</a></li>

    <?php

    if(Benutzer::get_logged_in_user()->has_permission('termine')) {
        echo "<li><a href='{$root}termine'>Termine</a></li>";
    }
    if(Benutzer::get_logged_in_user()->has_permission('nachhilfe')) {
        echo "<li><a href='{$root}nachhilfe'>Nachhilfe</a></li>";
    }
    if(Benutzer::get_logged_in_user()->has_permission('administration')) {
        echo "<li><a href='{$root}admin'>Administration</a></li>";
    }
    ?>
    <li><a href="<?php echo $root?>logout">Logout</a></li>
</ul>