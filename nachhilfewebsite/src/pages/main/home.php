<div class="row main" data-equalizer data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-6 columns">
                <h2>Nachhilfe</h2>
                <div class="data-label">
                    <p>Dein
                        Name: <?php echo Benutzer::get_logged_in_user()->vorname . " " . Benutzer::get_logged_in_user()->name ?></p>
                </div>

                <div class="data-label">
                    <p>Deine Rolle: <?php echo Benutzer::get_logged_in_user()->get_role() ?></p>
                </div>


            </div>

            <div class="small-6 columns" style="margin-top:15px">
                <img class="float-center" src="http://gymnasium-lohmar.org/images/Logo/Schullogo_Homepage.png"/>
            </div>
        </div>


    </div>

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <h2>Willkommen!</h2>
        <p>Willkommen bei der Nachhilfe des Gymnasiums Lohmar! Auf dieser Seite wird die Organsiation der Nachhilfe
            geregelt.</p>
        <p>Bla bla. Bla bla bla. Bla bla bla bla.</p>
        <p>Ich bin ein Absatz und weiß nicht, was ich hier soll.</p>
        <p>Ich bin auch ein Absatz und will hier raus.</p>
    </div>
    <?php
    if (Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
        echo '<div class="small-12 smallmedium-12 medium-6 columns">

        <h2> Der 15 Punkte Plan!</h2>
        <p> 1. Drücke auf "Suche" und suche nach einem Nachhilfelehrer.</p>
        <p> 2. Rufe das Profil dieser Person auf. </p>
        <p> 3. Wähle die Fächer aus, in denen du Nachhilfe beantragen möchtest.</p>
        <p> 4. Mit Doppelklick wählst du das Fach aus, das kostenlos sein wird.</p>
        <p> 5. Drücke auf "Nachhilfe anfragen". </p>
        <p> 6. Eine Anfrage wird an den Lehrer geschickt. </p>
        <p> 7. Sobald die Anfrage angenommen wurde, bekommst du eine Benachrichtigung sowie eine Email. </p>
        <p> 8. In dem Menüpunkt "Nachhilfe" siehst du deine Nachhilfeverbindungen.</p>
        <p> 9. Wenn du dort auf das Profil von deinem Nachhilfelehrer gehst, kannst du auf "Nachricht schreiben" klicken, ob einen Chat zu starten. </p>
        <p> 10. Dort kannst du nun etwaige Termine o.ä. aushandeln, oder auch über dieses <a target="_blank" class="link" href="https://www.youtube.com/watch?v=JXfzEpgRi7U">wunderschöne Wetter</a> reden. </p>
        <p> 11. Termine kann man allerdings auch unter dem Menüpunkt "Termine" aushandeln. Auf jeden Fall sollten dort jegliche Termine eingetragen werden.</p>
        <p> 12. In "Termine" kannst du auf "Termin vereinbaren" klicken, um einen Termin auszuwählen. Dieser muss dann von deinem Lehrer akzeptiert werden.</p>
        <p> 13. Hat der Termin stattgefunden musst du dies wieder dort abhaken.</p>
        <p> 14. Sollte dein Lehrer dir ein Vorschlag machen, erscheint dieser auch in "Termine" und du musst ihn annehmen. </p>
        <p> 15. Ostereier...</p>
    </div>';
    }
    if(Benutzer::get_logged_in_user()->has_permission("giveClasses")){
        echo '<div class="small-12 smallmedium-12 medium-6 columns">

        <h2> Der 15 Punkte Plan!</h2>
        <p> 1. Du kannst dich erst mal <a href="" class="link">relaxen.</a></p>
        <p> 2. Checke ab und zu deine "Nachrichten" bzw. deine E-Mails auf Anfragen. </p>
        <p> 3. Solltest du eine Anfrage erhalten haben, entscheide ob du diese annehmen willst.</p>
        <p> 4. Lehnst du die erste Anfrage des Schülers ab, werden alle anderen Anfragen auch gelöscht.</p>
        <p> 5. Genauso wie ein Schüler, kannst du über das Profil des Schülers oder über Nachrichten mit ihm/ihr Chatnachrichten austauschen. </p>
        <p> 6. In dem Menüpunkt "Nachhilfe" siehst du des Weiteren, wenen du alles Nachhilfe gibst. </p>
        <p> 7. Ihr könnt nun per Chat einen Termin aushandeln, oder du könntest gleich einen in "Termine" vorschlagen. </p>
        <p> 8. Sollte der Schüler einen Termin vorschlagen, würde dieser auch in "Termine" erscheinen.</p>
        <p> 9. Es muss auf jeden Fall jeder Termin in "Termine" eingetragen werden. </p>
        <p> 10. In "Suche" kannst du außerdem nach anderen Schülern suchen und diese anschreiben, solltest du <a href="https://www.youtube.com/watch?v=_eacPgr4GkI" class="link">Geldprobleme haben.</a></p>
        <p> 11. Auf deinem eigenen Profil kannst du außerdem deine eigenen Angaben ändern.</p>
        <p> 12. Solltest du nun nach einigem Warten einen Termin gehabt haben, so hake ihn bitte in "Termine" ab.</p>
        <p> 13. Dort solltest du außerdem vorher den Termin akzeptieren, sollte er von dem Schüler gesendet worden sein.</p>
        <p> 14. Viel Spaß auf dieser Seite :) </p>
        <p> 15. Ostereier...</p>
    </div>';
    }
    ?>
</div>