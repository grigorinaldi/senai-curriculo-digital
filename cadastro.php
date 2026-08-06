<?php

require_once "crud.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        $pdo->beginTransaction();

        $idPessoa = create($pdo, "dados_pessoais", [
            "nome" => $_POST["nome"],
            "cargo" => $_POST["cargo"],
            "resumo" => $_POST["resumo"],
            "informacoes_principais" => $_POST["informacoes_principais"]
        ]);

        create($pdo, "contatos", [
            "dados_pessoais_id" => $idPessoa,
            "email" => $_POST["email"],
            "telefone" => $_POST["telefone"],
            "perfis_profissionais" => $_POST["perfis_profissionais"]
        ]);

        create($pdo, "experiencias", [
            "dados_pessoais_id" => $idPessoa,
            "empresa" => $_POST["empresa"],
            "funcao" => $_POST["funcao"],
            "periodo" => $_POST["periodo_experiencia"],
            "descricao" => $_POST["descricao"]
        ]);

        create($pdo, "formacao", [
            "dados_pessoais_id" => $idPessoa,
            "instituicao" => $_POST["instituicao"],
            "curso" => $_POST["curso"],
            "periodo" => $_POST["periodo_formacao"]
        ]);

        $pdo->commit();

        header("Location: index.php?id=" . $idPessoa);
        exit;

    } catch (Exception $erro) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $mensagem = "Erro ao cadastrar: " . $erro->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar currículo</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <main class="formulario-container">

        <h1>Cadastrar currículo</h1>

        <?php if ($mensagem !== ""): ?>

            <p><?= htmlspecialchars($mensagem) ?></p>

        <?php endif; ?>

        <form method="POST" action="cadastro.php">

            <h2>Dados pessoais</h2>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="cargo" required>

            <label for="resumo">Resumo</label>
            <textarea id="resumo" name="resumo" required></textarea>

            <label for="informacoes_principais">Informações principais</label>

            <textarea id="informacoes_principais" name="informacoes_principais" required></textarea>


            <h2>Contato</h2>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="perfis_profissionais">Perfis profissionais</label>

            <input type="text" id="perfis_profissionais" name="perfis_profissionais">


            <h2>Experiência profissional</h2>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="empresa" required>

            <label for="funcao">Função</label>
            <input type="text" id="funcao" name="funcao" required>

            <label for="periodo_experiencia">Período</label>
            <input type="text" id="periodo_experiencia" name="periodo_experiencia" required>

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required></textarea>


            <h2>Formação</h2>

            <label for="instituicao">Instituição</label>
            <input type="text" id="instituicao" name="instituicao" required>

            <label for="curso">Curso</label>
            <input type="text" id="curso" name="curso" required>

            <label for="periodo_formacao">Período</label>
            <input type="text" id="periodo_formacao" name="periodo_formacao" required>

            <button type="submit">Salvar currículo</button>

        </form>

        <a href="index.php">Ver currículo</a>

    </main>

</body>

</html>