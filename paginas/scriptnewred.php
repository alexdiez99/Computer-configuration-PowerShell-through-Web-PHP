<?php

$script = "";

$numInterface = $_POST["numinterfaces"];

for ($i = 1; $i <= $numInterface; $i++) {
    
    $network = $_POST["namenet$i"];
    $ip = $_POST["ip$i"];
    $mask = $_POST["mascara$i"];
    $gateway = $_POST["puerta$i"];
    $dnsfirst = $_POST["dnspri$i"];

    $script .= "\$existe = Get-NetAdapter -Name \"" . $network . "\" -ErrorAction SilentlyContinue \n \n";
    $script .= "if (\$existe) { \n \n";
    $script .= "New-NetIPAddress -InterfaceAlias \"" . $network . "\" -IPAddress $ip -PrefixLength $mask -DefaultGateway $gateway \n";
    $script .= "Set-DnsClientServerAddress -InterfaceAlias \"" . $network . "\" -ServerAddresses (\"" . $dnsfirst . "\") \n \n";
    $script .= "\$newip = Get-NetIPAddress -InterfaceAlias \"" . $network . "\" | Where-Object {\$_.IPAddress -eq \"" . $ip . "\"} \n";
    $script .= "\$newmask = Get-NetIPAddress -InterfaceAlias \"" . $network . "\" | Where-Object {\$_.PrefixLength -eq \"" . $mask . "\"} \n";
    $script .= "\$newdns = Get-DnsClientServerAddress -InterfaceAlias \"" . $network . "\" | Where-Object {\$_.ServerAddresses -eq \"" . $dnsfirst . "\"} \n";
    $script .= "\$newgateway = Get-NetIPConfiguration -InterfaceAlias \"" . $network . "\" | Where-Object {\$_.IPv4DefaultGateway.NextHop -eq \"" . $gateway . "\"} \n \n";
    $script .= "if (\$newip -and \$newmask -and \$newdns -and \$newgateway) { \n";
    $script .= "Write-Host \"Configuracion de red asignada correctamente para $network\" -Foregroundcolor Green \n";
    $script .= "} else { \n";
    $script .= "Write-Host \"Hubo un problema al asignar la configuracion de red\" -Foregroundcolor Yellow \n";
    $script .= "} \n";
    $script .= "} else { \n";
    $script .= "Write-Host \"Error: la interfaz de red $network no existe. Verifique el nombre e intenta de nuevo\" -Foregroundcolor Red \n";
    $script .= "} \n \n";
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newconfigurationnetwork.ps1"');
echo $script;
exit();
?>