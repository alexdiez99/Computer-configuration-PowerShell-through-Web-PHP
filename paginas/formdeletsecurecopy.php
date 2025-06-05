<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete backup</title>
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
            <a href="../paginas/copiasseguridad.php">Atrás</a>
            <a href="../paginas/formdeletsecurecopy.php">Restablecer</a>
        </div>
        <h1>Eliminar copia de seguridad</h1>

        <form action="" method="POST">
            <label for="numcopias">¿Cuántas copias de seguridad desea eliminar? (1 al 4)</label>
            <input type="number" id="numcopias" name="numcopias" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numcopias"])) {
                $numCopias = $_POST["numcopias"];
                if ($numCopias < 1 || $numCopias > 4) {
                    echo "<p>El número de copias incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletsecurecopy.php' method='POST'>";
                    echo "<input type='hidden' name='numcopias' value='$numCopias'>";
                        for ($i = 1; $i <= $numCopias; $i++) {
                            echo "</br>";
                            echo "<h3>Copia de seguridad $i</h3>";
                            
                            echo "<label>¿Donde se encuentra la copia de seguridad?</label>";
                            echo "<select name='dondecopia$i' id='dondecopia$i' onchange='setWhereCopy($i)' required>";
                                echo "<option value='equipolocal'>En su equipo</option>";
                                echo "<option value='equiporemoto'>En un servidor</option>";
                            echo "</select>";

                            echo "<div id='localcontainer$i' name='localcontainer$i' style='display:none;'>";
                                echo "<label>Escriba la ruta completa de la copia a eliminar:</label>";
                                echo "<input type='text' name='localpath$i' id='localpath$i' placeholder='D:\Copias\miequipo'>";
                            echo "</div>";

                            echo "<div id='remotecontainer$i' name='remotecontainer$i' style='display:none;'>";
                                echo "<label>Escriba la ruta completa de la copia a eliminar:</label>";
                                echo "<input type='text' name='remotepath$i' id='remotepath$i' placeholder='\\192.168.1.39\copias\miequipo'>";
                            echo "</div>";

                            echo "<script>
                                    function setWhereCopy(i) {
                                        const selectWhereCopy = document.getElementById('dondecopia' + i);
                                        const writePathLocal = document.getElementById('localcontainer' + i);
                                        const writePathRemote = document.getElementById('remotecontainer' + i);
                                        
                                        if (selectWhereCopy.value === 'equipolocal') {
                                            writePathLocal.style.display = 'block';
                                            writePathRemote.style.display = 'none';
                                        } else if (selectWhereCopy.value === 'equiporemoto') {
                                            writePathLocal.style.display = 'none';
                                            writePathRemote.style.display = 'block';
                                        }
                                    }
                                </script>";

                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>