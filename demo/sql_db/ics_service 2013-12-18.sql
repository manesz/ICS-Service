/*
SQLyog Ultimate v9.63 
MySQL - 5.1.50-community : Database - ics_service
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ics_service` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ics_service`;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name_th` varchar(120) DEFAULT NULL,
  `name_en` varchar(120) DEFAULT NULL,
  `address_th` text,
  `address_en` text,
  `telephone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `image` text,
  `remark` text,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `company` */

/*Table structure for table `company_device` */

DROP TABLE IF EXISTS `company_device`;

CREATE TABLE `company_device` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  `company_id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `serial` varchar(120) DEFAULT NULL,
  `remark` text,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `company_device` */

/*Table structure for table `company_history` */

DROP TABLE IF EXISTS `company_history`;

CREATE TABLE `company_history` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  `service_type` varchar(120) DEFAULT NULL,
  `priority` tinyint(2) DEFAULT NULL COMMENT '1=report, 2=comment',
  `company_id` int(11) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `company_history` */

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `model` varchar(120) DEFAULT NULL,
  `brand` varchar(120) DEFAULT NULL,
  `type` varchar(120) DEFAULT NULL,
  `image` text,
  `datesheet` text,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `device` */

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `first_name` varchar(120) DEFAULT NULL,
  `last_name` varchar(120) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `permission` varchar(2) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `member` */

insert  into `member`(`id`,`first_name`,`last_name`,`telephone`,`mobile`,`email`,`username`,`password`,`permission`,`create_datetime`,`update_datetime`,`publish`) values (00000000001,'Wararit','Satitnimankan','027477635','0846727423','wararit.s@ideacorners.com','manesz','1111','1','2013-11-28 23:18:58','2013-11-28 23:19:01','1'),(00000000002,'rux','rux',NULL,NULL,NULL,'rux','e10adc3949ba59abbe56e057f20f883e','1',NULL,NULL,'1'),(00000000003,'admin','admin',NULL,NULL,'admin@test.com','admin','e10adc3949ba59abbe56e057f20f883e','1',NULL,NULL,'1');

/*Table structure for table `report_company` */

DROP TABLE IF EXISTS `report_company`;

CREATE TABLE `report_company` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  `warning_type` varchar(120) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `remark` text,
  `create_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `report_company` */

/*Table structure for table `report_image` */

DROP TABLE IF EXISTS `report_image`;

CREATE TABLE `report_image` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `path` text,
  `report_id` int(11) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `publish` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `report_image` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
