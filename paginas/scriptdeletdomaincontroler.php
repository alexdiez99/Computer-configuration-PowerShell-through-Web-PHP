<?php

$script = "";

$dominio = $_POST["domainname"];

/*$script .= "

Dominio: $dominio

";*/

$script .= "

\$dominio = \"$dominio\"

\$existeDominio = Get-ADDomainController -Filter \"Domain -eq '\$dominio'\"

if (\$existeDominio) {
    Uninstall-ADDSDomainController -DemoteOperationMasterRole:\$true -ForceRemoval:\$true -Force:\$true
    Write-Host \"Se elimino correctamente el dominio \$dominio en este controlador de dominio\" -ForegroundColor Green
} else {
    Write-Host \"No existe el dominio \$dominio en este controlador de dominio\" -ForegroundColor Red
}

";

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletedomainlocal.ps1"');
echo $script;
exit();
?>