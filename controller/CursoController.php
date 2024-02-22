<?php
require_once '../controller/Conexion.php';
require_once '../model/Curso.php';
/**
 * Description of CursoController
 *
 * @author rafag
 */
class CursoController {
    
    public static function findById($id){
        $curso='';
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM curso WHERE id_curso = '$id'");
            $fila = $resultado->fetch_object();
            
            if ($fila){
                    $curso = new Curso($fila->id_curso, $fila->descripcion, $fila->totalpartes);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo "Error en findById: ".$ex->getMessage();
        }
        return $curso;
    }
    
    public static function updatePartes($nuevosPartes, $id_curso){
        try {
            $conex = new Conexion();
            $fila = $conex->query("UPDATE curso SET totalpartes = '$nuevosPartes' WHERE id_curso = '$id_curso'");
            if($conex->affected_rows > 0) {
                return true;
            }
            return false;
            $conex->close();
        } catch (Exception $ex) {
            die("ERROR EN EL UPDATE. " . $ex->getMessage());
        }
        return false;
    }
    
    
}
