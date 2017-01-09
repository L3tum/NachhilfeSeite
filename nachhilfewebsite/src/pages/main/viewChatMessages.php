<?php

include_once __DIR__ . "/../assets/php/dbClasses/Chatnachricht.php";

$sender = Benutzer::get_by_id($id_sender);
$reciever = Benutzer::get_by_id($id_reciever);
//http://localhost/nachhilfewebsite/dist/user/4/viewMessagesTo/1
if(($reciever->idBenutzer != Benutzer::get_logged_in_user()->idBenutzer) || !$sender || !$reciever) {
    //Route::redirect_to_root();

}

$messages = Chatnachricht::get_all_messages_between($id_sender, $id_reciever);
?>


<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-8 columns result-boxes medium-centered" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <h2>Nachrichten mit <?php echo $sender->vorname . " " . $sender->name?></h2>
            </div>
        </div>
        <div class="row">
            <div class="small-12 columns">
                <form data-abide novalidate id="send-message-form" method="post">
                    <input name="reciever" value="<?php echo $sender->idBenutzer ?>" type="hidden">
                    <textarea name="content" placeholder="Nachricht.."></textarea>
                    <button class="button" type="submit" value="Submit">Nachricht senden</button>
                </form>
            </div>
        </div>

        <div class="row chat-messages">

            <div class="small-12 columns">

                <div class="row chat-messages">
                <?php

                foreach($messages as $message) {


                    if($message->idEmpfänger ==  Benutzer::get_logged_in_user()->idBenutzer) {

                        echo "
                        <div class='columns small-8 float-left'>
                        <div class='data-label'>
                        <p>{$message->inhalt}</p>
                        </div>
                        </div>
                        ";
                    }
                    else {

                        echo "
                        <div class='columns small-8 float-right'>
                        <div class='data-label'>
                        <p>{$message->inhalt}</p>
                        </div>
                        </div>
                        ";

                    }
                }

                ?>

                </div>
            </div>

        </div>



    </div>

</div>
