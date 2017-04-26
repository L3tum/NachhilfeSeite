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
$rights = $rolle->get_rechte();
$allrights = Berechtigung::get_all_rights();

$rights_key_array = Array();
foreach ($rights as $allright) {
    $rights_key_array[$allright->idBerechtigung] = true;
}

?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <h2>Rolle</h2>
                <?php
                echo "<div class='data-label'><p>Name: {$rolle->name}</p></div>";
                echo "<div class='data-label'><p>Beschreibung: {$rolle->beschreibung}</p></div><br>";

                echo "<a class='button secondary' href='" . ConfigStrings::get('root') . "role/" . $rolle->idRolle . "/edit'>Rolle bearbeiten</a><br>";

                echo "<p>Die rot markierten Rechte besitzt diese Rolle NICHT!</p>";
                echo "<p>Die grün markierten Rechte besitzt diese Rolle!</p>"
                ?>
                <div class="small-12 columns result-boxes">
                    <div class="result-boxes-inner search">
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Beschreibung</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($allrights as $allright) {
                                if (array_key_exists($allright->idBerechtigung, $rights_key_array)) {
                                    echo "<tr><td><p class='success'>{$allright->name}</p></td><td><p class='success'>{$allright->beschreibung}</p></td></tr>";
                                } else {
                                    echo "<tr><td><p class='alert'>{$allright->name}</p></td><td><p class='alert'>{$allright->beschreibung}</p></td></tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>