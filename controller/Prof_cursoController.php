<?php
require_once '../controller/Conexion.php';
require_once '../model/Prof_curso.php';
/**
 * Description of Prof_cursoController
 *
 * @author rafag
 */
class Prof_cursoController {
    
    /**
     * 
     * @param type $dni
     * @return \Cuenta
     */
    public static function findAlldByDNI($dni) {
        $cursos = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM prof_curso WHERE dni_p = '$dni'");
            
            while ($fila = $resultado->fetch_object()) {
                $cursos[]= new Prof_curso($fila->dni_p, $fila->id_curso);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAllByDNI: ' . $ex->getMessage(); 
        }
        return $cursos;
    }
    
    
}
