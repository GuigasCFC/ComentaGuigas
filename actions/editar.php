<?php
    require_once "../config/conexao.php";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id         = intval($_POST["id"] ?? 0);
        $nome       = trim($_POST["nome"] ?? "");
        $email      = trim($_POST["email"] ?? "");
        $comentario = trim($_POST["comentario"] ?? "");
        if ($id <= 0) {
            header("Location: ../index.php?erro=comentario_invalido");
            exit;
        }
        if (empty($nome) || empty($email) || empty($comentario)) {
            header("Location: editar.php?id=$id&erro=campos_obrigatorios");
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: editar.php?id=$id&erro=email_invalido");
            exit;
        }
        try {
            $sql = "UPDATE comentarios SET nome = ?, email = ?, comentario = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $comentario, $id]);
            header("Location: ../index.php?sucesso=comentario_editado");
            exit;
        } catch (PDOException $e) {
            header("Location: ../index.php?erro=falha_ao_editar");
            exit;
        }
    }
    $id = intval($_GET["id"] ?? 0);
    if ($id <= 0) {
        header("Location: ../index.php");
        exit;
    }
    try {
        $sql  = "SELECT * FROM comentarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $comentario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header("Location: ../index.php?erro=comentario_nao_encontrado");
        exit;
    }
    if (!$comentario) {
        header("Location: ../index.php?erro=comentario_nao_encontrado");
        exit;
    }
    $erro = $_GET["erro"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <button class="botao-tema" id="botaoTema" onclick="alternarTema()">
            <span class="botao-tema__trilho">
                <span class="botao-tema__bolinha"></span>
            </span>
        </button>
        <header class="cabecalho">
            <h1 class="cabecalho__titulo">Editar Comentario</h1>
            <p class="cabecalho__subtitulo">Altere as informacoes abaixo e salve</p>
        </header>
        <?php
         if (!empty($erro)) : 
        ?>
            <div class="alerta alerta--erro">
                <?php
                 if ($erro === "campos_obrigatorios") : 
                ?>
                    Todos os campos sao obrigatorios. Por favor, preencha tudo.
                <?php
                 elseif ($erro === "email_invalido") : 
                ?>
                    O e-mail informado nao é valido. Verifique e tente novamente.
                <?php
                 else : 
                ?>
                    Ocorreu um erro. Tente novamente.
                <?php
                 endif; 
                ?>
            </div>
        <?php
         endif; 
        ?>
        <section class="formulario-area">
            <form action="editar.php" method="POST" class="formulario">
                <input type="hidden" name="id" value="<?php echo $comentario["id"]; ?>">
                <div class="formulario__grupo">
                    <label class="formulario__label" for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" class="formulario__input" placeholder="Seu nome completo" value="<?php echo htmlspecialchars($comentario["nome"]); ?>" required>
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label" for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="formulario__input" placeholder="seu@email.com" value="<?php echo htmlspecialchars($comentario["email"]); ?>" required>
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label" for="comentario">Comentario</label>
                    <textarea id="comentario" name="comentario" class="formulario__textarea" placeholder="Escreva seu comentario aqui..." rows="5" required>
                        <?php
                        echo htmlspecialchars($comentario["comentario"]); 
                        ?>
                    </textarea>
                </div>
                <div class="formulario__acoes">
                    <a href="../index.php" class="botao botao--secundario">Cancelar</a>
                    <button type="submit" class="botao botao--primario">Salvar Alteracoes</button>
                </div>
            </form>
        </section>
    </div>
    <script>
        function confirmarExclusao(event) {
            var confirmou = confirm("Clique em OK para excluir seu comentário");
            if (!confirmou) {
                event.preventDefault();
                return false;
            }
            return true;
        }
        //modo escuro
        var textoTema = document.getElementById("textoTema");
        function aplicarTema(tema) {
            if (tema === "noturno") {
                document.body.classList.add("modo-noturno");
                textoTema.textContent = "Modo diurno";
            } else {
                document.body.classList.remove("modo-noturno");
                textoTema.textContent = "Modo noturno";
            }
        }
        function alternarTema() {
            var modoNoturnoAtivo = document.body.classList.contains("modo-noturno");

            if (modoNoturnoAtivo) {
                localStorage.setItem("tema", "claro");
                aplicarTema("claro");
            } else {
                localStorage.setItem("tema", "noturno");
                aplicarTema("noturno");
            }
        }
        var temaSalvo = localStorage.getItem("tema");
        if (temaSalvo) {
            aplicarTema(temaSalvo);
        } else {
            var prefereEscuro = window.matchMedia("(prefers-color-scheme: dark)").matches;
            if (prefereEscuro) {
                aplicarTema("noturno");
            } else {
                aplicarTema("claro");
            }
        }
    </script>
</body>
</html>
