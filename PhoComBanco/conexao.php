<?php
    $nomeBd = "127.0.0.1:3306";
    $user = "root";
    $senha = "enzo123";
    $banco = "sistema_login";

    $conexao= new mysqli($nomeBd, $user, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }
?>