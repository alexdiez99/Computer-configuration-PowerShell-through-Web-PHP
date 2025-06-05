<?php

$script = "";

$numTareas = $_POST["numtask"];

for ($i = 1; $i <= $numTareas; $i++) {

    $nombreTarea = $_POST["nametask$i"];

    $script .= "\$existeTarea = Get-ScheduledTask -TaskName \"" . $nombreTarea . "\" -ErrorAction SilentlyContinue | Select-Object TaskName \n \n";
    $script .= "if (\$existeTarea) { \n";
        $script .= "Unregister-ScheduledTask -TaskName \"" . $nombreTarea . "\" -Confirm:\$false \n";
        $script .= "Write-Host \"Se elimino correctamente la tarea programada con el nombre $nombreTarea\" -ForegroundColor Green \n";
    $script .= "} else { \n";
        $script .= "Write-Host \"No existe una tarea programada con el nombre $nombreTarea\" -ForegroundColor Red \n";
    $script .= "} \n \n";
    
}
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletetask.ps1"');
echo $script;
exit();
?>