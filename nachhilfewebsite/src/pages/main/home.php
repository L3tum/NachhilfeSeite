<div class="row main" data-equalizer data-equalize-on="medium">
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>

        <h2>Willkommen!</h2>
        <p>Commodi sit esse voluptatem atque eum commodi quis. Omnis consequatur enim porro. Voluptate non ut quidem eaque dicta. Voluptatem labore cum autem. Deserunt et vel suscipit qui velit molestiae enim molestiae.
            Consectetur dolorem aliquam dolorum. Quibusdam nesciunt sed et consequatur adipisci. Rerum sit aut ratione ea incidunt. Corrupti id pariatur praesentium sed. Voluptatem et non at est odit ducimus qui nihil. Eum hic repudiandae explicabo perferendis sapiente.
            Soluta voluptate a nobis hic cum. Voluptatem alias reiciendis sed sit. Quibusdam autem quaerat expedita tempore qui dolores dolores optio. In corporis aspernatur eius qui reiciendis voluptatem. Et quod sed vitae blanditiis est. Aut officia est molestiae.
            Eum molestiae minus est et totam. Enim praesentium id incidunt repellat esse voluptatem autem. Accusamus deserunt odio quia quam. Sunt consequuntur quaerat soluta hic quisquam vero rerum.
            Exercitationem architecto laborum totam asperiores quis dolores ea. Voluptas atque voluptatem assumenda perferendis quis doloremque similique odio. Nemo et natus harum ut modi perspiciatis hic. In unde est rerum et error qui aspernatur. Sed temporibus officia nemo.</p>
    </div>
    <div class="small-12 smallmedium-12 medium-6 columns" data-equalizer-watch>
        
        <h2>Aktionen</h2>
        <div class="row actions">
            <div class="small-12 columns">
                <button class="button" type="submit" value="Submit">Suchen</button>
            </div>
        </div>

        <div class="row actions">
            <div class="small-12 columns">
                <button class="button" type="submit" value="Submit">Benachrichtigungen</button>
            </div>
        </div>



        <div class="row actions">
            <div class="small-12 columns">
                <button class="button" type="submit" value="Submit">Profil betrachten</button>
            </div>
        </div>

        <div class="row actions">
            <div class="small-12 columns">
                <button class="button" type="submit" value="Submit">Profil bearbeiten</button>
            </div>
        </div>

        <div class="row actions">
            <div class="small-12 columns">
                <button class="button alert" type="submit" value="Submit">Administration</button>
            </div>
        </div>

        <div class="row actions">
            <div class="small-12 columns">
                <button class="button alert " type="submit" value="Submit">Nutzer melden</button>
            </div>
        </div>

        <?php
        if(Benutzer::get_logged_in_user()->get_role() == "Administrator") {

        }
        ?>
    </div>
</div>