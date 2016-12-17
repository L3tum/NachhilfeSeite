---
layout: noLayout
---

<?php
include __DIR__ . "/../assets/php/dbClasses/Benutzer.php";


$vorname = $_POST['vorname'];
echo Benutzer::get_logged_in_user();
?>