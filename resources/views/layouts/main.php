<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Sistema Académico') ?></title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <h1>Sistema Académico</h1>
                <ul>
                    <li><a href="<?= url('/') ?>">Inicio</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> Sistema Académico. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
