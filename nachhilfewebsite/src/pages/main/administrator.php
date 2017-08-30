<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <h2>Aktionen</h2>
        <div class="row actions">
            <div class="small-12 columns">
        <?php
        switch($parameters){
            case null:{
                echo "<a href='{$root}admin/benutzer' class='button success' type='button'>Verwalte Benutzer</a><br>";
                echo "<a href='{$root}admin/hours' class='button success' type='button'>Verwalte Stunden</a><br>";
                echo "<a href='{$root}admin/connections' class='button warning' type='button'>Verwalte Verbindungen</a><br>";
                echo "<a href='{$root}admin/nachhilfe' class='button alert' type='button'>Verwalte Nachhilfeangebote</a><br>";
                echo "<a href='{$root}admin/roles' class='button alert' type='button'>Verwalte Rollen</a><br>";
                echo "<a href='{$root}admin/settings' class='button alert' type='button'>Verwalte Einstellungen</a><br>";
                break;
            }
            case 'benutzer':{
                if (Benutzer::get_logged_in_user()->has_permission("registerNewUser")) {
                    echo "<a id='register_new_user' class='button' type='submit' value='Submit'>Registriere neuen Benutzer</a><br>";
                }
                if(Benutzer::get_logged_in_user()->has_permission("addUser")){
                    echo "<a id='add_user' class='button' type='submit' value='Submit'>Füge einen neuen Benutzer hinzu</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("delete_user")) {
                    echo "<a id='del_user' class='button alert' type='submit' value='Submit'>Benutzer löschen</a><br>";
                }
                if(Benutzer::get_logged_in_user()->has_permission("unblock_user")){
                    echo "<a id='unblock_user' class='button' type='submit' value='Submit'>Benutzer freischalten</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("showAllComplaints")) {
                    echo "<a id='show_complaints' class='button warning' type='submit' value='Submit'>Zeige alle Beschwerden</a><br>";
                }
                break;
            }
            case 'hours':{
                if (Benutzer::get_logged_in_user()->has_permission("showAllHours")) {
                    echo "<a id='show_all_hours' class='button' type='submit' value='Submit'>Zeige alle Stunden</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("showAllFreeRooms")) {
                    echo "<a id='show_free_rooms' class='button success' type='submit' value='Submit'>Zeige alle freien Räume</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("showAllTakenRooms")) {
                    echo "<a id='show_taken_rooms' class='button' type='submit' value='Submit'>Zeige alle gebuchten Räume</a><br>";
                }
                break;
            }
            case 'connections':{
                if (Benutzer::get_logged_in_user()->has_permission("showAllConnections")) {
                    echo "<a id='show_connections' class='button' type='submit' value='Submit'>Zeige alle Nachhilfeverbindungen</a><br>";
                }
                break;
            }
            case 'nachhilfe':{
                if (Benutzer::get_logged_in_user()->has_permission("addNewSubject")) {
                    echo "<a id='add_subject' class='button' type='submit' value='Submit'>Füge ein Fach hinzu</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("deleteSubject")) {
                    echo "<a id='del_subject' class='button alert' type='submit' value='Submit'>Lösche ein Fach</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("addNewYear")) {
                    echo "<a id='add_year' class='button' type='submit' value='Submit'>Füge ein Schuljahr hinzu</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("deleteYear")) {
                    echo "<a id='del_year' class='button alert' type='submit' value='Submit'>Lösche Schuljahr</a><br>";
                }
                break;
            }
            case 'roles':{
                if (Benutzer::get_logged_in_user()->has_permission("showAllRoles")) {
                    echo "<a id='show_roles' class='button' type='submit' value='Submit'>Zeige alle Rollen</a><br>";
                }
                if (Benutzer::get_logged_in_user()->has_permission("add_right")) {
                    echo "<a id='add_right' class='button' type='submit' value='Submit'>Füge eine Berechtigung hinzu</a><br>";
                }
                break;
            }
            case 'settings':{
                if(Benutzer::get_logged_in_user()->has_permission("set_settings")){
                    echo "<a id='set_settings' class='button' type='submit' value='Submit'>Setze Einstellungen</a><br>";
                }
                if(Benutzer::get_logged_in_user()->has_permission("add_settings")){
                    echo "<a id='add_setting' class='button' type='submit' value='Submit'>Füge eine Einstellung hinzu</a><br>";
                }
                if(Benutzer::get_logged_in_user()->has_permission("execute_sql")){
                    echo "<a id='exec_sql' class='button' type='submit' value='Submit'>Führe SQL aus</a><br>";
                }
                if(Benutzer::get_logged_in_user()->has_permission("sendTestMail")){
                    echo '<button class="button" id="sendMail" type="submit">SendMail</button>';
                }
                break;
            }
        }
        ?>
            </div>

        </div>
    </div>
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <h2>Ergebnisse</h2>
        <div class="result-boxes-inner" id="results" name="results">

        </div>
    </div>
</div>