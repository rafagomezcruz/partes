<?php 

require_once '../controller/ProfesoresController.php';
require_once '../controller/Prof_cursoController.php';
require_once '../controller/CursoController.php';
require_once '../controller/AlumnosController.php';
require_once '../controller/PartesController.php';


session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header("location:index.php");
}
if (isset($_POST['dniAlumno'])){
    $alumno = AlumnosController::findByDni($_POST['dniAlumno']);
    $_SESSION['alumno'] = $alumno;
    $curso = CursoController::findById($alumno->id_curso);
}

if (isset($_POST['grabarParte'])){
    PartesController::insertarParte($usuario->dni_p, $_SESSION['alumno']->dni_a, $_POST['textarea']);
    $curso = CursoController::findById($_SESSION['alumno']->id_curso);
    CursoController::updatePartes($curso->totalpartes + 1, $_SESSION['alumno']->id_curso);
    header("Location: partes.php");
}

?>
<a href="cerrarSesion.php">Cerrar sesión</a><br><a href="partes.php">   Inicio</a><br><!-- comment -->
<!-- comment -->
<h4>Profesor: <?php echo $usuario->nombre." ".$usuario->apellidos?> </h4>
<h2>PARTE DE INCIDENCIAS</h2>
<?php 
echo "D./Dª.<strong> $usuario->nombre $usuario->apellidos </strong>como profesor de este centro, comunica que el alumno/a"
        . "<strong> $alumno->nombre $alumno->apellidos </strong>del grupo<strong> $curso->descripcion</strong> ha cometido la siguiente falta:<br><br>" 
?>
<form action="" method="POST">
    <textarea name="textarea" rows="5" cols="100">Escriba aquí el motivo...</textarea><br><br>
    <input type="hidden" name="alumno" value="<?php $_SESSION['alumno']->dni_a ?>">
<input type="submit" name="grabarParte" value="Grabar parte">
</form>

