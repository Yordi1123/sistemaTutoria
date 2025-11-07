<?php
echo "PHP está funcionando correctamente.<br>";
echo "Ruta actual: " . __DIR__ . "<br>";
echo "URI solicitada: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "<br>";
echo "Script name: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "<br>";
phpinfo();

