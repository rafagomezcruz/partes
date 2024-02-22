<?php 

require_once '../controller/ProfesoresController.php';
require_once '../controller/Prof_cursoController.php';
require_once '../controller/CursoController.php';
require_once '../controller/AlumnosController.php';
$mensaje='';



session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header("location:index.php");
}

if (isset($_SESSION['alumno'])){
    $alumno = $_SESSION['alumno'];


if ($alumno) {
    $mensaje = "<font color='red'>El profesor $usuario->nombre $usuario->apellidos ha grabado una nueva incidencia "
            . "para el alumno $alumno->nombre $alumno->apellidos.</font><br>";
    unset($_SESSION['alumno']);
}
}

if (isset($_SESSION['alumnoHistorial'])){
    unset($_SESSION['alumnoHistorial']);
}

?>
<a href="cerrarSesion.php">Cerrar sesión</a><br><!-- comment -->
<h4>Profesor: <?php echo $usuario->nombre." ".$usuario->apellidos?> </h4>
<?php echo $mensaje ?>
<form action="" method="POST">
Seleccione curso del alumno/a:<br><br><!-- comment -->
<?php
$cursos = Prof_cursoController::findAlldByDNI($usuario->dni_p);
echo "<select name='curso'>";
foreach ($cursos as $curso) {
    $c= CursoController::findById($curso->id_curso);
    echo "<option value='$c->id_curso'>$c->descripcion</option>";
    }
    echo "</select>";
?>
    <input type="submit" name="seleccionarCurso" value="Seleccionar Curso">
</form>

<?php
if (isset($_POST['seleccionarCurso'])){
    $curso = CursoController::findById($_POST['curso']);
echo "Este curso tiene ".$curso->totalpartes." partes"; 
?>
    <h2>Listado de alumnos:</h2>

        <table border="1" >
    <tr>
        <th>Alumno</th>
        <th>Acciones</th>


    </tr>
<?php
    $alumnos = AlumnosController::findAlldByIdCurso($curso->id_curso);
    //var_dump($alumnos);
    //echo $curso->id_curso;
    foreach ($alumnos as $alumno){
?>
    <tr>
<?php
    echo '<td>'.$alumno->nombre.' '.$alumno->apellidos.'</td>'
            . '<td>'
            ."<form action='nuevoParte.php' method='POST'>"
            . "<input type=submit name='nuevoParte' value='Nuevo parte'>"
            . "<input type=hidden name='dniAlumno' value='".$alumno->dni_a."'>"           
            . "</form>"
            ."<form action='historial.php' method='POST'>"
            . "<input type=submit name='historial' value='Historial'>"
            . "<input type=hidden name='dniAlumno' value='".$alumno->dni_a."'>"           
            . "</form></td>";
?>
    </tr>
<?php   
    }
}
?>
