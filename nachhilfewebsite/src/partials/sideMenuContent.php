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