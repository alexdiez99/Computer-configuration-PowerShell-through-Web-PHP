<?php
/*var_dump($_POST);*/
$script = "";

$numTareas = $_POST["numtask"];

for ($i = 1; $i <= $numTareas; $i++) {
    
    $nombreTarea = $_POST["taskname$i"];
    $descripcionTarea = $_POST["taskdescription$i"];
    $empiezaTarea = $_POST["taskstart$i"];

    $fechaDia = $_POST["dailydate$i"];
    $horaDia = $_POST["dailyhour$i"];
    $repiteDia = $_POST["dailyrepeat$i"];
    
    $fechaSemana = $_POST["weeklydate$i"];
    $horaSemana = $_POST["weeklyhour$i"];
    $repiteSemana = $_POST["weeklyrepeat$i"];
    $diasSemana = $_POST["weeklydays$i"];
    
    $fechaMes = $_POST["monthlydate$i"];
    $horaMes = $_POST["monthlyhour$i"];
    $mes = $_POST["months$i"];
    $repiteDiaMes = $_POST["monthlyrepeat$i"];

    $unavezFecha = $_POST["oncedate$i"];
    $unavezHora = $_POST["oncehour$i"];

    $accion = $_POST["action$i"];

    $accionIniciarPrograma = $_POST["pathprogram$i"];
    $mostrarMensaje = $_POST["lineshowmessage$i"];

    /*$script .= "
        Nombre tarea: $nombreTarea
        Descripción tarea: $descripcionTarea
        Empieza tarea: $empiezaTarea
        Fecha inicio: $fechaDia
        Hora inicio: $horaDia
        Repite cada: $repiteDia días
        Accion: $accion
        Iniciar programa: $accionIniciarPrograma
    ";*/

    if ($accion == "startprogram") {
        if ($empiezaTarea == "daily") {
            
            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";
            
            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"" . $accionIniciarPrograma . "\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Daily -At \"" . $horaDia . "\" -DaysInterval $repiteDia \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaDia . "T" . $horaDia . ":00\" \n \n";
            
            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaDia cada $repiteDia dias, a partir del $fechaDia\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "weekly") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"" . $accionIniciarPrograma . "\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Weekly -At \"" . $horaSemana . "\" -WeeksInterval $repiteSemana -DaysOfWeek $diasSemana \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaSemana . "T" . $horaSemana . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaSemana cada $diasSemana cada $repiteSemana semanas, a partir del $fechaSemana\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "monthly") {

            /*$script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"" . $accionIniciarPrograma . "\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Monthly -At \"" . $horaMes . "\" -MonthsOfYear $mes -DaysOfMonth $repiteDiaMes \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaMes . "T" . $horaMes . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaMes cada $repiteDiaMes cada mes de $mes, a partir del $fechaMes\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";*/

        } elseif ($empiezaTarea == "once") {
  
            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"" . $accionIniciarPrograma . "\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Once -At \"" . $unavezHora . "\" \n";
            $script .= "\$trigger.StartBoundary = \"" . $unavezFecha . "T" . $unavezHora . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $unavezHora el $unavezFecha\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "sessionstartup") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"" . $accionIniciarPrograma . "\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -AtLogon \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. La tarea se iniciara al iniciar sesion de cualquier usuario\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        }
    } elseif ($accion == "shutdownpc") {
        if ($empiezaTarea == "daily") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";
            
            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"C:\Windows\System32\shutdown.exe\" -Argument \"/s /f /t 0\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Daily -At \"" . $horaDia . "\" -DaysInterval $repiteDia \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaDia . "T" . $horaDia . ":00\" \n \n";
            
            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaDia cada $repiteDia dias, a partir del $fechaDia\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "weekly") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"C:\Windows\System32\shutdown.exe\" -Argument \"/s /f /t 0\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Weekly -At \"" . $horaSemana . "\" -WeeksInterval $repiteSemana -DaysOfWeek $diasSemana \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaSemana . "T" . $horaSemana . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaSemana cada $diasSemana cada $repiteSemana semanas, a partir del $fechaSemana\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "monthly") {

        } elseif ($empiezaTarea == "once") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"C:\Windows\System32\shutdown.exe\" -Argument \"/s /f /t 0\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Once -At \"" . $unavezHora . "\" \n";
            $script .= "\$trigger.StartBoundary = \"" . $unavezFecha . "T" . $unavezHora . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $unavezHora el $unavezFecha\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "sessionstartup") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"C:\Windows\System32\shutdown.exe\" -Argument \"/s /f /t 0\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -AtLogon \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. La tarea se iniciara al iniciar sesion de cualquier usuario\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";
            
        }
    } elseif ($accion == "showmessage") {
        if ($empiezaTarea == "daily") {
        
            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";
            
            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-WindowStyle Hidden -Command Add-Type -AssemblyName PresentationFramework; [System.Windows.MessageBox]::Show('$mostrarMensaje')\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Daily -At \"" . $horaDia . "\" -DaysInterval $repiteDia \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaDia . "T" . $horaDia . ":00\" \n \n";
            
            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaDia cada $repiteDia dias, a partir del $fechaDia\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";
    
        } elseif ($empiezaTarea == "weekly") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-WindowStyle Hidden -Command Add-Type -AssemblyName PresentationFramework; [System.Windows.MessageBox]::Show('$mostrarMensaje')\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Weekly -At \"" . $horaSemana . "\" -WeeksInterval $repiteSemana -DaysOfWeek $diasSemana \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaSemana . "T" . $horaSemana . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaSemana cada $diasSemana cada $repiteSemana semanas, a partir del $fechaSemana\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "monthly") {

        } elseif ($empiezaTarea == "once") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-WindowStyle Hidden -Command Add-Type -AssemblyName PresentationFramework; [System.Windows.MessageBox]::Show('$mostrarMensaje')\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Once -At \"" . $unavezHora . "\" \n";
            $script .= "\$trigger.StartBoundary = \"" . $unavezFecha . "T" . $unavezHora . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $unavezHora el $unavezFecha\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "sessionstartup") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-WindowStyle Hidden -Command Add-Type -AssemblyName PresentationFramework; [System.Windows.MessageBox]::Show('$mostrarMensaje')\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -AtLogon \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. La tarea se iniciara al iniciar sesion de cualquier usuario\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";
                        
        }
    } elseif ($accion == "deletedownload") {
        if ($empiezaTarea == "daily") {
          
            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";
            
            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-Command Remove-Item -Path '\$env:USERPROFILE\Downloads\*' -Force\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Daily -At \"" . $horaDia . "\" -DaysInterval $repiteDia \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaDia . "T" . $horaDia . ":00\" \n \n";
            
            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaDia cada $repiteDia dias, a partir del $fechaDia\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";
            
        } elseif ($empiezaTarea == "weekly") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-Command Remove-Item -Path '\$env:USERPROFILE\Downloads\*' -Force\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Weekly -At \"" . $horaSemana . "\" -WeeksInterval $repiteSemana -DaysOfWeek $diasSemana \n";
            $script .= "\$trigger.StartBoundary = \"" . $fechaSemana . "T" . $horaSemana . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $horaSemana cada $diasSemana cada $repiteSemana semanas, a partir del $fechaSemana\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "monthly") {

        } elseif ($empiezaTarea == "once") {

            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-Command Remove-Item -Path '\$env:USERPROFILE\Downloads\*' -Force\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -Once -At \"" . $unavezHora . "\" \n";
            $script .= "\$trigger.StartBoundary = \"" . $unavezFecha . "T" . $unavezHora . ":00\" \n \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. A las $unavezHora el $unavezFecha\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";

        } elseif ($empiezaTarea == "sessionstartup") {
 
            $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";

            $script .= "\$accionTarea = New-ScheduledTaskAction -Execute \"powershell.exe\" -Argument \"-Command Remove-Item -Path '\$env:USERPROFILE\Downloads\*' -Force\" \n";
            $script .= "\$trigger = New-ScheduledTaskTrigger -AtLogon \n";

            $script .= "if (-not \$existeTarea) { \n";
                $script .= "\$crearTarea = Register-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Description \"" . $descripcionTarea . "\" -Action \$accionTarea -Trigger \$trigger \n";
                $script .= "if (\$crearTarea) { \n";
                    $script .= "Write-Host \"Se creo correctamente la tarea programada con el nombre $nombreTarea. La tarea se iniciara al iniciar sesion de cualquier usuario\" -ForegroundColor Green \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"Hubo un error al crear la tarea programada con el nombre $nombreTarea, vuelva a configurarla en la web\" -ForegroundColor Red \n";
                $script .= "} \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"Ya existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Yellow \n";
            $script .= "} \n \n";
                     
        }
    }
}
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newtask.ps1"');
echo $script;
exit();

?>