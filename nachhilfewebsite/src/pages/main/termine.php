<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 20:43
 */

include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";

$user = Benutzer::get_logged_in_user();

if ($user->has_permission("giveClasses")) {
    $appointments1 = $user->get_all_appointments_as_teacher(0);
    $appointments3 = $user->get_all_appointments_as_teacher(1);
}
if ($user->has_permission("takeClasses")) {
    $appointments2 = $user->get_all_appointments_as_pupil(0);
    $appointments4 = $user->get_all_appointments_as_pupil(1);
}
$today = date("d.m.Y H:i:s");
?>

<div class="row main">
    <div class="medium-12 columns result-boxes">
        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Anstehende Termine</h2>
            </div>
        </div>
        <br>
        <a class="button success" href="<?php echo ConfigStrings::get("root") . "appointment" ?>">Termin
            vereinbaren</a>
        <br>
        <div class="result-boxes-inner search">
            <table id="tableTermine">
                <thead>
                <tr>
                    <th>Lehrer</th>
                    <th>Schüler</th>
                    <th>Fach</th>
                    <th>Datum</th>
                    <th>Raum</th>
                    <th>Bestätigt(Schüler)</th>
                    <th>Bestätigt(Lehrer)</th>
                    <th>Termin Akzeptiert</th>
                    <?php
                    if ($user->has_permission("takeClasses")) {
                        echo "<th>Du Musst Diese Stunde Bezahlen</th>";
                    }
                    ?>
                    <th>Absagen</th>
                    <th>Blockiert</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $set = false;
                if (isset($appointments1) && !empty($appointments1)) {
                    $set = true;
                    foreach ($appointments1 as $appointment) {
                        $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));


                        echo "<tr><td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$appointment['fachName']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                        if ($appointment['bestaetigtSchueler'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='alert'>Nein</td>";
                            } else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                            }
                            else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($appointment['lehrerVorgeschlagen'] == 0 && $appointment['akzeptiert'] == 0 && !$appointment['vblockiert']) {
                            echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check no-margin-bottom'></i></button>";
                            echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x no-margin-bottom'></i></button></div></div></td>";
                        } else if ($appointment['akzeptiert'] == 0) {
                            echo "<td class='alert'>Nein</td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 1 || $appointment['bestaetigtSchueler'] == 1 && $appointment['akzeptiert'] != -1 && !$appointment['vblockiert']) {
                            echo "<td>Termin hat bereits stattgefunden</td>";
                        } else if($appointment['bestaetigtLehrer'] == 0 &&  $appointment['bestaetigtSchueler'] == 0 && $appointment['akzeptiert'] != -1 && ($appointment['vblockiert'] == 0 || $appointment['vblockiert'] == false)) {
                            echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                        }
                        else {
                            echo "<td><p class='alert'>Absagen nicht möglich</p></td>";
                        }
                        if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                            echo "<td><p class='alert'>Stunde blockiert</p></td></tr>";
                        }
                        else{
                            echo "<td>Alles gut</td></tr>";
                        }
                    }
                } else if (!isset($appointments2) || empty($appointments2)) {
                    $set = true;
                    echo "<tr><td>Nichts</td></tr>";
                }
                if (isset($appointments2) && !empty($appointments2)) {
                    foreach ($appointments2 as $appointment) {
                        $connection = Verbindung::is_first_connection($appointment['idVerbindung'], Benutzer::get_logged_in_user()->idBenutzer);
                        $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));

                        echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$appointment['fachName']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                        if ($appointment['bestaetigtSchueler'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                            }
                            else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='alert'>Nein</td>";
                            } else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($appointment['lehrerVorgeschlagen'] == 1 && $appointment['akzeptiert'] == 0 && !$appointment['vblockiert']) {
                            echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check'></i></button>";
                            echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x'></i></button></div></div></td>";
                        } else if ($appointment['akzeptiert'] == 0) {
                            echo "<td class='alert'>Nein</td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($connection) {
                            echo "<td class='success'>Nein</td>";
                        } else {
                            echo "<td class='warning'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 1 || $appointment['bestaetigtSchueler'] == 1 && $appointment['akzeptiert'] != -1 && ($appointment['vblockiert'] == 0 || $appointment['vblockiert'] == false)) {
                            echo "<td>Termin hat bereits stattgefunden</td>";
                        } else if($appointment['bestaetigtLehrer'] == 0 &&  $appointment['bestaetigtSchueler'] == 0 && $appointment['akzeptiert'] != -1 && ($appointment['vblockiert'] == 0 || $appointment['vblockiert'] == false)) {
                            echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                        }
                        else {
                            echo "<td><p class='alert'>Absagen nicht möglich</p></td>";
                        }
                        if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                            echo "<td><p class='alert'>Stunde blockiert</p></td></tr>";
                        }
                        else{
                            echo "<td>Alles gut</td></tr>";
                        }
                    }
                } else if (!$set) {
                    echo "<tr><td>Nichts</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="medium-12 columns result-boxes">
        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Abgelaufene Termine</h2>
            </div>
        </div>
        <div class="result-boxes-inner search">
            <br>
            <table id="tableTermine">
                <thead>
                <tr>
                    <th>Lehrer</th>
                    <th>Schüler</th>
                    <th>Fach</th>
                    <th>Datum</th>
                    <th>Raum</th>
                    <th>Bestätigt(Schüler)</th>
                    <th>Bestätigt(Lehrer)</th>
                    <th>Termin Akzeptiert</th>
                    <?php
                    if ($user->has_permission("takeClasses")) {
                        echo "<th>Du Musst Diese Stunde Bezahlen</th>";
                    }
                    ?>
                    <th>Absagen</th>
                    <th>Blockiert</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $set = false;
                if (isset($appointments3) && !empty($appointments3)) {
                    $set = true;
                    foreach ($appointments3 as $appointment) {
                        $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));

                        if ($date < $today && $appointment['akzeptiert'] == 0) {
                            Stunde::deleteStunde($appointment['idStunde']);
                            Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . " wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!", true);
                            Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . " wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!", true);
                            continue;
                        }

                        echo "<tr><td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$appointment['fachName']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                        if ($appointment['bestaetigtSchueler'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='alert'>Nein</td>";
                            } else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                            }
                            else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($appointment['lehrerVorgeschlagen'] == 0 && $appointment['akzeptiert'] == 0 && !$appointment['vblockiert']) {
                            echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check no-margin-bottom'></i></button>";
                            echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x no-margin-bottom'></i></button></div></div></td>";
                        } else if ($appointment['akzeptiert'] == 0) {
                            echo "<td class='alert'>Nein</td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 1 || $appointment['bestaetigtSchueler'] == 1 && $appointment['akzeptiert'] != -1 && !$appointment['vblockiert']) {
                            echo "<td>Termin hat bereits stattgefunden</td>";
                        } else if($appointment['bestaetigtLehrer'] == 0 &&  $appointment['bestaetigtSchueler'] == 0 && $appointment['akzeptiert'] != -1 && ($appointment['vblockiert'] == 0 || $appointment['vblockiert'] == false)) {
                            echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                        }
                        else {
                            echo "<td><p class='alert'>Absagen nicht möglich</p></td>";
                        }
                        if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                            echo "<td><p class='alert'>Stunde blockiert</p></td></tr>";
                        }
                        else{
                            echo "<td>Alles gut</td></tr>";
                        }
                    }
                } else if (!isset($appointments4) || empty($appointments4)) {
                    $set = true;
                    echo "<tr><td>Nichts</td></tr>";
                }
                if (isset($appointments4) && !empty($appointments4)) {
                    foreach ($appointments4 as $appointment) {
                        $connection = Verbindung::is_first_connection($appointment['idVerbindung'], Benutzer::get_logged_in_user()->idBenutzer);
                        $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                        if ($date < $today && $appointment['akzeptiert'] == 0) {
                            Stunde::deleteStunde($appointment['idStunde']);
                            Benachrichtigung::add($appointment['idNachhilfelehrer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!", true);
                            Benachrichtigung::add($appointment['idNachhilfenehmer'], "Eine Stunde wurde gelöscht!", "Die Stunde am " . $date . " mit " . $appointment['vorname'] . " " . $appointment['name'] . "wurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!", true);
                            continue;
                        }
                        echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$appointment['fachName']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                        if ($appointment['bestaetigtSchueler'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='text-center'><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                            }
                            else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }

                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 0) {
                            if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                                echo "<td class='alert'>Blockiert</td>";
                            }
                            else if ($date < $today) {
                                echo "<td class='alert'>Nein</td>";
                            } else {
                                echo "<td class='alert'>Datum nicht abgelaufen</td>";
                            }
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($appointment['lehrerVorgeschlagen'] == 1 && $appointment['akzeptiert'] == 0 && !$appointment['vblockiert']) {
                            echo "<td class='text-center'><div class='button-group no-margin-bottom'><button class='button success' type='submit' name='acceptAppointment' id='{$appointment['idStunde']}'><i class='fi-check'></i></button>";
                            echo "<button class='button alert' type='submit' name='denyAppointment' id='{$appointment['idStunde']}'><i class='fi-x'></i></button></div></div></td>";
                        } else if ($appointment['akzeptiert'] == 0) {
                            echo "<td class='alert'>Nein</td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }

                        if ($connection) {
                            echo "<td class='success'>Nein</td>";
                        } else {
                            echo "<td class='warning'>Ja</td>";
                        }
                        if ($appointment['bestaetigtLehrer'] == 1 || $appointment['bestaetigtSchueler'] == 1 && $appointment['akzeptiert'] != -1 && !$appointment['vblockiert']) {
                            echo "<td>Termin hat bereits stattgefunden</td>";
                        } else if($appointment['bestaetigtLehrer'] == 0 &&  $appointment['bestaetigtSchueler'] == 0 && $appointment['akzeptiert'] != -1 && ($appointment['vblockiert'] == 0 || $appointment['vblockiert'] == false)) {
                            echo "<td class='text-center'><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                        }
                        else {
                            echo "<td><p class='alert'>Absagen nicht möglich</p></td>";
                        }
                        if($appointment['vblockiert'] || $appointment['akzeptiert'] == -1){
                            echo "<td><p class='alert'>Stunde blockiert</p></td></tr>";
                        }
                        else{
                            echo "<td>Alles gut</td></tr>";
                        }
                    }
                } else if (!$set) {
                    echo "<tr><td>Nichts</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
