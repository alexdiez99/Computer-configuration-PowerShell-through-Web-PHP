<?php

$script = "";

$numReglasf = $_POST["numfirewall"];

for ($i = 1; $i <= $numReglasf; $i++) {
    
    $direccionRegla = $_POST["direccionregla$i"];
    $tipoRegla = $_POST["tiporegla$i"];
    $programaEspecifico = $_POST["programaespe$i"];
    $puertoEspecifico = $_POST["puertoespe$i"];
    $tcpUdp = $_POST["protocoloregla$i"];
    $tipoAccion = $_POST["accionregla$i"];
    $aplicaRegla = $_POST["perfilregla$i"];
    $nombreRegla = $_POST["nameregla$i"];
    $descripcionRegla = $_POST["descripcionregla$i"];

    $script .= "\$existe = Get-NetFirewallRule -DisplayName \"" . $nombreRegla . "\" -ErrorAction SilentlyContinue | Select-Object DisplayName \n \n";

    if ($tipoRegla == "program") {
        $script .= "if (-not \$existe) {
            \$nuevaregla = New-NetFirewallRule -DisplayName \"$nombreRegla\" -Program \"$programaEspecifico\" -Direction $direccionRegla -Action $tipoAccion -Profile $aplicaRegla
            if (\$nuevaregla) {
                Write-Host \"Se creo correctamente la nueva regla con el nombre $nombreRegla\" -ForegroundColor Green
            } else {
                Write-Host \"Hubo un error al crear la regla de firewall $nombreRegla, vuelva a la página web a intentarlo\" -ForegroundColor Red
            }
        } else {
            Write-Host \"Ya existe una regla de firewall con el nombre $nombreRegla, eliminala primero\" -ForegroundColor Yellow \n
        } \n \n";
    } elseif ($tipoRegla == "port") {
        $script .= "if (-not \$existe) {
            \$nuevaregla = New-NetFirewallRule -DisplayName \"$nombreRegla\" -Protocol $tcpUdp -LocalPort $puertoEspecifico -Direction $direccionRegla -Action $tipoAccion -Profile $aplicaRegla         
            if (\$nuevaregla) {
                Write-Host \"Se creo correctamente la nueva regla con el nombre $nombreRegla\" -ForegroundColor Green
            } else {
                Write-Host \"Hubo un error al crear la regla de firewall $nombreRegla, vuelva a la página web a intentarlo\" -ForegroundColor Red
            } 
        } else {
            Write-Host \"Ya existe una regla de firewall con el nombre $nombreRegla, eliminala primero\" -ForegroundColor Yellow \n
        }";
    }

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newfirewall.ps1"');
echo $script;
exit();
?>