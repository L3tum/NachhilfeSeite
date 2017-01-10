<?php
if(Benutzer::get_logged_in_user()->get_role() == "Nachhilfenehmer") {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfegeber == :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
}
else if(Benutzer::get_logged_in_user()->get_role() == "Nachhilfelehrer") {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfenehmer == :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
}
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-7 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-6 columns">
                <h2>Nachhilfe</h2>
                <?php
                    foreach ($connections as $connection) {

                        if($connection->idNachhilfenehmer == Benutzer::get_logged_in_user()->idBenutzer) {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfelehrer);
                        }
                        else {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfenehmer);
                        }
                        $fach = Fach::get_by_id($connection->idFach);

                        echo "<div class=\'result-box\'>

                        <div class=\'row no-padding left\'>

                            <div class=\'small-8 columns\'>

                                <div class=\'row no-padding right\'>
                                    <div class=\'small-12 columns notification-header no-padding right\'>
                                        <a href=\'{$userpath} \'>{$otherUser->vorname} {$otherUser->name}</a>
                                    </div>

                                    <div class=\'small-12 columns no-padding right\'>
                                        <p>{$fach->name}</p>
                                    </div>
                                </div>

                            </div>

                            <div class=\'small-4 columns no-padding both\'>

                            </div>
                        </div>

                    </div>";
                    }
                ?>

            </div>

        </div>



    </div>


</div>