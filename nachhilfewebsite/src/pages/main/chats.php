<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.04.2017
 * Time: 14:44
 */

$partners = Benutzer::get_logged_in_user()->get_all_chats();
$root = ConfigStrings::get('root');
$connections = Benutzer::get_logged_in_user()->get_all_connections_single();
?>

<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <div class="row">
            <div class="small-6 columns">
                <h2 class="text-left">Chats</h2>
            </div>
        </div>
        <div class="result-boxes-inner search">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Chat</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($partners as $partner) {
                    echo "<tr><th>" . $partner['vorname'] . " " . $partner['nachname'] . "</th><th><a class='tablebutton' href='" . $root . "user/" . $partner['idBenutzer'] . "/chatMessagesTo/" . Benutzer::get_logged_in_user()->idBenutzer . "'>Chat</a></th></tr>";
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <div class="row">
            <div class="small-6 columns">
                <h2 class="text-left">Verbindungen</h2>
            </div>
        </div>
        <div class="result-boxes-inner search">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Chat</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($connections as $partner) {
                    echo "<tr><th>" . $partner['vorname'] . " " . $partner['name'] . "</th><th><a href='" . $root . "user/" . Benutzer::get_logged_in_user()->idBenutzer . "/chatMessagesTo/" . $partner['ID'] . "'>Chat</a></th></tr>";
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
