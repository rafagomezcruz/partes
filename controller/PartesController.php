<?php
require_once '../controller/Conexion.php';
require_once '../model/Partes.php';
/**
 * Description of PartesController
 *
 * @author rafag
 */
class PartesController {
    
    
    
    public static function insertarParte($dni_p, $dni_a, $motivo) {
            $time= time();
        try {
            $conex = new Conexion();
            $fila = $conex->query("INSERT INTO partes (dni_p, dni_a, motivo, time) VALUES ('$dni_p', '$dni_a', '$motivo', '$time')");
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
    
    
    public static function findAlldByDniAlumno($dni_a) {
        $partes = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM partes WHERE dni_a = '$dni_a'");
            
            while ($fila = $resultado->fetch_object()) {
                $partes[]= new Partes($fila->id, $fila->dni_p, $fila->dni_a, $fila->motivo, $fila->time);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAllByDniAlumno: ' . $ex->getMessage(); 
        }
        return $partes;
    }
    
    
    public static function deleteById($id) {
        try {
            $conex = new Conexion();
            $conex->query("DELETE FROM partes WHERE id = '$id'");
            if ($conex->affected_rows > 0) {
                return true; 
            } else {
                return false;
            }
        } catch (Exception $ex) {
            echo 'Error en delete ' . $ex->getMessage();
            return false;
        }
    }
    

    
    
}
