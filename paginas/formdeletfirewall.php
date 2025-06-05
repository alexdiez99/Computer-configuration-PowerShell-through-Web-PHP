<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete firewall</title>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/firewall.php">Atrás</a>
            <a href="../paginas/formdeletfirewall.php">Restablecer</a>
        </div>
        <h1>Eliminar regla de firewall</h1>

        <form action="" method="POST">
            <label for="numfirewall">¿Cuantas reglas de firewall desea borrar? (1 al 4)</label>
            <input type="number" id="numfirewall" name="numfirewall" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numfirewall"])) {
                $numReglasf = $_POST["numfirewall"];
                if ($numReglasf < 1 || $numReglasf > 4) {
                    echo "<p>El número de reglas de firewall es incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletfirewall.php' method='POST'>";
                    echo "<input type='hidden' name='numfirewall' value='$numReglasf>'";
                        for ($i = 1; $i <= $numReglasf; $i++) {
                            echo "</br>";
                            echo "<h3>Regla $i</h3>";
                            echo "<label>Nombre de la regla de firewall:</label>";
                            echo "<input type='text' name='nameregla$i' placeholder='BloquearPuerto22' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>