<?php

require_once '../Helper/Autoloader.php';

$loader = new Facturacion\Helper\Autoloader();
$loader->registrar();

?>

<!DOCTYPE html>

<head>
    <title>Test PHP</title>
</head>

<body>
    <p>
    <!-- <?php phpinfo();?> -->
<!--     
        <?php
        $controlador = new Facturacion\Controlador\ControladorUsuario();
        $resultado = $controlador->obtenerUsuarioPorId(1);
        foreach ($resultado as $campo) {
            echo $campo['user_name'] . " => " . $campo['email'] . "</br>";
        }
        ?> -->
    <!-- <form action="#" method="POST">
        <div class="contenedor">
            <h2>Registro de usuario</h2>
            <label for="user-name">Nombre de usuario:</label>
            <input type="text" id="user-name" placeholder="Nombre de usuario"/>
            <label for="user-email">Email:</label>
            <input type="email" id="user-email" placeholder="Correo electrónico"/>
            <label for="user-password">Password:</label>
            <input type="password" id="user-password" placeholder="password"/>
            <input type="button" id="user-registrar" value="Registrar"/>
        </div>
    </form> -->
        
    </p>
</body>