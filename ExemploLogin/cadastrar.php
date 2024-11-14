<?php
session_start();
include 'conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, login, senha) VALUES (:nome, :login, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        $mensagem = "<p>Usuário cadastrado com sucesso!</p>";
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $mensagem = "<p>Erro ao cadastrar usuário: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="card">
        <h2>Cadastro</h2>
        <form method="post" action="">
            <label for="nome">Nome</label><br>
            <input type="text" id="nome" name="nome" required><br>

            <label for="login">Login</label><br>
            <input type="text" id="login" name="login" required><br>

            <label for="senha">Senha</label><br>
            <input type="password" id="senha" name="senha" required><br>

            <button type="submit">Cadastrar</button>
        </form>
        <?php if ($mensagem != "") : ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
