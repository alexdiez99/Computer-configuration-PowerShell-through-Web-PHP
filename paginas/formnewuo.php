<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New OU</title>
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
            <a href="../paginas/formnewuo.php">Restablecer</a>
        </div>
        <h1>Nueva unidad organizativa en el dominio</h1>

        <form action="" method="POST">
            <label for="numuo">¿Cuántas unidades organizativas desea crear en su dominio? (1 al 4)</label>
            <input type="number" id="numuo" name="numuo" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numuo"])) {
                $numUo = $_POST["numuo"];
                if ($numUo < 1 || $numUo > 4) {
                    echo "<p>El número de UOs incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewuo.php' method='POST'>";
                    echo "<input type='hidden' name='numuo' value='$numUo'>";
                        for ($i = 1; $i <= $numUo; $i++) {
                            echo "</br>";
                            echo "<h3>Unidad organizativa $i</h3>";
                            echo "<label>Nombre del dominio (FQDN):</label>";
                            echo "<input type='text' name='domainname$i' placeholder='iespabloserrano.local' required>";
                            
                            echo "<label>Nombre para la unidad organizativa:</label>";
                            echo "<input type='text' name='uoname$i' placeholder='Equipos'>";

                            echo "<label>¿Dento de esta nueva UO, desea crear otra unidad organizativa?</label>";
                            echo "<select name='subuo1$i' id='subuo1$i' onchange='setSubUo1($i)' required>
                                    <option value='no'>No</option>
                                    <option value='si'>Si</option>
                                </select>";
                            
                            echo "<div name='subuo1numbercontainer$i' id='subuo1numbercontainer$i' style='display:none;'>
                                <label>¿Cuántas UOs desea crear dentro de esta nueva UO?</label>
                                <select name='subuo1number$i' id='subuo1number$i' onchange='generateSubUo($i)'>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                </select>  
                                </div>";
                            
                            echo "<div name='showsubuo1container$i' id='showsubuo1container$i' style='display:none;'>
                                    
                                </div>";
                            
                            echo "<script>
                                function setSubUo1(i) {
                                    const selectSubUo1 = document.getElementById('subuo1' + i);
                                    const selectSubUo1Number = document.getElementById('subuo1numbercontainer' + i);
                                    const mostrarCampoSubUO = document.getElementById('showsubuo1container' + i);

                                    if (selectSubUo1.value === 'si') {
                                        selectSubUo1Number.style.display = 'block';
                                    } else {
                                        selectSubUo1Number.style.display = 'none';
                                        mostrarCampoSubUO.style.display = 'none';
                                        document.getElementById('subuo1number').value = '';
                                    }
                                }
                                </script>";

                            echo "<script>
                                function generateSubUo(i) {
                                    const numSelect = document.getElementById('subuo1number' + i);
                                    const num = parseInt(numSelect.value);
                                    const container = document.getElementById('showsubuo1container' + i);
                                    container.innerHTML = '';
                                    

                                    if (!isNaN(num)) {
                                    container.style.display = 'block';
                                        for (j = 1; j <= num; j++) {
                                            const label = document.createElement('label');
                                            label.textContent = 'Nombre de la sub-UO ' + j + ':';

                                            const input = document.createElement('input');
                                            input.type = 'text';
                                            input.name = 'subuo1name' + i + '_' + j;
                                            input.placeholder = 'Equipos ' + j;
                                            input.required = true;

                                            container.appendChild(label);
                                            container.appendChild(input);
                                        }
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