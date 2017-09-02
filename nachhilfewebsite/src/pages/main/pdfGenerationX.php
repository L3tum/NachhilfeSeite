---
layout: noLayout
---
<?php
include_once __DIR__ . "/../assets/php/PDF/mpdf.php";
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 29.08.2017
 * Time: 14:17
 */

function push($currDate, $header, $entries, &$mpdf)
{
    $html = "
<div class='row'>
  <div class='columns small-5'>
    <p class='float-left'>Gymnasium Lohmar - Nachhilfe</p>
  </div>
  
  <div class='columns small-5 float-right'>
    <p class='right'>{$currDate}</p>
  </div>
  
</div>

<div class='row'>
  <div class='columns small-12'>
    <h3>{$header}</h3>
  </div>
  
</div>
<div class='row'>
  {$entries}
</div>";
    //var_dump($html);
    $mpdf->WriteHTML($html, 2);
}


$currDate = date("d.m.Y");
$date = date('m.Y', strtotime($month));
$students = array();
$teachers = array();

if (isset($id) && $id != -1) {
    $user = Benutzer::get_by_id($id);
    if ($user->has_permissions("takeClasses")) {
        $students[0] = $user;
    }
    if ($user->has_permission("giveClasses")) {
        $teachers[0] = $user;
    }
}

if (isset($taken) && $taken == true) {
    $students = array_merge($students, Benutzer::get_all_users_with_right("takeClasses"));
    if ($students != false) {
        for ($i = 0; $i < count($students); $i++) {
            $isTrue = false;
            $header = "Von {$students[$i]->vorname} {$students[$i]->name} genommene Stunden {$date}";

            $hours = ArchivierteStunden::getAllByNameAndDate($students[$i]->vorname . $students[$i]->name, $date);
            if ($hours != false) {

                $connectionString = "";

                $connections = Benutzer::get_by_id($students[$i]->idBenutzer)->get_all_tutiution_connections_student();
                if($connections != false){
                    foreach ($connections as $connection){
                        $connectionString .= Fach::get_by_id($connection->idFach)->name . ", ";
                    }
                }
                trim($connectionString, ',');

                $isTrue = true;
                foreach ($hours as $houry) {
                    $sortedHours = ArchivierteStunden::getAllByStudentAndTeacherNameAndDateAndSubject($houry->studentName, $houry->teacherName, $houry->datum, $houry->subject);
                    $tableHeadline = "Lehrer: " . $sortedHours[0]->teacherName;
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $sortedHours->fach . "</h5>
          <h6>Nachhilfeverbindungen: " . $connectionString . "</h6>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='kostenfrei-header' class='header'>Kostenlos</th>
                </tr>
            <thead>";
                    foreach ($sortedHours as $hour) {
                        if ($hour->kostenfrei == 'kostenfrei') {
                            $kosten = "✔";
                        } else {
                            $kosten = "✘";
                        }
                        $entries .= "<tr>
              <th>{$hour->datum}</th>
              <th>{$kosten}</th>
            </tr>";
                    }

                    $entries .= "</table></div>";
                    if ($isTrue) {
                        if (count($students) > $i + 1 && isset($html)) {
                            $mpdf->AddPage();
                        }
                    }
                    push($date, $header, $entries, $mpdf);
                    $header = "";
                    $entries = "";
                }
            }
        }
    }
}

if (isset($given) && $given == true) {
    $teachers = array_merge($teachers, Benutzer::get_all_users_with_right("giveClasses"));
    if ($teachers != false) {
        for ($i = 0; $i < count($teachers); $i++) {
            $isTrue = false;
            $header = "Von {$teachers[$i]->vorname} {$teachers[$i]->name} gegebene Stunden {$date}";

            $hours = ArchivierteStunden::getAllByNameAndDate($teachers[$i]->vorname . $teachers[$i]->name, $date);
            if ($hours != false) {

                $connectionString = "";
                $subjectsString = "";
                $connections = Benutzer::get_by_id($students[$i]->idBenutzer)->get_all_tutiution_connections_teacher();
                if($connections != false){
                    foreach ($connections as $connection){
                        $connectionString .= Fach::get_by_id($connection->idFach)->name . ", ";
                    }
                }
                trim($connectionString, ',');

                $subjects = Benutzer::get_by_id($students[$i]->idBenutzer)->get_offered_subjects();
                if($subjects != false){
                    foreach ($subjects as $subject){
                        $subjectsString .= $subject->name . ", ";
                    }
                }
                trim($subjectsString, ',');

                $isTrue = true;
                foreach ($hours as $houry) {
                    $sortedHours = ArchivierteStunden::getAllByStudentAndTeacherNameAndDateAndSubject($houry->studentName, $houry->teacherName, $houry->datum, $houry->subject);
                    $tableHeadline = "Schüler: " . $sortedHours[0]->teacherName;
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $sortedHours->fach . "</h5>
          <h6>Nachhilfeverbindungen: " . $connectionString . "</h6>
          <h6>Angebotene Fächer: " . $subjectsString . "</h6>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='kostenfrei-header' class='header'>Kostenlos</th>
                </tr>
            <thead>";
                    foreach ($sortedHours as $hour) {
                        if ($hour->kostenfrei == 'kostenfrei') {
                            $kosten = "✔";
                        } else {
                            $kosten = "✘";
                        }
                        $entries .= "<tr>
              <th>{$hour->datum}</th>
              <th>{$kosten}</th>
            </tr>";
                    }

                    $entries .= "</table></div>";
                    if ($isTrue) {
                        if (count($students) > $i + 1 && isset($html)) {
                            $mpdf->AddPage();
                        }
                    }
                    push($date, $header, $entries, $mpdf);
                    $header = "";
                    $entries = "";
                }
            }
        }
    }
}

$mpdf->Output('Aufstellung ' . $date, 'I');

