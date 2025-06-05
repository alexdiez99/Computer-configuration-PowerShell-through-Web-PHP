<?php

$script = "";

$numReglasf = $_POST["numfirewall"];

for ($i = 1; $i <= $numReglasf; $i++) {
    
    $nombreRegla = $_POST["nameregla$i"];

    $script = 
        "\$existe = Get-NetFirewallRule -DisplayName \"" . $nombreRegla . "\" -ErrorAction SilentlyContinue | Select-Object DisplayName 
        
        if (\$existe) { 
            Remove-NetFirewallRule -DisplayName \"" . $nombreRegla . "\" 
            Write-Host \"La regla de firewall $nombreRegla se elimino correctamente\" -Foregroundcolor Green 
        } else { 
            Write-Host \"La regla de firewall $nombreRegla no existe, vuelva a intentarlo\" -Foregroundcolor Red 
        }";
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletefirewall.ps1"');
echo $script;
exit();
?>