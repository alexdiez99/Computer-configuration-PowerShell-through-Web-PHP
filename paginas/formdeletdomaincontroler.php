<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete domain local</title>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/dominio.php">Atrás</a>
            <a href="../paginas/formnewdomaincontroler.php">Restablecer</a>
        </div>
        <h1>Eliminar dominio local</h1>

        <form action="scriptdeletdomaincontroler.php" method="POST">
            <label>Nombre del dominio (FQDN):</label>
            <input type="text" id="domainname" name="domainname" placeholder="iespabloserrano.local" required>
            <button type='submit' class='botondescargascript'>Descargar script</button>
        </form>          
    </div>
</body>
</html>