<?php
session_start();

require __DIR__ . './../../vendor/autoload.php';
use App\Classes\Login;
use App\Classes\Register;

$login = new Login();
$register = new Register();

$login->check_session();

if (isset($_POST['logout'])) {
    $login->logout();
}

if (isset($_POST['registerAccount'])) {
    $register->fetch_data($_POST['registerUsername'], $_POST['registerEmail'], $_POST['registerPassword'], $_POST['passwordConfirm'])
        ->check_user()->hash_password()->register_user();
}

?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in system</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <style>
        html, body {
            height: 100%;
        }
        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */

            align-items: center;
        }
    </style>
</head>