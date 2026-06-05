<?php
require_once "../config/conexao.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome       = trim($_POST["nome"] ?? "");
    $email      = trim($_POST["email"] ?? "");
    $comentario = trim($_POST["comentario"] ?? "");
    if (empty($nome) || empty($email) || empty($comentario)) {
        header("Location: ../index.php?erro=campos_obrigatorios");
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?erro=email_invalido");
        exit;
    }
    try {
        $sql = "INSERT INTO comentarios (nome, email, comentario) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $comentario]);
        header("Location: ../index.php?sucesso=comentario_cadastrado");
        exit;

    } catch (PDOException $e) {
        header("Location: ../index.php?erro=falha_ao_salvar");
        exit;

    }
    } else {
        header("Location: ../index.php");
        exit;
    }
?>
