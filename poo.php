<?php
class Pessoa {
    private $nome;
    private $cpf;

    public function __construct($nome, $cpf) {
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }
}

class Produto {
    private $nome;
    private $preco;

    public function __construct($nome, $preco) {
        $this->nome = $nome;
        $this->preco = $preco;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPreco() {
        return $this->preco;
    }
}

// Classe Venda
class Venda {
    private $pessoa;
    private $produto;
    private $quantidade;
    private $total;

    public function __construct(Pessoa $pessoa, Produto $produto, $quantidade) {
        $this->pessoa = $pessoa;
        $this->produto = $produto;
        $this->quantidade = $quantidade;
        $this->total = $produto->getPreco() * $quantidade;
    }

    public function getDetalhesVenda() {
        return "Cliente: " . $this->pessoa->getNome() . "<br>" .
               "Produto: " . $this->produto->getNome() . "<br>" .
               "Quantidade: " . $this->quantidade . "<br>" .
               "Total: R$" . number_format($this->total, 2, ',', '.');
    }
}

session_start();
if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}
if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}
if (!isset($_SESSION['vendas'])) {
    $_SESSION['vendas'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'cadastrar_cliente':
                $nome = $_POST['nome_cliente'];
                $cpf = $_POST['cpf_cliente'];
                $_SESSION['clientes'][] = new Pessoa($nome, $cpf);
                $mensagem = "Cliente cadastrado com sucesso!";
                break;

            case 'cadastrar_produto':
                $nome = $_POST['nome_produto'];
                $preco = floatval($_POST['preco_produto']);
                $_SESSION['produtos'][] = new Produto($nome, $preco);
                $mensagem = "Produto cadastrado com sucesso!";
                break;

            case 'registrar_venda':
                $clienteIndex = intval($_POST['cliente']);
                $produtoIndex = intval($_POST['produto']);
                $quantidade = intval($_POST['quantidade']);
                $venda = new Venda($_SESSION['clientes'][$clienteIndex], $_SESSION['produtos'][$produtoIndex], $quantidade);
                $_SESSION['vendas'][] = $venda;
                $mensagem = "Venda registrada com sucesso!";
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulando uma loja</title>
</head>
<body>
    <h1>Simulando uma loja</h1>

    <?php if (!empty($mensagem)) echo "<p><strong>$mensagem</strong></p>"; ?>

    <h2>Cadastrar Cliente</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="cadastrar_cliente">
        <label>Nome: <input type="text" name="nome_cliente" required></label><br>
        <label>CPF: <input type="text" name="cpf_cliente" required></label><br>
        <button type="submit">Cadastrar Cliente</button>
    </form>

    <h2>Cadastrar Produto</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="cadastrar_produto">
        <label>Nome: <input type="text" name="nome_produto" required></label><br>
        <label>Preço: <input type="number" step="0.01" name="preco_produto" required></label><br>
        <button type="submit">Cadastrar Produto</button>
    </form>

    <h2>Registrar Venda</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="registrar_venda">
        <label>Cliente:
            <select name="cliente" required>
                <?php foreach ($_SESSION['clientes'] as $index => $cliente): ?>
                    <option value="<?= $index ?>"><?= $cliente->getNome() ?> (CPF: <?= $cliente->getCpf() ?>)</option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Produto:
            <select name="produto" required>
                <?php foreach ($_SESSION['produtos'] as $index => $produto): ?>
                    <option value="<?= $index ?>"><?= $produto->getNome() ?> (R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?>)</option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Quantidade: <input type="number" name="quantidade" min="1" required></label><br>
        <button type="submit">Registrar Venda</button>
    </form>

    <h2>Vendas Registradas</h2>
    <?php if (empty($_SESSION['vendas'])): ?>
        <p>Nenhuma venda registrada.</p>
    <?php else: ?>
        <?php foreach ($_SESSION['vendas'] as $index => $venda): ?>
            <p><strong>Venda <?= $index + 1 ?>:</strong><br><?= $venda->getDetalhesVenda() ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>