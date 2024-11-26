<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"]);
    setcookie("nome", $nome, time() + (7 * 24 * 60 * 60), "/"); 
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

$nome = isset($_COOKIE["nome"]) ? $_COOKIE["nome"] : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Cookie</title>
</head>
<body>
    <?php if ($nome): ?>
        <h1>Fala comigo <?= $nome ?>!</h1>
        <p> <a href="?reset=true">Voltar</a></p>
        <?php
        if (isset($_GET["reset"])) {
            setcookie("nome", "", time() - 3600, "/");
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        }
        ?>
    <?php else: ?>
        <h1>Opa, digite seu nome</h1>
        <form method="POST" action="">
            <label for="nome">digite seu nome</label>
            <input type="text" id="nome" name="nome" required>
            <button type="submit">Enviar</button>
        </form>
    <?php endif; ?>
</body>
</html>
