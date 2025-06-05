<?php

$script = "";

$numUsuarios = $_POST["numusers"];

for ($i = 1; $i <= $numUsuarios; $i++) {
    
    $nombre = $_POST["nameuser$i"];

    $script .= "\$existeusuario = Get-LocalUser -Name  \"" . $nombre . "\" -ErrorAction SilentlyContinue | Select-Object Name \n \n";

    $script .= "if (\$existeusuario) { \n";
        $script .= "Remove-LocalUser -Name $nombre \n";
        $script .= "Write-Host \"El usuario $nombre se elimino correctamente\" -ForegroundColor Green \n";
    $script .= "} else { \n";
        $script .= "Write-Host \"El usuario $nombre no existe\" -ForegroundColor Red \n";
    $script .= "} \n \n";
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletelocaluser.ps1"');
echo $script;
exit();
?>