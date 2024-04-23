<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Conexão com o base de dados (substitua com suas próprias credenciais)
    $servername = "docker1-db-1";
    $username = "root";
    $password_db = "12345";
    $dbname = "docker_database";

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Query para verificar se o email e senha correspondem
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login bem sucedido
        echo "Login bem sucedido!";
        // Redirecionar para outra página, se necessário
    } else {
        // Login falhou
        echo "Email ou senha incorretos!";
    }

    // Fecha a conexão
    $conn->close();
}
?>
