<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - Delete local user</title>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/usuarioslocales.php">Atrás</a>
            <a href="../paginas/formdeletlocaluser.php">Restablecer</a>
        </div>
        <h1>Eliminar usuario local</h1>

        <form action="" method="POST">
            <label for="numusers">¿Cuántos usuarios locales desea eliminar? (1 al 4)</label>
            <input type="number" id="numusers" name="numusers" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numusers"])) {
                $numUsuarios = $_POST["numusers"];
                if ($numUsuarios < 1 || $numUsuarios > 4) {
                    echo "<p>El número de usuarios incorrecto.</p>";
                } else {
                    echo "<form action='scriptdeletlocaluser.php' method='POST'>";
                    echo "<input type='hidden' name='numusers' value='$numUsuarios'>";
                        for ($i = 1; $i <= $numUsuarios; $i++) {
                            echo "</br>";
                            echo "<h3>Usuario $i</h3>";
                            echo "<label>Nombre de usuario:</label>";
                            echo "<input type='text' name='nameuser$i' placeholder='Pedro' required>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>