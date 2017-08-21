# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


# Host: localhost    Database: sistema_reserva_salas
# ------------------------------------------------------
# Server version 5.6.17

#
# Source for table reservas
#

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `sala_id_sala` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `reservas_fk0` (`sala_id_sala`),
  KEY `reservas_fk1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Source for table salas
#

DROP TABLE IF EXISTS `salas`;
CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL AUTO_INCREMENT,
  `nome_sala` varchar(25) NOT NULL,
  PRIMARY KEY (`id_sala`),
  UNIQUE KEY `nome_sala` (`nome_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Source for table usuarios
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
#  Foreign keys for table reservas
#

ALTER TABLE `reservas`
ADD CONSTRAINT `reservas_fk0` FOREIGN KEY (`sala_id_sala`) REFERENCES `salas` (`id_sala`),
ADD CONSTRAINT `reservas_fk1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id_user`);


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
