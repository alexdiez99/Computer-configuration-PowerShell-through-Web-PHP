<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New task</title>
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
            <a href="../paginas/tareasprogramadas.php">Atrás</a>
            <a href="../paginas/formnewtask.php">Restablecer</a>
        </div>
        <h1>Nueva tarea programada</h1>

        <form action="" method="POST">
            <label for="numtask">¿Cuántas tareas programadas desea crear? (1 al 4)</label>
            <input type="number" id="numtask" name="numtask" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numtask"])) {
                $numTareas = $_POST["numtask"];
                if ($numTareas < 1 || $numTareas > 4) {
                    echo "<p>El número de tareas incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewtask.php' method='POST'>";
                    echo "<input type='hidden' name='numtask' value='$numTareas'>";
                        for ($i = 1; $i <= $numTareas; $i++) {
                            echo "</br>";
                            echo "<h3>Tarea programada $i</h3>";
                            
                            echo "<label>Nombre:</label>";
                            echo "<input type='text' name='taskname$i' id='taskname$i' placeholder='EjecutarCopias' required>";

                            echo "<label>Descripción:</label>";
                            echo "<input type='text' name='taskdescription$i' id='taskdescription$i' placeholder='Ejecutar copias de seguridad cada mes'>";

                            echo "<label>¿Cuándo desea que se inicie la tarea programada?</label>";
                            echo "<select name='taskstart$i' id='taskstart$i' onchange='setStartTask($i)'>
                                    <option value='daily'>Diariamente</option>
                                    <option value='weekly'>Semanalmente</option>
                                    <option value='once'>Una vez</option>
                                    <option value='sessionstartup'>Al iniciar sesión</option>
                                </select>";

                            echo "<div name='dailycontainer$i' id='dailycontainer$i' style='display:none;'>
                                    <label>Fecha inicio:</label>
                                    <input type='date' name='dailydate$i' id='dailydate$i'>
                                    <label>Hora inicio:</label>
                                    <input type='time' name='dailyhour$i' id='dailyhour$i'>
                                    <label>¿Cada cuántos dias desea repetir la ejecución de la tarea?</label>
                                    <input type='number' name='dailyrepeat$i' id='dailyrepeat$i' placeholder='1' min='1' max='31'>
                                    
                                </div>";

                            echo "<div name='weeklycontainer$i' id='weeklycontainer$i' style='display:none;'>
                                    <label>Fecha inicio:</label>
                                    <input type='date' name='weeklydate$i' id='weeklydate$i'>
                                    <label>Hora inicio:</label>
                                    <input type='time' name='weeklyhour$i' id='weeklyhour$i'>
                                    <label>¿Cada cuantás semanas desea repetir la ejecución de la tarea?</label>
                                    <input type='number' name='weeklyrepeat$i' id='weeklyrepeat$i'>
                                    <label>¿En qué día de la semana desea repetir esta acción?</label>
                                    <select name='weeklydays$i' id='weeklydays$i'>
                                        <option value='Monday'>Lunes</option>
                                        <option value='Tuesday'>Martes</option>
                                        <option value='Wednesday'>Miércoles</option>
                                        <option value='Thursday'>Jueves</option>
                                        <option value='Friday'>Viernes</option>
                                        <option value='Saturday'>Sábado</option>
                                        <option value='Sunday'>Domingo</option>
                                    </select>                                    
                                </div>";
                            
                            echo "<div name='monthlycontainer$i' id='monthlycontainer$i' style='display:none;'>
                                    <label>Fecha inicio:</label>
                                    <input type='date' name='monthlydate$i' id='monthlydate$i'>
                                    <label>Hora inicio:</label>
                                    <input type='time' name='monthlyhour$i' id='monthlyhour$i'>
                                    <label>¿En qué mes desea repetir la ejecución de la tarea?</label>
                                    <select name='months$i' id='months$i'>
                                        <option value='enero'>Enero</option>
                                        <option value='febrero'>Febrero</option>
                                        <option value='marzo'>Marzo</option>
                                        <option value='abril'>Abril</option>
                                        <option value='mayo'>Mayo</option>
                                        <option value='junio'>Junio</option>
                                        <option value='julio'>Julio</option>
                                        <option value='agosto'>Agosto</option>
                                        <option value='septiembre'>Septiembre</option>
                                        <option value='octubre'>Octubre</option>
                                        <option value='noviembre'>Noviembre</option>
                                        <option value='diciembre'>Diciembre</option>
                                    </select>
                                    <label>¿Qué día del mes desea repetir esta acción?</label>
                                    <input type='number' name='monthlyrepeat$i' id='monthlyrepeat$i' placeholder='23' min='1' max='31'>                                                                       
                                </div>";

                            echo "<div name='oncecontainer$i' id='oncecontainer$i' style='display:none;'>
                                    <label>Fecha inicio:</label>
                                    <input type='date' name='oncedate$i' id='oncedate$i'>
                                    <label>Hora inicio:</label>
                                    <input type='time' name='oncehour$i' id='oncehour$i'>
                                </div>";

                            echo "<label>¿Qué acción desea que realice la tarea?</label>                                    
                                    <select name='action$i' id='action$i' onchange='setAction($i)' required>
                                        <option value='startprogram'>Iniciar un programa</option>
                                        <option value='shutdownpc'>Apagar el ordenador</option>
                                        <option value='showmessage'>Mostrar un mensaje</option>
                                        <option value='deletedownload'>Eliminar archivos en Descargas</option>
                                    </select>

                                    <div name='startprogramcontainer$i' id='startprogramcontainer$i' style='display:none;'>
                                        <label>Escriba la ruta completa del programa:</label>
                                        <input type='text' name='pathprogram$i' id='pathprogram$i'>
                                    </div>
                                    
                                    <div name='showmessagecontainer$i' id='showmessagecontainer$i' style='display:none;'>
                                        <label>Escriba el mensaje que se desea que aparezca:</label>
                                        <input type='text' name='lineshowmessage$i' id='lineshowmessage$i' placeholder='Horario laboral de 8:00 a 15:00'>
                                    </div>";

                            echo "<script>
                                    function setStartTask(i) {
                                        const selectTaskStart = document.getElementById('taskstart' + i);
                                        const writeDaily = document.getElementById('dailycontainer' + i);
                                        const writeWeekly = document.getElementById('weeklycontainer' +i);
                                        const writeMonthly = document.getElementById('monthlycontainer' + i);
                                        const writeOnce = document.getElementById('oncecontainer' + i);
                                        if (selectTaskStart.value === 'daily') {
                                            writeDaily.style.display = 'block';
                                            writeWeekly.style.display = 'none';
                                            writeMonthly.style.display = 'none';
                                            writeOnce.style.display = 'none';
                                        } else if (selectTaskStart.value === 'weekly') {
                                            writeWeekly.style.display = 'block';
                                            writeDaily.style.display = 'none';
                                            writeMonthly.style.display = 'none';
                                            writeOnce.style.display = 'none';
                                        } else if (selectTaskStart.value === 'monthly') {
                                            writeMonthly.style.display = 'block';
                                            writeDaily.style.display = 'none';
                                            writeWeekly.style.display = 'none';
                                            writeOnce.style.display = 'none';
                                        } else if (selectTaskStart.value === 'once') {
                                            writeOnce.style.display = 'block';
                                            writeMonthly.style.display = 'none';
                                            writeDaily.style.display = 'none';
                                            writeWeekly.style.display = 'none';
                                        } else if (selectTaskStart.value === 'sessionstartup') {
                                            writeWeekly.style.display = 'none';
                                            writeDaily.style.display = 'none';
                                            writeMonthly.style.display = 'none';
                                            writeOnce.style.display = 'none';
                                        }
                                    }
                                </script>";
                                
                            echo "<script>
                                    function setAction(i) {
                                        const selectAction = document.getElementById('action' + i);
                                        const writeStartProgram = document.getElementById('startprogramcontainer' + i);
                                        const writeShowMessage = document.getElementById('showmessagecontainer' + i);
                                        if (selectAction.value === 'startprogram') {
                                           writeStartProgram.style.display = 'block';
                                           writeShowMessage.style.display = 'none';
                                        } else if (selectAction.value === 'shutdownpc') {
                                            writeStartProgram.style.display = 'none';
                                            writeShowMessage.style.display = 'none';
                                        } else if (selectAction.value === 'showmessage') {
                                            writeShowMessage.style.display = 'block';
                                            writeStartProgram.style.display = 'none';
                                        } else if (selectAction.value === 'deletedownload') {
                                            writeStartProgram.style.display = 'none';
                                            writeShowMessage.style.display = 'none';
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