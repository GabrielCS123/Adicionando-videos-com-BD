<?php
$pdo = new PDO('mysql:host=localhost;dbname=testes_php', 'root', 'Nilcilenecelio123.');

$sql1 = $pdo->query("SELECT * FROM video");
$valores = $sql1->fetchAll(PDO::FETCH_ASSOC);

function transformarLink($linkA)
{
    $urlComponents = parse_url($linkA);
    $path = $urlComponents['path'];
    $videoId = explode('/', $path)[1];
    $query = isset($urlComponents['query']) ? '?' . $urlComponents['query'] : '';
    return "https://www.youtube.com/embed/{$videoId}{$query}";
}

function gerarVideo($valores)
{
    foreach ($valores as $valor) :
        $linkPronto = transformarLink($valor['link']); ?>

        <h1><?= htmlspecialchars($valor['nome']) ?></h1>
        <iframe width="560" height="315" src="<?= htmlspecialchars($linkPronto) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

<?php endforeach;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $link = $_POST['link'];
    $sql2 = $pdo->query("INSERT INTO video (nome, link) VALUES ('$nome', '$link')");

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testes com BD</title>
</head>

<body>

    <h1>Adicione um vídeo</h1>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>
        <label for="link">Link:</label>
        <input type="text" id="link" name="link" required>
        <br><br>
        <input type="submit" value="Enviar">
    </form>

    <?php gerarVideo($valores); ?>

</body>

</html>