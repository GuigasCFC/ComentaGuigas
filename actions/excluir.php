<?php
    require_once "../config/conexao.php";
    $id = intval($_GET["id"] ?? 0);
    if ($id <= 0) {
        header("Location: ../index.php?erro=id_invalido");
        exit;
    }
    try {
        $sql  = "DELETE FROM comentarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        header("Location: ../index.php?sucesso=comentario_excluido");
        exit;

    } catch (PDOException $e) {
        header("Location: ../index.php?erro=falha_ao_excluir");
        exit;
    }
?>
