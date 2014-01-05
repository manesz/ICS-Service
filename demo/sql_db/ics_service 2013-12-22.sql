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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `company` */

insert  into `company`(`id`,`name_th`,`name_en`,`address_th`,`address_en`,`telephone`,`fax`,`email`,`image`,`remark`,`create_datetime`,`update_datetime`,`publish`) values (00000000001,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-12-18 15:11:45','2013-12-18 16:25:56',0),(00000000002,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-12-18 15:19:58','2013-12-18 16:26:05',0),(00000000003,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-12-18 15:21:40','2013-12-18 16:27:40',0),(00000000004,'test','test','test','test','test','test','test',NULL,'test','2013-12-18 15:22:15','2013-12-18 16:28:47',0),(00000000005,'','','','','','','','uploads/company/20131218-153808-image-4726c46f45.jpg','','2013-12-18 15:38:08','2013-12-18 16:25:08',0),(00000000006,'6','6','6','6','6','6','6','uploads/company/20131218-161051-image-newaccents.png','6','2013-12-18 15:49:50','2013-12-18 16:10:51',1),(00000000007,'2','2','22','2','2','2','2','','2','2013-12-18 15:57:59','2013-12-18 16:33:04',1),(00000000008,'','','','','','','','','','2013-12-18 16:00:32','2013-12-18 16:03:44',0),(00000000009,'2','2','2','2','2','2222','axe_sad@hotmail.com','','2','2013-12-18 16:04:46','2013-12-18 16:04:59',0);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `device` */

insert  into `device`(`id`,`name`,`model`,`brand`,`type`,`image`,`datesheet`,`create_datetime`,`update_datetime`,`publish`) values (00000000001,'1','2','3','4','','','2013-12-19 11:15:56','2013-12-19 11:39:41',0),(00000000002,'1','','3','4','uploads/device/20131219-151851-image-12247_577460655603156_1848189957_n.jpg','','2013-12-19 11:40:05','2013-12-19 15:18:51',1);

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
  `image` text,
  `permission` varchar(2) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `member` */

insert  into `member`(`id`,`first_name`,`last_name`,`telephone`,`mobile`,`email`,`username`,`password`,`image`,`permission`,`create_datetime`,`update_datetime`,`publish`) values (00000000001,'Wararit','Satitnimankan','027477635','0846727423','wararit.s@ideacorners.com','manesz','b59c67bf196a4758191e42f76670ceba','',NULL,'2013-11-28 23:18:58','2013-12-19 10:35:35','1'),(00000000002,'rux','rux','-','0812345678','ruxchuk@gmail.com','rux','81dc9bdb52d04dc20036dbd8313ed055','uploads/member/20131219-152431-image-6110_476732965698341_331073758_n.jpg',NULL,NULL,'2013-12-19 15:24:31','1'),(00000000003,'admin','admin','-','-','admin@test.com','admin','e10adc3949ba59abbe56e057f20f883e','uploads/member/20131219-152542-image-120753rgu8rd8ud03gf3gr.jpg',NULL,NULL,'2013-12-19 15:25:56','1'),(00000000004,'test','test','-','-','test@test.com','admin','e10adc3949ba59abbe56e057f20f883e','',NULL,'2013-12-19 10:06:38','2013-12-19 11:41:54','0'),(00000000005,'','','','','','admin','e10adc3949ba59abbe56e057f20f883e','',NULL,'2013-12-19 21:19:39','2013-12-19 21:19:53','1'),(00000000006,'','','','','','admin','e10adc3949ba59abbe56e057f20f883e','',NULL,'2013-12-19 21:24:17','2013-12-19 21:27:53','1'),(00000000007,'','','','','','admin','e10adc3949ba59abbe56e057f20f883e','',NULL,'2013-12-19 21:24:53','0000-00-00 00:00:00','1');

/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `publish` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `module` */

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
