---
layout: noLayout
---

<?php
include_once __DIR__ . "/../assets/php/PDF/mpdf.php";
include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";

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

$user = Benutzer::get_logged_in_user();

if($taken_lessons) {
    $header = "Von {$user->vorname} {$user->name} genommene Stunden 2016";

    $entries = "";

    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfenehmer = :idBenutzer");
    $stmt->bindParam(':idBenutzer', $user->idBenutzer);
    $stmt->execute();

    foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung') as $verbindung) {
        $fach = Fach::get_by_id($verbindung->idFach);
        $lehrer = Benutzer::get_by_id($verbindung->idNachhilfelehrer);
        $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idVerbindung = :idVerbindung");
        $stmt->bindParam(':idVerbindung', $verbindung->idVerbindung);
        $stmt->execute();

        $entries .= "
        <div class='columns small-12'>
          <h4>Lehrer: " . $lehrer->vorname . " " . $lehrer->name . " </h4>
          <h5>Fach: " . $fach->name  . "</h5>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='room-header' class='header'>Raum</th>
                    <th id='confirmed-header' class='header'>Bestätigt</th>
                    <th id='other-header' class='header'>Sonstiges</th>
                </tr>
            <thead>";

        $stunden = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');
        if(empty($stunden)) {
            $entries .= '<tr><th colspan="4">Kein Termin!</th></tr>';
        }
        foreach ($stunden as $stunde) {
            $date = $date = date('d-m h:m', strtotime(str_replace('-','/', $stunde->datum)));
            $entries .= "<tr>
              <th>{$date}</th>
            
            </tr>";
        }
        $entries.= "</table></div>";
    }
}

$mpdf = new mPDF();

$stylesheet = file_get_contents(__DIR__ . "/../assets/css/app.css");
$mpdf->WriteHTML($stylesheet,1);
$currDate = date("d-m-Y");




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



$mpdf->WriteHTML($html, 2);

$mpdf->Output();
?>