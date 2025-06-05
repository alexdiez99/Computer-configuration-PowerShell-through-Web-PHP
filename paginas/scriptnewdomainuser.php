<?php

$script = "";

$numUsers = $_POST["numusers"];

for ($i = 1; $i <= $numUsers; $i++) {

    $dominio = $_POST["namedomain$i"];
    $nombreCompleto = $_POST["namecompleteuser$i"];
    $pilaNombre = $_POST["namepilauser$i"];
    $inicioSesionNombre = $_POST["namesessionuser$i"];
    $contraseña = $_POST["passuser$i"];
    $pathUOUser = $_POST["pathuouser$i"];
    $correoElectronico = $_POST["emailuser$i"];
    $departamento = $_POST["dptoeuser$i"];
    $cargo = $_POST["cargouser$i"];
    $tlfOficina = $_POST["tlfoffice$i"];
    $usoGrupos = $_POST["usegroups$i"];
    $nombreGrupo = $_POST["groups$i"];
    $usoExpiracionCuenta = $_POST["expireuser$i"];
    $fechaExpiracionCuenta = $_POST["user$i"];

    /*$script .= "
    
    Dominio: $dominio
    Nombre completo: $nombreCompleto
    Nombre de pila: $pilaNombre
    Nombre de inicio de sesión: $inicioSesionNombre
    Contraseña: $contraseña
    Se guarda en la UO: $pathUOUser
    Correo electrónico: $correoElectronico
    Departamento: $departamento
    Cargo: $cargo
    Teléfono oficina: $tlfOficina
    Usa grupos: $usoGrupos
    Nombre grupo: $nombreGrupo
    Usa expiración de cuenta: $usoExpiracionCuenta
    Fecha de expiración de cuenta: $fechaExpiracionCuenta

    ";*/

    $script .= "
    
    \$dominio = \"$dominio\"
    \$usuarioUO = \"$pathUOUser\"  
    
    \$dcPartes = \$dominio -split \"\.\" | ForEach-Object {\"DC=\$_\"}
    \$dcRuta = \$dcPartes -join \",\"

    if (\$usuarioUO -like \"*/*\") {
        \$usuarioUOPartes = \$usuarioUO -split \"/\"
        [array]::Reverse(\$usuarioUOPartes)
        \$usuarioUORuta = (\$usuarioUOPartes | ForEach-Object {\"OU=\$_\"}) -join \",\"
    } else {
        \$usuarioUORuta = \"ou=\$usuarioUO\"
    }

    \$dn = \"\$usuarioUORuta,\$dcRuta\"

    if (Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dn'\" -ErrorAction SilentlyContinue) {
        
        \$exiteUsuario = Get-ADUser -Filter \"UserPrincipalName -eq '$inicioSesionNombre@\$dominio'\" -SearchBase \$dn -ErrorAction SilentlyContinue

        if (-not \$exiteUsuario) {
            New-ADUser -Name \"$nombreCompleto\" -GivenName \"$pilaNombre\" -SamAccountName \"$inicioSesionNombre\" -UserPrincipalName \"$inicioSesionNombre@\$dominio\" -AccountPassword (ConvertTo-SecureString \"$contraseña\" -AsPlainText -Force) -Path \$dn -EmailAddress \"$correoElectronico\" -Department \"$departamento\" -Title \"$cargo\" -OfficePhone \"$tlfOficina\" -Enabled \$true
            Write-Host \"Se ha creado correctamente el usuario $inicioSesionNombre en \$dn\" -ForegroundColor Green
        } else {
            Write-Host \"El usuario con el nombre de inicio sesion $inicioSesionNombre ya existe en \$dn\" -ForegroundColor Yellow 
        }
    } else {
            Write-Host \"No existe la unidad organizativa \$dn\" -ForegroundColor Red 
    }
    
    ";

    if ($usoGrupos == "si") {

    $script .= "
    
    \$grupo = \"$nombreGrupo\"
    
    if (Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dn'\" -ErrorAction SilentlyContinue) {
        
        \$exiteUsuario = Get-ADUser -Filter \"UserPrincipalName -eq '$inicioSesionNombre@\$dominio'\" -SearchBase \$dn -ErrorAction SilentlyContinue
        \$existeGrupo = Get-ADGroup -Filter \"Name -eq '\$grupo'\"

        if (\$existeGrupo) {
            Add-ADGroupMember -Identity \"\$grupo\" -Members \"$inicioSesionNombre\"
            Write-Host \"Se añadio correctamente el usuario $inicioSesionNombre al grupo \$grupo\" -ForegroundColor Green
        } else {
            Write-Host \"No existe el grupo \$grupo\" -ForegroundColor Red
        }
    } else {
            Write-Host \"No existe la unidad organizativa \$dn\" -ForegroundColor Red 
    }
    ";

    }

    if ($usoExpiracionCuenta == "si") {

        $script .= "
        
        \$fechaExpiracionCuenta = \"$fechaExpiracionCuenta\"
        
        if (Get-ADOrganizationalUnit -Filter \"DistinguishedName -eq '\$dn'\" -ErrorAction SilentlyContinue) {
        
        \$exiteUsuario = Get-ADUser -Filter \"UserPrincipalName -eq '$inicioSesionNombre@\$dominio'\" -SearchBase \$dn -ErrorAction SilentlyContinue
            if (Set-ADUser -Identity \"$inicioSesionNombre\" -AccountExpirationDate \"\$fechaExpiracionCuenta\") {
                Write-Host \"Hubo un error al establecer la fecha de expiracion de la cuenta de $inicioSesionNombre\" -ForegroundColor Red
            } else {
                Write-Host \"Se asigno correctamente la fecha de expiracion de la cuenta \$fechaExpiracionCuenta de $inicioSesionNombre\" -ForegroundColor Green
            }
        } else {
            Write-Host \"No existe la unidad organizativa \$dn\" -ForegroundColor Red 
        }
        ";

    }
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newdomainuser.ps1"');
echo $script;
exit();
?>