<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 01:00
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../assets/php/dbClasses/Berechtigung.php";

$rolle = Rolle::get_by_id($idRole);
$rolle = Rolle::get_by_id($idRole);
$rights = $rolle->get_rechte();
$allrights = Berechtigung::get_all_rights();

$rights_key_array = Array();
foreach ($rights as $allright) {
    $rights_key_array[$allright->idBerechtigung] = true;
}

?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>

        <h2>Rolle bearbeiten</h2>

        <form data-abide novalidate id="rolle-edit-form" method="post">
            <input type="hidden" name="role-id" value="<?php echo $idRole?>">
            <div class="row">
                <div class="small-12 medium-6 columns">
                    <label>Name
                        <input name="name" type="text" value="<?php echo $rolle->name ?>" required
                               pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
                        <span class="form-error">
                            Der Name muss gesetzt sein und nicht mehr als 25 Zeichen enthalten!
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
                            if(array_key_exists($allright->idBerechtigung, $rights_key_array)){
                                echo "<tr><td class='success'>{$allright->idBerechtigung}</td><td class='success'>{$allright->name}</td><td><button class='tablebutton success' name='rollenButton' value='{$allright->idBerechtigung}'>Besitzt</button></td></tr>";
                            }
                            else{
                                echo "<tr><td class='alert'>{$allright->idBerechtigung}</td><td class='alert'>{$allright->name}</td><td><button class='tablebutton alert' name='rollenButton' value='{$allright->idBerechtigung}'>Besitzt</button></td></tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <button class="button warning" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
