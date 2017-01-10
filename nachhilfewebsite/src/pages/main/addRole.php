<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 18:47
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../assets/php/dbClasses/Berechtigung.php";

$allrights = Berechtigung::get_all_rights();
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>

        <h2>Rolle hinzufügen</h2>

        <form data-abide novalidate id="rolle-add-form" method="post">
            <div class="row">
                <div class="small-12-centered medium-6-centered columns">
                    <label>Name
                        <input name="name" id="name" type="text" required
                               pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                        <span class="form-error">
                            Der Name muss gesetzt sein und nicht mehr als 25 Zeichen enthalten!
                        </span>
                    </label>
                    <label>Beschreibung
                        <input name="beschreibung" id="beschreibung" type="text" required>
                        <span class="form-error">
                            Die Beschreibung muss gesetzt sein!
                        </span>
                    </label>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Besitzt</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($allrights as $allright){
                                echo "<tr><td class='alert'>{$allright->idBerechtigung}</td><td class='alert'>{$allright->name}</td><td><button class='tablebutton alert' name='rollenAddingButton' value='{$allright->idBerechtigung}'>Besitzt</button></td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <button class="button warning" type="submit" name="placeholderpls">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

