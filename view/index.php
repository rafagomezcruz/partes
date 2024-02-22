<?php
require_once '../Controller/ProfesoresController.php';
$error="";

if (isset($_POST['acceder'])){
    $usuario = ProfesoresController::comprobarUsuario($_POST['usuario']);
        if ($usuario) {
        if ($usuario->bloqueado) {
            $error = "<font color='red'>USUARIO BLOQUEADO</font>";
        } else {
            if (md5($_POST['clave']) == $usuario->pass) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                ProfesoresController::actualizarIntentos($usuario->dni_p, 3);
                header("Location: partes.php");
                exit();
            } else {
                $usuario->intentos--;
                ProfesoresController::actualizarIntentos($usuario->dni_p, $usuario->intentos);

                if ($usuario->intentos > 0) {
                    $error = "<font color='red'> LE QUEDAN " . $usuario->intentos . " INTENTOS</font>";
                } else {
                    $time = time();
                    ProfesoresController::bloqueoUsuario($usuario->dni_p,$time,1);
                    $error = "<font color='red'> USUARIO BLOQUEADO</font>";
                    
                    $horaDesbloqueo=$usuario->hora_bloqueo + 60000;
                    if ($time == $horaDesbloqueo){
                        ProfesoresController::bloqueoUsuario($usuario->dni_p,0,0);
                        ProfesoresController::actualizarIntentos($usuario->dni_p, 3);
                    }
                    
                }
            }
        }
    } else {
        $error = "<font color='red'> Usuario o contraseña incorrectos</font>";
    }
}
echo $error;
?>

<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <h2>LOGIN</h2>
        <form action="" method="POST">
            Usuario: <input type="text" name="usuario"><br><br>
            Clave: <input type="password" name="clave"><br><br>
            <input type="submit" name="acceder" value="Acceder">
        </form>
    </body>
</html>

