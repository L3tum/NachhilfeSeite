<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 20:43
 */

include_once __DIR__ . "/../assets/php/general/Logger.php";

$user = Benutzer::get_logged_in_user();
if($user->has_permission("give_classes")){
    $appointments1 = $user->get_all_appointments_as_teacher();
}
if($user->has_permission("take_classes")){
    $appointments2 = $user->get_all_appointments_as_pupil();
}

Logger::add($appointments1);
Logger::add($appointments2);

?>

<div class="row main">
    <table>
        <thead>
        <tr>
            <th>Lehrer</th>
            <th>Schüler</th>
            <th>Datum</th>
            <th>Bestätigt(Schüler)</th>
            <th>Bestätigt(Lehrer)</th>
            <?php
            if($user->has_permission("give_classes")){
                echo "<th>Bezahlt</th>";
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if($appointments1 != null && count($appointments1) > 0) {
            foreach ($appointments1 as $appointment) {
                echo "<tr><td>Du</td><td>{$appointment->vorname} {$appointment->name}</td><td>{$appointment->datum}</td>";
                if ($appointment->bestaetigtSchueler == 0) {
                    echo "<td class='alert'>Nein</td>";
                } else {
                    echo "<td class='success'>Ja</td>";
                }
                if ($appointment->bestaetigtLehrer == 0) {
                    echo "<td><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment->idStunde}'>Nein</button></td>";
                } else {
                    echo "<td class='success'>Ja</td>";
                }
                if ($user->has_permission("give_classes")) {
                    if ($appointment->bezahltLehrer == 0) {
                        echo "<td><button class='tablebutton alert' name='bestaetigen2Button' id='{$appointment->idStunde}'>Nein</button></td>";
                    } else {
                        echo "<td class='success'>Ja</td>";
                    }
                }
                echo "</tr>";
            }
        }
        else{
            echo "<tr><td>Nichts</td></tr>";
        }
        if($appointments2 != null && count($appointments2) > 0) {
            foreach ($appointments1 as $appointment2) {
                echo "<tr><td>{$appointment->vorname} {$appointment->name}</td><td>Du</td><td>{$appointment->datum}</td>";
                if ($appointment->bestaetigtSchueler == 0) {
                    echo "<td><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment->idStunde}'>Nein</button></td>";
                } else {
                    echo "<td class='success'>Ja</td>";
                }
                if ($appointment->bestaetigtLehrer == 0) {
                    echo "<td class='alert'>Nein</td>";
                } else {
                    echo "<td class='success'>Ja</td>";
                }
                if ($user->has_permission("give_classes")) {
                    if ($appointment->bezahltLehrer == 0) {
                        echo "<td class='alert'>Nein</td>";
                    } else {
                        echo "<td class='success'>Ja</td>";
                    }
                }
                echo "</tr>";
            }
        }
        else{
            echo "<tr><td>Nichts</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
