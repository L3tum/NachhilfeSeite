<div class="row main" data-equalizer="main" data-equalize-on="medium">

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch="main">

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
                <img class="float-center" src="https://gymnasium-lohmar.org/images/Logo/Schullogo_Homepage.png"/>
            </div>
        </div>


    </div>

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch="main">

        <h2>Willkommen!</h2>
        <p>Willkommen bei der Nachhilfe des Gymnasiums Lohmar! Auf dieser Seite wird die Organsiation der Nachhilfe
            geregelt.</p>
        <p>Ansprechpartnerin: Sabine Trautwein</p>
        <p>Email: <a class="link" href="mailto:trautwein@gymnasium-lohmar.org">trautwein@gymnasium-lohmar.org</a></p>
    </div>
</div>
<div class="row main" data-equalizer="hi" data-equalize-on="medium">
    <?php
    $root = ConfigStrings::get('root');
    if (Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
        //TODO Tutorial
    }
    if (Benutzer::get_logged_in_user()->has_permission("giveClasses")) {
        //TODO Tutorial
    }
    ?>
</div>