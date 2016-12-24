<?php

include_once  __DIR__ . "/../assets/php/dbClasses/Fach.php";

if (isset($user_to_show_id)) {
    $user = Benutzer::get_by_id($user_to_show_id);
}

$connections = $user->get_tutiution_connections(Benutzer::get_logged_in_user());
$connections_key_array = Array();
foreach($connections as $connection) {
    $connections_key_array[Fach::get_by_id($connection->idFach)->name] = true;
}
$user_is_me = Benutzer::get_logged_in_user()->idBenutzer == $user->idBenutzer;
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <h2>Profil</h2>

                <?php
                if($user->get_role() == "Nachhilfenehmer" && !empty($connections)) {
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

                    if(!empty($connections) || (Benutzer::get_logged_in_user()->get_role() == "Administrator") || $user_is_me) {
                        $number = $user->telefonnummer;
                        echo "<p>Telefonnummer: {$number}</p>";
                    }

                    else {
                        echo '<p>Telefonnummer: <span
                            class="blur">02246 0101010101</span>
                    </p>';
                    }
                    ?>


                </div>

                <div class="data-label">
                    <?php

                    if(!empty($connections) || (Benutzer::get_logged_in_user()->get_role() == "Administrator") || $user_is_me) {
                        $email = $user->email;
                        echo "<p>Email: {$email}</p>";
                    }

                    else {
                        echo '<p>Email: <span
                            class="blur">hierist@wirklichnix.de</span>
                        </p>';
                    }
                    ?>
                </div>

                <?php

                if(empty($connections) && !(Benutzer::get_logged_in_user()->get_role() == "Administrator") && !$user_is_me) {

                    echo '<p>Du kannst die Email und die Telefonnummer eines Nutzers nur sehen, wenn du ihm Nachhilfe gibst oder
                    bei ihm Nachhilfe nimmst!</p>';
                }
                ?>



            </div>


            <div class="small-12 columns">

                <div class="row">
                    <div class="small-12 columns">
                        <?php if ($user->get_role() == "Nachhilfelehrer") {
                            echo "<h3 > Fächer: </h3 >";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">


                    <?php
                    if ($user->get_role() == "Nachhilfelehrer") {
                        foreach ($user->get_offered_subjects() as $subject) {
                            $name = $subject->name;
                            if(isset($connections_key_array[$name])) {
                                $alert = "alert";
                            }
                            else {
                                $alert = "";
                            }
                            echo
                            "<div class=\"small-4 medium-12 large-4 columns\">
                              <div class=\"data-label {$alert}\">
                                <p class=\"center\">$name</p>
                              </div>
                            </div>";
                        }
                    }
                    ?>

                    <?php

                    if(!empty($connections)) {

                        echo "<div class=\"small-12 columns\"><p>In den rot markierten Fächern nimmst du bei dieser Person Nachhilfe!</p></div>";
                    }
                    ?>

                </div>
            </div>



            <div class="small-12 columns">

                <div class="row">
                    <div class="small-12 columns">
                        <?php if ($user->get_role() == "Nachhilfelehrer") {
                            echo "<h3 > Stufen: </h3 >";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">


                    <?php
                    if ($user->get_role() == "Nachhilfelehrer") {
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
            
        </div>
    </div>


    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <h2>Aktionen</h2>

        <?php
        if ($user_is_me || Benutzer::get_logged_in_user()->get_role() == "Administrator") {

            echo '        
        <div class="row actions">
            <div class="small-12 columns">
                <a href="' . ConfigStrings::get("root") . "user/" . $user->idBenutzer . "/edit" . '" class="button success" type="submit" value="Submit">Profil bearbeiten</a>
            </div>
        </div>';
        }

        if (!($user_is_me)) {

            echo '
        <div class="row actions">
            <div class="small-12 columns">
                <a href="#" class="button" type="submit" value="Submit">Nachricht senden</a>
            </div>
        </div>';

            echo '
            
        <div class="row actions">
            <div class="small-12 columns">
                <a href="#" class="button alert " type="submit" value="Submit">Nutzer melden</a>
            </div>
        </div>';

            if($user->get_role() == "Nachhilfelehrer") {

                echo '        
        <div class="row actions">
            <div class="small-12 columns">
                <a href="#" class="button" type="submit" value="Submit">Nachhilfe anfragen</a>
            </div>
        </div>';
            }
        }

        ?>


    </div>
</div>