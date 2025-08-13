<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        /** @var string $titre */
        echo $titre; ?></title>
    <script type="module" src="/fileAttente/ressources/js/script.js"></script>
    <link rel="stylesheet" href="/fileAttente/ressources/css/style.css">
</head>
<body>
<main>
    <?php
    /** @var string $cheminCorpsVue */
    require __DIR__ . "/{$cheminCorpsVue}";?>
</main>
</body>
</html>
