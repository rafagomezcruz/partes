<?php 

require_once '../controller/ProfesoresController.php';
require_once '../controller/Prof_cursoController.php';
require_once '../controller/CursoController.php';
require_once '../controller/AlumnosController.php';
require_once '../controller/PartesController.php';
$mensaje='';


session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header("location:index.php");
}
if (isset($_POST['dniAlumno'])){
    $alumno = AlumnosController::findByDni($_POST['dniAlumno']);
    $_SESSION['alumnoHistorial'] = $alumno;
}

if (isset($_POST['quitarParte'])){
    PartesController::deleteById($_POST['idParte']);
    $curso = CursoController::findById($_SESSION['alumnoHistorial']->id_curso);
    CursoController::updatePartes($curso->totalpartes - 1, $_SESSION['alumnoHistorial']->id_curso);
    $mensaje = "<font color='red'>Se ha eliminado el parte del alumno ".$_SESSION['alumnoHistorial']->nombre."</font>";
}


?>
<a href="cerrarSesion.php">Cerrar sesión</a><br><a href="partes.php">   Inicio</a><br><!-- comment -->
<!-- comment -->
<h4>Profesor: <?php echo $usuario->nombre." ".$usuario->apellidos?> </h4>
<?php echo $mensaje?>
<h4>Historial de partes del alumno:<?php echo $_SESSION['alumnoHistorial']->nombre." ".$_SESSION['alumnoHistorial']->apellidos?> </h4>
<?php
    $partes = PartesController::findAlldByDniAlumno($_SESSION['alumnoHistorial']->dni_a);
    if (!$partes){
        echo "El alumno no tiene partes";
    }
    else {
?>
        <table border="1" >
    <tr>
        <th>Fecha</th>
        <th>Profesor</th>
        <th>Motivo</th>
        <th>Quitar parte</th>
    </tr>
<?php    
    foreach ($partes as $parte){
        $profesor = ProfesoresController::findByDni($parte->dni_p);
        $fecha = date('d-m-Y', $parte->time);

?>
    <tr>
<?php
    echo '<td>'.$fecha.'</td>'
            .'<td>'.$profesor->nombre.' '.$profesor->apellidos.'</td>'
            .'<td>'.$parte->motivo.'</td>';
            if ($parte->dni_p == $usuario->dni_p){
                echo "<td><form action='' method='POST'>"
                        . "<input type=submit name='quitarParte' value='Quitar Parte'>"
                        . "<input type=hidden name='idParte' value='".$parte->id."'>"           
                        . "</form></td>";
            }
?>
    </tr>
<?php   
    }
}
?>
