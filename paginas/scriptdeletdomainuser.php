<?php

$script = "";

$numUsuarios = $_POST["numusers"];

for ($i = 1; $i <= $numUsuarios; $i++) {

    $dominio = $_POST["namedomain$i"];
    $nombreInicioSesion = $_POST["namesessionuser$i"];

    /*$script .= "
    
    Dominio: $dominio
    Nombre de inicio de sesión: $nombreInicioSesion

    ";*/

    $script .= "
    
    \$dominio = \"$dominio\"
    \$nombreInicioSesion = \"$nombreInicioSesion\"
    
    
    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"


    \$existeUsuario = Get-ADUser -Filter \"UserPrincipalName -eq '\$nombreInicioSesion@\$dominio'\" -SearchBase \$dcRuta -ErrorAction SilentlyContinue

    if (\$existeUsuario) {
        Remove-ADUser -Identity \$existeUsuario.DistinguishedName -Confirm:\$false
        Write-Host \"El usuario \$nombreInicioSesion@\$dominio se elimino correctamente\" -ForegroundColor Green
    } else {
        Write-Host \"El usuario \$nombreInicioSesion@\$dominio no existe\" -ForegroundColor Red
    }
    
    ";

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletedomainuser.ps1"');
echo $script;
exit();

?>