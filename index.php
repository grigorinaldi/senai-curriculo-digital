<?php
require_once "crud.php";

$candidatos = readAll($pdo, "dados_pessoais");

$idPessoa = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$idPessoa && !empty($candidatos)) {
    $idPessoa = $candidatos[0]["id"];
}

$dados = read(
    $pdo,
    "dados_pessoais",
    "*",
    "id = " . (int) $idPessoa
);

$contato = read(
    $pdo,
    "contatos",
    "*",
    "dados_pessoais_id = " . (int) $idPessoa
);

$experiencias = readAll(
    $pdo,
    "experiencias",
    "dados_pessoais_id = " . (int) $idPessoa
);

$formacoes = readAll(
    $pdo,
    "formacao",
    "dados_pessoais_id = " . (int) $idPessoa
);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="curriculo">

        <form method="GET" action="index.php">

            <label for="id">
                <strong>Selecionar candidato:</strong>
            </label>

            <select name="id" id="id" required>

                <?php foreach ($candidatos as $candidato): ?>

                    <option value="<?= $candidato["id"] ?>" <?= $candidato["id"] == $idPessoa ? "selected" : "" ?>>
                        <?= htmlspecialchars($candidato["nome"]) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <button type="submit">Visualizar currículo</button>

        </form>
        <header class="cabecalho">
            <h1><?= $dados["nome"] ?></h1>
            <h2><?= $dados["cargo"] ?></h2>
            <p><?= $dados["resumo"] ?></p>
            <p><?= $dados["informacoes_principais"] ?></p>
        </header>

        <div class="conteudo">
            <section>

                <h2>Contato</h2>
                <div class="contato">
                    <p>
                        <strong>E-mail: </strong>
                        <?= htmlspecialchars($contato["email"] ?? "Não informado") ?>
                    </p>
                    <p>
                        <strong>Telefone: </strong>
                        <?= htmlspecialchars($contato["telefone"] ?? "Não informado") ?>
                    </p>
                    <p>
                        <strong>Perfis Profissionais: </strong>
                        <?= htmlspecialchars($contato["perfis_profissionais"] ?? "Não informado") ?>
                    </p>
                </div>
            </section>

            <section>
                <h2>Experiência Profissional</h2>

                <?php foreach ($experiencias as $exp): ?>
                    <h3><?= $exp["empresa"] ?></h3>
                    <strong><?= $exp["funcao"] ?></strong>
                    <p><?= $exp["periodo"] ?></p>
                    <p><?= $exp["descricao"] ?></p>

                    <hr>

                <?php endforeach; ?>

                <h2>Formação</h2>

                <?php foreach ($formacoes as $formacao): ?>

                    <h3><?= $formacao["curso"] ?></h3>
                    <p><?= $formacao["instituicao"] ?></p>
                    <p><?= $formacao["periodo"] ?></p>
                <?php endforeach; ?>
            </section>
        </div>
    </main>

</body>

</html>