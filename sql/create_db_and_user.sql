-- Crea la base de datos y el usuario para fAIrclass
-- Ejecuta esto como root en MariaDB/MySQL (p. ej. sudo mysql -u root -p)

CREATE DATABASE IF NOT EXISTS `fairclass_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Crea un usuario para la aplicación. Cambia 'strong_password_here' por una contraseña segura.
CREATE USER IF NOT EXISTS 'fairclass_user'@'localhost' IDENTIFIED BY 'strong_password_here';

GRANT ALL PRIVILEGES ON `fairclass_db`.* TO 'fairclass_user'@'localhost';
FLUSH PRIVILEGES;

-- Después de crear la DB y el usuario, importa el dump de estructura:
-- mysql -u fairclass_user -p fairclass_db < setup.sql
