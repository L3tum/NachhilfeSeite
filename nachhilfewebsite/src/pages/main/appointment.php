<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 00:09
 */

include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Raum.php";

$current_user = Benutzer::get_logged_in_user();
$connections = $current_user->get_connection_other();

$others = Array();

foreach ($connections as $connection) {
    if ($connection{'einsID'} == $current_user->idBenutzer) {
        $others[$connection['zweiID']] = Array();
        $others[$connection['zweiID']]['ID'] = $connection['zweiID'];
        $others[$connection['zweiID']]['vorname'] = $connection['zweivorname'];
        $others[$connection['zweiID']]['name'] = $connection['zweiname'];
    } else {
        $others[$connection['einsID']] = Array();
        $others[$connection['einsID']]['ID'] = $connection['einsID'];
        $others[$connection['einsID']]['vorname'] = $connection['einsvorname'];
        $others[$connection['einsID']]['name'] = $connection['einsname'];
    }
}

$rooms = Raum::get_all_rooms();

?>

<div class="row main">
    <div class="small-12 columns">
        <form id="appointment-form">
        <table>
            <thead>
            <tr>
                <th>An</th>
                <th>Fach</th>
                <th>Datum</th>
                <th>Zeit</th>
                <th>Raum</th>
                <th>Abschicken</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="idUser">
                        <?php
                        foreach ($others as $other) {
                            echo "<option id='{$other['ID']}'>{$other['vorname']} {$other['name']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="idSubject">

                    </select>
                </td>
                <td>
                    <input type="date" id="datetime_app" name="datetime_app">
                </td>
                <td>
                    <input type="time" id="time_app" name="time_app">
                </td>
                <td>
                    <select name="idRoom">
                    <?php
                    foreach ($rooms as $room){
                        echo "<option id='{$room->raumNummer}'>{$room->raumNummer}</option>";
                    }
                    ?>
                    </select>
                </td>
                <td>
                    <button class="button success" type="submit" id="submitty" name="submitty">Abschicken</button>
                </td>
            </tr>
            </tbody>
        </table>
        </form>
    </div>
</div>
