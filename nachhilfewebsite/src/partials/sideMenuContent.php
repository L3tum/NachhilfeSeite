<ul class="menu main vertical">

    <li><a href="#">Suche</a></li>
    <li><a href="#">Termine</a></li>
    <li><a href="#">Profil</a></li>
    <li><a href="#">Benachrichtigungen</a></li>

    <?php

    if(Benutzer::get_logged_in_user()->has_permission('nachhilfe')) {
        echo '<li><a href="#">Nachhilfe</a></li>';
    }
    else if(Benutzer::get_logged_in_user()->has_permission('administration')) {
        echo '<li><a href="#">Administration</a></li>';
    }
    ?>
</ul>