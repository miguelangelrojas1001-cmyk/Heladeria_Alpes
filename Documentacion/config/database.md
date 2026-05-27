# config/database.php

## Descripción General

Clase `Database` que encapsula la conexión a la base de datos MySQL usando **PDO** (PHP Data Objects). Es el único punto de acceso a la BD en todo el sistema.

## Ubicación

```
config/database.php
```

## Dependencias

- PHP PDO extension (`pdo_mysql`)
- No depende de ningún otro archivo del proyecto

## Responsabilidades

- Almacenar las credenciales de conexión
- Crear y retornar una instancia PDO configurada
- Lanzar excepción si la conexión falla

## Configuración de Conexión

| Parámetro | Valor actual | Descripción |
|---|---|---|
| `$host` | `127.0.0.1` | Servidor MySQL |
| `$port` | `3320` | Puerto (XAMPP usa 3306 por defecto; aquí es 3320) |
| `$db_name` | `bdalpes` | Nombre de la base de datos |
| `$username` | `root` | Usuario MySQL |
| `$password` | `""` | Contraseña (vacía en desarrollo) |

## Métodos

| Método | Parámetros | Retorna | Descripción |
|---|---|---|---|
| `conectar()` | ninguno | `PDO` | Crea y retorna la conexión PDO |

## Flujo Lógico

```
1. Se verifica que la clase no esté ya definida (guard con class_exists)
2. Se construye el DSN: "mysql:host=...;port=...;dbname=...;charset=utf8mb4"
3. Se instancia PDO con las credenciales
4. Se configura ERRMODE_EXCEPTION para que los errores SQL lancen excepciones
5. Se retorna la conexión
6. Si falla, se lanza Exception con el mensaje del PDOException
```

## Ejemplo de Uso

```php
$database = new Database();
$db = $database->conectar();
$stmt = $db->prepare("SELECT * FROM producto WHERE disponible = 1");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

## Posibles Fallos y Consideraciones

- **Puerto incorrecto**: Si XAMPP usa el puerto 3306 (estándar), cambiar `$port` a `"3306"`.
- **Contraseña vacía**: En producción siempre debe tener contraseña.
- **Credenciales hardcodeadas**: En producción usar variables de entorno (`.env`).
- **Sin pool de conexiones**: Cada llamada a `conectar()` crea una nueva conexión. En alta concurrencia puede ser un cuello de botella.
- **charset utf8mb4**: Correcto para soportar emojis y caracteres especiales.

## Mejoras Recomendadas

```php
// Usar variables de entorno en producción:
$this->host     = $_ENV['DB_HOST']     ?? '127.0.0.1';
$this->port     = $_ENV['DB_PORT']     ?? '3306';
$this->db_name  = $_ENV['DB_NAME']     ?? 'bdalpes';
$this->username = $_ENV['DB_USER']     ?? 'root';
$this->password = $_ENV['DB_PASSWORD'] ?? '';
```
