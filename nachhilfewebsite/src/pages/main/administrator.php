<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <h2>Aktionen</h2>
        <?php
        if (Benutzer::get_logged_in_user()->has_permission("registerNewUser")) {
            echo "<a id='register_new_user' class='button' type='submit' value='Submit'>Registriere neuen Benutzer</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showAllRoles")) {
            echo "<a id='show_roles' class='button' type='submit' value='Submit'>Zeige alle Rollen</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showAllConnections")) {
            echo "<a id='show_connections' class='button' type='submit' value='Submit'>Zeige alle Nachhilfeverbindungen</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showPendingHours")) {
            echo "<a id='show_pending_hours' class='button' type='submit' value='Submit'>Zeige alle ausstehenden Stunden</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showUnpaidHours")) {
            echo "<a id='show_unpaid_hours' class='button alert' type='submit' value='Submit'>Zeige alle bisher unbezahlten Stunden</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showAllFreeRooms")) {
            echo "<a id='show_free_rooms' class='button success' type='submit' value='Submit'>Zeige alle freien Räume</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showAllTakenRooms")) {
            echo "<a id='show_taken_rooms' class='button' type='submit' value='Submit'>Zeige alle gebuchten Räume</a><br>";
        }
        if (Benutzer::get_logged_in_user()->has_permission("showAllComplaints")) {
            echo "<a id='show_complaints' class='button warning' type='submit' value='Submit'>Zeige alle Beschwerden</a><br>";
        }
        ?>
    </div>
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <h2>Ergebnisse</h2>
        <div class="result-boxes-inner search" id="results" name="results">

        </div>
    </div>
</div>