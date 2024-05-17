<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function passwordExposed($password) {
    $hash = strtoupper(sha1($password));
    $prefix = substr($hash, 0, 5);
    $suffix = substr($hash, 5);
    $response = file_get_contents("https://api.pwnedpasswords.com/range/".$prefix);
    $hashes = explode("\r\n", $response);
    foreach($hashes as $hash) {
        list($hashSuffix, $count) = explode(":", $hash);
        if($hashSuffix == $suffix) {
            return true;
        }
    }
    return false;
}

function loginUser($email, $password) {
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            // Gerar token e token_data
            $token_autenticacao = bin2hex(random_bytes(32)); // Gera um token aleatório de 64 caracteres
            $token_data = date('Y-m-d H:i:s', strtotime('+1 hour')); // Define a geração para 1 hora a partir de agora
            
            // Atualizar token e data de geração no banco de dados
            $updateSql = "UPDATE users SET token_autenticacao = ?, token_data = ? WHERE email = ?";
            $updateStmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($updateStmt, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "sss", $token_autenticacao, $token_data, $email);
            mysqli_stmt_execute($updateStmt);
            
            // Definir o token na sessão
            $_SESSION["user"] = $token_autenticacao;
            header("Location: index.php");
            exit();
        } else {
            return "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        return "<div class='alert alert-danger'>Email does not match</div>";
    }
}

function registerUser($email, $password, $passwordRepeat) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password)<11) {
        array_push($errors,"Password must be at least 8 charactes long");
    }
    if ($password!==$passwordRepeat) {
        array_push($errors,"Password does not match");
    }
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount>0) {
        array_push($errors,"Email already exists!");
    }
    if (count($errors)>0) {
        return $errors;
    } else {
        $sql = "INSERT INTO users (email, password) VALUES ( ?, ? )";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt,"ss", $email, $passwordHash);
            mysqli_stmt_execute($stmt);
            return "<div class='alert alert-success'>You are registered successfully.</div>";
        } else {
            die("Something went wrong");
        }
    }
}

function recoverPassword() {
    if(isset($_POST["recover"])) {
        require_once "database.php";
        $emailAddress = isset($_POST["email"]) ? $_POST["email"] : '';
        $token_recuperacao = bin2hex(random_bytes(50));
        $_SESSION['token_recuperacao'] = $token_recuperacao;
        $_SESSION['email'] = $emailAddress;  // Store email in session for later use

        $sql = "UPDATE users SET token_recuperacao = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $token_recuperacao, $emailAddress);
        if(mysqli_stmt_execute($stmt)) {
            echo "Token de recuperação atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o token de recuperação: " . mysqli_error($conn);
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'manelaugusto025@gmail.com'; 
        $mail->Password = 'p a p e h y k i j e o y b i x a'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('manelaugusto025@gmail.com', 'Recuperação de Senha'); 
        $mail->addAddress($emailAddress); 
        $mail->isHTML(true);
        $mail->Subject = 'Redefinir sua senha';
        $mail->Body    = "<b>Caro usuário,</b>
        <br><br>
        <p>Recebemos uma solicitação para redefinir sua senha.</p>
        <p>Clique no link abaixo para redefinir sua senha:</p>
        <a href='http://localhost/reset_password.php?token=$token_recuperacao'>Redefinir Senha</a>
        <br><br>
        <p>Atenciosamente,</p>
        <b>Programando</b>";

        if(!$mail->send()) {
            echo 'A mensagem não pôde ser enviada.';
            echo 'Erro do PHPMailer: ' . $mail->ErrorInfo;
        } else {
            echo 'Mensagem enviada.';
        }
    }
}

function resetPassword() {
    if(isset($_POST["reset"])){
        require_once "database.php";
        $psw = $_POST["password"];
        $token_recuperacao = isset($_GET['token']) ? $_GET['token'] : '';
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

        if(isset($_SESSION['token_recuperacao']) && $token_recuperacao === $_SESSION['token_recuperacao']) {
            // Token válido, continue com o processo de redefinição de senha
            $hash = password_hash($psw, PASSWORD_DEFAULT);
            if(mysqli_query($conn, "UPDATE users SET password='$hash' WHERE email='$email'")) {
                unset($_SESSION['token_recuperacao']);
                unset($_SESSION['email']);
                echo "Senha redefinida com sucesso.";
                header("Location: index.php");
                exit();
            } else {
                echo "Erro ao redefinir a senha: " . mysqli_error($conn);
            }
        } else {
            // Token inválido, redirecione para uma página de erro ou de login
            header("Location: error_page.php");
            exit();
        }
    }
}
?>