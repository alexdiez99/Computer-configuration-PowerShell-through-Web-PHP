<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete task</title>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/tareasprogramadas.php">Atrás</a>
            <a href="../paginas/formdelettask.php">Restablecer</a>
        </div>
        <h1>Eliminar tarea programada</h1>

        <form action="" method="POST">
            <label for="numtask">¿Cuantas tareas programadas desea borrar? (1 al 4)</label>
            <input type="number" id="numtask" name="numtask" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numtask"])) {
                $numTask = $_POST["numtask"];
                if ($numTask < 1 || $numTask > 4) {
                    echo "<p>El número de tareas programadas es incorrecto.</p>";
                } else {
                    echo "<form action='scriptdelettask.php' method='POST'>";
                    echo "<input type='hidden' name='numtask' value='$numTask>'";
                        for ($i = 1; $i <= $numTask; $i++) {
                            echo "</br>";
                            echo "<h3>Tarea programada $i</h3>";
                            echo "<label>Nombre de la tarea programada:</label>";
                            echo "<input type='text' name='nametask$i' placeholder='EjecutarNotepad31diciembre' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>