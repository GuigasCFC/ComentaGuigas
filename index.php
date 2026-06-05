<?php
    require_once "config/conexao.php";
    try {
        $sql  = "SELECT * FROM comentarios ORDER BY data_envio DESC";
        $stmt = $pdo->query($sql);
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $comentarios = [];
    }
    $sucesso = $_GET["sucesso"] ?? "";
    $erro = $_GET["erro"]    ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComentaGuigas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <button class="botao-tema" id="botaoTema" onclick="alternarTema()">
            <span class="botao-tema__trilho">
                <span class="botao-tema__bolinha"></span>
            </span>
        </button>
        <header class="cabecalho">
            <h1 class="cabecalho__titulo">ComentaGuigas</h1>
            <p class="cabecalho__subtitulo">Deixe seu comentário bem daora!</p>
        </header>
        <?php 
        if (!empty($sucesso)) : 
        ?>
            <div class="alerta alerta--sucesso">
                <?php
                 if ($sucesso === "comentario_cadastrado") : 
                ?>
                    Valeu pelo comentário!
                <?php
                 elseif ($sucesso === "comentario_editado") : 
                ?>
                    Tipo Bomba Patch, 100% atualizado
                <?php
                 elseif ($sucesso === "comentario_excluido") : 
                ?>
                    Excluído!
                <?php
                 endif; 
                ?>
            </div>
        <?php 
            endif; 
        ?>

        <?php
         if (!empty($erro)) : 
         ?>
            <div class="alerta alerta--erro">
                <?php
                 if ($erro === "campos_obrigatorios") : 
                ?>
                    Por favor, preencha tudo doidão.
                <?php
                 elseif ($erro === "email_invalido") : 
                ?>
                    O e-mail informado nao é valido. Para de inventar.
                <?php
                 elseif ($erro === "comentario_nao_encontrado") : 
                ?>
                    Comentario nao encontrado. Talvez ele ja tenha sido excluido.
                <?php
                 else : 
                ?>
                    Ocorreu um erro inesperado. Tente novamente.
                <?php
                    endif; 
                ?>
            </div>
        <?php
            endif; 
        ?>

        <section class="formulario-area">
            <h2 class="formulario-area__titulo">Manda o papo</h2>
            <form action="actions/cadastrar.php" method="POST" class="formulario">

                <div class="formulario__grupo">
                    <label class="formulario__label" for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" class="formulario__input" placeholder="Nome por favor" required>
                </div>
                <div class="formulario__grupo">
                    <label class="formulario__label" for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="formulario__input" placeholder="Nem invente email" required>
                </div>
                <div class="formulario__grupo">
                    <label class="formulario__label" for="comentario">Comentario</label>
                    <textarea id="comentario" name="comentario" class="formulario__textarea" placeholder="Lance o papo..." rows="4" required></textarea>
                </div>

                <div class="formulario__acoes">
                    <button type="submit" class="botao botao--primario">Enviar Comentario</button>
                </div>

            </form>
        </section>
        <section class="comentarios-area">
            <h2 class="comentarios-area__titulo">
                <?php
                    $total = count($comentarios);
                    if ($total === 0) {
                        echo "Nenhum comentario ainda";
                    } elseif ($total === 1) {
                        echo "1 Comentario";
                    } else {
                        echo $total . " Comentarios";
                    }
                ?>
            </h2>

            <div class="lista-comentarios">

                <?php
                 if (empty($comentarios)) : 
                ?>
                    <div class="sem-comentarios">
                        <p>Me sinto sozinho, deixe algo para eu responder</p>
                    </div>

                <?php 
                    else : 
                ?>
                    <?php
                     foreach ($comentarios as $item) : 
                    ?>

                        <article class="card-comentario">
                            <div class="card-comentario__cabecalho">
                                <div>
                                    <p class="card-comentario__nome">
                                        <?php
                                            echo htmlspecialchars($item["nome"]);
                                        ?>
                                    </p>
                                    <p class="card-comentario__email">
                                        <?php
                                         echo htmlspecialchars($item["email"]); 
                                        ?>
                                    </p>
                                </div>
                                <span class="card-comentario__data">
                                    <?php
                                        echo date("d/m/Y - H:i", strtotime($item["data_envio"]));
                                    ?>
                                </span>
                            </div>
                            <p class="card-comentario__texto">
                                <?php echo nl2br(htmlspecialchars($item["comentario"])); ?>
                            </p>
                            <div class="card-comentario__acoes">
                                <a href="actions/editar.php?id=
                                <?php
                                 echo $item["id"]; 
                                ?>" class="botao botao--editar"><i class="fa-solid fa-pencil"></i></a>
                                <a href="actions/excluir.php?id=
                                <?php
                                 echo $item["id"]; 
                                ?>" class="botao botao--excluir" onclick="return confirmarExclusao(event)"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </article>
                    <?php
                     endforeach; 
                    ?>

                <?php
                    endif; 
                ?>
            </div>
        </section>
        <footer class="rodape">
            <p>ComentaGuigas - Made by Guigas</p>
        </footer>

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
