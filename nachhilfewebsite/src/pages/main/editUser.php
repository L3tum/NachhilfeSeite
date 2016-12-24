<?php

if(Benutzer::get_logged_in_user()->idBenutzer == $user_to_edit_id) {
    $user = Benutzer::get_logged_in_user();
}
else {
    $user = Benutzer::get_by_id($user_to_edit_id);
    if(!$user) {
        Route::redirect_to_root();
    }
}

?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>

        <h2>Profil bearbeiten</h2>

        <form data-abide novalidate id="user-edit-form" method="post">
            <div class="row">

                <input type="hidden" name="user-id" value=<?php echo $user->idBenutzer?>>

                <div class="small-12 medium-6 columns">
                    <label>Vorname
                        <input <?php if(!Benutzer::get_logged_in_user()->has_permission("canEditName")) {echo "readonly";}?> value="<?php echo $user->vorname?>" name="vorname" type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                <span class="form-error">
                    Der Vorname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                    </label>

                    <label>Nachname
                        <input <?php if(!Benutzer::get_logged_in_user()->has_permission("canEditName")) {echo "readonly";}?> value="<?php echo $user->name?>" name="nachname" type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                <span class="form-error">
                    Der Nachname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                    </label>

                    <label>Passwort
                        <input name="passwort" type="password" id="passwort">
                <span class="form-error">
                    Das Passwortfeld darf nicht leer sein.
                </span>
                    </label>

                    <label style="display:none" id="passwort-wiederholung">Passwort Wiederholung
                        <input name="passwort-wiederholung" type="password" data-equalto="passwort">
                <span class="form-error">
                    Die Passwörter müssen übereinstimmen.
                </span>
                    </label>

                    <label>Telefonnummer
                        <input  value="<?php echo $user->telefonnummer?>" pattern="^[0-9]{0,15}$" name="telefonnummer" type="tel">
                <span class="form-error">
                    Das Feld muss eine gültige Telefonnummer enthalten, diese darf nur aus Zahlen bestehen.
                </span>
                    </label>

                    <label>Email
                        <input  value="<?php echo $user->email?>" name="email" type="email">
                <span class="form-error">
                    Das Feld muss eine gültige Email-Adresse enthalten.
                </span>
                    </label>

                    <button class="button" type="submit" value="Submit">Submit</button>
                </div>


        </form>


    </div>


</div>



    </div>

</div>