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
                                    <form data-abide novalidate id=\"request-response-form\" method=\"post\">
                                    <input type='hidden' name='idRequest' value='" . $anfrage->idAnfrage . "'>
                                    <input type='hidden' name='idFach' value='" . $anfrage->idFach . "'>
                                    <input type='hidden' name='idSendingUser' value='" . $sender->idBenutzer . "'>
                                    <button name='response' class='button success' type='submit' value='acceptRequest'><i class='fi-check'></i></button>
                                    <button name='response' class='button alert' type='submit' value='denyRequest'><i class='fi-x'></i></button>
                                    </form>
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
                                        <p>{$chatnachricht->inhalt}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>
                                <div class='button-group medium '>
                                    <a href='" . ConfigStrings::get("root") . "user/" . $sender->idBenutzer . "/chatMessagesTo/" . Benutzer::get_logged_in_user()->idBenutzer . "' class='button success' type='submit' value='Submit'>Lesen</a>
                                </div>
                            </div>
                        </div>

                    </div>";
        }
    }

    public function echo_notifications() {

        $user = Benutzer::get_logged_in_user();
        $stmt = Connection::$PDO->prepare("SELECT * FROM benachrichtigung WHERE idBenutzer = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $user->idBenutzer);
        $stmt->execute();
        $root = ConfigStrings::get("root");

        foreach($stmt->fetchAll(PDO::FETCH_CLASS, 'Benachrichtigung') as $ben) {
            echo "<div class='result-box'>

                        <div class='row no-padding left'>

                            <div class='small-8 columns'>

                                <div class='row no-padding right'>
                                    <div class='small-12 columns notification-header no-padding right'>
                                        <p>$ben->titel</p>
                                    </div>

                                    <div class='small-12 columns no-padding right'>
                                        <p>{$fach->name}</p>
                                    </div>
                                </div>

                            </div>

                            <div class='small-4 columns no-padding both'>
                                <div class='button-group medium '>
                                    <form data-abide novalidate id=\"request-response-form\" method=\"post\">
                                    <input type='hidden' name='idRequest' value='" . $ben->idBenachrichtigung . "'>
                                    <button name='response' class='button alert' type='submit' value='denyRequest'><i class='fi-x'></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>";
        }
    }


}