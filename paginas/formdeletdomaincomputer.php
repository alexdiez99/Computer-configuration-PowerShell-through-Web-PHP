<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete domain computer</title>
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
            <a href="../paginas/equiposdc.php">Atrás</a>
            <a href="../paginas/formdeletdomaincomputer.php">Restablecer</a>
        </div>
        <h1>Eliminar equipo en el dominio</h1>

        <form action="" method="POST">
            <label for="numcomputers">¿Cuántos equipos desea eliminar en su dominio? (1 al 4)</label>
            <input type="number" id="numcomputers" name="numcomputers" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numcomputers"])) {
                $numComputers = $_POST["numcomputers"];
                if ($numComputers < 1 || $numComputers > 4) {
                    echo "<p>El número de equipos incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletdomaincomputer.php' method='POST'>";
                    echo "<input type='hidden' name='numcomputers' value='$numComputers'>";
                        for ($i = 1; $i <= $numComputers; $i++) {
                            echo "</br>";
                            echo "<h3>Equipo $i</h3>";
                            echo "<label>Nombre del dominio (FQDN):</label>";
                            echo "<input type='text' name='namedomain$i' placeholder='iespabloserrano.local' required>";
                            echo "<label>Nombre de equipo:</label>";
                            echo "<input type='text' name='namecomputer$i' placeholder='SOLPO001I039' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>