<?php

$script = "";

$dominio = $_POST["domainname"];
$netbios = $_POST["netbiosname"];

/*$script .= "
    Dominio: $dominio
    Nombre NetBIOS: $netbios

";*/

$script .= "
    #Verificar si el rol de AD DS ya está instalado
    \$rolADDS = Get-WindowsFeature -Name AD-Domain-Services

    if (\$rolADDS.Installed) {
        Write-Host \"El rol de AD DS ya esta instalado. Saltando instalacion ...\" -ForegroundColor Yellow
    } else {
        Write-Host \"Instalando el rol de AD DS ...\" -ForegroundColor Cyan
        Install-WindowsFeature -Name AD-Domain-Services -IncludeManagementTools
    }

    # Intentar importar el modulo (solo si no esta disponible ya)
    \$obtenerModulo = Get-Module -ListAvailable -Name ADDSDeployment

    if (-not \$obtenerModulo) {
        Write-Host \"El modulo ADDSDeployment no esta disponible\" -ForegroundColor Red
    } else {
        Write-Host \"Instlando el modulo ADDSDeployment ...\" -ForegroundColor Green
        Import-Module ADDSDeployment
    }

    #Verificar si hay un dominio
    \$obtenerDominio = Get-ADDomain -Identity \"$dominio\" | Where-Object {\$_.Forest -eq \"$dominio\"}

    if (\$obtenerDominio) {
        Write-Host \"Ya existe un dominio en este servidor. No se realizara la promocion nuevamente\" -ForegroundColor Yellow
    } else {
        Write-Host \"Instalando nuevo contolador de dominio ...\" -ForegroundColor Green
        Install-ADDSForest -DomainName \"" . $dominio . "\" -DomainNetbiosName \"" . $netbios . "\" -ForestMode \"WinThreshold\" -DomainMode \"WinThreshold\" -InstallDNS -CreateDnsDelegation:\$false -DatabasePath \"C:\Windows\NTDS\" -LogPath \"C:\Windows\NTDS\" -SysvolPath \"C:\Windows\SYSVOL\" -Force
    }
    ";

header('Content-Disposition: attachment; filename="newdomainlocal.ps1"');
echo $script;
exit();

?>