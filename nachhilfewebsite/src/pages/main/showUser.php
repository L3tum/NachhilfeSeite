<?php

include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";

if (isset($user_to_show_id)) {
    $user = Benutzer::get_by_id($user_to_show_id);
}

$connections = Verbindung::get_by_user_ids(Benutzer::get_logged_in_user()->idBenutzer, $user_to_show_id);

$connections_key_array = Array();
foreach ($connections as $connection) {
    $connections_key_array[$connection->idFach] = $connection;
}

$anfragen = $user->get_anfragen(Benutzer::get_logged_in_user()->idBenutzer);
$anfragen_key_array = Array();
foreach ($anfragen as $anfrage) {
    $anfragen_key_array[Fach::get_by_id($anfrage->idFach)->name] = $anfrage;
}

$user_is_me = Benutzer::get_logged_in_user()->idBenutzer == $user->idBenutzer;
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <h2>Profil</h2>

                <?php
                if ($user->has_permission("takeClasses") && !empty($connections) && !$user_is_me) {
                    echo '<div class="data-label">
                    <p>Du nimmst bei dieser Person Nachhilfe!</p>
                    </div>';
                }
                ?>

                <div class="data-label">
                    <p>Name: <?php echo $user->vorname . " " . $user->name ?></p>
                </div>

                <div class="data-label">
                    <p>Rolle: <?php echo $user->get_role() ?></p>
                </div>


                <div class="data-label">
                    <?php

                    if (!empty($connections) || (Benutzer::get_logged_in_user()->has_permission("showCredentials")) || $user_is_me) {
                        $number = $user->telefonnummer;
                        echo "<p>Telefonnummer: {$number}</p>";
                    } else {
                        echo '<p>Telefonnummer: <span
                            class="blur">02246 0101010101</span>
                    </p>';
                    }
                    ?>


                </div>

                <div class="data-label">
                    <?php

                    if (!empty($connections) || (Benutzer::get_logged_in_user()->has_permission("showCredentials")) || $user_is_me) {
                        $email = $user->email;
                        echo "<p>Email: {$email}</p>";
                    } else {
                        echo '<p>Email: <span
                            class="blur">hierist@wirklichnix.de</span>
                        </p>';
                    }
                    ?>
                </div>

                <?php
                if ($user_is_me || Benutzer::get_logged_in_user()->has_permission("showProfileExtended")) {
                    echo '<div class="data-label">';
                    $wants = $user->wantsEmails;
                    if ($wants == 1 || $wants == true) {
                        $response = "Ja";
                    } else {
                        $response = "Nein";
                    }
                    echo "<p>Erhält Email-Benachrichtigungen: {$response}</p>";
                    echo "</div>";
                }
                ?>

                <?php

                if (empty($connections) && !(Benutzer::get_logged_in_user()->has_permission("showCredentials")) && !$user_is_me) {

                    echo '<p>Du kannst die Email und die Telefonnummer eines Nutzers nur sehen, wenn du ihm Nachhilfe gibst oder
                    bei ihm Nachhilfe nimmst!</p>';
                }
                ?>


            </div>


            <div class="small-12 columns">

                <div class="row">
                    <div class="small-12 columns">
                        <?php if ($user->has_permission("giveClasses") && count($user->get_offered_subjects()) > 0) {
                            echo "<h3 > Fächer: </h3 >";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">


                    <?php
                    if ($user->has_permission("giveClasses")) {
                        $isnot = false;
                        foreach ($user->get_offered_subjects() as $subject) {
                            $id = $subject->idFach;

                            //Check if verbindung and first
                            if (isset($connections_key_array[$id]) && $connections_key_array[$id]->kostenfrei == true && !$user_is_me) {
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <div class=\"data-label firstConnection\">
                                <p class=\"center\">$subject->name</p>
                              </div>
                            </div>";
                            } //Check if verbindung and hasnt got first
                            else if (isset($connections_key_array[$id]) && $user->get_first_connection() == false && !$user_is_me) {
                                //Button for Anfrage
                                $isnot = true;
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <p type=\"button\" id={$id} name='fachButton' class='labelled success center'>
                              {$subject->name}
                              </p>
                            </div>";
                            } //Check if verbindung
                            else if (isset($connections_key_array[$id]) && !$user_is_me) {
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <div class=\"data-label alert\">
                                <p class=\"center\">$subject->name</p>
                              </div>
                            </div>";
                            } //Check if Anfrage and first
                            else if (isset($anfragen_key_array[$id]) && $anfragen_key_array[$id]->kostenfrei == true && !$user_is_me) {
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <div class=\"data-label firstRequest\">
                                <p class=\"center\">$subject->name</p>
                              </div>
                            </div>";
                            } //Check if anfrage and hasnt got first
                            else if (isset($anfragen_key_array[$id]) && $user->get_first_anfrage() == false && !$user_is_me) {
                                //Button for Anfrage
                                $isnot = true;
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <p type=\"button\" id={$id} name='fachButton' class='labelled success center'>
                              {$subject->name}
                              </p>
                            </div>";
                            } //Check if Anfrage
                            else if (isset($anfragen_key_array[$id]) && !$user_is_me) {
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <div class=\"data-label secondary\">
                                <p class=\"center\">$subject->name</p>
                              </div>
                            </div>";
                            } //Button for Anfrage
                            else if (!$user_is_me) {
                                $isnot = true;
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <p type=\"button\" id={$id} name='fachButton' class='labelled success center'>
                              {$subject->name}
                              </p>
                            </div>";
                            } else {
                                echo
                                "<div class=\"small-6 medium-12 large-4 columns\">
                              <div class=\"data-label\">
                                <p class=\"center\">$subject->name</p>
                              </div>
                            </div>";
                            }
                            if ($user->get_first_connection() == false) {
                                echo "<input type='hidden' id='{$id}connection' value='false'>";
                            } else {
                                echo "<input type='hidden' id='{$id}connection' value='true'>";
                            }
                            if ($user->get_first_anfrage() == false) {
                                echo "<input type='hidden' id='{$id}anfrage' value='false'>";
                            } else {
                                echo "<input type='hidden' id='{$id}anfrage' value='true'>";
                            }
                        }

                        if (!empty($connections) && !$user_is_me) {
                            echo "<div class=\"small-12 columns\"><p>In den rot markierten Fächern nimmst du bei dieser Person, oder gibst du dieser Person, Nachhilfe!</p></div>";
                            echo "<div class=\"small-12 columns\"><p>Das lila markierte Fach ist das Fach, das du nicht selber bezahlen musst!</p></div>";
                        }
                        if (!empty($anfragen) && !$user_is_me) {
                            echo "<div class=\"small-12 columns\"><p>In den blau markierten Fächern hast du bereits eine Anfrage gesendet!</p></div>";
                            echo "<div class=\"small-12 columns\"><p>Das hellblau markierte Fach ist das Fach, das du nicht selber bezahlen musst!</p></div>";
                        }
                        if ($isnot) {
                            echo "<div class=\"small-12 columns\"><p>Die grün markierten Felder kannst du anklicken, um Nachhilfe in diesem Fach anzufragen!</p></div>";
                        }
                        if (Benutzer::get_logged_in_user()->get_first_connection() == false && $isnot && !$user_is_me) {
                            echo "<div class=\"small-12 columns\"><p>Wenn du doppelt klickst, wählst du das Fach als erstes Fach aus, wodurch du die Stunden nicht bezahlen musst!</p></div>";
                        }
                    }
                    ?>

                </div>
            </div>


            <div class="small-12 columns">

                <div class="row">
                    <div class="small-12 columns">
                        <?php if ($user->has_permission("giveClasses") && count($user->get_offered_classes()) > 0) {
                            echo "<h3 > Stufen: </h3 >";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">


                    <?php
                    if ($user->has_permission("giveClasses")) {
                        foreach ($user->get_offered_classes() as $class) {
                            $name = $class->name;
                            echo
                            "<div class=\"small-4 columns\">
                              <div class=\"data-label\">
                                <p class=\"center\">$name</p>
                              </div>
                            </div>";
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="small-12 columns">

                <div class="row">
                    <div class="small-12 columns">
                        <?php
                        if ($user->has_permission("giveClasses") && count($user->get_all_qualifications()) > 0) {
                            echo "<h3> Qualifikationen: </h3>";
                        }
                        ?>
                    </div>
                </div>
                <div class="row">


                    <?php
                    $quals = $user->get_all_qualifications();
                    if (isset($quals) && count($quals) > 0) {
                        foreach ($quals as $qual) {
                            $name = $qual->name;
                            echo
                            "<div class=\"small-6 columns\">
                              <div class=\"data-label\">
                                <p class=\"center\">$name</p>
                              </div>
                            </div>";
                        }
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>


    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <h2>Aktionen</h2>

        <?php
        if ($user_is_me || Benutzer::get_logged_in_user()->has_permission("showProfileExtended")) {
            echo '        
        <div class="row actions">
            <div class="small-12 columns">
                <a href="' . ConfigStrings::get("root") . "user/" . $user->idBenutzer . "/edit" . '" class="button success" type="submit" value="Submit">Profil bearbeiten</a>
            </div>
        </div>';
        }
        if ($user_is_me) {
            echo '        
        <div class="row actions">
            <div class="small-12 columns">
                <a href="' . ConfigStrings::get("root") . "notifications" . '" class="button" type="submit" value="Submit">Nachhilfeanfragen aufrufen</a>
            </div>
        </div>';
        }


        if (!($user_is_me)) {

            echo '
        <div class="row actions">
            <div class="small-12 columns">
                <a href="' . ConfigStrings::get("root") . "user/" . $user->idBenutzer . "/chatMessagesTo/" . Benutzer::get_logged_in_user()->idBenutzer . '" class="button" type="submit" value="Submit">Nachricht senden</a>
            </div>
        </div>';

            if ($user->has_permission("giveClasses")) {

                echo '
        <div class="row actions">
            <div class="small-12 columns">
                    <a id="nachhilfeAnfragenButton" class="button" type="submit" value="Submit">Nachhilfe anfragen</a>
            </div>
        </div>
                        <input type="hidden" id="user_to_show" value="' . $user->idBenutzer . '"/>';
            }

            echo '
            
        <div class="row actions">
            <div class="small-12 columns">
                <a class="button alert" type="submit" name="' . $user->idBenutzer . '" id="alerting">Nutzer melden</a>
            </div>
        </div>';

            if (Benutzer::get_logged_in_user()->has_permission("blockUser")) {
                if ($user->is_blocked() == "1" || $user->is_blocked() == "true") {
                    echo '
                      <div class="row actions">
                        <div class="small-12 columns">
                          <a id="unblockUserButton" class="button alert" type="submit" value="Submit">Benutzer entblocken</a>
                        </div>
                      </div>';
                } else {
                    echo '
                      <div class="row actions">
                        <div class="small-12 columns">
                          <a id="blockUserButton" class="button alert" type="submit" value="Submit">Benutzer blockieren</a>
                        </div>
                       </div>';
                }
            }
        }

        ?>


    </div>

    <?php
    if (($user_is_me && Benutzer::get_logged_in_user()->has_permission("getSelfPDFReports")) || (!$user_is_me && Benutzer::get_logged_in_user()->has_permission("getOtherPDFReports"))) {

        $givenButton = "";
        $takenButton = "";
        if ($user->has_permission("giveClasses")) {
            $givenButton = '<button type="submit" name="action" value="given" class="button" type="submit">PDF für gegebene Stunden generieren</button>';
        }
        if ($user->has_permission("takeClasses")) {
            $takenButton = '<button type="submit" name="action" value="taken" class="button" >PDF für genommene Stunden generieren</a>';
        }

        $currYear = date("Y");

        echo "
            <div class='small-12 smallmedium-12 medium-6 columns'>
              <h2>PDF</h2>
              <form data-abide novalidate id='show-pdf-form' method='post'>
                <input id='pdf-year' style='width:200px' type='month'>
                <input id='pdf-user' type='hidden' name='idBenutzer' value='{$user->idBenutzer}'>
                
                {$givenButton}<br>{$takenButton}
              </form>
            <div>
        ";
    }
    ?>

</div>
</div>


