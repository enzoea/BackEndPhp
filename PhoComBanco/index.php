<?php
require_once 'funcoes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    inserirUsuario($nome, $login, $senha);
}

    //deletarUsuarios($nome, $login, $senha);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br>
        Login: <input type="text" name="login" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <!--
    <form action="funcoes.php" method="post">
        <button type="submit" name="botao">Deletar</button>
    </form>-->

    <?php
    listarUsuarios();
    ?>

</body>
</html>
