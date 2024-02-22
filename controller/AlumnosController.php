<?php
require_once '../controller/Conexion.php';
require_once '../model/Alumnos.php';
/**
 * Description of AlumnosController
 *
 * @author rafag
 */
class AlumnosController {
    
    /**
     * 
     * @param 
     * @return \
     */
    public static function findAlldByIdCurso($id) {
        $alumnos = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM alumnos WHERE id_curso = '$id'");
            
            while ($fila = $resultado->fetch_object()) {
                $alumnos[]= new Alumnos($fila->dni_a, $fila->nombre, $fila->apellidos, $fila->direccion, $fila->telf, $fila->id_curso);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAllByDNI: ' . $ex->getMessage(); 
        }
        return $alumnos;
    }
    
    public static function findByDni($dni){
        $alumno='';
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM alumnos WHERE dni_a = '$dni'");
            $fila = $resultado->fetch_object();
            
            if ($fila){
                $alumno = new Alumnos($fila->dni_a, $fila->nombre, $fila->apellidos, $fila->direccion, $fila->telf, $fila->id_curso);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo "Error en findByIban: ".$ex->getMessage();
        }
        return $alumno;
    }
    
    
}
