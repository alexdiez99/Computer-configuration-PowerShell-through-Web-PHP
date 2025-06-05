<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete domain user</title>
    <style>
        form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/usuariosdc.php">Atrás</a>
            <a href="../paginas/formdeletdomainuser.php">Restablecer</a>
        </div>
        <h1>Eliminar usuario en el dominio</h1>

        <form action="" method="POST">
            <label for="numusers">¿Cuántos usuarios desea eliminar en su dominio? (1 al 4)</label>
            <input type="number" id="numusers" name="numusers" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numusers"])) {
                $numUsers = $_POST["numusers"];
                if ($numUsers < 1 || $numUsers > 4) {
                    echo "<p>El número de usuarios incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletdomainuser.php' method='POST'>";
                    echo "<input type='hidden' name='numusers' value='$numUsers'>";
                        for ($i = 1; $i <= $numUsers; $i++) {
                            echo "</br>";
                            echo "<h3>Usuario $i</h3>";
                            echo "<label>Nombre del dominio (FQDN):</label>";
                            echo "<input type='text' name='namedomain$i' placeholder='iespabloserrano.local' required>";
                            echo "<label>Nombre de inicio de sesión:</label>";
                            echo "<input type='text' name='namesessionuser$i' placeholder='mortadelo.perez' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>