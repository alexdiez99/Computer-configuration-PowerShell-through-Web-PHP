<?php

$script = "";

$numUO = $_POST["numuo"];

for ($i = 1; $i <= $numUO; $i++) {

    $dominio = $_POST["namedomain$i"];
    $nombreUO = $_POST["maneou$i"];

    /*$script .= "
    
    Dominio: $dominio
    Nombre UO: $nombreUO

    ";*/

    $script .= "
    
    \$dominio = \"$dominio\"
    \$nombreUO = \"$nombreUO\"
        
    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"

    if (\$nombreUO -like \"*/*\") {
        \$nombreUOPartes = \$nombreUO -split \"/\"
        [array]::Reverse(\$nombreUOPartes)
        \$nombreUORuta = (\$nombreUOPartes | ForEach-Object {\"OU=\$_\"}) -join \",\"
    } else {
        \$nombreUORuta = \"OU=\$nombreUO\"
    }

    \$dn = \"\$nombreUORuta,\$dcRuta\"
    
    \$existeOU = \$null
    \$existeOU = Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dn'\"

    if (\$existeOU) {
        Set-ADOrganizationalUnit -Identity \$dn -ProtectedFromAccidentalDeletion \$false
        Remove-ADOrganizationalUnit -Identity \$dn -Confirm:\$false -Recursive
        Write-Host \"Se elimino correctamente la unidad organizativa \$dn\" -ForegroundColor Green
    } else {
        Write-Host \"No existe la unidad organizativa \$dn\" -ForegroundColor Red
    } 
    
    ";

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deleteuo.ps1"');
echo $script;
exit();
?>