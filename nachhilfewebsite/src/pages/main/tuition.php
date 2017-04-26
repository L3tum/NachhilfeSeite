<?php
$can_show = false;
if (Benutzer::get_logged_in_user()->has_permission("giveClasses")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfelehrer = :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    $can_show = true;
}
if (Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfenehmer = :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections2 = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    $can_show = true;
}
if (!$can_show) {
    Route::redirect_to_root();
}
?>

<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-7 columns small-centered" data-equalizer_watch>
        <div class="row">
            <div class="small-8 columns">
                <h2>Nachhilfe</h2>
            </div>
        </div>
        <div class="row">


            <?php
            if (isset($connections) && !empty($connections)) {
                echo '<div class="small-8 columns"><h4>Du gibst Nachhilfe für:</h4></div><br>';
                echo '<div class="small-12 columns"><div class="result-boxes-inner search"><table><thead><tr><th>Schüler</th><th>Fach</th><th>Schüler bezahlt</th><th>Blockiert</th><th>Beenden</th></tr></thead><tbody>';
                foreach ($connections as $connection) {


                    $otherUser = Benutzer::get_by_id($connection->idNachhilfenehmer);
                    $userpath = $root . "user/" . $connection->idNachhilfenehmer . "/view";
                    $fach = Fach::get_by_id($connection->idFach);
                    $schuelerBezahlt;
                    if ($connection->kostenfrei == 1 || $connection->kostenfrei == true) {
                        $schuelerBezahlt = "<p class='success'>Nein</p>";
                    } else {
                        $schuelerBezahlt = "<p class='warning'>Ja</p>";
                    }
                    $blockiert;
                    if ($connection->blockiert) {
                        $blockiert = "<p class='alert'>Blockiert!</p>";
                    } else {
                        $blockiert = "<p class='success'>Alles gut</p>";
                    }
                    $button;
                    if ($connection->blockiert) {
                        $button = "<p class='alert'>Beenden nicht möglich</p>";
                    } else {
                        $button = "<form data-abide novalidate class='tuition-end-form' method='post'>
                                    <input type='hidden' name='idFach' value='" . $connection->idFach . "'>
                                    <input type='hidden' name='idConnection' value='" . $connection->idVerbindung . "'>
                                    <button class='button alert small no-margin-bottom' type='submit'>Beenden</button>
                              </form>";
                    }

                    echo "<tr><td><a class='tablebutton' href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a></td>
                            <td>
                              <p>{$fach->name}</p>
                            </td>
                           
                           <td>
                            {$schuelerBezahlt}
                            </td>
                            <td>
                            {$blockiert}
                            </td>
                            <td>            
                             {$button}
             
                            </td></tr>";
                }
                echo "</tbody></table></div></div>";
            }

            if (isset($connections2) && !empty($connections2)) {
                echo '<div class="small-8 columns"><h4>Du nimmst Nachhilfe bei:</h4></div><br>';
                echo '<div class="small-12 columns"><div class="result-boxes-inner search"><table><thead><tr><th>Lehrer</th><th>Fach</th><th>Schüler bezahlt</th><th>Blockiert</th><th>Beenden</th></tr></thead><tbody>';
                foreach ($connections2 as $connection) {


                    $otherUser = Benutzer::get_by_id($connection->idNachhilfelehrer);
                    $userpath = $root . "user/" . $connection->idNachhilfelehrer . "/view";
                    $fach = Fach::get_by_id($connection->idFach);
                    $schuelerBezahlt;
                    if ($connection->kostenfrei == 1 || $connection->kostenfrei == true) {
                        $schuelerBezahlt = "<p class='success'>Nein</p>";
                    } else {
                        $schuelerBezahlt = "<p class='warning'>Ja</p>";
                    }
                    $blockiert;
                    if ($connection->blockiert) {
                        $blockiert = "<p class='alert'>Blockiert!</p>";
                    } else {
                        $blockiert = "<p class='success'>Alles gut</p>";
                    }
                    $button;
                    if ($connection->blockiert) {
                        $button = "<p class='alert'>Beenden nicht möglich</p>";
                    } else {
                        $button = "<form data-abide novalidate class='tuition-end-form' method='post'>
                                    <input type='hidden' name='idFach' value='" . $connection->idFach . "'>
                                    <input type='hidden' name='idConnection' value='" . $connection->idVerbindung . "'>
                                    <button class='button alert small no-margin-bottom' type='submit'>Beenden</button>
                              </form>";
                    }

                    echo "<tr><td><a class='tablebutton' href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a></td>
                            <td>
                              <p>{$fach->name}</p>
                            </td>
                           
                           <td>
                            {$schuelerBezahlt}
                            </td>
                            <td>
                            {$blockiert}
                            </td>
                            <td>            
                             {$button}
             
                            </td></tr>";
                }
                echo "</tbody></table></div></div>";
            }

            if ((!isset($connections2) || empty($connections2)) && (!isset($connections) || empty($connections))) {
                echo '<div class="small-8 columns"><h3>Bisher keine Verbindungen!</h3></div>';
            }


            ?>


        </div>
    </div>

</div>