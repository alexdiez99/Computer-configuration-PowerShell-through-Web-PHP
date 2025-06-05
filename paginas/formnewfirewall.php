<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New firewall</title>
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
            <a href="../paginas/firewall.php">Atrás</a>
            <a href="../paginas/formnewfirewall.php">Restablecer</a>
        </div>
        <h1>Nueva regla de firewall</h1>

        <form action="" method="POST">
            <label for="numfirewall">¿Cuántas reglas de firewall desea crear? (1 al 4)</label>
            <input type="number" id="numfirewall" name="numfirewall" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numfirewall"])) {
                $numReglas = $_POST["numfirewall"];
                if ($numReglas < 1 || $numReglas > 4) {
                    echo "<p>El número de reglas de firewall es incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewfirewall.php' method='POST'>";
                    echo "<input type='hidden' name='numfirewall' value='$numReglas'>";
                        for ($i = 1; $i <= $numReglas; $i++) {
                            echo "</br>";
                            echo "<h3>Regla $i</h3>";
                           
                            echo "<label>¿Qué tipo de tráfico desea?</label>";
                            echo "<select name='direccionregla$i' id=='direccionregla$i'>
                                    <option value='Inbound'>Entrada: tráfico que llega desde afuera hacia su equipo.</option>
                                    <option value='Outbound'>Salida: tráfico que sale desde su equipo hacia afuera.</option>
                                  </select>";

                            echo "<label>¿Qué tipo de regla desea crear?</label>";
                            echo "<select name='tiporegla$i' id='tiporegla$i' onchange='setTypeRules($i)'>
                                    <option value='program'>Programa</option>
                                    <option value='port'>Puerto</option>
                                  </select>";
                            
                            echo "<div id='tipoprograma$i' name='tipoprograma$i' style='display:none;'>";
                                echo "<label>Escriba la ruta completa del programa:</label>";
                                echo "<input type='text' name='programaespe$i' id='programaespe$i' placeholder='C:\Windows\System32\notepad.exe'>";
                            echo "</div>";

                            echo "<div id='tipopuerto$i' name='tipopuerto$i' style='display:none;'>";
                                echo "<label>Se aplica esta regla a TCP o UDP?Protocolo:</label>";
                                echo "<select name='protocoloregla$i' id='protocoloregla$i'>
                                        <option value='TCP'>TCP</option>
                                        <option value='UDP'>UDP</option>
                                    </select>";
                                echo "<label>Escriba los puertos locales específicosPuerto:</label>";
                                echo "<input type='number' name='puertoespe$i' id='puertoespe$i' placeholder='22, 443, 21'>";
                            echo "</div>";

                            echo "<label>¿Qué acción desea realizar?</label>";
                            echo "<select name='accionregla$i' id='accionregla$i'>
                                    <option value='Allow'>Permitir</option>
                                    <option value='Block'>Bloquear</option>
                                  </select>";
                            
                            echo "<label>¿Cuando se aplica esta regla?</label>";
                            echo "<select name='perfilregla$i' id='perfilregla$i'>
                                    <option value='Domain'>Dominio: un equipo está conectado a un dominio.</option>
                                    <option value='Public'>Público: un equipo está conectado a redes públicas.</option>
                                    <option value='Private'>Privado: un equipo está conectado a una red privada, como doméstica o de trabajo.</option>
                                    <option value='Any'>Todos los anteriores.</option>
                                  </select>";

                            echo "<label>Escriba un nombre para la regla nueva:</label>";
                            echo "<input type='text' name='nameregla$i' id='nameregla$i' placeholder='BloquearPuerto22' required>";
                            
                            echo "<label>Escriba una descripción para la regla (opcional):</label>";
                            echo "<input type='text' name='descripcionregla$i' id='descripcionregla$i' placeholder='Regla para bloquear el puerto 22'>";
                            
                            echo "<script>
                                    function setTypeRules(i) {
                                        const selectTypeRules = document.getElementById('tiporegla' + i);
                                        const writeProgram = document.getElementById('tipoprograma' + i);
                                        const writePort = document.getElementById('tipopuerto' + i);
                                        
                                        if (selectTypeRules.value === 'program') {
                                            writeProgram.style.display = 'block';
                                            writePort.style.display = 'none';
                                        } else if (selectTypeRules.value === 'port') {
                                            writeProgram.style.display = 'none';
                                            writePort.style.display = 'block';
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