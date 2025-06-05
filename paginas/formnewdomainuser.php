<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/styles.css">
    <link rel="stylesheet" href="../estilos/forms.css">
    <title>Computer configuration - New domain user</title>
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
            <a href="../paginas/usuariosdc.php">Atrás</a>
            <a href="../paginas/formnewdomainuser.php">Restablecer</a>
        </div>
        <h1>Nuevo usuario en el dominio</h1>

        <form action="" method="POST">
            <label for="numusers">¿Cuántos usuarios desea crea en su dominio? (1 al 4)</label>
            <input type="number" id="numusers" name="numusers" min="1" max="4" value="1" required>
            <button type="submit" class="botongenerarform">Generar formulario</button>
        </form>    
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numusers"])) {
                $numUsers = $_POST["numusers"];
                if ($numUsers < 1 || $numUsers > 4) {
                    echo "<p>El número de usuarios incorrecto.</p>";
                } else {
                    echo "<form action='scriptnewdomainuser.php' method='POST'>";
                    echo "<input type='hidden' name='numusers' value='$numUsers'>";
                        for ($i = 1; $i <= $numUsers; $i++) {
                            echo "</br>";
                            echo "<h3>Usuario $i</h3>";
                            echo "<label>Nombre del dominio (FQDN):</label>";
                            echo "<input type='text' name='namedomain$i' placeholder='iespabloserrano.local' required>";
                            echo "<label>Nombre completo del usuario:</label>";
                            echo "<input type='text' name='namecompleteuser$i' placeholder='Mortadelo Perez' required>";
                            echo "<label>Nombre de pila:</label>";
                            echo "<input type='text' name='namepilauser$i' placeholder='Mortadelo' required>";
                            echo "<label>Nombre de inicio de sesión:</label>";
                            echo "<input type='text' name='namesessionuser$i' placeholder='mortadelo.perez' required>";
                            echo "<label>Contraseña del usuario:</label>";
                            echo "<input type='password' name='passuser$i' minlength='12' required>";
                            echo "<label>¿En qué unidad organizativa desea crear el usuario?</label>";
                            echo "<input type='text' name='pathuouser$i' placeholder='Usuarios ó Sede Zaragoza\Usuarios' required>";
                            echo "<label>Correo electrónico del usuario</label>";
                            echo "<input type='text' name='emailuser$i' placeholder='mortadelo.perez@iespabloserrano.local' required>";
                            echo "<label>Departamento al que pertenece el usuario:</label>";
                            echo "<input type='text' name='dptoeuser$i' placeholder='Informática' required>";
                            echo "<label>Cargo del usuario:</label>";
                            echo "<input type='text' name='cargouser$i' placeholder='Administrador de sistemas' required>";
                            echo "<label>Teléfeno de oficina</label>";
                            echo "<input type='text' name='tlfoffice$i' placeholder='971561247' required>";
                            
                            echo "<label>¿Desea asignar grupos al usuario?</label>
                                <select name='usegroups$i' id='usegroups$i' onchange='setGrupo($i)' required>
                                    <option value='no'>No</option>
                                    <option value='si'>Si</option>
                                </select>";

                            echo "<div id='groupscontainer$i' name='groupscontainer$i' style='display:none;'>";
                                echo "<label>Nombre del grupo:</label>";
                                echo "<input type='text' name='groups$i' id='groups$i' placeholder='Users'>";
                            echo "</div>";

                            echo "<label>¿Desea que la cuenta del usuario expire?</label>
                                <select name='expireuser$i' id='expireuser$i' onchange='setExpireUser($i)' required>
                                    <option value='no'>No</option>
                                    <option value='si'>Si</option>
                                </select>";

                            echo "<div id='userexpireaccountcontainer$i' name='userexpireaccountcontainer$i' style='display:none;'>";
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
                                        const writeDate = document.getElementById('userexpireaccountcontainer' + i);
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