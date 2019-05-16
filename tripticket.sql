/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.1.41 : Database - trip_ticket_sys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`trip_ticket_sys` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `trip_ticket_sys`;

/*Table structure for table `daily_route_list` */

DROP TABLE IF EXISTS `daily_route_list`;

CREATE TABLE `daily_route_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Driver` int(5) DEFAULT NULL,
  `Helper` int(5) DEFAULT NULL,
  `route` int(5) DEFAULT NULL,
  `time` varchar(15) DEFAULT NULL,
  `date_deliver` date DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `daily_route_list` */

insert  into `daily_route_list`(`id`,`Driver`,`Helper`,`route`,`time`,`date_deliver`,`date_created`) values (3,3,18,2,'8:00 am','2019-01-19','2019-01-19 01:50:03');

/*Table structure for table `route_list` */

DROP TABLE IF EXISTS `route_list`;

CREATE TABLE `route_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `route_list` */

insert  into `route_list`(`id`,`route`) values (1,'Caloocan / Manila Cargo'),(2,'Manila Cargo'),(3,'Manila / Pasay'),(4,'Manila / Sta Mesa'),(5,'Pasig / Cubao'),(6,'Makati / Mandaluyong'),(7,'Alabang / Las piñas'),(8,'Sucat / Taguig'),(9,'Sucat / Parañaque'),(10,'Nova / Fairview / SJDM'),(11,'Nova / Fairview'),(12,'Cavite'),(13,'Laguna'),(14,'Batangas'),(15,'Caloocan / Valenzuela'),(16,'Bulacan'),(17,'Pampanga'),(18,'Bataan'),(19,'QC'),(20,'Marikina / Montalban');

/*Table structure for table `tbl_driver_helper` */

DROP TABLE IF EXISTS `tbl_driver_helper`;

CREATE TABLE `tbl_driver_helper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `category` varchar(2) DEFAULT NULL COMMENT 'D = truck driver, H = helper, R = rider dp = dispatcher',
  `Plate_no` varchar(25) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_driver_helper` */

insert  into `tbl_driver_helper`(`id`,`name`,`category`,`Plate_no`,`Contact`) values (1,'GRINGO BORELA','D','NM4286','0977-185-0561'),(2,'ANGELO CAÑADA','D','WHP366','0915-146-8715'),(3,'MARIO TAWIRAN','D','RLU972','0915-911-5895'),(4,'JOEL TOMATE','D','NR5138','0907-465-6344'),(5,'HANZEL BACUYAG','D','NDC1121','0906-233-7261'),(6,'RICHARD FERMALE','D','RJS923','0905-701-9731'),(7,'GARY VILLAFUERTE','D','RLK589','0995-663-0487'),(8,'NIMUEL MONGADO','D','NR6071',''),(9,'RAMIE ALVARAN','D','DOZ225','0995-230-4239'),(10,'JOEL CONJI','D','DOZ224','0908-615-7798'),(11,'JULY EHONG','dp','',''),(12,'MARK ADEVA','dp','',''),(13,'MICHAEL CARMEN','dp','',''),(14,'ARDAM REEVEE LAMBOY','R','','0936-143-4469'),(15,'EDWIN VILLANUEVA','R','','0929-123-3966'),(16,'CLARK OCAMPO','R','','0975-124-8807'),(17,'ALBERT HULIPAS','H','','0999-594-0073'),(18,'JAYPEE SAME','H','','0950-838-6765'),(19,'JOHN ANGELO GRAVA','H','','0912-749-4741'),(20,'MARJHON NASAYAO','H','','0948-996-0248'),(21,'JOHN R. TABELINA','H','','0927-003-7391'),(22,'TOBBY VILLANUEVA','H','','0928-949-5397'),(23,'JOHNDEE ALIGONZA','H','','0999-312-4765'),(24,'FELIX AGBU','H','','0945-572-0851'),(25,'HIKARU NISHI','H','','0977-717-0225'),(26,'RICHARD ZULUETA','H','','0930-580-4099'),(27,'ROLAND SARABOSQUEZ','R','','0975-565-4139'),(28,'JHYPYMS TEJADA','R','','0908-494-6100'),(29,'ARIEL MANANSALA','R','','0932-205-7484'),(30,'TIRSO C. DELA CRUZ','R','','0965-703-9144'),(31,'REYNALDO BELOTINDOS','R','','0977-685-3664');

/*Table structure for table `tbl_main` */

DROP TABLE IF EXISTS `tbl_main`;

CREATE TABLE `tbl_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_series_no` int(15) DEFAULT NULL,
  `driver` int(5) DEFAULT NULL,
  `plate_no` varchar(20) DEFAULT NULL,
  `helper` int(5) DEFAULT NULL,
  `contact` varchar(12) DEFAULT NULL,
  `date_delivery` date DEFAULT NULL,
  `maker` int(5) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `time` varchar(15) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `is_printed` varchar(2) DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_main` */

insert  into `tbl_main`(`id`,`form_series_no`,`driver`,`plate_no`,`helper`,`contact`,`date_delivery`,`maker`,`area`,`time`,`date_created`,`is_printed`) values (1,3263,2,'WHP366',19,'09999999999','2019-01-19',9,'manila','08:00','2019-01-18 02:51:17','Y');

/*Table structure for table `tblusers` */

DROP TABLE IF EXISTS `tblusers`;

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(25) DEFAULT NULL,
  `Middlename` varchar(25) DEFAULT NULL,
  `Lastname` varchar(25) DEFAULT NULL,
  `Contact` varchar(12) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_last_modified` datetime DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `is_active` varchar(2) DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `user_type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `tblusers` */

insert  into `tblusers`(`id`,`Firstname`,`Middlename`,`Lastname`,`Contact`,`Birthdate`,`email`,`username`,`password`,`date_created`,`date_last_modified`,`token`,`is_active`,`date_last_login`,`user_type`) values (9,'JOSEPH','PLANTA','CRUZ','0303030303','2018-12-19','jccruz@exxelprime.com','Jccruz','$2y$10$UeAeXgU9su96gTAqr..IeO/lTyOoR1BxPIIJkRlMg71TKkTEBE.5S','2018-12-19 07:20:51','2018-12-26 05:09:36','tgwf5DcEq76gS4GLTZqqxBqEIGcekkX0cvf4MNLa','Y','2019-02-04 07:29:54',0),(10,'GERRY',NULL,'CONRADO','45434354354','2018-12-20','gmconrado@gmail.com','Gconrado','$2y$10$LsEtBkfaAGtqWSBUFm1wg.r6GvaCNo.jkzSbIJxUyXHZ7gNS3uc6y','2018-12-19 07:38:35','2018-12-19 08:59:09','tgwf5DcEq76gS4GLTZqqxBqEIGcekkX0cvf4MNLa','N','2019-01-02 05:57:18',1),(14,'DONA','','GADEM','34343434343','2018-12-26','donagadem@test.com','dona','$2y$10$UeAeXgU9su96gTAqr..IeO/lTyOoR1BxPIIJkRlMg71TKkTEBE.5S','2018-12-26 06:06:43',NULL,'So4po9Y2Snx6t2WNzjiAkfYMOCHN1Y7Tyu5SLVAR','N','2019-01-17 03:10:16',0),(15,'JULY','','TEST','23443434343','2018-12-26','july@test.com','july','$2y$10$UeAeXgU9su96gTAqr..IeO/lTyOoR1BxPIIJkRlMg71TKkTEBE.5S','2018-12-26 07:39:03',NULL,'IghrfYyy6jofochLEPsiKfaSKsemDRrKgb5xB4gt',NULL,NULL,0);

/*Table structure for table `temp_sched` */

DROP TABLE IF EXISTS `temp_sched`;

CREATE TABLE `temp_sched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet` varchar(120) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `brand` varchar(25) DEFAULT NULL,
  `dr_no` varchar(25) DEFAULT NULL,
  `category` varchar(5) DEFAULT NULL,
  `no_of_box` int(10) DEFAULT NULL,
  `series` varchar(25) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `form_no` int(15) DEFAULT NULL,
  `is_printed` char(2) DEFAULT 'N',
  `si_no` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `temp_sched` */

insert  into `temp_sched`(`id`,`outlet`,`address`,`amount`,`brand`,`dr_no`,`category`,`no_of_box`,`series`,`date_created`,`form_no`,`is_printed`,`si_no`) values (1,'FISHERMALL','#42 GENERAL LIM STREET.,',23676.27,'omg','20605','O',9,'1234','2019-01-18 02:51:16',3263,'Y',NULL);

/* Procedure structure for procedure `trip_ticket` */

/*!50003 DROP PROCEDURE IF EXISTS  `trip_ticket` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `trip_ticket`(`form_no` VARCHAR(15))
BEGIN
	
	
  SET  @sql_text = CONCAT(
		" 
		SELECT c.`name` driver,d.`name` helper,a.`plate_no`,a.`form_series_no`,a.`contact`,a.`date_delivery`,a.`area` AS load_area,a.time AS time_outgoing,
b.`outlet`,b.`address`,b.`amount`,b.`brand`,b.`dr_no`,b.`category` AS classificication,b.`no_of_box`,b.`series` AS series_no
FROM tbl_main  a inner join temp_sched b on b.`form_no` = a.`form_series_no`
left join tbl_driver_helper c on c.`id` = a.`driver`
LEFT JOIN tbl_driver_helper d ON d.`id` = a.`helper`
where a.`form_series_no`=",form_no,"
		");
  PREPARE stmt FROM @sql_text;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt; 
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
