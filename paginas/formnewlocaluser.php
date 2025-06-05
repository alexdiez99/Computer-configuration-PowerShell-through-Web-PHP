<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New local user</title>
    <style>
        form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="contenedor-form">
        <div class="contenedor-form-botones-guia">
            <a href="../paginas/usuarioslocales.php">Atrás</a>
            <a href="../paginas/formnewlocaluser.php">Restablecer</a>
        </div>
        <h1>Nuevo usuario local</h1>

        <form action="" method="POST">
            <label for="numusers">¿Cuántos usuarios locales desea crear? (1 al 4)</label>
            <input type="number" id="numusers" name="numusers" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numusers"])) {
                $numUsuarios = $_POST["numusers"];
                if ($numUsuarios < 1 || $numUsuarios > 4) {
                    echo "<p>El número de usuarios incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewlocaluser.php' method='POST'>";
                    echo "<input type='hidden' name='numusers' value='$numUsuarios'>";
                        for ($i = 1; $i <= $numUsuarios; $i++) {
                            echo "</br>";
                            echo "<h3>Usuario $i</h3>";
                            echo "<label>Nombre de usuario:</label>";
                            echo "<input type='text' name='nameuser$i' placeholder='Valentina' required>";
                            
                            echo "<label>Contraseña:</label>";
                            echo "<input type='password' name='password$i' placeholder='Kl1gh2du' minlength='8' required>";

                            echo "<label>Nombre completo:</label>";
                            echo "<input type='text' name='completename$i' placeholder='Pablo Gargallo Buñuel' required>";
                            
                            echo "<label>Descripción:</label>";
                            echo "<input type='text' name='description$i' placeholder='Este usuario es para invitados' required>";
                            
                            echo "<label>¿Desea asignar grupos al usuario?</label>";
                            echo "<select name='usegroups$i' id='usegroups$i' onchange='setGrupo($i)' required>";
                                echo "<option value='no'>No</option>";
                                echo "<option value='si'>Si</option>";
                            echo "</select>";
                            
                            echo "<div id='groupscontainer$i' name='groupscontainer$i' style='display:none;'>";
                                echo "<label>Grupos (separados por coma):</label>";
                                echo "<input type='text' name='groups$i' id='groups$i' placeholder='Users, Administrator'>";
                            echo "</div>";

                            echo "<label>¿Desea que la cuenta expire?</label>";
                            echo "<select name='expireuser$i' id='expireuser$i' onchange='setExpireUser($i)' required>";
                                echo "<option value='no'>No</option>";
                                echo "<option value='si'>Si</option>";
                            echo "</select>";
                            
                            echo "<div id='usercontainer$i' name='usercontainer$i' style='display:none;'>";
                                echo "<label>Fecha de expiración de la cuenta:</label>";
                                echo "<input type='date' name='user$i' id='user$i' placeholder='31/08/2026'>";
                            echo "</div>";
                            
                            echo "<script>
                                    function setGrupo(i) {
                                        const selectsino = document.getElementById('usegroups' + i);
                                        const writeGrupo = document.getElementById('groupscontainer' + i);
                                        if (selectsino.value === 'si') {
                                            writeGrupo.style.display = 'block';
                                        } else {
                                            writeGrupo.style.display = 'none';
                                            document.getElementById('groups').value = '';
                                        }
                                    }
                                </script>";

                            echo "<script>
                                    function setExpireUser(i) {
                                        const selectsino = document.getElementById('expireuser' + i);
                                        const writeDate = document.getElementById('usercontainer' + i);
                                        if (selectsino.value === 'si') {
                                            writeDate.style.display = 'block';
                                        } else {
                                            writeDate.style.display = 'none';
                                            document.getElementById('user').value = '';
                                        }
                                    }
                                </script>";
                        }
                    echo "<button type='submit' class='botondescargascript'>Descargar script</button>";
                    echo "</form>";
                }
            }
        ?>
    </div>
</body>
</html>