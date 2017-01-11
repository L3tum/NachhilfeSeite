<?php
if(Benutzer::get_logged_in_user()->has_permission("giveClasses")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfelehrer = :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');

}
else if(Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfenehmer = :id");
    $stmt->bindParam(':id', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->execute();
    $connections2 = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
}
else {
    Route::redirect_to_root();

}
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-7 columns small-centered" data-equalizer-watch>

        <div class="row">
            <div class="small-8 columns">
                <h2>Nachhilfe</h2>
                </div>
            <div class="small-8 columns">


                <?php
                if(isset($connections) && !empty($connections)) {
                    echo '<h4>Du gibst Nachhilfe für:</h4>';
                    foreach ($connections as $connection) {


                        if($connection->idNachhilfenehmer == Benutzer::get_logged_in_user()->idBenutzer) {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfelehrer);
                            $userpath =  $root . "user/" . $connection->idNachhilfelehrer . "/view";
                        }
                        else {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfenehmer);
                            $userpath =  $root . "user/" . $connection->idNachhilfenehmer . "/view";
                        }
                        $fach = Fach::get_by_id($connection->idFach);

                        echo "<div class='result-box'>

                        <div class='row no-padding left'>

                            <div class='small-8 columns'>

                                <div class='row no-padding right'>
                                    <div class='small-8 columns notification-header no-padding right'>
                                        <a href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a>
                                    </div>

                                    <div class='small-4 columns no-padding right'>
                                        <p>{$fach->name}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>

                            </div>
                        </div>

                    </div>";
                    }
                }

                if(isset($connections2) && !empty($connections2)) {
                    echo '<h4>Du nimmst Nachhilfe bei:</h4>';
                    foreach ($connections2 as $connection) {


                        if($connection->idNachhilfenehmer == Benutzer::get_logged_in_user()->idBenutzer) {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfelehrer);
                            $userpath =  $root . "user/" . $connection->idNachhilfelehrer . "/view";
                        }
                        else {
                            $otherUser = Benutzer::get_by_id($connection->idNachhilfenehmer);
                            $userpath =  $root . "user/" . $connection->idNachhilfenehmer . "/view";
                        }
                        $fach = Fach::get_by_id($connection->idFach);

                        echo "<div class='result-box'>

                        <div class='row no-padding left'>

                            <div class='small-8 columns'>

                                <div class='row no-padding right'>
                                    <div class='small-8 columns notification-header no-padding right'>
                                        <a href='{$userpath} '>{$otherUser->vorname} {$otherUser->name}</a>
                                    </div>

                                    <div class='small-4 columns no-padding right'>
                                        <p>{$fach->name}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>

                            </div>
                        </div>

                    </div>";
                    }
                }

                if((!isset($connections2) || empty($connections2)) && (!isset($connections) || empty($connections))) {
                    echo '<h3>Bisher keine Verbindungen!</h3>';
                }


                ?>

            </div>

            </div>


        </div>



    </div>


</div>