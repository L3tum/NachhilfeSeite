<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Suche</h2>
            </div>

            <div class="small-12 columns">
                <form data-abide novalidate id="search-form" method="post">


                    <div class="row no-padding right">
                        <div class="small-7 columns no-padding right">
                            <label>Sortieren
                                <select name="sort">
                                    <option value="no">Keine Sortierung</option>
                                    <option value="ascVorname">Vorname alphabetisch aufsteigend</option>
                                    <option value="descVorname">Vorname alphabetisch absteigend</option>
                                    <option value="ascName">Nachname alphabetisch aufsteigend</option>
                                    <option value="descName">Nachname alphabetisch absteigend</option>
                                    <option value="ascFach">Fach alphabetisch aufsteigend</option>
                                    <option value="descFach">Fach alphabetisch absteigend</option>
                                    <option value="ascStufe">Stufe alphabetisch aufsteigend</option>
                                    <option value="descStufe">Stufe alphabetisch absteigend</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="small-12 medium-6 columns small-centered">
                            <br>
                            <label>Vorname
                                <input name="vorname" type="text" placeholder="Max" pattern="^[a-zA-ZÄÖÜäöüß]{0,20}$">
                                <span class="form-error">
                                    Der Vorname ist invalid!
                                </span>
                            </label>

                            <label>Nachname
                                <input name="nachname" type="text" placeholder="Mustermann"
                                       pattern="^[a-zA-ZÄÖÜäöüß]{0,20}$">
                                <span class="form-error">
                                    Der Nachname ist invalid!
                                </span>
                            </label>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Stufen
                                        <select name="stufen">
                                            <option value="hallo">Keine Stufe</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM stufe");
                                            $stmt->execute();
                                            $stufen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
                                            foreach ($stufen AS $stufe) {
                                                echo "<option value={$stufe->idStufe}> {$stufe->name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Fächer
                                        <select name="faecher">
                                            <option value="hallo">Kein Fach</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM fach");
                                            $stmt->execute();
                                            $faecher = $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');

                                            foreach ($faecher AS $fach) {
                                                echo "<option value={$fach->idFach}> {$fach->name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Rollen
                                        <select name="rollen">
                                            <option value="hallo">Keine Rolle</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
                                            $stmt->execute();
                                            $rollen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
                                            foreach ($rollen AS $rolle) {
                                                echo "<option value={$rolle->idRolle}> {$rolle->name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <button class="button" type="submit" value="Submit">Suche starten</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>

    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Ergebnisse</h2>
            </div>
        </div>

        <div class="row">

            <div class="small-12 columns result-boxes">
                <div class="result-boxes-inner search">
                    <?php
                    if(isset($finalParam)){

                    }
                    ?>
                </div>
            </div>

        </div>


    </div>

</div>
