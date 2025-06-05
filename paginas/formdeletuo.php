<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete OU</title>
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
            <a href="../paginas/uodc.php">Atrás</a>
            <a href="../paginas/formdeletuo.php">Restablecer</a>
        </div>
        <h1>Eliminar unidad organizativa en el dominio</h1>

        <form action="" method="POST">
            <label for="numuo">¿Cuántas unidades organizativas desea eliminar en su dominio? (1 al 4)</label>
            <input type="number" id="numuo" name="numuo" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numuo"])) {
                $numUO = $_POST["numuo"];
                if ($numUO < 1 || $numUO > 4) {
                    echo "<p>El número de UOs incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletuo.php' method='POST'>";
                    echo "<input type='hidden' name='numuo' value='$numUO'>";
                        for ($i = 1; $i <= $numUO; $i++) {
                            echo "</br>";
                            echo "<h3>Unidad organizativa $i</h3>";
                            echo "<label>Nombre del dominio (FQDN):</label>";
                            echo "<input type='text' name='namedomain$i' placeholder='iespabloserrano.local' required>";
                            echo "<label>Nombre de la unidad organizativa:</label>";
                            echo "<input type='text' name='maneou$i' placeholder='Equipos ó Sede Zaragoza/Equipos/ST' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>