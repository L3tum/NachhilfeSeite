<?php

include_once __DIR__ . "/../assets/php/dbClasses/Chatnachricht.php";
//include_once __DIR__ . "/websocket.php";

$sender = Benutzer::get_by_id($id_sender);
$reciever = Benutzer::get_by_id($id_reciever);
//http://localhost/nachhilfewebsite/dist/user/4/viewMessagesTo/1
if (($reciever->idBenutzer != Benutzer::get_logged_in_user()->idBenutzer) || !$sender || !$reciever) {
    Route::redirect_to_root();

}

$messages = Chatnachricht::get_all_messages_between($id_sender, $id_reciever);
?>
<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-8 columns result-boxes medium-centered" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <div class="small-11 columns">
                    <h2>Nachrichten mit <?php echo $sender->vorname . " " . $sender->name ?></h2>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="small-12 columns">

                <div class="row chat-messages">
                    <?php
                    $oldestDate = null;
                    foreach ($messages as $message) {
                        $id = $message->idChatnachricht;
                        $newerDate = date('d.m.Y', strtotime(str_replace('-', '/', $message->datum)));
                        if ($oldestDate == null || $oldestDate != $newerDate) {
                            echo "<div class='row'><div class='columns small-offset-4 small-4 text-center'>
                        <div class='secondary data-label radius text-center'>
                        <p name='oldest' style='font-size: 75%' class='message-content text-center'>{$newerDate}</p>
                        </div>
                        </div></div><br>
                        ";
                            $oldestDate = $newerDate;
                        }
                        $date = date('H:i', strtotime(str_replace('-', '/', $message->datum))) . ":";

                        if ($message->idEmpfänger == Benutzer::get_logged_in_user()->idBenutzer) {

                            echo "
                        <div class='columns small-8 float-right'>
                        <div class='data-label round'>
                        <input type='hidden' name='chatNachrichtID' value='{$id}'>
                        <p class='message-content'>{$date}</p>
                        <p class='message-content'>{$message->inhalt}</p>
                        </div>
                        </div>
                        ";
                        } else {

                            echo "
                        <div class='columns small-8 float-left'>
                        <div class='data-label success round'>
                        <input type='hidden' name='chatNachrichtID' value='{$id}'>
                        <p class='message-content'>{$date}</p>
                        <p class='message-content'>{$message->inhalt}</p>
                        </div>
                        </div>
                        ";

                        }
                    }

                    ?>

                </div>
            </div>

        </div>

        <div class="row">
            <div class="small-12 columns">
                <form data-abide novalidate id="send-message-form" method="post">
                    <input name="reciever" id="reciever" value="<?php echo $sender->idBenutzer ?>" type="hidden">
                    <input name="sender" id="sender" value="<?php echo $reciever->idBenutzer ?>" type="hidden">
                    <textarea id="message" name="content" placeholder="Nachricht.."></textarea>
                    <button class="button" type="submit" value="Submit" id="sendMessage">Nachricht senden</button>
                </form>
            </div>
        </div>
    </div>

</div>
