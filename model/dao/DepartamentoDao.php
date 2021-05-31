<?php
class DepartamentoDao
{
    private $conn;
    public function __construct()
    {
        $this->conn = new Mysql();
    }
    public function select()
    {
        return $this->conn->query("SELECT * FROM departamento");
    }
    public function selectById($departamento_id)
    {
        return $this->conn->query("SELECT * FROM departamento WHERE departamento_id = $departamento_id");
    }
    public function insert(
        $departamento_nombre,
        $departamento_descripcion,
        $departamento_createat
    ) {
        return $this->conn->query("
            INSERT INTO departamento SET 
                departamento_nombre='$departamento_nombre', 
                departamento_descripcion='$departamento_descripcion', 
                departamento_createat='$departamento_createat' 
        ");
    }
    public function update(
        $departamento_nombre,
        $departamento_descripcion,
        $departamento_createat,
        $departamento_id
    ) {
        return $this->conn->query("
            UPDATE departamento SET 
                departamento_nombre='$departamento_nombre', 
                departamento_descripcion='$departamento_descripcion', 
                departamento_createat='$departamento_createat' 
            WHERE departamento_id = $departamento_id 
        ");
    }
    public function delete($departamento_id)
    {
        return $this->conn->query("DELETE FROM departamento WHERE departamento_id = $departamento_id ");
    }
}
