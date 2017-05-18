<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 00:09
 */

include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Raum.php";
include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
include_once __DIR__ . "/../assets/php/dbClasses/AngebotenesFach.php";

$current_user = Benutzer::get_logged_in_user();
$others = $current_user->get_all_connections_single();

$offered_subjects = AngebotenesFach::get_offered_subjects();
$rooms = Raum::get_all_rooms();

?>

<div class="row main">
    <div class="small-12 columns">
        <br>
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
                        <select name="idUser" id="idUser">
                            <option value="no">Nichts</option>
                            <?php
                            foreach ($others as $other) {
                                echo "<option value='{$other['ID']}'>{$other['vorname']} {$other['name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="idSubject" id="idSubject">
                            <option value="no">Nichts</option>
                            <?php
                            foreach ($offered_subjects as $subject) {
                                echo "<option value='{$subject->idFach}'>{$subject->name}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" id="datetime_app" name="datetime_app">
                    </td>
                    <td>
                        <input type="time" id="time_app" name="time_app">
                    </td>
                    <td>
                        <select name="idRoom" id="idRoom">
                            <option value="no">Nichts</option>
                            <?php
                            foreach ($rooms as $room) {
                                echo "<option value='{$room->raumNummer}'>{$room->raumNummer}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <button class="button success" type="submit" id="submit" name="Submit">Abschicken</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
