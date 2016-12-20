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