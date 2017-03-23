---
layout: noLayout
---

<?php
include_once __DIR__ . "/../assets/php/PDF/mpdf.php";
include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

/*
class PDF extends FPDF
{
    function taken_lessons() {


        $user = Benutzer::get_logged_in_user();
        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfenehmer = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $user->idBenutzer);
        $stmt->execute();

        $y_axis = 5;
        $y_line_height = 20;

        foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung') as $verbindung) {
            $fach = Fach::get_by_id($verbindung->idFach);
            $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idVerbindung = :idVerbindung");
            $stmt->bindParam(':idVerbindung', $verbindung->idVerbindung);
            $stmt->execute();

            foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde') as $stunde) {


                $this->Cell(40,10,'Hallo Welt!',1);
                $this->Cell(40,10,'Hallo Welt!',1);
                $this->Ln(10);
            }
        }
    }

    function given_lessons() {
        $user = Benutzer::get_logged_in_user();

    }
}
*/

$students = Benutzer::get_all_users_with_right("takeClasses");
$teachers = Benutzer::get_all_users_with_right("giveClasses");

$mpdf = new mPDF();
//$mpdf->debug = true;
//$mpdf->allow_output_buffering = true;

$stylesheet = file_get_contents(__DIR__ . "/../assets/css/app.css");
$mpdf->WriteHTML($stylesheet, 1);
$currDate = date("d.m.Y");
$newMonth = date('m.Y', strtotime($month));
if ($taken == true) {
    for($i = 0; $i < count($students); $i++) {
        $isTrue = false;
        $header = "Von {$students[$i]->vorname} {$students[$i]->name} genommene Stunden {$newMonth}";
        $connections = $students[$i]->get_all_tutiution_connections_student();
        if (isset($connections) && !empty($connections) && count($connections) > 0) {
            foreach ($connections as $connection) {
                $hours = Stunde::get_lessons_by_user_date_connection($month, $connection->idVerbindung);
                if (isset($hours) && !empty($hours) && count($hours) > 0) {
                    $isTrue = true;
                    $fach = Fach::get_by_id($hours[0]['idFach']);

                    $lehrer = Benutzer::get_by_id($hours[0]['idTeacher']);
                    $tableHeadline = "Lehrer: " . $lehrer->vorname . " " . $lehrer->name;

                    if ($hour['kostenfrei'] == 1) {
                        $kostenfrei = "<span style='display: inline;' class='alert'> (Kostenlos)</span>";
                    }
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $fach->name . $kostenfrei . "</h5>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='room-header' class='header'>Raum</th>
                    <th id='state-header' class='header'>Status</th>
                    <th id='state-icon-header' class='header'>?</th>
                </tr>
            <thead>";
                    foreach ($hours as $hour) {
                        $date = $hour['date'];

                        $status = "";
                        $icon = "";

                        if (strtotime($hour['date']) > strtotime('now')) {
                            $status = "Findet noch statt.";
                            $icon = "❯";
                        } else {
                            $icon = "✘";
                            if ($hour['akzeptiert']) {
                                if ($hour['bestaetigtSchueler']) {
                                    if ($hour['bestaetigtLehrer']) {
                                        $status = "Akzeptiert und von beiden bestätigt";
                                        $icon = "✔";
                                    } else {
                                        $status = "Akzeptiert aber vom Lehrer <em>nicht</em> bestätigt.";
                                    }
                                } else if ($hour['bestaetigtLehrer']) {
                                    $status = "Akzeptiert aber vom Schüler <em>nicht</em> bestätigt.";
                                } else {
                                    $status = "Akzeptiert aber von <em>keinem</em> bestätigt.";
                                }
                            } else {
                                if ($hour['bestaetigtSchueler']) {
                                    if ($hour['bestaetigtLehrer']) {
                                        $status = "Nicht akzeptiert aber von beiden bestätigt";
                                    } else {
                                        $status = "Nicht akzeptiert <em>nur</b> vom Schüler bestätigt";
                                    }
                                } else if ($hour['bestaetigtLehrer']) {
                                    $status = "Nicht akzeptiert und <em>nur</em> vom Lehrer bestätigt.";
                                } else {
                                    $status = "Nicht akzeptiert und von <em>keinem</em> bestätigt.";
                                }
                            }
                        }

                        $entries .= "<tr>
              <th>{$date}</th>
              <th>{$hour['raumNummer']}</th>
              <th>{$status}</th>
              <th>{$icon}</th>
            </tr>";
                    }
                    $entries .= "</table></div>";
                }
            }
        }
        if ($isTrue) {
            if(count($students) > $i+1 && isset($html)) {
                $mpdf->AddPage();
            }
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
        $header = "";
        $entries = "";
    }
}
if ($given == true) {
    for($i = 0; $i < count($teachers); $i++) {
        $isTrue = false;
        $header = "Von {$teachers[$i]->vorname} {$teachers[$i]->name} gegebene Stunden {$newMonth}";
        $connections = $teachers[$i]->get_all_tutiution_connections_teacher();
        if (isset($connections) && !empty($connections) && count($connections) > 0) {
            foreach ($connections as $connection) {
                $hours = Stunde::get_lessons_by_user_date_connection($month, $connection->idVerbindung);
                if (isset($hours) && !empty($hours) && count($hours) > 0) {
                    $isTrue = true;
                    $fach = Fach::get_by_id($hours[0]['idFach']);

                    $lehrer = Benutzer::get_by_id($hours[0]['idStudent']);
                    $tableHeadline = "Schüler: " . $lehrer->vorname . " " . $lehrer->name;

                    if ($hour['kostenfrei'] == 1) {
                        $kostenfrei = "<span style='display: inline;' class='alert'> (Kostenlos)</span>";
                    }
                    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $fach->name . $kostenfrei . "</h5>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='room-header' class='header'>Raum</th>
                    <th id='state-header' class='header'>Status</th>
                    <th id='state-icon-header' class='header'>?</th>
                </tr>
            <thead>";
                    foreach ($hours as $hour) {
                        $date = $hour['date'];

                        $status = "";
                        $icon = "";

                        if (strtotime($hour['date']) > strtotime('now')) {
                            $status = "Findet noch statt.";
                            $icon = "❯";
                        } else {
                            $icon = "✘";
                            if ($hour['akzeptiert']) {
                                if ($hour['bestaetigtSchueler']) {
                                    if ($hour['bestaetigtLehrer']) {
                                        $status = "Akzeptiert und von beiden bestätigt";
                                        $icon = "✔";
                                    } else {
                                        $status = "Akzeptiert aber vom Lehrer <em>nicht</em> bestätigt.";
                                    }
                                } else if ($hour['bestaetigtLehrer']) {
                                    $status = "Akzeptiert aber vom Schüler <em>nicht</em> bestätigt.";
                                } else {
                                    $status = "Akzeptiert aber von <em>keinem</em> bestätigt.";
                                }
                            } else {
                                if ($hour['bestaetigtSchueler']) {
                                    if ($hour['bestaetigtLehrer']) {
                                        $status = "Nicht akzeptiert aber von beiden bestätigt";
                                    } else {
                                        $status = "Nicht akzeptiert <em>nur</b> vom Schüler bestätigt";
                                    }
                                } else if ($hour['bestaetigtLehrer']) {
                                    $status = "Nicht akzeptiert und <em>nur</em> vom Lehrer bestätigt.";
                                } else {
                                    $status = "Nicht akzeptiert und von <em>keinem</em> bestätigt.";
                                }
                            }
                        }

                        $entries .= "<tr>
              <th>{$date}</th>
              <th>{$hour['raumNummer']}</th>
              <th>{$status}</th>
              <th>{$icon}</th>
            </tr>";
                    }
                    $entries .= "</table></div>";
                }
            }
        }
        if ($isTrue) {
            if(count($students) > $i+1 && isset($html)) {
                $mpdf->AddPage();
            }
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
        $header = "";
        $entries = "";
    }
}
$mpdf->Output('Aufstellung '. $newMonth, 'I');
?>
