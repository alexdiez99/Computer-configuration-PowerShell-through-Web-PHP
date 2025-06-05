<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete network</title>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/confred.php">Atrás</a>
            <a href="../paginas/formdeletred.php">Restablecer</a>
        </div>
        <h1>Eliminar configuración de red</h1>

        <form action="" method="POST">
            <label for="numinterfaces">¿A cuántos adaptadores de red desea eliminar la configuración de red? (1 al 4)</label>
            <input type="number" id="numinterfaces" name="numinterfaces" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numinterfaces"])) {
                $numInterface = $_POST["numinterfaces"];
                if ($numInterface < 1 || $numInterface > 4) {
                    echo "<p>El número de interfaces incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletred.php' method='POST'>";
                    echo "<input type='hidden' name='numinterfaces' value='$numInterface>'";
                        for ($i = 1; $i <= $numInterface; $i++) {
                            echo "</br>";
                            echo "<h3>Adaptador $i</h3>";
                            echo "<label>Nombre del adaptador:</label>";
                            echo "<input type='text' name='namenet$i' placeholder='Ethernet 4' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>