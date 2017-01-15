<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 20:43
 */

$user = Benutzer::get_logged_in_user();

if ($user->has_permission("giveClasses")) {
    $appointments1 = $user->get_all_appointments_as_teacher($abgesagt, $past);
}
if ($user->has_permission("takeClasses")) {
    $appointments2 = $user->get_all_appointments_as_pupil($abgesagt, $past);
}

?>

<div class="row main">
    <div class="medium-12 columns">
        <br>
        <a class="button success" href="<?php echo ConfigStrings::get("root")."appointment"?>">Termin vereinbaren</a>
        <button class="button warning" id="show_old_appointments" value="0">Zeige Vergangene Termine</button>
        <button class="button warning" id="show_cancelled_appointments" value="0">Zeige abgesagte Termine</button>
        <table id="tableTermine">
            <thead>
            <tr>
                <th>Lehrer</th>
                <th>Schüler</th>
                <th>Datum</th>
                <th>Raum</th>
                <th>Bestätigt(Schüler)</th>
                <th>Bestätigt(Lehrer)</th>
                <th>Findet Statt</th>
                <th>Schüler Bezahlt Diese Stunde</th>
                <th>Ablehnen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $set = false;
            if (isset($appointments1) && !empty($appointments1)) {
                foreach ($appointments1 as $appointment) {
                    $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                    if($appointment['abgesagt']){
                        echo "<tr class='alert'>";
                    }
                    else{
                        echo "<tr>";
                    }
                    echo "<td>Du</td><td>{$appointment['vorname']} {$appointment['name']}</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                    if ($appointment['bestaetigtSchueler'] == 0 && $appointment['abgesagt'] == 0) {
                        echo "<td class='alert'>Nein</td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if ($appointment['bestaetigtLehrer'] == 0 && $appointment['abgesagt'] == 0) {
                        echo "<td><button class='tablebutton alert' name='bestaetigenButton' id='{$appointment['idStunde']}'>Nein</button></td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if($appointment['findetStatt'] == 1){
                        echo "<td class='success'>Ja</td>";
                    }
                    else{
                        echo "<td class='alert'>Nein</td>";
                    }
                    if($appointment['kostenfrei'] == 0){
                        echo "<td class='success'>Ja</td>";
                    }
                    else{
                        echo "<td class='alert'>Nein</td>";
                    }
                    if($appointment['abgesagt'] == 0) {
                        echo "<td><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                    }
                    else{
                        echo "<td class='alert'>Abgesagt</td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                $set = true;
                echo "<tr><td>Nichts</td></tr>";
            }
            if (isset($appointments2) && !empty($appointments2)) {
                foreach ($appointments2 as $appointment) {
                    $date = date('d.m.Y H:i:s', strtotime($appointment['datum']));
                    echo "<tr><td>{$appointment['vorname']} {$appointment['name']}</td><td>Du</td><td>{$date}</td><td>{$appointment['raumNummer']}</td>";
                    if ($appointment['bestaetigtSchueler'] == 0 && $appointment['abgesagt'] == 0) {
                        echo "<td><button class='tablebutton alert' name='bestaetigen3Button' id='{$appointment['idStunde']}'>Nein</button></td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if ($appointment['bestaetigtLehrer'] == 0 && $appointment['abgesagt'] == 0) {
                        echo "<td class='alert'>Nein</td>";
                    }
                    else {
                        echo "<td class='success'>Ja</td>";
                    }
                    if($appointment['findetStatt'] == 1){
                        echo "<td class='success'>Ja</td>";
                    }
                    else{
                        echo "<td class='alert'>Nein</td>";
                    }
                    if($appointment['kostenfrei'] == 0){
                        echo "<td class='success'>Ja</td>";
                    }
                    else{
                        echo "<td class='alert'>Nein</td>";
                    }
                    if($appointment['abgesagt'] == 0) {
                        echo "<td><button class='tablebutton alert' id='{$appointment['idStunde']}' name='refuseButton'>Absagen</button></td>";
                    }
                    else{
                        echo "<td class='alert'>Abgesagt</td>";
                    }
                    echo "</tr>";
                }
            } else if(!$set){
                echo "<tr><td>Nichts</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
