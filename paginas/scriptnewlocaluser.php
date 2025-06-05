<?php

$script = "";

$numUsuarios = $_POST["numusers"];

for ($i = 1; $i <= $numUsuarios; $i++) {
    
    $nombre = $_POST["nameuser$i"];
    $contra = $_POST["password$i"];
    $nombrecompleto = $_POST["completename$i"];
    $descripcion = $_POST["description$i"];
    $usargrupos = $_POST["usegroups$i"];
    $grupos = $_POST["groups$i"];
    $expiracuenta = $_POST["expireuser$i"];
    $fechaexpiracuenta = $_POST["user$i"];

    $script .= "\$existeusuario = Get-LocalUser -Name  \"" . $nombre . "\" -ErrorAction SilentlyContinue | Select-Object Name \n";
    $script .= "\$existegrupo = Get-LocalGroup -Name   \"" . $grupos . "\" -ErrorAction SilentlyContinue | Select-Object Name \n \n";
        
    $script .= "if (-not \$existeusuario) { \n";
    $script .= "\$password = ConvertTo-SecureString \"" . $contra . "\" -AsPlainText -Force \n";
    $script .= "New-LocalUser -Name  \"" . $nombre . "\" -Password  \$password -FullName   \"" . $nombrecompleto . "\" -Description  \"" . $descripcion . "\" \n"; 
    $script .= "Add-LocalGroupMember -Group \"Usuarios\" -Member $nombre \n";

            if ($usargrupos == "si" && !empty($grupos)) {
                $script .= "if (\$existegrupo) { \n";
                    $script .= "Add-LocalGroupMember -Group $grupos -Member $nombre \n";
                $script .= "} else { \n";
                    $script .= "Write-Host \"El grupo $grupos no existe\" -ForegroundColor Yellow \n";
                $script .= "} \n";
            }
            
            if ($expiracuenta == "no") {
                $script .= "Set-LocalUser \"" . $nombre . "\" -AccountNeverExpires \n";
            }

            if ($expiracuenta == "si" && !empty($fechaexpiracuenta)) {
                $script .= "Set-LocalUser \"" . $nombre . "\" -AccountExpires \"" . $fechaexpiracuenta . "\" \n";
            }
            $script .= "Write-Host \"El usuario $nombre se creo correctamente\" -ForegroundColor Green \n";

    $script .= "} else { \n";
        $script .= "Write-Host \"El usuario $nombre ya existe\" -ForegroundColor Red \n";
    $script .= "} \n \n";
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newlocaluser.ps1"');
echo $script;
exit();
?>