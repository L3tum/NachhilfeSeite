<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        <div class="row">
            <div class="small-12 columns">
                <h2 class="text-left">Suche</h2>
            </div>

            <div class="small-12 columns">
                <form data-abide novalidate id="search-form" method="post">


                    <div class="row no-padding right">
                        <div class="small-12 columns no-padding right">
                            <div class="small-7 columns">
                                <label>Sortierung
                                    <select name="sort">
                                        <option value="no">Keine Sortierung</option>
                                        <option
                                            value="Vorname" <?php if (isset($sorting_sel) && $sorting_sel == 'Vorname') {
                                            echo "selected='selected'";
                                        } ?>>Vorname
                                        </option>
                                        <option value="Name" <?php if (isset($sorting_sel) && $sorting_sel == 'Name') {
                                            echo "selected='selected'";
                                        } ?>>Nachname
                                        </option>
                                        <option value="Fach <?php if (isset($sorting_sel) && $sorting_sel == 'Fach') {
                                            echo "selected='selected'";
                                        } ?>">Fach
                                        </option
                                        <option value="Stufe <?php if (isset($sorting_sel) && $sorting_sel == 'Stufe') {
                                            echo "selected='selected'";
                                        } ?>">Stufe
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="small-5 columns">
                                <label>Alphabetisch
                                    <select name="ascDesc">
                                        <option value="asc" <?php if(isset($ascDesc_sel) && $ascDesc_sel == 'asc'){ echo "selected='selected'";} ?>>Aufsteigend</option>
                                        <option value="desc" <?php if(isset($ascDesc_sel) && $ascDesc_sel == 'desc'){ echo "selected='selected'";} ?>>Absteigend</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="small-12 medium-6 columns small-centered">
                            <br>
                            <label>Vorname
                                <input name="vorname" type="text" placeholder="Max" <?php if (isset($vorname_sel)) {
                                    echo "value='" . $vorname_sel . "'";
                                } ?>>
                                <span class="form-error">
                                    Der Vorname ist invalid!
                                </span>
                            </label>

                            <label>Nachname
                                <input name="nachname" type="text" placeholder="Mustermann"<?php if (isset($name_sel)) {
                                    echo "value='" . $name_sel . "'";
                                } ?>>
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
                                                echo "<option value={$stufe->idStufe} ";
                                                if (isset($stufe_sel) && $stufe_sel == $stufe->idStufe) {
                                                    echo "selected='selected'";
                                                }
                                                echo "> {$stufe->name}</option>";
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
                                                echo "<option value={$fach->idFach} ";
                                                if (isset($fach_sel) && $fach_sel == $fach->idFach) {
                                                    echo "selected='selected'";
                                                }
                                                echo "> {$fach->name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Rollen
                                        <select id="rollen" name="rollen">
                                            <option value="hallo">Keine Rolle</option>
                                            <?php
                                            $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
                                            $stmt->execute();
                                            $rollen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
                                            foreach ($rollen AS $rolle) {
                                                echo "<option value={$rolle->idRolle} ";
                                                if (isset($rolle_sel) && $rolle_sel == $rolle->idRolle) {
                                                    echo "selected='selected'";
                                                }
                                                echo "> {$rolle->name}</option>";
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
                <div class="result-boxes-inner search" id="search-results">

                </div>
            </div>

        </div>


    </div>

</div>
