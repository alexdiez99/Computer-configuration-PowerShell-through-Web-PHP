<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New backup</title>
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
            <a href="../paginas/formnewsecurecopy.php">Restablecer</a>
        </div>
        <h1>Nueva copia de seguridad</h1>

        <form action="" method="POST">
            <label for="numcopias">¿Cuántas copias de seguridad desea crear? (1 al 4)</label>
            <input type="number" id="numcopias" name="numcopias" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numcopias"])) {
                $numCopias = $_POST["numcopias"];
                if ($numCopias < 1 || $numCopias > 4) {
                    echo "<p>El número de copias incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewsecurecopy.php' method='POST'>";
                    echo "<input type='hidden' name='numcopias' value='$numCopias'>";
                        for ($i = 1; $i <= $numCopias; $i++) {
                            echo "</br>";
                            echo "<h3>Copia de seguridad $i</h3>";
                            
                            echo "<label>¿De que quiere hacer la copia de seguridad?</label>";
                            echo "<select name='objetocopia$i' id='objetocopia$i' onchange='setObjectCopy($i)' required>";
                                echo "<option value='archivo'>Archivo</option>";
                                echo "<option value='carpeta'>Carpeta</option>";
                            echo "</select>";

                            echo "<div id='filecontainer$i' name='filecontainer$i' style='display:none;'>";
                                echo "<label>Escriba la ruta completa donde se encuentra el archivo a copiar:</label>";
                                echo "<input type='text' name='filepath$i' id='filepath$i' placeholder='D:\Informatica\intro-powershell.php'>";
                                
                                echo "<label>¿Donde quiere guardar la copia de seguridad?</label>";
                                echo "<select name='dondecopia$i' id='dondecopia$i' onchange='setWhereFileCopy($i)' required>";
                                    echo "<option value='equipolocal'>En su equipo</option>";
                                    echo "<option value='equiporemoto'>En otro equipo</option>";
                                echo "</select>";

                                echo "<div id='localcontainer$i' name='localcontainer$i' style='display:none;'>";
                                    echo "<label>Escriba la ruta completa donde desea guardar el archivo:</label>";
                                    echo "<input type='text' name='localpath$i' id='localpath$i' placeholder='D:\Copias\miequipo'>";
                                    echo "<label>Escriba un nuevo nombre para la copia:</label>";
                                    echo "<input type='text' name='nombrecopia$i' id='nombrecopia$i' placeholder='Pruebamiequipo'>";
                                echo "</div>";

                                echo "<div id='remotecontainer$i' name='remotecontainer$i' style='display:none;'>";
                                    echo "<label>Escriba la dirección IP y ruta completa donde desea guardar el archivo:</label>";
                                    echo "<input type='text' name='remotepath$i' id='remotepath$i' placeholder='\\192.168.1.39\copias\'>";
                                    echo "<label>Escriba un nuevo nombre para la copia:</label>";
                                    echo "<input type='text' name='nombrecopia2$i' id='nombrecopia2$i' placeholder='Pruebaremoto'>";
                                echo "</div>";

                            echo "</div>";

                            echo "<div id='directorycontainer$i' name='directorycontainer$i' style='display:none;'>";
                                echo "<label>Escriba la ruta completa donde se encuentra la carpeta a copiar:</label>";
                                echo "<input type='text' name='directorypath$i' id='directorypath$i' placeholder='D:\Informatica\OVAs'>";

                                echo "<label>¿Donde quiere guardar la copia de seguridad?</label>";
                                echo "<select name='dondecopia2$i' id='dondecopia2$i' onchange='setWhereDirectoryCopy($i)' required>";
                                    echo "<option value='equipolocal2'>En su equipo</option>";
                                    echo "<option value='equiporemoto2'>En otro equipo</option>";
                                echo "</select>";

                                echo "<div id='localcontainer2$i' name='localcontainer2$i' style='display:none;'>";
                                    echo "<label>Escriba la ruta completa donde desea guardar la carpeta:</label>";
                                    echo "<input type='text' name='localpath2$i' id='localpath2$i' placeholder='D:\Copias\enremoto'>";
                                    echo "<label>Escriba un nuevo nombre para la copia:</label>";
                                    echo "<input type='text' name='nombrecopia3$i' id='nombrecopia3$i' placeholder='Pruebamiequipo'>";
                                echo "</div>";

                                echo "<div id='remotecontainer2$i' name='remotecontainer2$i' style='display:none;'>";
                                    echo "<label>Escriba la dirección IP y ruta completa donde desea guardar la carpeta:</label>";
                                    echo "<input type='text' name='remotepath2$i' id='remotepath2$i' placeholder='\\192.168.24.254\copias\'>";
                                    echo "<label>Escriba un nuevo nombre para la copia:</label>";
                                    echo "<input type='text' name='nombrecopia4$i' id='nombrecopia4$i' placeholder='Pruebaremoto'>";
                                echo "</div>";

                            echo "</div>";


                            echo "<script>
                                    function setObjectCopy(i) {
                                        const selectfiledirectory = document.getElementById('objetocopia' + i);
                                        const writePathFile = document.getElementById('filecontainer' + i);
                                        const writePathDirectory = document.getElementById('directorycontainer' + i);
                                        
                                        if (selectfiledirectory.value === 'archivo') {
                                            writePathFile.style.display = 'block';
                                            writePathDirectory.style.display = 'none';
                                        } else if (selectfiledirectory.value === 'carpeta') {
                                            writePathFile.style.display = 'none';
                                            writePathDirectory.style.display = 'block';
                                        }
                                    }
                                </script>";

                            echo "<script>
                                    function setWhereFileCopy(i) {
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
                            echo "<script>
                                    function setWhereDirectoryCopy(i) {
                                        const selectWhereCopy = document.getElementById('dondecopia2' + i);
                                        const writePathLocal = document.getElementById('localcontainer2' + i);
                                        const writePathRemote = document.getElementById('remotecontainer2' + i);
                                        
                                        if (selectWhereCopy.value === 'equipolocal2') {
                                            writePathLocal.style.display = 'block';
                                            writePathRemote.style.display = 'none';
                                        } else if (selectWhereCopy.value === 'equiporemoto2') {
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