<?php

$script = "";

$numEquipos = $_POST["numcomputers"];

for ($i = 1; $i <= $numEquipos; $i++) {

    $dominio = $_POST["namedomain$i"];
    $unidadOrganizativa = $_POST["ou$i"];
    $nombreEquipo = $_POST["namecomputer$i"];
    $descripcionEquipo = $_POST["descriptioncomputer$i"];

    /*$script .= "
    
    Dominio: $dominio
    Unidad organizativa: $unidadOrganizativa
    Nombre equipo: $nombreEquipo
    Descripción equipo: $descripcionEquipo

    ";*/

    $script .= "
    
    \$dominio = \"$dominio\"
    \$equipoUO = \"$unidadOrganizativa\"
    \$nombreEquipo = \"$nombreEquipo\"
    \$descripcionEquipo = \"$descripcionEquipo\"
        
    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"

    if (\$equipoUO -like \"*/*\") {
        \$equipoUOPartes = \$equipoUO -split \"/\"
        [array]::Reverse(\$equipoUOPartes)
        \$equipoUORuta = (\$equipoUOPartes | ForEach-Object {\"OU=\$_\"}) -join \",\"
    } else {
        \$equipoUORuta = \"OU=\$equipoUO\"
    }

    \$dn = \"\$equipoUORuta,\$dcRuta\"
    
    \$existeOU = \$null
    \$existeOU = Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dn'\"

    if (\$existeOU) {
        \$existeEquipo =  Get-ADComputer -Filter \"Name -eq '\$nombreEquipo'\" -SearchBase \$dn
        if (-not \$existeEquipo) {
            New-ADComputer -Name \"\$nombreEquipo\" -SamAccountName \"\$nombreEquipo\" -Description \"\$descripcionEquipo\" -Path \$dn -Enabled \$true
            Write-Host \"El equipo \$nombreEquipo se creo correctamente en la unidad organizativa \$dn\" -ForegroundColor Green
        } else {
            Write-Host \"Ya existe un equipo con el nombre \$nombreEquipo en la unidad organizativa \$dn\" -ForegroundColor Yellow
        }
    
    } else {
        Write-Host \"No existe la unidad organizativa \$dn\" -ForegroundColor Red
    }
    ";

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newdomaincomputer.ps1"');
echo $script;
exit();
?>