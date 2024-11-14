<?php
session_start();

if (isset($_SESSION['usuarios']) && count($_SESSION['usuarios']) > 0) {
    echo "<h2>Lista de Usuários</h2>";
    echo "<ul>";
    foreach ($_SESSION['usuarios'] as $usuario) {
        echo "<li>Nome: {$usuario['nome']}, Login: {$usuario['login']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum usuário cadastrado.</p>";
}
?>
