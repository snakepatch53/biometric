<?php
class AsistenciaDao
{
    private $conn;
    public function __construct()
    {
        $this->conn = new Mysql();
    }
    public function getLastId()
    {
        return $this->conn->getLastId();
    }
    public function select()
    {
        return $this->conn->query("
            SELECT * FROM asistencia
                INNER JOIN usuario ON usuario.usuario_id = asistencia.usuario_id
                INNER JOIN privilegio ON privilegio.privilegio_id = usuario.privilegio_id
            ORDER BY asistencia.asistencia_id DESC
        ");
    }
    public function selectById($asistencia_id)
    {
        return $this->conn->query("
            SELECT * FROM asistencia 
                INNER JOIN usuario ON usuario.usuario_id = asistencia.usuario_id
                INNER JOIN privilegio ON privilegio.privilegio_id = usuario.privilegio_id
            WHERE asistencia_id = $asistencia_id
        ");
    }
    public function selectByUsuario_id($usuario_id)
    {
        return $this->conn->query("
            SELECT * FROM asistencia 
                INNER JOIN usuario ON usuario.usuario_id = asistencia.usuario_id
            WHERE 
                usuario.usuario_id = $usuario_id AND 
                (asistencia.asistencia_fecha_salida = null OR asistencia.asistencia_fecha_salida = '')
        ");
    }
    public function insert(
        $asistencia_fecha_entrada,
        $asistencia_fecha_salida,
        $usuario_id
    ) {
        return $this->conn->query("
            INSERT INTO asistencia SET 
                asistencia_fecha_entrada='$asistencia_fecha_entrada', 
                asistencia_fecha_salida='$asistencia_fecha_salida', 
                usuario_id=$usuario_id 
        ");
    }
    public function update(
        $asistencia_fecha_entrada,
        $asistencia_fecha_salida,
        $usuario_id,
        $asistencia_id
    ) {
        return $this->conn->query("
            UPDATE asistencia SET 
                asistencia_fecha_entrada='$asistencia_fecha_entrada', 
                asistencia_fecha_salida='$asistencia_fecha_salida', 
                usuario_id=$usuario_id 
            WHERE asistencia_id = $asistencia_id 
        ");
    }
    public function delete($asistencia_id)
    {
        return $this->conn->query("
            DELETE FROM asistencia 
            WHERE asistencia_id = $asistencia_id 
        ");
    }
}
