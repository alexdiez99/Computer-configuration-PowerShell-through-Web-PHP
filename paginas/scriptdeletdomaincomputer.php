<?php

$script = "";

$numEquipos = $_POST["numcomputers"];

for ($i = 1; $i <= $numEquipos; $i++) {

    $dominio = $_POST["namedomain$i"];
    $nombreEquipo = $_POST["namecomputer$i"];

    /*$script .= "
    
    Dominio: $dominio
    Nombre equipo: $nombreEquipo

    ";*/

    $script .= "
    
    \$dominio = \"$dominio\"
    \$nombreEquipo = \"$nombreEquipo\"

    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"

    \$dn = \"\$dcRuta\"
    
    \$existeEquipo = Get-ADComputer -Filter \"Name -eq '\$nombreEquipo'\" -SearchBase \$dn 
    
    if (\$existeEquipo) {
        Remove-ADComputer -Identity \"\$nombreEquipo\" -Confirm:\$false
        Write-Host \"Se elimino correctamente el equipo \$nombreEquipo\" -ForegroundColor Green
    } else {
        Write-Host \"No existe el equipo \$nombreEquipo en el dominio \$dominio\" -ForegroundColor Red 
    }
    ";

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletedomaincomputer.ps1"');
echo $script;
exit();
?>