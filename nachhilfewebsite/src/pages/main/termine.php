<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 20:43
 */

$user = Benutzer::get_logged_in_user();
$appointments = $user->get_all_appointments();