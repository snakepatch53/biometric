<?php
class UsuarioDao
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
            SELECT * FROM usuario
                INNER JOIN privilegio ON privilegio.privilegio_id = usuario.privilegio_id
                INNER JOIN departamento ON departamento.departamento_id = usuario.departamento_id
                INNER JOIN horario ON horario.horario_id = usuario.horario_id
        ");
    }
    public function selectById($usuario_id)
    {
        return $this->conn->query("
            SELECT * FROM usuario 
                INNER JOIN privilegio ON privilegio.privilegio_id = usuario.privilegio_id
                INNER JOIN departamento ON departamento.departamento_id = usuario.departamento_id
                INNER JOIN horario ON horario.horario_id = usuario.horario_id
            WHERE usuario_id = $usuario_id
        ");
    }
    public function insert(
        $usuario_nombre,
        $usuario_email,
        $usuario_pass,
        $usuario_cedula,
        $usuario_estado,
        $usuario_createat,
        $privilegio_id,
        $departamento_id,
        $horario_id
    ) {
        return $this->conn->query("
            INSERT INTO usuario SET 
                usuario_nombre='$usuario_nombre', 
                usuario_email='$usuario_email', 
                usuario_pass='$usuario_pass', 
                usuario_cedula='$usuario_cedula', 
                usuario_estado=$usuario_estado, 
                usuario_createat='$usuario_createat', 
                privilegio_id=$privilegio_id, 
                departamento_id=$departamento_id, 
                horario_id=$horario_id 
        ");
    }
    public function update(
        $usuario_nombre,
        $usuario_email,
        $usuario_cedula,
        $usuario_estado,
        $privilegio_id,
        $departamento_id,
        $horario_id,
        $usuario_id
    ) {
        return $this->conn->query("
            UPDATE usuario SET 
                usuario_nombre='$usuario_nombre', 
                usuario_email='$usuario_email', 
                usuario_cedula='$usuario_cedula', 
                usuario_estado=$usuario_estado, 
                privilegio_id=$privilegio_id, 
                departamento_id=$departamento_id, 
                horario_id=$horario_id 
            WHERE usuario_id = $usuario_id ");
    }
    public function updatePassword(
        $usuario_pass,
        $usuario_id
    ) {
        return $this->conn->query("
            UPDATE usuario SET 
                usuario_pass='$usuario_pass'
            WHERE usuario_id = $usuario_id 
        ");
    }
    public function updateUsuario_foto(
        $usuario_foto,
        $usuario_id
    ) {
        return $this->conn->query("
            UPDATE usuario SET 
                usuario_foto='$usuario_foto'
            WHERE usuario_id = $usuario_id 
        ");
    }
    public function delete($usuario_id)
    {
        return $this->conn->query("
            DELETE FROM usuario 
            WHERE usuario_id = $usuario_id
        ");
    }
    public function login($usuario_email, $usuario_pass)
    {
        return $this->conn->query("
            SELECT * FROM usuario 
                INNER JOIN privilegio ON privilegio.privilegio_id = usuario.privilegio_id
                INNER JOIN departamento ON departamento.departamento_id = usuario.departamento_id
                INNER JOIN horario ON horario.horario_id = usuario.horario_id
            WHERE usuario_email = '$usuario_email' AND usuario_pass = '$usuario_pass'
        ");
    }
}
