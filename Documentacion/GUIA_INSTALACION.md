# Guía de Instalación y Despliegue Local — Heladería Alpes

Esta guía detalla los pasos requeridos para poner en marcha el sistema **Heladería Alpes** en un entorno local de desarrollo utilizando **Laragon** (o cualquier servidor con PHP y MySQL).

---

## 📋 Requisitos del Sistema

* **Servidor Web:** Apache (incluido en Laragon).
* **Lenguaje:** PHP 8.0 o superior (con extensiones `pdo`, `pdo_mysql`, `mbstring`, `curl` activadas).
* **Gestor de Base de Datos:** MySQL 5.7+ o MariaDB 10.4+.
* **Navegador Web:** Google Chrome, Mozilla Firefox, Microsoft Edge o similar.

---

## 🚀 Pasos de Instalación

### 1. Clonar o Ubicar el Proyecto
Ubica la carpeta del proyecto en el directorio raíz de Laragon:
```text
C:\laragon\www\Heladeria_Alpes
```

### 2. Configuración de la Base de Datos
1. Inicia los servicios de **Apache** y **MySQL** en Laragon.
2. Abre tu gestor de base de datos preferido (HeidiSQL, phpMyAdmin o DBeaver).
3. Crea una nueva base de datos llamada:
   ```sql
   CREATE DATABASE bdalpes CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```
4. Importa el archivo consolidado de base de datos ubicado en:
   ```text
   sql/bdalpes.sql
   ```

---

### 3. Configuración del Archivo de Conexión (`database.php`)
Copia la plantilla de ejemplo `config/database.example.php` como `config/database.php` si no existe:
```php
<?php
if (!class_exists('Database')) {
    class Database
    {
        private $host     = "127.0.0.1";
        private $port     = "3306";       // Puerto de MySQL (3306 o 3320 en Laragon)
        private $db_name  = "bdalpes";
        private $username = "root";
        private $password = "";           // Tu contraseña si aplica

        public function conectar()
        {
            try {
                $dsn  = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
                $conn = new PDO($dsn, $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                throw new Exception("Error de conexión: " . $e->getMessage());
            }
        }
    }
}
```

---

### 4. Acceso al Sistema

Abre tu navegador e ingresa a:
* **URL:** `http://localhost/Heladeria_Alpes/public/` (o el VirtualHost `http://heladeria-alpes.test` si está activo en Laragon).

#### Roles predeterminados para pruebas:
| Rol | Funcionalidades |
| :--- | :--- |
| **Administrador** | Gestión de catálogo, productos, insumos, inventario y reportes. |
| **Domiciliario** | Vista de pedidos pendientes de entrega y confirmación de entregas. |
| **Cliente** | Catálogo interactivo, carrito de compras, pagos y chatbot de pedidos. |
