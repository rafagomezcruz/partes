<?php
//Pasos para eliminar una sesión

//Eliminar en la parte de servidor
session_start(); // para eliminar una sesión lo primero es llamarla
session_unset(); // Eliminamos las variables de sesión con unset
session_destroy(); //Elimina la sesión en el servidor

//Eliminar en la parte cliente (cookie de sesión)

//seleccionamos la cookie de sesion mediante el identificador y le pasamos los parámetros 
//1.- identificador
//2.- parámetro cualquiera
//3.- time()- algo, para eliminar la cookie
//4.- la ruta (path) entre comillas dobles
setcookie("PHPSESSID",0,time()-100,"/"); 
header("location:index.php");
?>

