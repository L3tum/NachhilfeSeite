<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns small-centered" data-equalizer-watch>
        <div class="row">
            <div class="small-12 columns">
                <h1 class="text-center">Willkommen bei der Suche !</h1>
            </div>

            <div class="small-12 columns">
                <form data-abide novalidate id="search-form" method="post">
                    <div class="row">

                        <div class="small-12 medium-6 columns small-centered">
                            <br>
                            <label>Vorname
                                <input name="vorname" type="text" placeholder="Max" pattern="^[a-zA-ZÄÖÜäöüß]{0,25}$">
                <span class="form-error">
                    Der Vorname ist invalid!
                </span>
                            </label>

                            <label>Nachname
                                <input name="nachname" type="text" placeholder="Mustermann" pattern="^[a-zA-ZÄÖÜäöüß]{0,25}$">
                <span class="form-error">
                    Der Nachname ist invalid!
                </span>
                            </label>

                            <label>Fach
                                <input name="fach" type="text" pattern="^[a-zA-ZÄÖÜäöüß]{0,25}$">
                <span class="form-error">
                    Das Fach ist invalid!
                </span>
                            </label>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Stufen
                                        <select>
                                            <option value="noneStufe">Keine Stufe</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM stufe");
                                            $stmt->execute();
                                            $stufen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
                                            foreach($stufen AS $stufe){
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
                                        <select>
                                            <option value="noneFach">Kein Fach</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM fach");
                                            $stmt->execute();
                                            $faecher = $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');

                                            foreach($faecher AS $fach){
                                                $name = utf8_encode($fach->name);
                                                echo "<option value={$fach->idFach}> {$name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Rollen
                                        <select>
                                            <option value="noneRolle">Keine Rolle</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
                                            $stmt->execute();
                                            $rollen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
                                            foreach($rollen AS $rolle){
                                                echo "<option value={$rolle->idRolle}> {$rolle->name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <button class="button" type="submit" value="Submit">Suche starten</button>
                                </div>

                            </div>
                        </div>
                </form>
            </div>
        </div>


        </div>
    </div>
