CREATE DATABASE IF NOT EXISTS lendflow_db;
CREATE USER 'lendflow_user'@'%' IDENTIFIED BY 'lendflow_pass';
GRANT ALL PRIVILEGES ON lendflow_db.* TO 'lendflow_user'@'%';
FLUSH PRIVILEGES;
