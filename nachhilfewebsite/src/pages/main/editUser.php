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

                <div class="small-12 medium-6 columns">
                    <label>Vorname
                        <input readonly value="<?php echo $user->vorname?>" name="vorname" type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                <span class="form-error">
                    Der Vorname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                    </label>

                    <label>Nachname
                        <input readonly value="<?php echo $user->name?>" name="nachname" type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                <span class="form-error">
                    Der Nachname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                    </label>

                    <label>Passwort
                        <input name="password" type="password">
                <span class="form-error">
                    Das Passwortfeld darf nicht leer sein.
                </span>
                    </label>

                    <label>Passwort Wiederholung
                        <input name="password" type="password">
                <span class="form-error">
                    Das Passwortfeld darf nicht leer sein.
                </span>
                    </label>

                    <label>Telefonnummer
                        <input  value="<?php echo $user->telefonnummer?>" name="password" type="tel">
                <span class="form-error">
                    Das Feld muss eine gültige Telefonnummer enthalten.
                </span>
                    </label>

                    <label>Email
                        <input  value="<?php echo $user->email?>" name="password" type="email">
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