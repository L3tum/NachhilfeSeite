---
layout: noLayout
---
<?php

error_reporting(E_ERROR);
ini_set('display_errors', 1);

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 21:03
 */
//include_once "seite1.php";
/*@session_start();
header('Set-Cookie: "PHPSESSID ' . session_id() . ';path=/"');
ob_end_flush();*/

include_once __DIR__ . "/assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/assets/php/general/Route.php";
include_once __DIR__ . "/assets/php/general/Connection.php";
include_once __DIR__ . "/assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/assets/php/dbClasses/Berechtigung.php";
include_once __DIR__ . "/assets/php/dbClasses/Settings.php";
include_once __DIR__ . "/assets/php/general/tldextract.php";

/*
echo $_SERVER['REQUEST_URI'];
exit();
*/
$var = headers_sent($filename, $linenum);
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
//echo session_id();


if (!Connection::connect(true)) {
    exit;
}


$logged_in_user = Benutzer::get_logged_in_user();

Route::init();


Route::add404(function () {

    Route::redirect_to_root();


});


Route::add('', function () {


    include "main/home.php";

});

Route::add('home', function () {

    include "main/home.php";
});

Route::add('/', function () {


    include "main/home.php";
});

Route::add('logout', function () {

    Benutzer::get_logged_in_user()->log_out();
    Route::redirect_to_root();
});

Route::add('user/(.+)/edit', function ($id) {
    //Do something
    $user_to_edit_id = $id;
    if ($user_to_edit_id == Benutzer::get_logged_in_user()->idBenutzer || Benutzer::get_logged_in_user()->has_permission("editEveryUser")) {
        include 'main/editUser.php';
    } else {
        Route::redirect_to_root();
    }

});

Route::add('user/(.+)/pdf/taken/(.+)', function ($id, $month) {
    //Do something
    $taken_lessons = true;
    include 'main/allLessonsPDF.php';

});

Route::add('user/(.+)/pdf/given/(.+)', function ($id, $month) {
    //Do something
    $taken_lessons = false;
    include 'main/allLessonsPDF.php';

});

Route::add('user/(.+)/view', function ($id) {
    //Do something
    $user_to_show_id = $id;
    include 'main/showUser.php';
});


Route::add('noDB', function () {
    //Do something
    include "special/noDBConnection.php";
});


Route::add('suche/?\??(.*)', function ($param1 = null) {
    //Do something
    if (isset($param1)) {
        $params = explode('&', $param1);
        foreach ($params as $param) {
            $arr = explode('=', $param);
            switch ($arr[0]) {
                case 'vorname':
                    $vorname_sel = $arr[1];
                    break;
                case 'name':
                    $name_sel = $arr[1];
                    break;
                case 'stufe':
                    $stufe_sel = $arr[1];
                    break;
                case 'fach':
                    $fach_sel = $arr[1];
                    break;
                case 'rolle':
                    $rolle_sel = $arr[1];
                    break;
                case 'sorting':
                    $sorting_sel = $arr[1];
                    break;
                case 'ascDesc':
                    $ascDesc_sel = $arr[1];
            }
        }
    }
    include 'main/search.php';
});

Route::add('notifications', function () {
    //Do something
    include 'main/notifications.php';
});

Route::add('user/(.*)/chatMessagesTo/(.*)', function ($id_sender, $id_reciever) {

    include 'main/viewChatMessages.php';
});

Route::add('admin/?(.*)', function ($param1 = null) {
    $parameters = $param1;
    include 'main/administrator.php';
});

Route::add('tuition', function () {
    include 'main/tuition.php';
});

Route::add('role/(.+)/edit', function ($param) {
    if (Benutzer::get_logged_in_user()->has_permission("editRole")) {
        if (!Benutzer::get_logged_in_user()->has_permission("elevated_administrator") && Rolle::get_by_id($param)->has_right(Berechtigung::get_by_name("administrator"))) {
            Route::redirect_to_root();
        }
        $idRole = $param;
        include 'main/editRole.php';
    } else {
        Route::redirect_to_root();
    }
});

Route::add('role/(.+)/view', function ($param) {
    if (Benutzer::get_logged_in_user()->has_permission("viewRole")) {
        $idRole = $param;
        include 'main/viewRole.php';
    } else {
        Route::redirect_to_root();
    }
});

Route::add('role/add', function () {
    if (Benutzer::get_logged_in_user()->has_permission("addRole")) {
        include 'main/addRole.php';
    } else {
        Route::redirect_to_root();
    }
});

Route::add('termine', function () {
    if (Benutzer::get_logged_in_user()->has_permission("termine")) {
        include 'main/termine.php';
    } else {
        Route::redirect_to_root();
    }
});

Route::add('appointment', function () {
    include 'main/appointment.php';
});

Route::add('verifyEmail/(.+)', function ($hash) {
    include 'special/verifyEmail.php';

});

Route::add('pdf?(.+)', function($param){
    $params = explode('&', $param);
    $taken = false;
    $given = false;
    $id = -1;
    $month = -1;
    foreach ($params as $param){
        switch ($param) {
            case "all": {
                $taken = true;
                $given = true;
                break;
            }
            case "taken": {
                $taken = true;
                break;
            }
            case "given": {
                $given = true;
                break;
            }
            case "month":{
                $month = explode(':', $param)[1];
            }
            case "id":{
                $id = intval(explode(':', $param)[1]);
            }
            default:{
                Route::redirect_to_root();
            }
        }
    }
});
Route::add('spdf/(.+)', function ($param) {
    $params = explode('/', $param);
    $taken = false;
    $given = false;
    switch ($params[0]) {
        case "all": {
            $taken = true;
            $given = true;
            break;
        }
        case "taken": {
            $taken = true;
            break;
        }
        case "given": {
            $given = true;
            break;
        }
    }
    $month = $params[1];
    include 'main/allLessonsPDFMonth.php';
});
//($setup)*(insane=true)*
Route::add('credits/?\??(.*)', function ($param = 0) {
    include 'special/credits.php';
});
Route::add('goodcredits', function () {
    include 'main/goodCredits.php';
});
Route::add('chats', function () {
    include 'main/chats.php';
});
Route::add('login', function(){
    include 'special/login.php';
});

Route::run();
//print_r($_SERVER);

ArchivierteStunden::Update();

?>