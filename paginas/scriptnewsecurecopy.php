<?php

$script = "";

$numCopias = $_POST["numcopias"];

for ($i = 1; $i <= $numCopias; $i++) {
    
    $objetoACopiar = $_POST["objetocopia$i"];
    $rutaOrigenArchivo = $_POST["filepath$i"];
    $dondeGuardarCopiaArchivo = $_POST["dondecopia$i"];
    $rutaDestinoLocalArchivo = $_POST["localpath$i"];
    $rutaDestinoRemotoArchivo = $_POST["remotepath$i"];
    $rutaOrigenDirectorio = $_POST["directorypath$i"];
    $dondeGuardarCopiaDirectorio = $_POST["dondecopia2$i"];
    $rutaDestinoLocalDirectorio = $_POST["localpath2$i"];
    $rutaDestinoRemotoDirectorio = $_POST["remotepath2$i"];
    $nombreNuevoCopiaLocalArchivo = $_POST["nombrecopia$i"];
    $nombreNuevoCopiaRemotoArchivo = $_POST["nombrecopia2$i"];
    $nombreNuevoCopiaLocalDirectorio = $_POST["nombrecopia3$i"];
    $nombreNuevoCopiaRemotoDirectorio = $_POST["nombrecopia4$i"];

    if ($objetoACopiar == "archivo") {
        if ($dondeGuardarCopiaArchivo == "equipolocal") {
            
            $script .= "\$existeCopiaLocalArchivo = Get-ChildItem $rutaDestinoLocalArchivo\\$nombreNuevoCopiaLocalArchivo -ErrorAction SilentlyContinue \n \n";
            $script .= "if (-not \$existeCopiaLocalArchivo) { \n";
                $script .= "Copy-Item -Path $rutaOrigenArchivo -Destination $rutaDestinoLocalArchivo\\$nombreNuevoCopiaLocalArchivo \n";
                $script .= "Write-Host \"Se ha creado correctamente la copia de seguridad del archivo en tu equipo\" -ForegroundColor Green \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"La copia de seguridad con este nombre $nombreNuevoCopiaLocalArchivo ya existe en tu equipo\" -ForegroundColor Red \n";
            $script .= "} \n \n";

        } elseif ($dondeGuardarCopiaArchivo == "equiporemoto") {
             
            $script .= "\$existeCopiaLocalArchivo = Get-ChildItem $rutaDestinoRemotoArchivo\\$nombreNuevoCopiaRemotoArchivo -ErrorAction SilentlyContinue \n \n";
            $script .= "if (-not \$existeCopiaLocalArchivo) { \n";
                $script .= "Copy-Item -Path $rutaOrigenArchivo -Destination $rutaDestinoRemotoArchivo\\$nombreNuevoCopiaRemotoArchivo \n";
                $script .= "Write-Host \"Se ha creado correctamente la copia de seguridad del archivo en el equipo remoto\" -ForegroundColor Green \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"La copia de seguridad con este nombre $nombreNuevoCopiaRemotoArchivo ya existe en el equipo remoto\" -ForegroundColor Red \n";
            $script .= "} \n \n";

        }
    } elseif ($objetoACopiar == "carpeta") {
        if ($dondeGuardarCopiaDirectorio == "equipolocal2") {
            
            $script .= "\$existeCopiaLocalArchivo = Get-ChildItem $rutaDestinoLocalDirectorio\\$nombreNuevoCopiaLocalDirectorio -ErrorAction SilentlyContinue \n \n";
            $script .= "if (-not \$existeCopiaLocalArchivo) { \n";
                $script .= "Copy-Item -Path $rutaOrigenDirectorio -Destination $rutaDestinoLocalDirectorio\\$nombreNuevoCopiaLocalDirectorio -Recurse \n";
                $script .= "Write-Host \"Se ha creado correctamente la copia de seguridad de la carpeta en tu equipo\" -ForegroundColor Green \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"La copia de seguridad con este nombre $nombreNuevoCopiaLocalDirectorio ya existe en tu equipo\" -ForegroundColor Red \n";
            $script .= "} \n \n";

        } elseif ($dondeGuardarCopiaDirectorio == "equiporemoto2") {
            
            $script .= "\$existeCopiaLocalArchivo = Get-ChildItem $rutaDestinoRemotoDirectorio\\$nombreNuevoCopiaRemotoDirectorio -ErrorAction SilentlyContinue \n \n";
            $script .= "if (-not \$existeCopiaLocalArchivo) { \n";
                $script .= "Copy-Item -Path $rutaOrigenDirectorio -Destination $rutaDestinoRemotoDirectorio\\$nombreNuevoCopiaRemotoDirectorio -Recurse \n";
                $script .= "Write-Host \"Se ha creado correctamente la copia de seguridad de la carpeta en tu equipo\" -ForegroundColor Green \n";
            $script .= "} else { \n";
                $script .= "Write-Host \"La copia de seguridad con este nombre $nombreNuevoCopiaRemotoDirectorio ya existe en el equipo remoto\" -ForegroundColor Red \n";
            $script .= "} \n \n";

        }
    }
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="newbackup.ps1"');
echo $script;
exit();
?>