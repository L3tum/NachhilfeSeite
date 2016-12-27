<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 26.12.2016
 * Time: 17:41
 */
include_once  __DIR__ . "/../dbClasses/Benutzer.php";
include_once  __DIR__ . "/../dbClasses/Anfrage.php";
include_once  __DIR__ . "/../dbClasses/Chatnachricht.php";

class NotificationHandler
{

    public function echo_tutiution_requests() {

        $user = Benutzer::get_logged_in_user();
        $stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE idEmpfänger = :idEmpfaenger");
        $stmt->bindParam(':idEmpfaenger', $user->idBenutzer);
        $stmt->execute();
        $root = ConfigStrings::get("root");

        foreach($stmt->fetchAll(PDO::FETCH_CLASS, 'Anfrage') as $anfrage) {
            $sender = Benutzer::get_by_id($anfrage->idSender);
            $fach = Fach::get_by_id($anfrage->idFach);
            $userpath =  $root . "user/" . $sender->idBenutzer . "/view";
            echo "<div class='result-box'>

                        <div class='row no-padding left'>

                            <div class='small-8 columns'>

                                <div class='row no-padding right'>
                                    <div class='small-12 columns notification-header no-padding right'>
                                        <a href='{$userpath} '>{$sender->vorname} {$sender->name}</a>
                                    </div>

                                    <div class='small-12 columns no-padding right'>
                                        <p>{$fach->name}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>
                                <div class='button-group medium '>
                                    <a href='#' class='button success' type='submit' value='Submit'><i class='fi-check'></i></a>
                                    <a href='#' class='button alert' type='submit' value='Submit'><i class='fi-x'></i></a>
                                </div>
                            </div>
                        </div>

                    </div>";
        }
    }

    public function echo_chat_messages()
    {

        $user = Benutzer::get_logged_in_user();
        $stmt = Connection::$PDO->prepare("SELECT * FROM chatnachricht WHERE idEmpfänger = :idEmpfaenger AND gelesen = FALSE");
        $stmt->bindParam(':idEmpfaenger', $user->idBenutzer);
        $stmt->execute();
        $root = ConfigStrings::get("root");

        foreach($stmt->fetchAll(PDO::FETCH_CLASS, 'Chatnachricht') as $chatnachricht) {
            $sender = Benutzer::get_by_id($chatnachricht->idSender);

            $userpath =  $root . "user/" . $sender->idBenutzer . "/view";
            echo "<div class='result-box'>

                        <div class='row no-padding left'>

                            <div class='small-8 columns'>

                                <div class='row no-padding right'>
                                    <div class='small-12 columns notification-header no-padding right'>
                                        <a href='{$userpath} '>{$sender->vorname} {$sender->name}</a>
                                    </div>

                                    <div class='small-12 columns no-padding right'>
                                        <p>{$chatnachricht->titel}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>
                                <div class='button-group medium '>
                                    <a href='#' class='button success' type='submit' value='Submit'>Lesen</a>
                                </div>
                            </div>
                        </div>

                    </div>";
        }
    }

}