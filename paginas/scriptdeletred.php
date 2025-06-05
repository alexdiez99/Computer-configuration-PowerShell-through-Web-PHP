<?php

$script = "";

$numInterface = $_POST["numinterfaces"];

for ($i = 1; $i <= $numInterface; $i++) {
    
    $network = $_POST["namenet$i"];

    $script .= "\$existe = Get-NetAdapter -Name \"" . $network . "\" -ErrorAction SilentlyContinue \n \n";
    $script .= "if (\$existe) { \n"; 
    $script .= "Remove-NetIPAddress -InterfaceAlias \"" . $network . "\" -Confirm:\$false -ErrorAction SilentlyContinue \n";
    $script .= "Remove-NetRoute -InterfaceAlias \"" . $network . "\" -Confirm:\$false -ErrorAction SilentlyContinue \n";
    $script .= "Set-DnsClientServerAddress -InterfaceAlias \"" . $network . "\" -ResetServerAddresses \n";
    $script .= "Disable-NetAdapter -InterfaceAlias \"" . $network . "\" -Confirm:\$false \n";
    $script .= "Enable-NetAdapter -InterfaceAlias \"" . $network . "\" -Confirm:\$false \n \n";
    $script .= "Write-Host \"Se elimino correctamente toda la configuracion del adaptador de red $network\" -Foregroundcolor Green \n";
    $script .= "} else { \n";
    $script .= "Write-Host \"El adaptador de red $network no existe, vuelva a intentarlo\" -Foregroundcolor Red \n";
    $script .= "}";
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deleteconfigurationnetwork.ps1"');
echo $script;
exit();
?>