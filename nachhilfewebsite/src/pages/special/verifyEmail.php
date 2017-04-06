---
layout: special
---
<?php
    include_once __DIR__ . "/../assets/php/general/Route.php";
    include_once __DIR__ . "/../assets/php/general/Connection.php";
    $secret = "52df1c3b0748b09539d64a781fda";
    $email = openssl_decrypt ( $hash , "aes-256-ofb" , $secret);

$stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
$user = $stmt->fetch();

if($user) {
    if($user->emailActivated == true) {
        $message = "Die Email-Adresse wurde bereits bestätigt!";
    }
    else {
        $stmt = Connection::$PDO->prepare("UPDATE benutzer SET emailActivated = TRUE WHERE idBenutzer = :id");
        $stmt->bindParam(':id', $user->idBenutzer);
        if($stmt->execute()) {
            $message = "Die Email-Adresse wurde erfolgreich bestätigt!";
        }
    }
}
else {
    $message = "Link nicht korrekt!";
}
?>

<div class="row">
    <div class="small-12 columns small-centered">
        <h1 class="text-center"><?php echo $message ?></h1>
    </div>
</div>

