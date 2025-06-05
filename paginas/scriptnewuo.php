<?php
/*var_dump($_POST);*/
$script = "";

$numUo = $_POST["numuo"];

for ($i = 1; $i <= $numUo; $i++) {

$dominio = $_POST["domainname$i"];
$nombreNuevoUO = $_POST["uoname$i"];
$seleccionarSubUO = $_POST["subuo1$i"];

$nombreSubUO = [];

    $script .= "
    \$dominio = \"$dominio\"
    \$uoPadre = \"$nombreNuevoUO\"

    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"

    \$dnUOPadre = \"OU=\$uoPadre,\$dcRuta\"

    if (-not (Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dnUOPadre'\" -ErrorAction SilentlyContinue)) {
        New-ADOrganizationalUnit -Name \$uoPadre -Path \$dcRuta
        Write-Host \"OU \$uoPadre creada correctamente en \$dominio\" -ForegroundColor Green
    } else {
        Write-Host \"OU \$uoPadre ya existe en \$dominio\" -ForegroundColor Red 
    }
    ";

if ($seleccionarSubUO == "si") {
    $numeroSubUO = $_POST["subuo1number$i"];
    for ($j = 1; $j <= $numeroSubUO; $j++) {
        $nombreSubUO = $_POST["subuo1name{$i}_{$j}"];

        $script .= "
        \$uoHijo = \"$nombreSubUO\"

        \$dnUOHijo = \"OU=\$uoHijo,\$dnUOPadre\"

        if (-not (Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dnUOHijo'\" -ErrorAction SilentlyContinue)) {
            New-ADOrganizationalUnit -Name \$uoHijo -Path \$dnUOPadre
            Write-Host \"OU \$uoHijo creada correctamente dentro de \$uoPadre\" -ForegroundColor Green
        } else {
            Write-Host \"OU \$uoHijo ya existe dentro de \$uoPadre\" -ForegroundColor Red 
        }
        ";
        }
    }
    
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newuo.ps1"');
echo $script;
exit();
?>