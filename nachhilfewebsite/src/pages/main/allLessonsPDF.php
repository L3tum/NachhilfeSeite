---
layout: noLayout
---
<?php
include_once __DIR__ . "/../assets/php/PDF/mpdf.php";
include_once __DIR__ . "/../assets/php/dbClasses/Fach.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";


$user = Benutzer::get_by_id($id);

$date = date("m.Y", strtotime($month));

if($taken_lessons) {
    $header = "Von {$user->vorname} {$user->name} genommene Stunden {$date}";
}
else {
    $header = "Von {$user->vorname} {$user->name} gegebene Stunden {$date}";
}

$entries = "";

if($taken_lessons) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfenehmer = :idBenutzer");
}
else {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfelehrer = :idBenutzer");
}
$stmt->bindParam(':idBenutzer', $user->idBenutzer);

$stmt->execute();

foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung') as $verbindung) {
    $fach = Fach::get_by_id($verbindung->idFach);

    $tableHeadline = '';

    if ($taken_lessons) {
        $lehrer = Benutzer::get_by_id($verbindung->idNachhilfelehrer);
        $tableHeadline = "Lehrer: " . $lehrer->vorname . " " . $lehrer->name;

    } else {
        $schueler = Benutzer::get_by_id($verbindung->idNachhilfenehmer);
        $tableHeadline = "Schüler: " . $schueler->vorname . " " . $schueler->name;
    }

    $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idVerbindung = :idVerbindung AND DATE_FORMAT(datum, '%Y-%m') = :month ORDER BY datum DESC");
    $stmt->bindParam(':idVerbindung', $verbindung->idVerbindung);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $stunden = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');

    $entries .= "
        <div class='columns small-12'>
          <h4>" . $tableHeadline . "</h4>
          <h5>Fach: " . $fach->name . "</h5>
          <table>
            <thead>
                
                <tr>
                  
                    <th id='date-header' class='header'>Datum</th>
                    <th id='room-header' class='header'>Raum</th>
                    <th id='kostenfrei-header' class='header'>Kostenlos</th>
                    <th id='state-header' class='header'>Status</th>
                    <th id='state-icon-header' class='header'>?</th>
                </tr>
            <thead>";

    if (empty($stunden)) {
        $entries .= '<tr><th colspan="4">Kein Termin!</th></tr>';
    }
    else {
        foreach ($stunden as $stunde) {
            $date = $date = date('d.m h:m', strtotime(str_replace('-', '/', $stunde->datum)));
            if ($stunde->kostenfrei) {
                $kosten = "✔";
            } else {
                $kosten = "✘";
            }

            $status = "";
            $icon = "";

            if (strtotime($stunde->datum) > strtotime('now')) {
                $status = "Findet noch statt.";
                $icon = "❯";
            } else {
                $icon = "✘";
                if ($stunde->akzeptiert) {
                    if ($stunde->bestaetigtSchueler) {
                        if ($stunde->bestaetigtLehrer) {
                            $status = "Akzeptiert und von beiden bestätigt";
                            $icon = "✔";
                        } else {
                            $status = "Akzeptiert aber vom Lehrer <em>nicht</em> bestätigt.";
                        }
                    } else if ($stunde->bestaetigtLehrer) {
                        $status = "Akzeptiert aber vom Schüler <em>nicht</em> bestätigt.";
                    } else {
                        $status = "Akzeptiert aber von <em>keinem</em> bestätigt.";
                    }
                } else {
                    if ($stunde->bestaetigtSchueler) {
                        if ($stunde->bestaetigtLehrer) {
                            $status = "Nicht akzeptiert aber von beiden bestätigt";
                        } else {
                            $status = "Nicht akzeptiert <em>nur</b> vom Schüler bestätigt";
                        }
                    } else if ($stunde->bestaetigtLehrer) {
                        $status = "Nicht akzeptiert und <em>nur</em> vom Lehrer bestätigt.";
                    } else {
                        $status = "Nicht akzeptiert und von <em>keinem</em> bestätigt.";
                    }
                }
            }

            $entries .= "<tr>
              <th>{$date}</th>
              <th>{$stunde->raumNummer}</th>
              <th>{$kosten}</th>
              <th>{$status}</th>
              <th>{$icon}</th>
            </tr>";
        }
    }
    $entries .= "</table></div>";
}
$mpdf = new mPDF();

$stylesheet = file_get_contents(__DIR__ . "/../assets/css/app.css");
$mpdf->WriteHTML($stylesheet,1);
$currDate = date("d.m.Y");




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