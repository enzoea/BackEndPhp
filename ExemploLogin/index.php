<?php
session_start();
include 'conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensagem = validar($_POST["login"], $_POST["senha"]);
}

function validar($login, $senha) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            header("Location: home.php");
            exit();
        } else {
            return "Login ou senha inválidos";
        }
    } catch (PDOException $e) {
        return "Erro ao acessar o banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="login">Login</label><br>
            <input type="text" id="login" name="login" required><br>

            <label for="senha">Senha</label><br>
            <input type="password" id="senha" name="senha" required><br>

            <button type="submit">Entrar</button>
            <?php if ($mensagem != "") : ?>
                <p><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </form>
        <button id="buttonCadastrar"><a href="cadastrar.php">Quero me cadastrar</a></button>
    </div>
</body>
</html>
