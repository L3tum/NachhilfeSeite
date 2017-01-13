<?php

if (Benutzer::get_logged_in_user()->idBenutzer == $user_to_edit_id) {
    $user = Benutzer::get_logged_in_user();
} else {
    $user = Benutzer::get_by_id($user_to_edit_id);
    if (!$user) {
        Route::redirect_to_root();
    }
}

?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>

        <h2>Profil bearbeiten</h2>

        <form data-abide novalidate id="user-edit-form" method="post">
            <div class="row">

                <input type="hidden" name="user-id" id="user-id" value=<?php echo $user->idBenutzer ?>>

                <div class="small-12-centered medium-6-centered columns">
                    <div class="small-10-centered medium-5-centered columns no-padding both">
                        <label>Vorname
                            <input <?php if (!Benutzer::get_logged_in_user()->has_permission("canEditName")) {
                                echo "readonly";
                            } ?> value="<?php echo $user->vorname ?>" name="vorname" type="text" placeholder="Max"
                                 required
                                 pattern="^[a-zA-ZÄÖÜäöüß ]{1,25}$">
                            <span class="form-error">
                    Der Vorname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                        </label>

                        <label>Nachname
                            <input <?php if (!Benutzer::get_logged_in_user()->has_permission("canEditName")) {
                                echo "readonly";
                            } ?> value="<?php echo $user->name ?>" name="nachname" type="text" placeholder="Mustermann"
                                 required pattern="^[a-zA-ZÄÖÜäöüß ]{1,25}$">
                            <span class="form-error">
                    Der Nachname darf nicht leer sein und nur aus Bustaben bestehen.
                </span>
                        </label>

                        <label>Neues Passwort
                            <input name="passwort" type="password" id="passwort">
                            <span class="form-error">
                    Das Passwortfeld darf nicht leer sein.
                </span>
                        </label>

                        <label style="display:none" id="passwort-wiederholung">Neues Passwort Wiederholung
                            <input name="passwort-wiederholung" type="password" data-equalto="passwort">
                            <span class="form-error">
                    Die Passwörter müssen übereinstimmen.
                </span>
                        </label>

                        <label>Telefonnummer
                            <input value="<?php echo $user->telefonnummer ?>" pattern="^[0-9]{0,15}$"
                                   name="telefonnummer"
                                   type="tel">
                            <span class="form-error">
                    Das Feld muss eine gültige Telefonnummer enthalten, diese darf nur aus Zahlen bestehen.
                </span>
                        </label>

                        <label>Email
                            <input value="<?php echo $user->email ?>" name="email" type="email">
                            <span class="form-error">
                    Das Feld muss eine gültige Email-Adresse enthalten.
                </span>
                        </label>

                        <?php
                        if (Benutzer::get_logged_in_user()->has_permission("editUserRole") == true) {
                            echo "<label>Rolle
                        <select id='rollenSelector' name='rollenSelector'>";
                            $rollen = Rolle::get_all_roles();
                            $rolleID = Benutzer::get_by_id($user_to_edit_id)->get_role_id();
                            foreach ($rollen as $rolle) {
                                echo "<option id='{$rolle->idRolle}' value='{$rolle->idRolle}' ";
                                if ($rolleID == $rolle->idRolle) {
                                    echo "selected='selected'";
                                }
                                echo ">{$rolle->name}</option>";
                            }
                            echo "</select>
                        </label>";
                        }
                        if (Benutzer::get_logged_in_user()->has_permission("editSubjects") == true && Benutzer::get_by_id($user_to_edit_id)->has_permission("giveClasses")) {
                            echo "<div class='data-label'><label>Fächer</label>";
                            $subjects = Fach::get_all_subjects();
                            $user_to_edit = $user;
                            $subject_key_array = Array();
                            foreach ($subjects as $subject) {
                                if ($user_to_edit->offers_subject($subject->idFach)) {
                                    $subject_key_array[$subject->idFach] = true;
                                }
                            }
                            foreach ($subjects as $subject) {
                                if (array_key_exists($subject->idFach, $subject_key_array)) {
                                    echo "<button class='button success' id='{$subject->idFach}' name='subjectChoosing'>{$subject->name}</button>";
                                } else {
                                    echo "<button class='button alert' id='{$subject->idFach}' name='subjectChoosing'>{$subject->name}</button>";
                                }
                            }
                            echo "</div>";
                        }
                        if (Benutzer::get_logged_in_user()->has_permission("editYears") == true && Benutzer::get_by_id($user_to_edit_id)->has_permission("giveClasses")) {
                            echo "<div class='data-label'><label>Stufen</label>";
                            $subjects = Stufe::get_all_years();
                            $user_to_edit = $user;
                            $subject_key_array = Array();
                            foreach ($subjects as $subject) {
                                if ($user_to_edit->offers_year($subject->idStufe)) {
                                    $subject_key_array[$subject->idStufe] = true;
                                }
                            }
                            foreach ($subjects as $subject) {
                                if (array_key_exists($subject->idStufe, $subject_key_array)) {
                                    echo "<button class='button success' id='{$subject->idStufe}' name='yearChoosing'>{$subject->name}</button>";
                                } else {
                                    echo "<button class='button alert' id='{$subject->idStufe}' name='yearChoosing'>{$subject->name}</button>";
                                }
                            }
                            echo "</div>";
                        }
                        if (Benutzer::get_logged_in_user()->has_permission("editQuals") == true && Benutzer::get_by_id($user_to_edit_id)->has_permission("giveClasses")) {
                            echo "<div class='data-label'>";
                            echo "<label>Qualifikationen</label>";
                            echo "<input type='text' id='qual_name' name='qual_name' placeholder='Name'>";
                            echo "<input type='text' id='qual_desc' name='qual_desc' placeholder='Beschreibung'>";
                            echo "<button class='button success' type='button' id='add_qual' name='add_qual'>Qualifikation Hinzufügen</button>";
                            echo "</div>";
                            //Remove Quals
                        }
                        ?>
                        <br><button class="button" type="submit" value="Submit">Submit</button>
                    </div>
                </div>

        </form>


    </div>


</div>