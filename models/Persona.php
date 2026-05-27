<?php

if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/database.php';
}

class Persona
{
    public static function login($correo, $contrasena)
    {
        $database = new Database();
        $db = $database->conectar();

        $sql = "SELECT p.idpersona, p.nombre, p.correo, p.contrasena, r.nombre AS rol
        FROM persona p
        INNER JOIN roles r ON p.idrol = r.idrol
        WHERE p.correo = :correo
        LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return null;
        }

        // Verificar contraseña (con soporte para hash o texto plano legacy)
        $contrasenaValida = false;

        if (password_get_info($usuario['contrasena'])['algo'] !== null) {
            // La contraseña está hasheada con bcrypt
            $contrasenaValida = password_verify($contrasena, $usuario['contrasena']);
        } else {
            // Contraseña legacy en texto plano — verificar y migrar al vuelo
            $contrasenaValida = ($contrasena === $usuario['contrasena']);
            if ($contrasenaValida) {
                $hash = password_hash($contrasena, PASSWORD_BCRYPT);
                $db->prepare("UPDATE persona SET contrasena = :hash WHERE idpersona = :id")
                   ->execute([':hash' => $hash, ':id' => $usuario['idpersona']]);
            }
        }

        return $contrasenaValida ? $usuario : null;
    }

    public static function registrar($nombre, $correo, $contrasena, $rolNombre = 'cliente')
    {
        $database = new Database();
        $db = $database->conectar();

        // Verificar si el correo ya existe
        $check = $db->prepare("SELECT idpersona FROM persona WHERE correo = :correo LIMIT 1");
        $check->bindParam(':correo', $correo, PDO::PARAM_STR);
        $check->execute();

        if ($check->fetch()) {
            return false; // correo ya registrado
        }

        // Obtener el idrol por nombre
        $rolStmt = $db->prepare("SELECT idrol FROM roles WHERE nombre = :nombre LIMIT 1");
        $rolStmt->bindParam(':nombre', $rolNombre, PDO::PARAM_STR);
        $rolStmt->execute();
        $rol = $rolStmt->fetch(PDO::FETCH_ASSOC);

        if (!$rol) {
            return false; // rol no encontrado
        }

        $idrol = $rol['idrol'];
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);

        $sql = "INSERT INTO persona (idrol, nombre, correo, contrasena) 
                VALUES (:idrol, :nombre, :correo, :contrasena)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idrol',      $idrol,   PDO::PARAM_INT);
        $stmt->bindParam(':nombre',     $nombre,  PDO::PARAM_STR);
        $stmt->bindParam(':correo',     $correo,  PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $hash,    PDO::PARAM_STR);

        return $stmt->execute();
    }
}
