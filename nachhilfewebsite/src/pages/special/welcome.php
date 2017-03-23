---
layout: special
---
<div class="row">
    <div class="small-12 columns">
        <h1 class="text-center">Willkommen bei der Nachhilfe des Gymnasium Lohmars!</h1>
    </div>
</div>

<form data-abide novalidate id="login-form" method="post">
    <div class="row">

        <div class="small-12 medium-6 columns small-centered">
            <label>Vorname
                <input name="vorname" type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß ]{1,20}$">
                <span class="form-error">
                    Der Vorname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                </span>
            </label>

            <label>Nachname
                <input name="nachname" type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß ]{1,20}$">
                <span class="form-error">
                    Der Nachname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                </span>
            </label>

            <label>Passwort
                <input name="passwort" type="password" required>
                <span class="form-error">
                    Das Passwortfeld darf nicht leer sein.
                </span>
            </label>

            <button class="button" type="submit" value="Submit">Submit</button>
        </div>
    </div>
</form>

<div class="row" id="bullshittery">

</div>