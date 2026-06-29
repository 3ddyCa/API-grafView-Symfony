CREATE DATABASE IF NOT EXISTS meteoView CHARSET utf8mb4;
USE meteoNews;

CREATE TABLE IF NOT EXISTS city_datas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) UNIQUE NOT NULL,
    latitude DECIMAL(8,2) UNIQUE NOT NULL,
    longitude DECIMAL(8,2) UNIQUE NOT NULL,
    elevation DECIMAL(8,2) NOT NULL
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS today(
    id INT PRIMARY KEY AUTO_INCREMENT,
    currentDate DATETIME UNIQUE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    TC DECIMAL(5,2) UNIQUE NOT NULL,
    TCmax DECIMAL(5,2) UNIQUE NOT NULL,
    TCmin DECIMAL(5,2) NOT NULL,
    sunrise TIME NOT NULL,
    sunset TIME NOT NULL,
    pressure DECIMAL(8,2) NOT NULL,
    humidity DECIMAL(8,2) NOT NULL,
    fk_city INT NOT NULL
    ADD CONSTRAINT fk_meteoJour_city_datas FOREIGN KEY (fk_city) REFERENCES city_datas(id) ON DELETE CASCADE;
)ENGINE=innoDB;

CREATE VIEW IF NOT EXISTS vw_currentCity AS
SELECT cd.id, `name`, latitude, longitude, elevation, 
td.id, currentDate, TC, TCmax, TCmin, sunrise, sunset, presure, humidity FROM city_datas cd INNER JOIN today td ON cd.id = td.fk_city;

CREATE VIEW IF NOT EXISTS vw_weekCity AS
SELECT cd.id, `name`, latitude, longitude, elevation, 
GROUP_CONCAT(CONCAT(td.id, currentDate, TC, TCmax, TCmin, sunrise, sunset, presure, humidity) SEPARATOR ' | ') FROM city_datas cd INNER JOIN today td ON cd.id = td.fk_city GROUP BY cd.id ORDER BY td.id DESC LIMIT 7;
