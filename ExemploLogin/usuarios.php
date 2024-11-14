<?php

// Função para inicializar o array de usuários na sessão, se ainda não estiver definido
function inicializarUsuarios() {
    if (!isset($_SESSION['usuarios'])) {
        $_SESSION['usuarios'] = [];
    }
}

// Função para registrar um novo usuário
function registrarUsuario($nome, $login, $senha) {
    inicializarUsuarios();
    
    // Cria um novo usuário com senha criptografada
    $novoUsuario = [
        'nome' => $nome,
        'login' => $login,
        'senha' => password_hash($senha, PASSWORD_DEFAULT)
    ];

    // Adiciona o usuário ao array na sessão
    $_SESSION['usuarios'][] = $novoUsuario;
}

// Função para validar o login
function validarLogin($login, $senha) {
    inicializarUsuarios();
    
    // Percorre os usuários para verificar o login e a senha
    foreach ($_SESSION['usuarios'] as $usuario) {
        if ($usuario['login'] === $login && password_verify($senha, $usuario['senha'])) {
            return true; // Login bem-sucedido
        }
    }

    return false; // Login falhou
}
?>
