<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 20:43
 */

$user = Benutzer::get_logged_in_user();
if ($user->has_permission("giveClasses")) {
    $appointments1 = $user->get_all_appointments_as_teacher();
}
if ($user->has_permission("takeClasses")) {
    $appointments2 = $user->get_all_appointments_as_pupil();
}

?>

<div class="row main">
    <div class="medium-12 columns">
        <br>
        <a class="button success" href="<?php echo ConfigStrings::get("root")."appointment"?>">Termin vereinbaren</a>
        <table>
            <thead>
            <tr>
                <th>Lehrer</th>
                <th>Schüler</th>
                <th>Datum</th>
                <th>Raum</th>
                <th>Bestätigt(Schüler)</th>
                <th>Bestätigt(Lehrer)</th>
                <th>Ablehnen</th>
                <?php
                if ($user->has_permission("giveClasses")) {
                    echo "<th>Bezahlt</th>";
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($appointments1 != null && !empty($appointments1)) {
                foreach ($appointments1 as $appointment) {
                    $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                    echo "<tr><td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                    if ($appointment['bestaetigtSchueler'] == 0) {
                        echo "<td class='alert'>Nein</td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if ($appointment['bestaetigtLehrer'] == 0) {
                        echo "<td><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    echo "<td><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                    if ($user->has_permission("giveClasses")) {
                        if ($appointment['bezahltLehrer'] == 0) {
                            echo "<td><button class='tablebutton alert' name='bestaetigen2Button' id='{$appointment['idStunde']}'>Nein</button></td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            if ($appointments2 != null && !empty($appointments2)) {
                foreach ($appointments2 as $appointment) {
                    $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                    echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                    if ($appointment['bestaetigtSchueler'] == 0) {
                        echo "<td><button class='tablebutton alert' name='bestaetigen3Button' id='{$appointment['idStunde']}'>Nein</button></td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if ($appointment['bestaetigtLehrer'] == 0) {
                        echo "<td class='alert'>Nein</td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    echo "<td><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                    if ($user->has_permission("giveClasses")) {
                        if ($appointment['bezahltLehrer'] == 0) {
                            echo "<td class='alert'>Nein</td>";
                        } else {
                            echo "<td class='success'>Ja</td>";
                        }
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td>Nichts</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
