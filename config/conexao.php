<?php
// ============================================================
// config/conexao.php
// Arquivo de conexao com o banco de dados
//
// Aqui a gente configura os dados de acesso ao MySQL
// e cria a conexao usando PDO.
//
// PDO é uma forma segura e moderna de trabalhar com banco
// de dados no PHP. Ele evita problemas de segurança
// como SQL Injection quando usado corretamente.
// ============================================================

// Configuracoes do banco de dados
// Se voce mudou o usuario ou senha no seu XAMPP, altere aqui
$host    = "localhost";       // Endereco do servidor de banco de dados
$banco   = "comentarios_db"; // Nome do banco que criamos no banco.sql
$usuario = "root";           // Usuario padrao do XAMPP
$senha   = "";               // Senha padrao do XAMPP (normalmente vazia)

// Tenta conectar ao banco de dados
// Se der algum erro, o try/catch captura e exibe uma mensagem amigavel
try {

    // Cria a conexao PDO
    // charset=utf8 garante que acentos e caracteres especiais funcionem certo
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );

    // Configura o PDO para mostrar erros em vez de esconder
    // Muito util para debugar problemas durante o desenvolvimento
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // Se a conexao falhar, para tudo e mostra o erro
    // Em producao, voce nao mostraria o erro diretamente assim
    // mas para aprender é mais facil ver o que aconteceu
    die("Erro na conexao com o banco de dados: " . $e->getMessage());

}
?>
