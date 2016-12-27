<?php

    include_once __DIR__ . "/../assets/php/general/NotificationHandler.php";

    $notification_handler = new NotificationHandler();
?>

<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns notifications" data-equalizer-watch>

        <div class="row">
            <div class="small-6 columns">
                <h2>Nachhilfeanfragen</h2>
            </div>
        </div>

        <div class="row">

            <div class="small-12 columns notifications">
                <div class="notifications-inner">

                    <?php
                    $notification_handler->echo_tutiution_requests();
                    ?>

                </div>
            </div>

        </div>

    </div>

    <div class="small-12 smallmedium-12 medium-6 columns notificaion-column" data-equalizer-watch>

        <div class="row">
            <div class="small-6 columns">
                <h2>Nachrichten</h2>
            </div>
        </div>

        <div class="row">

            <div class="small-12 columns notifications">
                <div class="notifications-inner">

                    <?php
                    $notification_handler->echo_chat_messages();
                    ?>

                </div>
            </div>

        </div>

    </div>
</div>