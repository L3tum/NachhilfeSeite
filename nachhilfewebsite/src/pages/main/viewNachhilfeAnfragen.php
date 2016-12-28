<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 28.12.2016
 * Time: 12:09
 */
include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";

if (isset($user_anfrage)) {
    $user = Benutzer::get_by_id($user_anfrage);
}
?>

<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Nachhilfeanfragen</h2>
            </div>

            <div class="small-12 columns">
                <div class="row">

                    <div class="small-12 medium-6 columns small-centered">
                        <?php
                        $anfragen = $user->get_all_anfragen();
                        $root = ConfigStrings::get('root');
                        if ($anfragen == null || count($anfragen) == 0) {
                            echo "<div class='data-label'><p>Dieser Benutzer hat keine Anfragen!</p></div>";
                        } else {
                            echo "<div class='result-box'>" .
                                "<div class='row align-center text-center'>" .
                                "<div class='small-12-centered columns'>" .
                                "<div class='row'>" .
                                "<div class='small-12-centered columns notification-header no-padding'>";
                            if($user->get_role() == "Nachhilfenehmer"){
                                foreach ($anfragen AS $anfrage) {
                                    echo "<a href='" . $root . "user/" . $anfrage->idSender . "/view" . "'>".
                                        "<div class='result-box button-group'><a class='button info' href='" . $root . "user/" . $anfrage->idEmpfänger . "/view" . "' target='_blank'>Benutzer: " . Benutzer::get_by_id($anfrage->idEmpfänger)->vorname . " " . Benutzer::get_by_id($anfrage->idEmpfänger)->name ."</a></br>".
                                        "<a href='" . $root . "user/" . $anfrage->idSender . "/view" . "' target='_blank'>Fach: " . Fach::get_by_id($anfrage->idFach)->name ."</a>".
                                        "<a class='button alert' href='" . $root . "user/" . $anfrage->idSender . "/ChatMessagesTo/" . $anfrage->idEmpfänger . "' target='_blank'>Nachricht" ."</a>".
                                        "<br></div></a>";
                                }
                            }
                            else if($user->get_role() == "Nachhilfelehrer"){
                                foreach ($anfragen AS $anfrage) {
                                    echo "<a href='" . $root . "user/" . $anfrage->idSender . "/view" . "'>".
                                        "<div class='result-box button radius success'><a>Benutzer: " . Benutzer::get_by_id($anfrage->idSender)->vorname . " " . Benutzer::get_by_id($anfrage->idSender)->name ."</a></br>".
                                        "<a href='" . $root . "user/" . $anfrage->idSender . "/view" . "' target='_blank'>Fach: " . Fach::get_by_id($anfrage->idFach)->name ."</a>".
                                        "<a class='button alert' href='" . $root . "user/" . $anfrage->idSender . "/ChatMessagesTo/" . $anfrage->idEmpfänger . "' target='_blank'>Nachricht" ."</a>".
                                        "</div></a><br>";
                                    //Placeholder:  href='" . $root . "user/" . $anfrage->idSender . "/view" . "' target='_blank'
                                }
                            }
                            echo "</div>" .
                                "</div>".
                                "</div>".
                                "</div>".
                                "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

