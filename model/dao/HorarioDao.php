                            
<?php
/* 
- CREA UN ARCHIVO CON EL NOMBRE Y EXTENSION INDICADA.
- RUTA: proyect/model/dao/HorarioDao.php
*/
class HorarioDao{
private $conn;
public function __construct(){
$this->conn = new Mysql();
}
public function select(){
return $this->conn->query("SELECT * FROM horario");
}
public function selectById($horario_id){
return $this->conn->query("SELECT * FROM horario WHERE horario_id = $horario_id");
}
public function insert($horario_nombre, $horario_entrada, $horario_salida, $horario_createat){
return $this->conn->query("INSERT INTO horario SET horario_nombre='$horario_nombre', horario_entrada='$horario_entrada', horario_salida='$horario_salida', horario_createat='$horario_createat' ");
}
public function update($horario_nombre, $horario_entrada, $horario_salida, $horario_createat, $horario_id){
return $this->conn->query("UPDATE horario SET horario_nombre='$horario_nombre', horario_entrada='$horario_entrada', horario_salida='$horario_salida', horario_createat='$horario_createat' WHERE horario_id = $horario_id ");
}
public function delete($horario_id){
return $this->conn->query("DELETE FROM horario WHERE horario_id = $horario_id ");
}


}
?>
            
                        