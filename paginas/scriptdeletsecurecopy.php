<?php

$script = "";

$numCopias = $_POST["numcopias"];

for ($i = 1; $i <= $numCopias; $i++) {
    
    $dondeCopia = $_POST["dondecopia$i"];
    $rutaEliminarLocalCopia = $_POST["localpath$i"];
    $rutaEliminarRemotoCopia = $_POST["remotepath$i"];

    if ($dondeCopia == "equipolocal") {
        
        $script .= "\$existeCopia = Get-ChildItem $rutaEliminarLocalCopia -ErrorAction SilentlyContinue \n \n";
        $script .= "if (\$existeCopia) { \n";
            $script .= "Remove-Item -Path $rutaEliminarLocalCopia -Recurse -Force \n";
            $script .= "Write-Host \"Se elimino correctamente la copia de seguridad de tu equipo\" -ForegroundColor Green \n";
        $script .= "} else { \n";
            $script .= "Write-Host \"La copia de seguridad no existe en tu equipo\" -ForegroundColor Red \n";
        $script .= "} \n \n";

    } elseif ($dondeCopia == "equiporemoto") {

        $script .= "\$existeCopia = Get-ChildItem $rutaEliminarRemotoCopia -ErrorAction SilentlyContinue \n \n";
        $script .= "if (\$existeCopia) { \n";
            $script .= "Remove-Item -Path $rutaEliminarRemotoCopia -Recurse -Force \n";
            $script .= "Write-Host \"Se elimino correctamente la copia de seguridad del equipo remoto\" -ForegroundColor Green \n";
        $script .= "} else { \n";
            $script .= "Write-Host \"La copia de seguridad no existe en el equipo remoto\" -ForegroundColor Red \n";
        $script .= "} \n \n";

    } 

}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="deletebackup.ps1"');
echo $script;
exit();
?>