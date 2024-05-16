<?php session_start() ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Login Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Recuperação de Password</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recuperação de Password</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="recover_psw">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Recuperar" name="Recuperar">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>

<?php 
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["recover"])) {
    $emailAddress = isset($_POST["email"]) ? $_POST["email"] : '';
    $token_recuperacao = bin2hex(random_bytes(50));

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'manelaugusto025@gmail.com'; // Substitua pelo seu e-mail
    $mail->Password = 'manel12345?'; // Substitua pela sua senha
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('manelaugusto025@gmail.com', 'Recuperação de Senha'); // Substitua pelo seu e-mail
    $mail->addAddress($emailAddress); // O e-mail do destinatário, que é o e-mail inserido no formulário

    $mail->isHTML(true);

    $mail->Subject = 'Redefinir sua senha';
    $mail->Body    = "<b>Caro usuário,</b>
    <br><br>
    <p>Recebemos uma solicitação para redefinir sua senha.</p>
    <p>Clique no link abaixo para redefinir sua senha:</p>
    <a href='http://localhost/reset_password.php?token=$token_recuperacao'>Redefinir Senha</a>
    <br><br>
    <p>Atenciosamente,</p>
    <b>Programando com Lam</b>";

    if(!$mail->send()) {
        echo 'A mensagem não pôde ser enviada.';
        echo 'Erro do PHPMailer: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensagem enviada.';
    }
}
?>