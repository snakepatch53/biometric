                            
<?php
/* 
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/dao/PrivilegioDao.php
*/
class PrivilegioDao{
private $conn;
public function __construct(){
$this->conn = new Mysql();
}
public function select(){
return $this->conn->query("SELECT * FROM privilegio");
}
public function selectById($privilegio_id){
return $this->conn->query("SELECT * FROM privilegio WHERE privilegio_id = $privilegio_id");
}
public function insert($privilegio_nombre, $privilegio_descripcion, $privilegio_administrador, $privilegio_informacion, $privilegio_departamento, $privilegio_horario, $privilegio_privilegio, $privilegio_usuario, $privilegio_asistencia, $privilegio_createat){
return $this->conn->query("INSERT INTO privilegio SET privilegio_nombre='$privilegio_nombre', privilegio_descripcion='$privilegio_descripcion', privilegio_administrador=$privilegio_administrador, privilegio_informacion=$privilegio_informacion, privilegio_departamento=$privilegio_departamento, privilegio_horario=$privilegio_horario, privilegio_privilegio=$privilegio_privilegio, privilegio_usuario=$privilegio_usuario, privilegio_asistencia=$privilegio_asistencia, privilegio_createat='$privilegio_createat' ");
}
public function update($privilegio_nombre, $privilegio_descripcion, $privilegio_administrador, $privilegio_informacion, $privilegio_departamento, $privilegio_horario, $privilegio_privilegio, $privilegio_usuario, $privilegio_asistencia, $privilegio_createat, $privilegio_id){
return $this->conn->query("UPDATE privilegio SET privilegio_nombre='$privilegio_nombre', privilegio_descripcion='$privilegio_descripcion', privilegio_administrador=$privilegio_administrador, privilegio_informacion=$privilegio_informacion, privilegio_departamento=$privilegio_departamento, privilegio_horario=$privilegio_horario, privilegio_privilegio=$privilegio_privilegio, privilegio_usuario=$privilegio_usuario, privilegio_asistencia=$privilegio_asistencia, privilegio_createat='$privilegio_createat' WHERE privilegio_id = $privilegio_id ");
}
public function delete($privilegio_id){
return $this->conn->query("DELETE FROM privilegio WHERE privilegio_id = $privilegio_id ");
}


}
?>
            
                        