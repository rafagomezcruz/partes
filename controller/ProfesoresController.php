<?php
require_once '../controller/Conexion.php';
require_once '../model/Profesores.php';
/**
 * Description of ProfesoresController
 *
 * @author rafag
 */
class ProfesoresController {
    
    /**
     * 
     * @param type $user
     * @param type $pass
     * @return 
     */
    public static function comprobarUsuario($user) {
        $usuario = null; 
        try{
             $conex = new conexion();
             $stmt = $conex->prepare("select * from profesores where dni_p = ?");
             $stmt->bind_param("s", $user);
             $stmt->execute();            
             $resultado = $stmt->get_result()->fetch_object();
             if( $resultado) {                           
                $usuario = new Profesores($resultado->dni_p, $resultado->nombre, $resultado->apellidos, $resultado->pass, $resultado->bloqueado, $resultado->hora_bloqueo, $resultado->intentos);               
            }
             $stmt->close();
             $conex->close();
         } catch (Exception $ex) {
             echo "Fallo en comprobarUsuario".$ex->getMessage();
         }
         return $usuario;
    }
    
    
    public static function actualizarIntentos($dni, $nuevosIntentos) {
        try {
            $conex = new Conexion();
            $fila = $conex->query("UPDATE profesores SET intentos = $nuevosIntentos WHERE dni_p = '$dni'");
            if($conex->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo "Fallo al actualizar intentos: " . $ex->getMessage();
        }
        return false;
    }
    
    public static function bloquearUsuario($dni) {
        try {
            $conex = new Conexion();
            $fila = $conex->query("UPDATE profesores SET bloqueado = 1 WHERE dni_p = '$dni'");
            if($conex->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo "Fallo al bloquear usuario: " . $ex->getMessage();
        }
        return false;
    }
    
    public static function bloqueoUsuario($dni, $time, $bloqueado) {
        try {
            $conex = new Conexion();
            $fila = $conex->query("UPDATE profesores SET bloqueado = '$bloqueado', hora_bloqueo = '$time'  WHERE dni_p = '$dni'");
            if($conex->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo "Fallo al bloquear usuario: " . $ex->getMessage();
        }
        return false;
    }
    
    
    public static function findByDni($dni){
        $profesor='';
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM profesores WHERE dni_p = '$dni'");
            $fila = $resultado->fetch_object();
            
            if ($fila){
                $profesor = new Profesores($fila->dni_p, $fila->nombre, $fila->apellidos, $fila->pass, $fila->bloqueado, $fila->hora_bloqueo, $fila->intentos);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo "Error en findByIban: ".$ex->getMessage();
        }
        return $profesor;
    }
    
    
}
