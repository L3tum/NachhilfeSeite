---
layout: special
---
<div class="row">
    <div class="small-12 columns">
        <h1 class="text-center">Willkommen bei der Nachhilfe des Gymnasiums Lohmar !</h1>
    </div>
</div>
<div class="row">

</div>

<form data-abide novalidate>
    <div class="row">

        <div class="small-12 columns">
            <label>Vorname
                <input type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
        <span class="form-error">
          Der Vorname darf nicht leer sein und nur aus Bustaben bestehen.
        </span>
            </label>
        </div>

        <div class="small-12 columns">
            <label>Nachname
                <input type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß]{1,25}$">
        <span class="form-error">
          Der Nachname darf nicht leer sein und nur aus Bustaben bestehen.
        </span>
            </label>
        </div>

        <div class="small-12 columns">
            <label>Passwort
                <input type="password" required>
        <span class="form-error">
          Das Passwortfeld darf nicht leer sein.
        </span>
            </label>
        </div>



    </div>

    <div class="row">
        <fieldset class="large-6 columns">
            <button class="button" type="submit" value="Submit">Submit</button>
        </fieldset>

    </div>
</form>