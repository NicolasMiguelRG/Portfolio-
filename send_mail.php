<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Chargement des classes PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$env = parse_ini_file(__DIR__ . '/.env');


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Fonction de nettoyage + anti header injection
    function clean_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        // Empêche l'injection d'en-têtes
        if (preg_match('/[\r\n]/', $data)) {
            die("Tentative d'injection détectée.");
        }

        return $data;
    }

    // Récupération sécurisée des champs
    $name = clean_input($_POST["name"] ?? "");
    $email = clean_input($_POST["email"] ?? "");
    $message = clean_input($_POST["message"] ?? "");

    // Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide.");
    }

    // Vérification des champs obligatoires
    if (empty($name) || empty($email) || empty($message)) {
        die("Tous les champs sont obligatoires.");
    }

    // Initialisation PHPMailer
    $mail = new PHPMailer(true);

    try {
        // CONFIG SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp-devnicolas.alwaysdata.net';          // Serveur SMTP 
        $mail->SMTPAuth = true;
        $mail->Username = 'ramalho.nicolas.miguel@gmail.com';
        $mail->Username = 'devnicolas@alwaysdata.net';
        $mail->Password = $env['SMTP_PASSWORD']; // Mot de passe d'application Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur
        $mail->setFrom('devnicolas@alwaysdata.net', 'Formulaire DevNicolas');

        // Destinataire
        $mail->addAddress('ramalho.nicolas.miguel@gmail.com');

        // Contenu du mail
        $mail->isHTML(false);
        $mail->Subject = "📩 Nouveau message depuis ton site";
        $mail->Body =
            "Nom : $name\n" .
            "Email : $email\n\n" .
            "Message :\n$message\n";

        // Envoi
        $mail->send();

        header("Location: contact.html?success=1");
        exit;
    } catch (Exception $e) {
        echo "Erreur SMTP : " . $mail->ErrorInfo;
        exit;
    }
}
