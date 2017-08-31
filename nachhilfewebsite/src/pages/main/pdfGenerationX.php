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

if (isset($id)) {
    $user = Benutzer::get_by_id($id);
    if ($user->has_permissions("takeClasses")) {
        $students[0] = $user;
    }
    if ($user->has_permission("giveClasses")) {
        $teachers[0] = $user;
    }
} else {
    $students = Benutzer::get_all_users_with_right("takeClasses");
    $teachers = Benutzer::get_all_users_with_right("giveClasses");
}

if (isset($taken) && $taken == true) {
    if ($students != false) {
        for ($i = 0; $i < count($students); $i++) {
            $isTrue = false;
            $header = "Von {$students[$i]->vorname} {$students[$i]->name} genommene Stunden {$date}";

            $hours = ArchivierteStunden::getAllByNameAndDate($students[$i]->vorname . $students[$i]->name, $date);
            if ($hours != false) {
                $isTrue = true;
                foreach ($hours as $houry) {
                    $sortedHours = ArchivierteStunden::getAllByStudentAndTeacherNameAndDateAndSubject($houry->studentName, $houry->teacherName, $houry->datum, $houry->subject);
                    $tableHeadline = "Lehrer: " . $sortedHours[0]->teacherName;
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $sortedHours->fach . "</h5>
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
                    push($currDate, $header, $entries, $mpdf);
                    $header = "";
                    $entries = "";
                }
            }
        }
    }
}

if (isset($given) && $given == true) {
    if ($teachers != false) {
        for ($i = 0; $i < count($teachers); $i++) {
            $isTrue = false;
            $header = "Von {$teachers[$i]->vorname} {$teachers[$i]->name} gegebene Stunden {$date}";

            $hours = ArchivierteStunden::getAllByNameAndDate($teachers[$i]->vorname . $teachers[$i]->name, $date);
            if ($hours != false) {
                $isTrue = true;
                foreach ($hours as $houry) {
                    $sortedHours = ArchivierteStunden::getAllByStudentAndTeacherNameAndDateAndSubject($houry->studentName, $houry->teacherName, $houry->datum, $houry->subject);
                    $tableHeadline = "Schüler: " . $sortedHours[0]->teacherName;
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $sortedHours->fach . "</h5>
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
                    push($currDate, $header, $entries, $mpdf);
                    $header = "";
                    $entries = "";
                }
            }
        }
    }
}

$mpdf->Output('Aufstellung ' . $newMonth, 'I');

