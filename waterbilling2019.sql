CREATE DATABASE  IF NOT EXISTS `waterbilling2019` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `waterbilling2019`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: waterbilling2019
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account_classes`
--

DROP TABLE IF EXISTS `account_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_classes` (
  `account_class_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_class` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `account_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` date DEFAULT '0000-00-00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`account_class_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_classes`
--

LOCK TABLES `account_classes` WRITE;
/*!40000 ALTER TABLE `account_classes` DISABLE KEYS */;
INSERT INTO `account_classes` VALUES (1,'Current Assets','',1,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(2,'Non-Current Assets','',1,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(3,'Current Liabilities','',2,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(4,'Long-term Liabilities','',2,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(5,'Owners Equity','',3,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(6,'Operating Expense','',5,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0'),(7,'Income','',4,'0000-00-00 00:00:00','0000-00-00','0000-00-00 00:00:00',0,0,0,'','\0');
/*!40000 ALTER TABLE `account_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_integration`
--

DROP TABLE IF EXISTS `account_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_integration` (
  `integration_id` int(11) NOT NULL,
  `input_tax_account_id` bigint(20) DEFAULT '0',
  `payable_account_id` bigint(20) DEFAULT '0',
  `payable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_to_supplier_id` bigint(20) DEFAULT '0',
  `output_tax_account_id` bigint(20) DEFAULT '0',
  `receivable_account_id` bigint(20) DEFAULT '0',
  `receivable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_from_customer_id` bigint(20) DEFAULT '0',
  `retained_earnings_id` bigint(20) DEFAULT '0',
  `petty_cash_account_id` int(11) DEFAULT '0',
  `sales_invoice_inventory` bit(1) DEFAULT NULL,
  `depreciation_expense_debit_id` bigint(20) DEFAULT '0',
  `depreciation_expense_credit_id` bigint(20) DEFAULT '0',
  `cash_invoice_debit_id` bigint(20) DEFAULT '0',
  `cash_invoice_credit_id` bigint(20) DEFAULT '0',
  `cash_invoice_inventory` bit(1) DEFAULT NULL,
  `dispatching_invoice_inventory` bit(1) DEFAULT b'0',
  `supplier_wtax_account_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`integration_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_integration`
--

LOCK TABLES `account_integration` WRITE;
/*!40000 ALTER TABLE `account_integration` DISABLE KEYS */;
INSERT INTO `account_integration` VALUES (1,55,16,57,2,55,5,57,1,18,3,'',7,8,1,NULL,'','\0',62);
/*!40000 ALTER TABLE `account_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_titles`
--

DROP TABLE IF EXISTS `account_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_titles` (
  `account_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(75) DEFAULT '',
  `account_title` varchar(755) DEFAULT '',
  `account_class_id` int(11) DEFAULT '0',
  `parent_account_id` int(11) DEFAULT '0',
  `grand_parent_id` int(11) DEFAULT '0',
  `description` varchar(1000) DEFAULT '',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_titles`
--

LOCK TABLES `account_titles` WRITE;
/*!40000 ALTER TABLE `account_titles` DISABLE KEYS */;
INSERT INTO `account_titles` VALUES (1,'1000','Cash on Hand',1,0,1,'','2018-04-18 11:47:31','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(2,'1100','Cash in Bank - GRB',1,0,2,'','2018-04-18 11:47:48','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(3,'1100','Petty Cash Fund',1,0,3,'','2018-04-18 11:48:04','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(4,'1120','Revolving Fund',1,0,4,'','2018-04-18 11:48:50','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(5,'1200','Account Receivable',1,0,5,'','2018-04-18 11:49:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(6,'1210','Account Receivable OTH',1,0,6,'','2018-04-18 11:49:33','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(7,'1300','Furniture and Fixture',2,0,7,'','2018-04-18 11:50:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(8,'1301','Accumulative Depreciation',2,0,8,'','2018-04-18 11:50:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(9,'1400','Service Vehicles',2,0,9,'','2018-04-18 11:51:11','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(10,'1500','Kitchen Equipment',2,0,10,'','2018-04-18 11:51:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(11,'1600','Computer and Electronic Equipment',2,0,11,'','2018-04-18 11:52:23','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(12,'1700','Appliances and Other Electronic Gadgets',2,0,12,'','2018-04-18 11:52:57','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(13,'2000','Liability',3,0,13,'','2018-04-18 11:53:13','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(14,'2001','Long Term Loan',3,0,14,'','2018-04-18 11:53:34','2018-04-18 11:53:44','0000-00-00 00:00:00',1,1,0,'','\0'),(15,'2002','Short Term Loan',3,0,15,'','2018-04-18 11:54:10','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(16,'2200','Account Payable - Trade Supplier',3,0,16,'','2018-04-18 11:54:41','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(17,'3000','Capital - Equity',5,0,17,'','2018-04-18 11:55:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(18,'3010','Retained Earnings',5,0,18,'','2018-04-18 11:55:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(19,'4000','Sales',7,0,19,'','2018-04-18 12:03:37','2018-07-18 09:23:39','0000-00-00 00:00:00',1,1,0,'','\0'),(20,'4010','Other Income',7,0,20,'','2018-04-18 12:04:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(21,'4020','Mini Bar Sales',7,0,21,'','2018-04-18 12:04:33','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(22,'4030','Event Income',7,0,22,'','2018-04-18 12:04:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(23,'4040','Function Income',7,0,23,'','2018-04-18 12:05:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(24,'5000','Expenses',6,0,24,'','2018-04-18 12:05:42','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(25,'5010','Labor',6,0,25,'','2018-04-18 12:06:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(26,'5020','Repair and Maintenance',6,0,26,'','2018-04-18 12:06:35','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(27,'5030','Salaries and Wages - Admin',6,0,27,'','2018-04-18 12:06:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(28,'5031','Salaries and Wages - Agency and Security',6,0,28,'','2018-04-18 12:07:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(29,'5032','Salaries and Wages - Hotel Personnel',6,0,29,'','2018-04-18 12:07:45','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(30,'5040','Office Supplies',6,0,30,'','2018-04-18 12:08:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(31,'5050','Commissions - Massage / Vehicle',6,0,31,'','2018-04-18 12:08:32','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(32,'5060','Gas and Oil',6,0,32,'','2018-04-18 12:09:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(33,'5070','Telephone and Communication and Internet',6,0,33,'','2018-04-18 12:09:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(34,'5080','Garbage Expense and Sewerage',6,0,34,'','2018-04-18 12:09:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(35,'5090','Water Consumption',6,0,35,'','2018-04-18 12:10:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(36,'5100','Miscellaneous Expense',6,0,36,'','2018-04-18 12:10:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(37,'5200','Construction Maintenance',6,0,37,'','2018-04-18 12:10:58','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(38,'5300','Utility Expenses and Plumbing',6,0,38,'','2018-04-18 12:11:21','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(39,'5400','Janitorial Expense',6,0,39,'','2018-04-18 12:11:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(40,'550','Rental and Occupancy Expense',6,0,40,'','2018-04-18 12:12:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(41,'5600','Purchases and Wet Market Purchases',6,0,41,'','2018-04-18 12:12:37','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(42,'5700','Groceries',6,0,42,'','2018-04-18 12:12:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(43,'5800','Hotel Supplies',6,0,43,'','2018-04-18 12:12:59','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(44,'5900','Toiletries',6,0,44,'','2018-04-18 12:13:08','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(45,'5901','Donation and Contribution',6,0,45,'','2018-06-05 01:27:06','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(46,'t01','Cash Advances',1,0,46,'','2018-06-20 14:20:18','0000-00-00 00:00:00','2018-10-03 17:36:19',1,0,1,'',''),(47,'t02','Check Advances',1,0,47,'','2018-06-20 14:20:31','0000-00-00 00:00:00','2018-10-03 17:36:21',1,0,1,'',''),(48,'t03','Card Advances',1,0,48,'','2018-06-20 14:20:45','0000-00-00 00:00:00','2018-10-03 17:36:24',1,0,1,'',''),(49,'t04','Charge Advances',1,0,49,'','2018-06-20 14:20:58','0000-00-00 00:00:00','2018-10-03 17:36:26',1,0,1,'',''),(50,'tr05','Advance Bank Deposit',1,0,50,'','2018-06-20 14:21:13','0000-00-00 00:00:00','2018-10-03 17:36:28',1,0,1,'',''),(51,'t06','Advance Sales',7,0,51,'','2018-06-20 14:22:15','0000-00-00 00:00:00','2018-10-03 17:36:32',1,0,1,'',''),(52,'100','Bank - Check',1,0,52,'','2018-06-20 14:23:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(53,'110','Bank - Card',1,0,53,'','2018-06-20 14:23:45','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(54,'130','Bank  -Bank Deposit',1,0,54,'','2018-06-20 14:24:01','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(55,'2010','Tax',1,0,55,'','2018-07-10 16:21:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(56,'2011','INVENTORY',1,0,56,'','2018-07-18 09:00:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(57,'5902','Discounts',6,0,57,'','2018-07-31 09:26:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(58,'101','Bank - Current BDO ACT#9837459879',1,0,58,'','2018-08-07 10:13:50','2018-08-07 11:00:28','0000-00-00 00:00:00',1,1,0,'','\0'),(59,'1200-1','Accounts Receivable  - Trade',1,5,5,'','2018-08-07 10:15:27','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(60,'5903','Training Expense',6,0,60,'','2018-08-07 10:21:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(61,'5903','Electric and Power Consumption',6,0,61,'','2018-08-07 10:59:56','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(62,'2300','Withholding Tax Payable',3,0,62,'','2018-10-11 09:25:24','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0');
/*!40000 ALTER TABLE `account_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_types` (
  `account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(155) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  PRIMARY KEY (`account_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` VALUES (1,'Asset',''),(2,'Liability',''),(3,'Capital',''),(4,'Income',''),(5,'Expense','');
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_year`
--

DROP TABLE IF EXISTS `account_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_year` (
  `account_year_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_year` varchar(100) DEFAULT '',
  `description` varchar(755) DEFAULT '',
  `status` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `closed_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`account_year_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_year`
--

LOCK TABLES `account_year` WRITE;
/*!40000 ALTER TABLE `account_year` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounting_period`
--

DROP TABLE IF EXISTS `accounting_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting_period` (
  `accounting_period_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `period_start` date DEFAULT '0000-00-00',
  `period_end` date DEFAULT '0000-00-00',
  `closed_by_user` bigint(20) DEFAULT '0',
  `date_time_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `remarks` varchar(1000) DEFAULT '',
  PRIMARY KEY (`accounting_period_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting_period`
--

LOCK TABLES `accounting_period` WRITE;
/*!40000 ALTER TABLE `accounting_period` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounting_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_info`
--

DROP TABLE IF EXISTS `adjustment_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_info` (
  `adjustment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adjustment_code` varchar(75) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `adjustment_type` varchar(20) DEFAULT 'IN',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) unsigned zerofill DEFAULT '000000000000000000.00',
  `date_adjusted` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT NULL,
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `pos_is_received` bit(1) DEFAULT b'0',
  `is_for_pos` bit(1) DEFAULT b'0',
  `is_journal_posted` tinyint(1) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `is_returns` bit(1) DEFAULT b'0',
  `inv_no` varchar(145) DEFAULT '',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`adjustment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_info`
--

LOCK TABLES `adjustment_info` WRITE;
/*!40000 ALTER TABLE `adjustment_info` DISABLE KEYS */;
INSERT INTO `adjustment_info` VALUES (1,'ADJ-20181017-1',1,'','IN',0.00,600.00,600.00,000000000000000000.00,'2018-10-17','2018-10-17 14:46:15','2018-10-17 06:46:15',NULL,1,0,0,'','\0','\0','\0',0,0,0,'\0','','',0,'\0'),(2,'ADJ-20181017-2',1,'','IN',0.00,360.00,360.00,000000000000000000.00,'2018-10-17','2018-10-17 14:46:27','2019-01-03 07:41:35',NULL,1,0,0,'','\0','\0','\0',0,0,0,'\0','','Close po',1,''),(3,'ADJ-20181218-3',2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et\ndolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\nex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore\neu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia\ndeserunt mollit anim id est laborum.\n','IN',0.00,116.25,120.00,000000000000000003.75,'2018-12-18','2018-12-18 09:02:21','2018-12-18 01:11:54',NULL,1,1,0,'','\0','\0','\0',1,46,0,'\0','','',0,'\0'),(4,'ADJ-20190103-4',1,'','IN',0.00,1000.00,1120.00,000000000000000120.00,'2019-01-03','2019-01-03 11:46:15','2019-01-03 07:40:37',NULL,1,0,0,'','\0','\0','\0',0,0,0,'\0','','123',1,''),(5,'ADJ-20190103-5',1,'','OUT',0.00,1000.00,1120.00,000000000000000120.00,'2019-01-03','2019-01-03 11:47:25','2019-01-03 04:11:28',NULL,1,0,0,'','\0','\0','\0',1,56,0,'\0','','',0,'\0'),(6,'ADJ-20190306-6',2,'','IN',0.00,1000.00,1120.00,000000000000000120.00,'2019-03-06','2019-03-06 09:43:56','2019-03-06 01:44:51',NULL,1,0,0,'','\0','\0','\0',0,0,0,'\0','','Rafael Manalo',1,'');
/*!40000 ALTER TABLE `adjustment_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adjustment_items`
--

DROP TABLE IF EXISTS `adjustment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adjustment_items` (
  `adjustment_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adjustment_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `adjust_qty` decimal(20,2) DEFAULT '0.00',
  `adjust_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `adjust_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`adjustment_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_items`
--

LOCK TABLES `adjustment_items` WRITE;
/*!40000 ALTER TABLE `adjustment_items` DISABLE KEYS */;
INSERT INTO `adjustment_items` VALUES (1,1,1,1,1,5.00,120.0000,0.0000,0.0000,600.0000,0.0000,0.0000,600.0000,'0000-00-00',''),(2,2,1,0,2,30.00,12.0000,0.0000,0.0000,360.0000,0.0000,0.0000,360.0000,'0000-00-00',''),(7,3,3,1,1,1.00,85.0000,0.0000,0.0000,85.0000,0.0000,0.0000,85.0000,'0000-00-00',''),(8,3,4,1,1,1.00,35.0000,0.0000,12.0000,35.0000,0.0000,3.7500,31.2500,'0000-00-00',''),(9,4,6,1,1,1.00,1120.0000,0.0000,12.0000,1120.0000,0.0000,120.0000,1000.0000,'0000-00-00',''),(10,5,6,1,1,1.00,1120.0000,0.0000,12.0000,1120.0000,0.0000,120.0000,1000.0000,'0000-00-00',''),(11,6,6,1,1,1.00,1120.0000,0.0000,12.0000,1120.0000,0.0000,120.0000,1000.0000,'0000-00-00','');
/*!40000 ALTER TABLE `adjustment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_status`
--

DROP TABLE IF EXISTS `approval_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approval_status` (
  `approval_id` int(11) NOT NULL AUTO_INCREMENT,
  `approval_status` varchar(100) DEFAULT '',
  `approval_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`approval_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_status`
--

LOCK TABLES `approval_status` WRITE;
/*!40000 ALTER TABLE `approval_status` DISABLE KEYS */;
INSERT INTO `approval_status` VALUES (1,'Approved','','','\0'),(2,'Pending','','','\0');
/*!40000 ALTER TABLE `approval_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_property_status`
--

DROP TABLE IF EXISTS `asset_property_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_property_status` (
  `asset_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_property_status` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`asset_status_id`) USING BTREE,
  UNIQUE KEY `asset_property_id` (`asset_status_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_property_status`
--

LOCK TABLES `asset_property_status` WRITE;
/*!40000 ALTER TABLE `asset_property_status` DISABLE KEYS */;
INSERT INTO `asset_property_status` VALUES (1,'Active',1,0),(2,'Inactive',1,0),(3,'Obsolete',1,0),(4,'Lost',1,0),(5,'Damage',1,0);
/*!40000 ALTER TABLE `asset_property_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(20) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_type` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` VALUES (1,'Security Bank','Security Bank','234234234234234',1,1,0),(2,'Banco De Oro','Banco De Oro','5645345632342',1,1,0),(3,'Maybank','Maybank','Maybank',1,1,0),(4,'GRB','GRB','GRB',1,1,0);
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_reconciliation`
--

DROP TABLE IF EXISTS `bank_reconciliation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_reconciliation` (
  `bank_recon_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) DEFAULT '0',
  `date_reconciled` date DEFAULT '0000-00-00',
  `reconciled_by` int(11) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `account_balance` decimal(10,0) DEFAULT '0',
  `bank_service_charge` decimal(10,0) DEFAULT '0',
  `nsf_check` decimal(10,0) DEFAULT '0',
  `check_printing_charge` decimal(10,0) DEFAULT '0',
  `interest_earned` decimal(10,0) DEFAULT '0',
  `notes_receivable` decimal(10,0) DEFAULT '0',
  `actual_balance` decimal(10,0) DEFAULT '0',
  `outstanding_checks` decimal(10,0) DEFAULT '0',
  `deposit_in_transit` decimal(10,0) DEFAULT '0',
  `journal_adjusted_collection` decimal(10,0) DEFAULT '0',
  `bank_adjusted_collection` decimal(10,0) DEFAULT '0',
  PRIMARY KEY (`bank_recon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation`
--

LOCK TABLES `bank_reconciliation` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation` DISABLE KEYS */;
INSERT INTO `bank_reconciliation` VALUES (1,NULL,'2018-10-16',1,2,322310,0,0,0,0,0,235960,86350,172700,0,0),(2,NULL,'2018-10-16',1,2,322310,0,0,0,0,0,372660,50350,0,0,0),(3,NULL,'2018-10-16',1,2,322310,100,15000,150,23,15,321310,51712,37500,0,0),(4,NULL,'2018-10-18',1,2,322310,0,0,0,0,0,322870,560,0,0,0);
/*!40000 ALTER TABLE `bank_reconciliation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_reconciliation_details`
--

DROP TABLE IF EXISTS `bank_reconciliation_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_reconciliation_details` (
  `bank_recon_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_recon_id` int(11) DEFAULT '0',
  `journal_id` int(11) DEFAULT '0',
  `check_status` int(11) DEFAULT '0' COMMENT '0 = no selected\n1 = outstanding\n2 = good check',
  PRIMARY KEY (`bank_recon_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation_details`
--

LOCK TABLES `bank_reconciliation_details` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation_details` DISABLE KEYS */;
INSERT INTO `bank_reconciliation_details` VALUES (1,1,33,0),(2,1,34,2),(3,1,35,1),(4,1,27,1),(5,1,30,1),(6,1,36,0),(7,1,26,NULL),(8,2,34,2),(9,2,33,2),(10,2,35,1),(11,2,27,1),(12,2,30,1),(13,2,36,2),(14,2,26,2),(15,3,34,2),(16,3,33,1),(17,3,35,1),(18,3,27,1),(19,3,30,1),(20,3,36,1),(21,3,26,2),(22,4,8,1);
/*!40000 ALTER TABLE `bank_reconciliation_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `batch_info`
--

DROP TABLE IF EXISTS `batch_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batch_info` (
  `batch_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `batch_no` varchar(75) DEFAULT '',
  `date_replenished` datetime DEFAULT '0000-00-00 00:00:00',
  `replenished_by` int(11) DEFAULT '0',
  PRIMARY KEY (`batch_id`) USING BTREE,
  UNIQUE KEY `batch_id` (`batch_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batch_info`
--

LOCK TABLES `batch_info` WRITE;
/*!40000 ALTER TABLE `batch_info` DISABLE KEYS */;
INSERT INTO `batch_info` VALUES (1,'PCVB-20181217-1','2018-12-17 12:18:30',1);
/*!40000 ALTER TABLE `batch_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `brand_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`brand_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'NONE','\0','');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `card_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_code` varchar(100) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`card_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_invoice`
--

DROP TABLE IF EXISTS `cash_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_invoice` (
  `cash_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cash_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `email_address` varchar(75) DEFAULT NULL,
  `contact_no` varchar(75) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  `for_dispatching` bit(1) DEFAULT b'0',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`cash_invoice_id`) USING BTREE,
  UNIQUE KEY `cash_inv_no` (`cash_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice`
--

LOCK TABLES `cash_invoice` WRITE;
/*!40000 ALTER TABLE `cash_invoice` DISABLE KEYS */;
INSERT INTO `cash_invoice` VALUES (1,'CI-INV-20181029-1',0,'',1,1,NULL,2,40,0,'',0.0000,0.0000,0.0000,150.0000,133.9300,16.0700,150.0000,'2018-10-29','2018-10-29','2018-10-29 11:55:32','0000-00-00 00:00:00','2019-02-06 06:13:17',1,0,0,'\0','','\0','',0,1,1,'Various Customers','Various Customers',NULL,NULL,0,0,'\0','',0,'\0'),(2,'CI-INV-20181217-2',0,'',1,1,NULL,2,50,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.0000,0.0000,0.0000,175.0000,169.6400,5.3600,175.0000,'2018-12-17','2018-12-17','2018-12-17 11:53:58','0000-00-00 00:00:00','2019-02-06 06:13:17',1,0,1,'\0','','\0','',0,1,2,'Various Customers','Various Customers',NULL,NULL,0,0,'\0','',0,'\0'),(3,'CI-INV-20181228-3',0,'',1,2,NULL,3,0,0,'',0.0000,0.0000,0.0000,50.0000,44.6400,5.3600,50.0000,'2018-12-28','2018-12-28','2018-12-28 15:26:11','0000-00-00 00:00:00','2019-02-06 06:13:17',1,0,0,'\0','','\0','\0',0,1,2,'Cristina Joy Punzalan1','Cristina Joy Punzalan',NULL,NULL,0,0,'\0','Close Sales',1,''),(4,'CI-INV-20190103-4',0,'',1,1,NULL,2,58,0,'12',0.0000,0.0000,0.0000,200.0000,178.5700,21.4300,200.0000,'2019-01-03','2019-01-03','2019-01-03 11:51:59','0000-00-00 00:00:00','2019-02-06 06:13:17',1,0,0,'\0','','\0','',0,1,2,'Various Customers Various Customers Various Customers Various Customers Various Customers Various Customers','Various Customers',NULL,NULL,0,0,'\0','',0,'\0');
/*!40000 ALTER TABLE `cash_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_invoice_items`
--

DROP TABLE IF EXISTS `cash_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_invoice_items` (
  `cash_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cash_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`cash_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice_items`
--

LOCK TABLES `cash_invoice_items` WRITE;
/*!40000 ALTER TABLE `cash_invoice_items` DISABLE KEYS */;
INSERT INTO `cash_invoice_items` VALUES (1,1,4,1,1,150.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,150.0000,150.0000,16.0714,133.9286,150.0000,NULL,NULL,'0000-00-00',''),(3,2,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,50.0000,50.0000,5.3600,44.6400,50.0000,NULL,NULL,'0000-00-00',''),(4,2,3,1,1,125.0000,0.0000,0.0000,0.0000,0.0000,0.0000,1.00,125.0000,125.0000,0.0000,125.0000,125.0000,NULL,NULL,'0000-00-00',''),(5,3,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,50.0000,50.0000,5.3600,44.6400,50.0000,NULL,NULL,'0000-00-00',''),(6,4,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,200.0000,200.0000,21.4300,178.5700,200.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `cash_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_code` bigint(20) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Hardware','Hardware',NULL,'0000-00-00 00:00:00','\0',''),(2,NULL,'DRINKS','DRINKS ',NULL,'0000-00-00 00:00:00','\0',''),(3,NULL,'FASHION','FASHION',NULL,'0000-00-00 00:00:00','\0',''),(4,NULL,'FOOD','FOOD',NULL,'0000-00-00 00:00:00','\0','');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `charge_unit`
--

DROP TABLE IF EXISTS `charge_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charge_unit` (
  `charge_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `charge_unit_name` varchar(255) DEFAULT NULL,
  `charge_unit_desc` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`charge_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charge_unit`
--

LOCK TABLES `charge_unit` WRITE;
/*!40000 ALTER TABLE `charge_unit` DISABLE KEYS */;
INSERT INTO `charge_unit` VALUES (1,'Unit1123123','1312312','',''),(2,'Meter','Meter','\0',''),(3,'Pcs','Pcs','\0',''),(4,'House','House','\0','');
/*!40000 ALTER TABLE `charge_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `charges`
--

DROP TABLE IF EXISTS `charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charges` (
  `charge_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `charge_code` varchar(255) DEFAULT NULL,
  `charge_desc` varchar(255) DEFAULT NULL,
  `charge_unit_id` varchar(255) DEFAULT NULL,
  `charge_amount` decimal(25,2) DEFAULT '0.00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`charge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charges`
--

LOCK TABLES `charges` WRITE;
/*!40000 ALTER TABLE `charges` DISABLE KEYS */;
INSERT INTO `charges` VALUES (1,'12','12','3',12.00,'','',0,7,0),(2,'1232','1231','3',10.00,'','',0,7,0),(3,'CC-01','Connection Charge','2',1500.00,'','\0',0,0,0),(4,'CC-02','Disconnection Charge','2',1750.00,'','\0',0,0,0),(5,'CC-03','Reconnection Charge','2',1350.00,'','\0',0,0,0),(6,'CC-04','Yearly Maintenance','4',500.00,'','\0',0,0,0);
/*!40000 ALTER TABLE `charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `chat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `chat_code` varchar(150) DEFAULT '0',
  `message` varchar(160) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`chat_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `check_layout`
--

DROP TABLE IF EXISTS `check_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `check_layout` (
  `check_layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `check_layout` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `particular_pos_left` decimal(20,0) DEFAULT '0',
  `particular_pos_top` decimal(20,0) DEFAULT '0',
  `particular_font_family` varchar(555) DEFAULT 'Tahoma',
  `particular_font_size` varchar(20) DEFAULT '12pt',
  `particular_is_italic` varchar(55) DEFAULT 'normal',
  `particular_is_bold` varchar(55) DEFAULT 'bold',
  `words_pos_left` decimal(20,4) DEFAULT '0.0000',
  `words_pos_top` decimal(20,4) DEFAULT '0.0000',
  `words_font_family` varchar(555) DEFAULT 'Tahoma',
  `words_font_size` varchar(20) DEFAULT '12pt',
  `words_is_italic` varchar(55) DEFAULT 'normal',
  `words_is_bold` varchar(55) DEFAULT 'bold',
  `amount_pos_left` decimal(20,4) DEFAULT '0.0000',
  `amount_pos_top` decimal(20,4) DEFAULT '0.0000',
  `amount_font_family` varchar(555) DEFAULT '',
  `amount_font_size` varchar(20) DEFAULT '12pt',
  `amount_is_italic` varchar(55) DEFAULT 'normal',
  `amount_is_bold` varchar(20) DEFAULT 'bold',
  `date_pos_left` decimal(20,4) DEFAULT '0.0000',
  `date_pos_top` decimal(20,4) DEFAULT '0.0000',
  `date_font_family` varchar(555) DEFAULT '',
  `date_font_size` varchar(20) DEFAULT '12pt',
  `date_is_italic` varchar(55) DEFAULT 'normal',
  `date_is_bold` varchar(55) DEFAULT 'bold',
  `is_portrait` bit(1) DEFAULT b'1',
  `posted_by_user` bigint(20) DEFAULT '0',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` bigint(20) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` bigint(20) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`check_layout_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `check_layout`
--

LOCK TABLES `check_layout` WRITE;
/*!40000 ALTER TABLE `check_layout` DISABLE KEYS */;
INSERT INTO `check_layout` VALUES (1,'Security Bank','',47,832,'Tahoma','16px','normal','bold',46.7500,868.7190,'Tahoma','16px','normal','bold',527.6250,826.6250,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold',529.7030,792.6410,'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif','16px','normal','bold','',1,'2017-09-13 11:47:30',0,'2018-10-11 14:50:25',0,'0000-00-00 00:00:00','','\0');
/*!40000 ALTER TABLE `check_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `civil_status`
--

DROP TABLE IF EXISTS `civil_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `civil_status` (
  `civil_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `civil_status_name` varchar(145) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`civil_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `civil_status`
--

LOCK TABLES `civil_status` WRITE;
/*!40000 ALTER TABLE `civil_status` DISABLE KEYS */;
INSERT INTO `civil_status` VALUES (1,'Single','','\0'),(2,'Married','','\0'),(3,'Widowed','','\0'),(4,'Divorced','','\0'),(5,'Separated','','\0');
/*!40000 ALTER TABLE `civil_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_info` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(555) DEFAULT '',
  `company_address` varchar(755) DEFAULT '',
  `email_address` varchar(155) DEFAULT '',
  `mobile_no` varchar(125) DEFAULT '',
  `landline` varchar(125) DEFAULT '',
  `tin_no` varchar(55) DEFAULT NULL,
  `tax_type_id` int(11) DEFAULT '0',
  `registered_to` varchar(555) DEFAULT '',
  `logo_path` varchar(555) DEFAULT '',
  `rdo_no` varchar(55) DEFAULT NULL,
  `nature_of_business` varchar(155) DEFAULT NULL,
  `business_type` int(11) DEFAULT NULL,
  `registered_address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `telephone_no` varchar(255) DEFAULT NULL,
  `industry_classification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_info`
--

LOCK TABLES `company_info` WRITE;
/*!40000 ALTER TABLE `company_info` DISABLE KEYS */;
INSERT INTO `company_info` VALUES (1,'Friendship Plaza Waterworks','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','jdevtechsolution@gmail.com',' 0955-283-3018','(045) 900-3988 ','469299358000',1,'JDEV OFFICE SOLUTIONS INC.','assets/img/company/5bc9278a2b363.jpg','057','Service',1,'4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009','9003988 ','Service');
/*!40000 ALTER TABLE `company_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_types`
--

DROP TABLE IF EXISTS `contract_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_types` (
  `contract_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_type_name` varchar(145) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`contract_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_types`
--

LOCK TABLES `contract_types` WRITE;
/*!40000 ALTER TABLE `contract_types` DISABLE KEYS */;
INSERT INTO `contract_types` VALUES (1,'Residential','','\0'),(2,'Commercial','','\0');
/*!40000 ALTER TABLE `contract_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_photos`
--

DROP TABLE IF EXISTS `customer_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`photo_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_photos`
--

LOCK TABLES `customer_photos` WRITE;
/*!40000 ALTER TABLE `customer_photos` DISABLE KEYS */;
INSERT INTO `customer_photos` VALUES (1,1,'assets/img/anonymous-icon.png'),(3,3,'assets/img/anonymous-icon.png'),(4,4,'assets/img/anonymous-icon.png'),(5,5,'assets/img/anonymous-icon.png'),(6,6,'assets/img/anonymous-icon.png'),(7,7,'assets/img/anonymous-icon.png'),(8,8,'assets/img/anonymous-icon.png'),(9,2,'assets/img/anonymous-icon.png'),(10,9,'assets/img/anonymous-icon.png'),(11,10,'assets/img/anonymous-icon.png'),(17,12,'assets/img/anonymous-icon.png'),(18,11,'assets/img/anonymous-icon.png'),(19,13,NULL),(20,14,NULL),(21,15,NULL);
/*!40000 ALTER TABLE `customer_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_type` (
  `customer_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_type_name` varchar(145) DEFAULT NULL,
  `customer_type_description` varchar(145) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_type`
--

LOCK TABLES `customer_type` WRITE;
/*!40000 ALTER TABLE `customer_type` DISABLE KEYS */;
INSERT INTO `customer_type` VALUES (1,'Wholesaler','Wholesaler','','\0'),(2,'Dealer','Dealer','','\0'),(3,'Distributor','Distributor','','\0'),(4,'Reseller','Reseller','','\0');
/*!40000 ALTER TABLE `customer_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pos_customer_id` bigint(20) DEFAULT '0',
  `hotel_customer_id` bigint(20) DEFAULT '0',
  `customer_code` varchar(255) DEFAULT '',
  `customer_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(100) DEFAULT '',
  `term` varchar(100) DEFAULT '',
  `customer_type_id` bigint(20) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `link_department_id` int(11) DEFAULT '0',
  `refcustomertype_id` bigint(20) DEFAULT '0',
  `tin_no` varchar(100) DEFAULT '',
  `photo_path` varchar(500) DEFAULT '',
  `total_receivable_amount` decimal(19,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `credit_limit` decimal(20,4) DEFAULT '0.0000',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `ceiling_amount` decimal(20,4) DEFAULT '0.0000',
  `spouse_nationality_id` int(11) DEFAULT '0',
  `spouse_occupation` varchar(445) DEFAULT '',
  `spouse_name` varchar(145) DEFAULT '',
  `tenant_birth_date` date DEFAULT '0000-00-00',
  `sex_id` int(11) DEFAULT '0',
  `civil_status_id` int(11) DEFAULT '0',
  `nationality_id` int(11) DEFAULT '0',
  `date_move_in` date DEFAULT '0000-00-00',
  `tenant_occupation` varchar(445) DEFAULT '',
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,0,0,'','N/A','N/A','N/A','N/A','N/A',NULL,0,NULL,0,NULL,'N/A','assets/img/anonymous-icon.png',2350.00,'2018-10-03 17:18:41','0000-00-00 00:00:00','0000-00-00 00:00:00',1,NULL,0,0,'\0','\0','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(2,0,0,'','Various Customers','Various Customers','Various Customers Various Customers Various Customers Various Customers Various Customers Various Customers','Various Customers','Various Customers',NULL,0,NULL,0,NULL,'Various Customers','assets/img/anonymous-icon.png',550.00,'2018-10-03 17:20:20','2018-12-19 10:19:39','0000-00-00 00:00:00',1,NULL,1,0,'\0','\0','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(3,0,0,'','Cristina Joy Punzalan','Cristina Joy Punzalan','Cristina Joy Punzalan','Cristina Joy Punzalan','Cristina Joy Punzalan',NULL,0,NULL,0,NULL,'Cristina Joy Punzalan','assets/img/anonymous-icon.png',0.00,'2018-10-03 17:34:14','0000-00-00 00:00:00','0000-00-00 00:00:00',1,NULL,0,0,'\0','\0','',150.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(4,0,0,'','asd','asd','asd','asd','asd',NULL,0,NULL,0,NULL,'asd','assets/img/anonymous-icon.png',0.00,'2018-10-04 09:39:43','0000-00-00 00:00:00','2018-10-11 10:35:53',1,NULL,0,1,'\0','','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(5,0,0,'','1','','1','','',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2018-10-04 12:15:58','0000-00-00 00:00:00','2018-10-11 10:35:57',1,NULL,0,1,'\0','','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(6,0,0,'','123','123123123','123123123','12312312','31223123',NULL,0,NULL,0,NULL,'13212323','assets/img/anonymous-icon.png',0.00,'2018-10-04 12:16:07','0000-00-00 00:00:00','2018-10-11 10:36:00',1,NULL,0,1,'\0','','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(7,0,0,'','qwe','qwe','qwe','e','qwe',NULL,1,NULL,0,NULL,'wqe','assets/img/anonymous-icon.png',0.00,'2018-10-04 13:31:37','0000-00-00 00:00:00','2018-10-11 10:36:03',1,NULL,0,1,'\0','','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(8,0,0,'','deleted','deleted','deleted','deleted','deleted',NULL,1,NULL,0,NULL,'deleted','assets/img/anonymous-icon.png',0.00,'2018-11-15 11:06:17','0000-00-00 00:00:00','2018-11-15 11:06:20',1,NULL,0,1,'\0','','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(9,0,0,'','Sales Invoice','None','None','','656545452',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2019-02-18 14:04:56','0000-00-00 00:00:00','0000-00-00 00:00:00',1,NULL,0,0,'\0','\0','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(10,0,0,'','Sales Order','None','None','','09009238',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2019-02-18 14:07:27','0000-00-00 00:00:00','0000-00-00 00:00:00',1,NULL,0,0,'\0','\0','',0.0000,0,'','','0000-00-00',0,0,0,'0000-00-00',''),(11,0,0,'','Rafael Manalo','Gladys Manalo','Villa Gloria Angeles City','manaloraf03@gmail.com','09453158563',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2019-05-08 14:26:33','2019-05-08 15:07:14','0000-00-00 00:00:00',7,NULL,7,0,'\0','\0','',0.0000,1,'Junior Accountant','Gladys D. Manalo','2019-05-11',1,2,1,'2019-05-24','Software Developer'),(12,0,0,'','Erick Pecson','Jason Patawaran','Balibago Angeles City','erick.pecson@yahoo.com','092365498532',NULL,0,NULL,0,NULL,'','assets/img/anonymous-icon.png',0.00,'2019-05-08 14:28:06','2019-05-08 15:05:48','0000-00-00 00:00:00',7,NULL,7,0,'\0','\0','',0.0000,0,'','','2019-05-21',1,1,1,'2019-05-29','Programmer'),(13,0,0,'','Joash Jezreel L. Noble','Noel M. Noble','5069 Malabanias Road Abacan St. Angeles City','noblejjoash@gmail.com','09067819374',NULL,0,NULL,0,NULL,'0012547785',NULL,0.00,'2019-05-09 10:41:30','0000-00-00 00:00:00','0000-00-00 00:00:00',8,NULL,0,0,'\0','\0','',0.0000,0,'','','1996-11-23',1,1,1,'2019-05-10','Programmer'),(14,0,0,'','sadsa','','sad','','',NULL,0,NULL,0,NULL,'',NULL,0.00,'2019-05-09 10:44:05','0000-00-00 00:00:00','0000-00-00 00:00:00',8,NULL,0,0,'\0','\0','',0.0000,0,'','','1970-01-01',1,0,0,'1970-01-01',''),(15,0,0,'','Jason Patawaran','','Angeles City','','',NULL,0,NULL,0,NULL,'',NULL,0.00,'2019-05-15 17:10:13','0000-00-00 00:00:00','0000-00-00 00:00:00',8,NULL,0,0,'\0','\0','',0.0000,0,'','','1970-01-01',1,0,0,'1970-01-01','');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_invoice`
--

DROP TABLE IF EXISTS `delivery_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_invoice` (
  `dr_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dr_invoice_no` varchar(75) DEFAULT '',
  `purchase_order_id` int(11) DEFAULT '0',
  `external_ref_no` varchar(75) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(75) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `date_due` date DEFAULT '0000-00-00',
  `date_delivered` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `batch_no` varchar(50) DEFAULT NULL,
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`dr_invoice_id`) USING BTREE,
  UNIQUE KEY `dr_invoice_no` (`dr_invoice_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice`
--

LOCK TABLES `delivery_invoice` WRITE;
/*!40000 ALTER TABLE `delivery_invoice` DISABLE KEYS */;
INSERT INTO `delivery_invoice` VALUES (1,'P-INV-20181017-1',0,'','','','',1,1,1,0,'',0.0000,256021.4300,30578.5700,286600.0000,0.0000,0.0000,286600.0000,'','','\0','\0','2018-10-17','2018-09-01','2018-10-17 14:42:56','2018-11-05 00:44:06','2018-11-05 08:44:06',1,1,1,NULL,'',0,'\0'),(2,'P-INV-20181017-2',0,'','','','',1,1,NULL,0,'',0.0000,600.0000,0.0000,600.0000,0.0000,0.0000,600.0000,'','','\0','\0','2018-10-17','2018-09-01','2018-10-17 14:43:07','2018-11-05 00:44:29','2018-11-05 08:44:29',1,1,1,NULL,'',0,'\0'),(3,'P-INV-20181017-3',0,'','','','',1,1,1,0,'',0.0000,600.0000,0.0000,600.0000,0.0000,0.0000,600.0000,'','','\0','\0','2018-10-17','2018-10-17','2018-10-17 14:44:12','2018-11-05 03:46:25','2018-11-05 11:46:25',1,0,1,NULL,'',0,'\0'),(4,'P-INV-20181018-4',0,'','NCR Construction Supply','','',4,1,1,0,'',3500.0000,25312.5000,3037.5000,31500.0000,10.0000,3150.0000,28350.0000,'','','\0','\0','2018-10-18','2018-10-18','2018-10-18 15:14:40','2018-11-05 03:45:46','2018-11-05 11:45:46',1,1,1,NULL,'',0,'\0'),(5,'P-INV-20181023-5',6,'','12','12','',1,2,1,0,'',6.0000,63.4800,7.6200,71.1000,10.0000,7.9000,71.1000,'','','\0','\0','2018-10-23','2018-10-23','2018-10-23 10:25:28','2018-11-05 04:10:17','2018-11-05 12:10:17',1,1,1,NULL,'',0,'\0'),(6,'P-INV-20181023-6',7,'','','','',1,1,NULL,0,'',3.5000,25.3100,3.0400,28.3500,10.0000,3.1500,28.3500,'','\0','\0','\0','2018-10-23','2018-10-23','2018-10-23 10:49:08','2018-10-23 02:49:08','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(7,'P-INV-20181105-7',0,'','Don\'s Original Spanish Original Churros','','',3,1,1,0,'',0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:42:20','2018-11-05 00:42:20','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(8,'P-INV-20181105-8',0,'','','','',1,1,1,0,'',0.0000,31.2500,3.7500,35.0000,0.0000,0.0000,35.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:42:25','2018-11-05 00:42:25','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(9,'P-INV-20181105-9',0,'','Owners','','',2,1,1,0,'',0.0000,1000.0000,120.0000,1120.0000,0.0000,0.0000,1120.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:42:32','2018-11-05 00:42:32','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(10,'P-INV-20181105-10',0,'','NCR Construction Supply','','',4,2,2,0,'',0.0000,31.2500,3.7500,35.0000,0.0000,0.0000,35.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:42:38','2018-11-05 00:42:38','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(11,'P-INV-20181105-11',0,'','JAMM Fire Extinguisher Enterprise','','',6,4,1,0,'',0.0000,1000.0000,120.0000,1120.0000,0.0000,0.0000,1120.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:42:50','2018-11-05 00:42:50','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(12,'P-INV-20181105-12',0,'','Owners','','',2,3,1,0,'',0.0000,1150.0000,120.0000,1270.0000,0.0000,0.0000,1270.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:43:46','2018-11-05 00:43:46','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(13,'P-INV-20181105-13',0,'','','','',1,2,1,0,'',0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 08:44:23','2018-11-05 00:44:23','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(14,'P-INV-20181105-14',0,'','Don\'s Original Spanish Original Churros','','',3,2,1,0,'',0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,'','\0','\0','\0','2018-11-05','2018-11-05','2018-11-05 11:45:39','2019-01-03 08:24:39','0000-00-00 00:00:00',1,0,0,NULL,'closed due to already recorded',1,''),(15,'P-INV-20181105-15',0,'','','','',1,4,1,42,'',0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,'','\0','\0','','2018-11-05','2018-11-05','2018-11-05 11:46:14','2018-12-11 06:55:09','0000-00-00 00:00:00',1,0,0,NULL,'',0,'\0'),(16,'P-INV-20181105-16',0,'','Owners','','',2,2,1,49,' sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.0000,25632.1400,3057.8600,28690.0000,0.0000,0.0000,28690.0000,'','\0','\0','','2018-11-05','2018-11-05','2018-11-05 12:10:06','2018-12-18 02:26:25','0000-00-00 00:00:00',1,1,0,NULL,'',0,'\0'),(17,'P-INV-20190103-17',0,'','','','',1,1,1,0,'',0.0000,1000.0000,120.0000,1120.0000,0.0000,0.0000,1120.0000,'','\0','\0','\0','2019-01-03','2019-01-03','2019-01-03 11:50:36','2019-01-03 08:21:52','0000-00-00 00:00:00',1,0,0,NULL,'Clsing Remarks DR',1,'');
/*!40000 ALTER TABLE `delivery_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_invoice_items`
--

DROP TABLE IF EXISTS `delivery_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_invoice_items` (
  `dr_invoice_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `dr_qty` decimal(20,2) DEFAULT '0.00',
  `dr_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_price` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`dr_invoice_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice_items`
--

LOCK TABLES `delivery_invoice_items` WRITE;
/*!40000 ALTER TABLE `delivery_invoice_items` DISABLE KEYS */;
INSERT INTO `delivery_invoice_items` VALUES (4,2,1,0,2,50.00,0.0000,12.0000,0.0000,600.0000,0.0000,0.0000,600.0000,600.0000,'1970-01-01',NULL),(5,3,1,1,1,5.00,0.0000,120.0000,0.0000,600.0000,0.0000,0.0000,600.0000,600.0000,'1970-01-01',NULL),(12,4,4,1,1,1000.00,10.0000,35.0000,3500.0000,31500.0000,12.0000,3037.5000,25312.5000,28350.0000,'1970-01-01',NULL),(15,5,4,1,1,1.00,10.0000,35.0000,3.5000,31.5000,12.0000,3.0400,25.3100,28.3500,'1970-01-01',NULL),(16,5,5,1,1,1.00,5.0000,50.0000,2.5000,47.5000,12.0000,4.5800,38.1700,42.7500,'1970-01-01',NULL),(17,6,4,1,1,1.00,10.0000,35.0000,3.5000,31.5000,12.0000,3.0400,25.3100,28.3500,'1970-01-01',NULL),(18,7,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(19,8,4,1,1,1.00,0.0000,35.0000,0.0000,35.0000,12.0000,3.7500,31.2500,35.0000,'1970-01-01',NULL),(20,9,6,1,1,1.00,0.0000,1120.0000,0.0000,1120.0000,12.0000,120.0000,1000.0000,1120.0000,'1970-01-01',NULL),(21,10,4,1,1,1.00,0.0000,35.0000,0.0000,35.0000,12.0000,3.7500,31.2500,35.0000,'1970-01-01',NULL),(22,11,6,1,1,1.00,0.0000,1120.0000,0.0000,1120.0000,12.0000,120.0000,1000.0000,1120.0000,'1970-01-01',NULL),(27,1,1,1,1,10.00,0.0000,120.0000,0.0000,1200.0000,0.0000,0.0000,1200.0000,1200.0000,'1970-01-01',NULL),(28,1,2,1,1,10.00,0.0000,28540.0000,0.0000,285400.0000,12.0000,30578.5700,254821.4300,285400.0000,'1970-01-01',NULL),(29,12,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(30,12,6,1,1,1.00,0.0000,1120.0000,0.0000,1120.0000,12.0000,120.0000,1000.0000,1120.0000,'1970-01-01',NULL),(31,13,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(32,14,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(33,15,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(38,16,1,1,1,1.00,0.0000,150.0000,0.0000,150.0000,0.0000,0.0000,150.0000,150.0000,'1970-01-01',NULL),(39,16,2,1,1,1.00,0.0000,28540.0000,0.0000,28540.0000,12.0000,3057.8600,25482.1400,28540.0000,'1970-01-01',NULL),(40,17,6,1,1,1.00,0.0000,1120.0000,0.0000,1120.0000,12.0000,120.0000,1000.0000,1120.0000,'1970-01-01',NULL);
/*!40000 ALTER TABLE `delivery_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(20) DEFAULT '',
  `department_name` varchar(255) DEFAULT '',
  `department_desc` varchar(255) DEFAULT '',
  `delivery_address` varchar(755) DEFAULT '',
  `default_cost` tinyint(4) DEFAULT '1' COMMENT '1=Purchase Cost 1, 2=Purchase Cost 2',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`department_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'','Admin','','',1,'2018-10-03 17:08:47','0000-00-00 00:00:00','\0',''),(2,'','Accounting','Accounting',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(3,'','Human Resources','Human Resources',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(4,'','IT ','IT ',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(5,'','Restaurant','Restaurant',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(6,'','Purchasing','Purchasing',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(7,'','Audio Visual','Audio Visual',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(8,'','Treasury','Treasury',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(9,'','Maintenance','Maintenance',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(10,'','qwe','qwe',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(11,'',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(12,'','qwe','qwe',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0','');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depreciation_expense`
--

DROP TABLE IF EXISTS `depreciation_expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `depreciation_expense` (
  `de_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `de_date` date NOT NULL,
  `de_expense_total` decimal(20,4) NOT NULL,
  `de_remarks` text NOT NULL,
  `de_ref_no` varchar(75) NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_journal_posted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`de_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depreciation_expense`
--

LOCK TABLES `depreciation_expense` WRITE;
/*!40000 ALTER TABLE `depreciation_expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `depreciation_expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `discount_id` bigint(100) NOT NULL AUTO_INCREMENT,
  `discount_code` bigint(100) DEFAULT NULL,
  `discount_type` varchar(200) DEFAULT NULL,
  `discount_desc` varchar(200) DEFAULT NULL,
  `discount_percent` bigint(100) DEFAULT NULL,
  `discount_amount` bigint(100) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`discount_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatching_invoice`
--

DROP TABLE IF EXISTS `dispatching_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatching_invoice` (
  `dispatching_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dispatching_inv_no` varchar(75) DEFAULT '',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `sales_inv_no` varchar(245) DEFAULT '',
  `cash_invoice_id` bigint(20) DEFAULT '0',
  `cash_inv_no` varchar(245) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`dispatching_invoice_id`) USING BTREE,
  UNIQUE KEY `dispatching_inv_no` (`dispatching_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice`
--

LOCK TABLES `dispatching_invoice` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice` DISABLE KEYS */;
INSERT INTO `dispatching_invoice` VALUES (1,'DIS-INV-20181217-1',1,'SAL-INV-20181017-1',0,'',1,1,NULL,1,0,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.0000,0.0000,0.0000,2100.0000,2100.0000,0.0000,2100.0000,'2018-10-17','2018-10-17','2018-12-17 12:07:52','0000-00-00 00:00:00','2018-12-17 04:07:52',1,0,0,'\0','','\0','\0',0,1,NULL,'N/A','N/A',0,0);
/*!40000 ALTER TABLE `dispatching_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatching_invoice_items`
--

DROP TABLE IF EXISTS `dispatching_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatching_invoice_items` (
  `dispatching_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dispatching_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`dispatching_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice_items`
--

LOCK TABLES `dispatching_invoice_items` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice_items` DISABLE KEYS */;
INSERT INTO `dispatching_invoice_items` VALUES (1,1,1,1,1,210.0000,0.0000,0.0000,0.0000,0.0000,0.0000,10.00,2100.0000,2100.0000,0.0000,2100.0000,2100.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `dispatching_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_settings`
--

DROP TABLE IF EXISTS `email_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_settings` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email_from` varchar(150) NOT NULL,
  `name_from` varchar(50) NOT NULL,
  `default_message` varchar(500) NOT NULL,
  `email_to` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_settings`
--

LOCK TABLES `email_settings` WRITE;
/*!40000 ALTER TABLE `email_settings` DISABLE KEYS */;
INSERT INTO `email_settings` VALUES (1,'manaloraf03@gmail.com','xxseunghyunk216','','JDEV IT BUSINESS SOLUTION','This is the Default message from the Accounting System of JDEV Office Solutions',NULL),(2,'jdevofficesolutioninc@gmail.com','!jdev123*','','JDEV OFFICE SOLUTION INC','This is a system generation report sent to you from the Accounting System of JDEV Office Solution Inc.','manaloraf03@gmail.com');
/*!40000 ALTER TABLE `email_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fixed_assets`
--

DROP TABLE IF EXISTS `fixed_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fixed_assets` (
  `fixed_asset_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(55) DEFAULT '',
  `asset_description` varchar(555) DEFAULT '',
  `serial_no` varchar(155) DEFAULT '',
  `location_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `acquisition_cost` decimal(20,4) DEFAULT '0.0000',
  `salvage_value` decimal(20,4) DEFAULT '0.0000',
  `life_years` int(11) DEFAULT '0',
  `asset_status_id` int(11) DEFAULT '0',
  `date_acquired` date DEFAULT '0000-00-00',
  `remarks` varchar(1000) DEFAULT NULL,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`fixed_asset_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixed_assets`
--

LOCK TABLES `fixed_assets` WRITE;
/*!40000 ALTER TABLE `fixed_assets` DISABLE KEYS */;
INSERT INTO `fixed_assets` VALUES (1,'AC101','ACER Projector 10,000 Lamp Hours','2212835484275100',1,1,1,23580.0000,10.0000,2,1,'2018-10-11','','2018-10-11 11:05:32',1,'2018-10-11 11:07:55',1,'0000-00-00 00:00:00',0,0,1),(2,'AC102','Ford Everest Company Car','38796734512101',2,1,1,600000.0000,10.0000,5,1,'2018-10-11','','2018-10-11 11:06:21',1,'2018-10-11 11:08:01',1,'0000-00-00 00:00:00',0,0,1),(3,'AC103','Mio Motorcycle Delivery','000238428980',2,6,1,45000.0000,10.0000,0,1,'2018-10-11','','2018-10-11 11:07:45',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,0,1);
/*!40000 ALTER TABLE `fixed_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_2307`
--

DROP TABLE IF EXISTS `form_2307`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_2307` (
  `form_2307_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `journal_id` bigint(20) DEFAULT '0',
  `supplier_id` bigint(20) DEFAULT '0',
  `txn_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT '0000-00-00',
  `payee_tin` varchar(145) DEFAULT NULL,
  `payee_name` varchar(245) DEFAULT NULL,
  `payee_address` varchar(445) DEFAULT NULL,
  `payor_name` varchar(245) DEFAULT NULL,
  `payor_tin` varchar(145) DEFAULT NULL,
  `payor_address` varchar(445) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `gross_amount` decimal(20,2) DEFAULT '0.00',
  `deducted_amount` decimal(20,2) DEFAULT '0.00',
  `date_created` date DEFAULT '0000-00-00',
  `created_by_user` bigint(20) DEFAULT '0',
  `date_deleted` date DEFAULT '0000-00-00',
  `deleted_by_user` bigint(20) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  `atc` varchar(255) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`form_2307_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_2307`
--

LOCK TABLES `form_2307` WRITE;
/*!40000 ALTER TABLE `form_2307` DISABLE KEYS */;
INSERT INTO `form_2307` VALUES (1,26,4,'TXN-20181008-26','2018-10-08','NCR Construction Supply','NCR Construction Supply','NCR Construction Supply','JDEV OFFICE SOLUTIONS INC.','','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,15000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 157','Payments made by government offices on their purchases of goods and services from local/resident suppliers.'),(2,27,5,'TXN-20181008-27','2018-10-08','469299358000','Jenra Supermarket','Jenra Supermarket Angeles City','JDEV OFFICE SOLUTIONS INC.','377339368000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,85000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 010','Professional / Talent fees paid to juridical persons / individuals (Lawyers, cpas, etc.) if current year\'s gross income does not exceed P720,000.00'),(3,29,3,'TXN-20181008-29','2018-10-08','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','JDEV OFFICE SOLUTIONS INC.','','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City',NULL,10000.00,1000.00,'2018-10-08',1,'0000-00-00',0,1,0,'WI 157','Payments made by government offices on their purchases of goods and services from local / resident suppliers.'),(4,40,3,'TXN-20181018-40','2018-10-18','453369315000','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',200000.00,1000.00,'2018-10-18',1,'0000-00-00',0,1,0,'WI 010','Payments made by government offices on their purchases of goods and services from local/resident suppliers.'),(5,38,1,'TXN-20181025-38','2018-10-25','','N/A','','JDEV OFFICE SOLUTIONS INC.','469299358000','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009',1700.00,200.00,'2018-10-25',1,'0000-00-00',0,1,0,'250','Trial');
/*!40000 ALTER TABLE `form_2307` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_2551m`
--

DROP TABLE IF EXISTS `form_2551m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_2551m` (
  `form_2551m_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT '0000-00-00',
  `payor_tin` varchar(255) DEFAULT NULL,
  `payor_name` varchar(255) DEFAULT NULL,
  `payor_address` varchar(255) DEFAULT NULL,
  `rdo_no` varchar(255) DEFAULT NULL,
  `nature_of_business` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `telephone_no` varchar(255) DEFAULT NULL,
  `month_id` int(11) DEFAULT '0',
  `year` bigint(20) DEFAULT '0',
  `taxable_amount` decimal(20,5) DEFAULT '0.00000',
  `tax_rate` decimal(20,5) DEFAULT '0.00000',
  `tax_due` decimal(20,5) DEFAULT '0.00000',
  `industry_classification` varchar(255) DEFAULT NULL,
  `atc` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT '0000-00-00',
  `date_modified` date DEFAULT '0000-00-00',
  `date_deleted` date DEFAULT '0000-00-00',
  `created_by_user` int(12) DEFAULT '0',
  `modified_by_user` int(12) DEFAULT '0',
  `deleted_by_user` int(12) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`form_2551m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_2551m`
--

LOCK TABLES `form_2551m` WRITE;
/*!40000 ALTER TABLE `form_2551m` DISABLE KEYS */;
INSERT INTO `form_2551m` VALUES (1,'2018-10-18','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',10,2018,2100.00000,3.00000,63.00000,'Service','w310','2018-10-18','2018-10-25','0000-00-00',1,1,0,'','\0'),(2,'2018-09-18','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',9,2018,208060.00000,3.00000,6241.80000,'Service','PT 010','2018-09-18','0000-00-00','0000-00-00',1,0,0,'','\0'),(3,'2018-10-22','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',8,2018,68058.00000,3.00000,2041.74000,'Service','PT 101','2018-10-22','0000-00-00','0000-00-00',1,0,0,'','\0'),(4,'2018-10-24','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',1,2018,249050.00000,3.00000,7471.50000,'Service','PT 123','2018-10-24','0000-00-00','0000-00-00',1,0,0,'','\0'),(5,'2018-10-24','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',2,2018,122500.00000,3.00000,3675.00000,'Service','PT 100','2018-10-24','0000-00-00','0000-00-00',1,0,0,'','\0'),(6,'2018-10-24','469299358000','JDEV OFFICE SOLUTIONS INC.','4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','057','Service','2009','9003988 ',3,2018,52370.00000,3.00000,1571.10000,'Service','PT 103','2018-10-24','0000-00-00','0000-00-00',1,0,0,'','\0');
/*!40000 ALTER TABLE `form_2551m` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generics`
--

DROP TABLE IF EXISTS `generics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generics` (
  `generic_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `generic_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`generic_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generics`
--

LOCK TABLES `generics` WRITE;
/*!40000 ALTER TABLE `generics` DISABLE KEYS */;
/*!40000 ALTER TABLE `generics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giftcards`
--

DROP TABLE IF EXISTS `giftcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftcards` (
  `giftcard_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `giftcard_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`giftcard_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giftcards`
--

LOCK TABLES `giftcards` WRITE;
/*!40000 ALTER TABLE `giftcards` DISABLE KEYS */;
/*!40000 ALTER TABLE `giftcards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_items`
--

DROP TABLE IF EXISTS `hotel_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_items` (
  `hotel_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(45) DEFAULT NULL,
  `department_id` bigint(45) DEFAULT '0',
  `sales_date` datetime DEFAULT '0000-00-00 00:00:00',
  `shift` varchar(45) DEFAULT '0',
  `adv_cash` decimal(20,5) DEFAULT '0.00000',
  `adv_check` decimal(20,5) DEFAULT '0.00000',
  `adv_card` decimal(20,5) DEFAULT '0.00000',
  `adv_charge` decimal(20,5) DEFAULT '0.00000',
  `adv_bank` decimal(20,5) DEFAULT '0.00000',
  `cash_amount` decimal(20,5) DEFAULT '0.00000',
  `check_amount` decimal(20,5) DEFAULT '0.00000',
  `card_amount` decimal(20,5) DEFAULT '0.00000',
  `charge_amount` decimal(20,5) DEFAULT '0.00000',
  `bank_amount` decimal(20,5) DEFAULT '0.00000',
  `room_sales` decimal(20,5) DEFAULT '0.00000',
  `bar_sales` decimal(20,5) DEFAULT '0.00000',
  `other_sales` decimal(20,5) DEFAULT '0.00000',
  `advance_sales` decimal(20,5) DEFAULT '0.00000',
  `is_posted` tinyint(1) DEFAULT '0',
  `posted_by` bigint(20) DEFAULT '0',
  `posted_date` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id` bigint(20) DEFAULT '0',
  `file_path` varchar(245) DEFAULT '',
  PRIMARY KEY (`hotel_items_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_items`
--

LOCK TABLES `hotel_items` WRITE;
/*!40000 ALTER TABLE `hotel_items` DISABLE KEYS */;
INSERT INTO `hotel_items` VALUES (1,'ADV',2,'2018-03-20 00:00:00','06 AM - 02 PM',8700.00000,2250.00000,1000.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,11950.00000,0,0,'0000-00-00 00:00:00',0,'POLV-03202018.jdev'),(2,'ADV',2,'2018-04-17 00:00:00','06 AM - 02 PM',10700.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,10700.00000,1,1,'2018-04-17 11:11:27',1,'POLV-04172018.jdev'),(3,'COUT',2,'2018-04-17 00:00:00','06 AM - 02 PM',0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,1700.00000,0.00000,0.00000,1700.00000,1,1,'2018-04-17 11:11:39',3,'POLV-04172018.jdev'),(4,'REV',2,'2018-04-17 00:00:00','06 AM - 02 PM',1700.00000,0.00000,0.00000,0.00000,0.00000,1700.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,1,1,'2018-04-17 11:11:32',2,'POLV-04172018.jdev');
/*!40000 ALTER TABLE `hotel_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_settings`
--

DROP TABLE IF EXISTS `hotel_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_settings` (
  `hotel_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_cash_id` bigint(20) DEFAULT '0',
  `adv_check_id` bigint(20) DEFAULT '0',
  `adv_card_id` bigint(20) DEFAULT '0',
  `adv_charge_id` bigint(20) DEFAULT '0',
  `adv_bank_id` bigint(20) DEFAULT '0',
  `cash_id` bigint(20) DEFAULT '0',
  `check_id` bigint(20) DEFAULT '0',
  `card_id` bigint(20) DEFAULT '0',
  `charge_id` bigint(20) DEFAULT '0',
  `bank_id` bigint(20) DEFAULT '0',
  `room_sales_id` bigint(20) DEFAULT '0',
  `bar_sales_id` bigint(20) DEFAULT '0',
  `other_sales_id` bigint(20) DEFAULT '0',
  `adv_sales_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`hotel_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_settings`
--

LOCK TABLES `hotel_settings` WRITE;
/*!40000 ALTER TABLE `hotel_settings` DISABLE KEYS */;
INSERT INTO `hotel_settings` VALUES (2,51,51,52,50,25,4,33,50,49,52,17,19,37,38,17),(3,1,1,1,1,1,1,2,1,5,2,1,1,1,1,5),(4,NULL,NULL,NULL,NULL,NULL,1,2,1,5,2,1,1,1,NULL,3),(5,NULL,NULL,NULL,NULL,NULL,1,2,1,5,2,1,1,1,NULL,2);
/*!40000 ALTER TABLE `hotel_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initial_setup`
--

DROP TABLE IF EXISTS `initial_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initial_setup` (
  `initial_setup_id` int(11) NOT NULL,
  `setup_company_info` bit(1) DEFAULT NULL,
  `setup_general_configuration` bit(1) DEFAULT NULL,
  `setup_user_account` bit(1) DEFAULT NULL,
  `setup_complete` bit(1) DEFAULT NULL,
  PRIMARY KEY (`initial_setup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initial_setup`
--

LOCK TABLES `initial_setup` WRITE;
/*!40000 ALTER TABLE `initial_setup` DISABLE KEYS */;
INSERT INTO `initial_setup` VALUES (1,'','','','');
/*!40000 ALTER TABLE `initial_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_counter`
--

DROP TABLE IF EXISTS `invoice_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_counter` (
  `counter_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `counter_start` bigint(20) DEFAULT '0',
  `counter_end` bigint(20) DEFAULT '0',
  `last_invoice` bigint(20) DEFAULT '0',
  PRIMARY KEY (`counter_id`) USING BTREE,
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_counter`
--

LOCK TABLES `invoice_counter` WRITE;
/*!40000 ALTER TABLE `invoice_counter` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_department_info`
--

DROP TABLE IF EXISTS `issuance_department_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_department_info` (
  `issuance_department_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trn_no` varchar(75) DEFAULT '',
  `to_department_id` bigint(20) DEFAULT '0',
  `from_department_id` bigint(20) DEFAULT '0',
  `date_issued` date DEFAULT '0000-00-00',
  `terms` varchar(50) DEFAULT NULL,
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted_from` bit(1) DEFAULT b'0',
  `posted_by_from` int(11) DEFAULT '0',
  `date_posted_from` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id_from` bigint(20) DEFAULT '0',
  `is_journal_posted_to` bit(1) DEFAULT b'0',
  `posted_by_to` int(11) DEFAULT '0',
  `date_posted_to` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id_to` bigint(20) DEFAULT '0',
  `closing_reason_from` varchar(445) DEFAULT '',
  `closed_by_user_from` bigint(20) DEFAULT '0',
  `is_closed_from` bit(1) DEFAULT b'0',
  `closing_reason_to` varchar(445) DEFAULT '',
  `closed_by_user_to` bigint(20) DEFAULT '0',
  `is_closed_to` bit(1) DEFAULT b'0',
  PRIMARY KEY (`issuance_department_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_info`
--

LOCK TABLES `issuance_department_info` WRITE;
/*!40000 ALTER TABLE `issuance_department_info` DISABLE KEYS */;
INSERT INTO `issuance_department_info` VALUES (1,'TRN-20181217-1',2,1,'2018-12-17','1','',0.00,625.00,75.00,700.00,'2018-12-17 11:14:43','2019-01-07 01:21:16','0000-00-00 00:00:00',0,1,0,'','\0','\0',0,'0000-00-00 00:00:00',0,'\0',0,'0000-00-00 00:00:00',0,'Closing Due to irrelevant Details',1,'','Closed To',1,''),(2,'TRN-20181218-2',1,4,'2018-12-18','1','sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et\ndolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\nex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore\neu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia\ndeserunt mollit anim id est laborum.',0.00,116.25,3.75,120.00,'2018-12-18 09:09:28','2019-01-03 08:28:02','0000-00-00 00:00:00',1,1,0,'','\0','\0',0,'0000-00-00 00:00:00',0,'',1,'2019-01-03 16:13:01',57,'qwe',1,'','',0,'\0'),(3,'TRN-20190306-3',3,1,'2019-03-06','12','',0.00,1000.00,120.00,1120.00,'2019-03-06 09:43:47','2019-03-06 01:44:56','0000-00-00 00:00:00',0,1,0,'','\0','\0',0,'0000-00-00 00:00:00',0,'\0',0,'0000-00-00 00:00:00',0,'',0,'\0','To',1,'');
/*!40000 ALTER TABLE `issuance_department_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_department_items`
--

DROP TABLE IF EXISTS `issuance_department_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_department_items` (
  `issuance_department_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `issuance_department_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `issue_qty` decimal(20,2) DEFAULT '0.00',
  `issue_price` decimal(20,2) DEFAULT '0.00',
  `issue_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_rate` decimal(11,2) DEFAULT '0.00',
  `issue_line_total_price` decimal(20,2) DEFAULT '0.00',
  `issue_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_amount` decimal(20,2) DEFAULT '0.00',
  `issue_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`issuance_department_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_items`
--

LOCK TABLES `issuance_department_items` WRITE;
/*!40000 ALTER TABLE `issuance_department_items` DISABLE KEYS */;
INSERT INTO `issuance_department_items` VALUES (1,1,4,1,1,20.00,35.00,0.00,12.00,700.00,0.00,75.00,625.00,0,'0000-00-00',''),(9,2,4,1,1,1.00,35.00,0.00,12.00,35.00,0.00,3.75,31.25,0,'0000-00-00',''),(10,2,3,1,1,1.00,85.00,0.00,0.00,85.00,0.00,0.00,85.00,0,'0000-00-00',''),(11,3,6,1,1,1.00,1120.00,0.00,12.00,1120.00,0.00,120.00,1000.00,0,'0000-00-00','');
/*!40000 ALTER TABLE `issuance_department_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_info`
--

DROP TABLE IF EXISTS `issuance_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_info` (
  `issuance_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `slip_no` varchar(75) DEFAULT '',
  `issued_department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `issued_to_person` varchar(155) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_issued` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `customer_id` int(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `terms` varchar(50) DEFAULT NULL,
  `is_for_pos` bit(1) DEFAULT b'0',
  `is_received` bit(1) DEFAULT b'0',
  `is_journal_posted` tinyint(1) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`issuance_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_info`
--

LOCK TABLES `issuance_info` WRITE;
/*!40000 ALTER TABLE `issuance_info` DISABLE KEYS */;
INSERT INTO `issuance_info` VALUES (1,'SLP-20180529-1',4,'','',0.00,3571.42,428.58,4000.00,'2018-05-29','2018-05-29 16:37:54','2018-05-29 08:38:40','0000-00-00 00:00:00',1,1,0,'','\0',NULL,NULL,'12','\0','\0',0,0);
/*!40000 ALTER TABLE `issuance_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issuance_items`
--

DROP TABLE IF EXISTS `issuance_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_items` (
  `issuance_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `issuance_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `issue_qty` decimal(20,2) DEFAULT '0.00',
  `issue_price` decimal(20,2) DEFAULT '0.00',
  `issue_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_rate` decimal(11,2) DEFAULT '0.00',
  `issue_line_total_price` decimal(20,2) DEFAULT '0.00',
  `issue_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_amount` decimal(20,2) DEFAULT '0.00',
  `issue_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`issuance_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_items`
--

LOCK TABLES `issuance_items` WRITE;
/*!40000 ALTER TABLE `issuance_items` DISABLE KEYS */;
INSERT INTO `issuance_items` VALUES (5,1,12,1,5,1.00,2000.00,0.00,12.00,2000.00,0.00,214.29,1785.71,0,'0000-00-00',''),(6,1,12,1,5,1.00,2000.00,0.00,12.00,2000.00,0.00,214.29,1785.71,0,'0000-00-00','');
/*!40000 ALTER TABLE `issuance_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_types`
--

DROP TABLE IF EXISTS `item_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_types` (
  `item_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type_code` varchar(20) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`item_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_types`
--

LOCK TABLES `item_types` WRITE;
/*!40000 ALTER TABLE `item_types` DISABLE KEYS */;
INSERT INTO `item_types` VALUES (1,'IP','Inventory','','','\0'),(2,'NP','Non-inventory','','','\0'),(3,'CP','Services','','','\0');
/*!40000 ALTER TABLE `item_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_accounts`
--

DROP TABLE IF EXISTS `journal_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_accounts` (
  `journal_account_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `journal_id` bigint(20) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `memo` varchar(700) DEFAULT '',
  `dr_amount` decimal(25,2) DEFAULT '0.00',
  `cr_amount` decimal(25,2) DEFAULT '0.00',
  PRIMARY KEY (`journal_account_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_accounts`
--

LOCK TABLES `journal_accounts` WRITE;
/*!40000 ALTER TABLE `journal_accounts` DISABLE KEYS */;
INSERT INTO `journal_accounts` VALUES (1,1,1,'',750000.00,0.00),(2,1,2,'',345800.00,0.00),(3,1,17,'',0.00,1095800.00),(4,2,5,'',37650.00,0.00),(5,2,19,'',0.00,37650.00),(6,3,1,'',96520.00,0.00),(7,3,2,'',96520.00,0.00),(8,3,19,'',0.00,193040.00),(9,4,38,'',63500.00,0.00),(10,4,16,'',0.00,63500.00),(11,5,30,'',13500.00,0.00),(12,5,16,'',0.00,13500.00),(15,7,33,'',5250.00,0.00),(16,7,1,'',0.00,5250.00),(17,8,35,'',560.00,0.00),(18,8,2,'',0.00,560.00),(19,9,36,'',350.00,0.00),(20,9,1,'',0.00,350.00),(21,10,27,'',95000.00,0.00),(22,10,1,'',0.00,45000.00),(23,10,2,'',0.00,50000.00),(24,11,3,'',15000.00,0.00),(25,11,1,'',0.00,15000.00),(26,12,3,'',16000.00,0.00),(27,12,1,'',0.00,16000.00),(28,13,30,'',3500.00,0.00),(29,13,3,'',0.00,3500.00),(30,14,36,'',350.00,0.00),(31,14,3,'',0.00,350.00),(36,15,30,'',900.00,0.00),(37,15,3,'',0.00,900.00),(38,17,1,'',652000.00,0.00),(39,17,17,'',0.00,652000.00),(40,18,1,'',12.00,0.00),(41,18,1,'',0.00,12.00),(42,19,16,'',100000.00,0.00),(43,19,62,'',0.00,1000.00),(44,19,1,'',0.00,99000.00),(45,20,16,'',0.00,100000.00),(46,20,41,'',100000.00,0.00),(47,21,41,'',256400.89,0.00),(48,21,55,'',30624.11,0.00),(49,21,16,'',0.00,287025.00),(50,22,16,'',8000.00,0.00),(51,22,2,'',0.00,7750.00),(52,22,62,'',0.00,250.00),(53,23,1,'',98000.00,0.00),(54,23,19,'',0.00,98000.00),(55,24,1,'',526000.00,0.00),(56,24,19,'',0.00,526000.00),(57,25,1,'',125000.00,0.00),(58,25,17,'',0.00,125000.00),(59,26,2,'',10000.00,0.00),(60,26,19,'',0.00,10000.00),(61,27,41,'',15000.00,0.00),(62,27,2,'',0.00,15000.00),(63,28,3,'',12.00,0.00),(64,28,4,'',0.00,12.00),(65,29,1,'',25000.00,0.00),(66,29,4,'',0.00,25000.00),(67,30,41,'',35000.00,0.00),(68,30,2,'',0.00,35000.00),(69,31,41,'',10000.00,0.00),(70,31,2,'',0.00,10000.00),(71,32,41,'',13000.00,0.00),(72,32,2,'',0.00,13000.00),(73,33,2,'',15000.00,0.00),(74,33,19,'',0.00,15000.00),(75,34,41,'',35000.00,0.00),(76,34,2,'',0.00,35000.00),(77,35,36,'',350.00,0.00),(78,35,2,'',0.00,350.00),(79,36,36,'',1350.00,0.00),(80,36,2,'',0.00,1350.00),(81,37,6,'',10000.00,0.00),(82,37,19,'',0.00,10000.00),(83,38,41,'',1700.00,0.00),(84,38,1,'',0.00,1500.00),(85,38,62,'',0.00,200.00),(86,39,5,'',2100.00,0.00),(87,39,19,'',0.00,2100.00),(88,40,1,'',150.00,0.00),(89,40,19,'',0.00,133.93),(90,40,55,'',0.00,16.07),(91,41,5,'',13500.00,0.00),(92,41,57,'',1500.00,0.00),(93,41,19,'',0.00,15000.00),(94,42,41,'',200.00,0.00),(95,42,16,'',0.00,150.00),(96,42,62,'',0.00,50.00),(97,43,1,'',12.00,0.00),(98,43,1,'',0.00,12.00),(99,16,30,'',750.00,0.00),(100,16,3,'',0.00,750.00),(101,45,3,'',5500.00,0.00),(102,45,1,'',0.00,5500.00),(103,46,41,'',85.00,0.00),(104,46,1,'',0.00,85.00),(105,47,2,'',123.00,0.00),(106,47,4,'',0.00,123.00),(107,48,2,'',121.00,0.00),(108,48,2,'',0.00,121.00),(109,49,41,'',25632.14,0.00),(110,49,55,'',3057.86,0.00),(111,49,16,'',0.00,28690.00),(112,50,1,'',125.00,0.00),(113,50,19,'',0.00,125.00),(114,51,2,'',0.00,12.00),(115,51,5,'',12.00,0.00),(116,52,41,'',37500.00,0.00),(117,52,1,'',0.00,37500.00),(118,53,1,'',0.00,0.00),(119,53,1,'',0.00,0.00),(120,54,1,'',12.00,0.00),(121,54,1,'',0.00,12.00),(122,57,41,'',85.00,0.00),(123,57,33,'',0.00,85.00),(132,60,1,'',12000.00,0.00),(133,60,23,'',0.00,12000.00),(136,59,5,'',12000.00,0.00),(137,59,19,'',0.00,12000.00),(142,61,41,'',11000.00,0.00),(143,61,16,'',0.00,11000.00),(148,62,41,'',13000.00,0.00),(149,62,3,'',0.00,13000.00),(154,63,1,'',13000.00,0.00),(155,63,17,'',0.00,13000.00),(156,64,5,'',250.00,0.00),(157,64,19,'',0.00,223.21),(158,64,55,'',0.00,26.79),(159,65,2,'',22751.08,0.00),(160,65,2,'',0.00,22751.08);
/*!40000 ALTER TABLE `journal_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry_templates`
--

DROP TABLE IF EXISTS `journal_entry_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entry_templates` (
  `entry_template_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_id` bigint(20) DEFAULT '0',
  `account_id` bigint(20) DEFAULT '0',
  `memo` varchar(1000) DEFAULT '',
  `dr_amount` decimal(20,4) DEFAULT '0.0000',
  `cr_amount` decimal(20,4) DEFAULT '0.0000',
  PRIMARY KEY (`entry_template_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_templates`
--

LOCK TABLES `journal_entry_templates` WRITE;
/*!40000 ALTER TABLE `journal_entry_templates` DISABLE KEYS */;
INSERT INTO `journal_entry_templates` VALUES (1,1,33,'',5250.0000,0.0000),(2,1,1,'',0.0000,5250.0000),(3,2,35,'',560.0000,0.0000),(4,2,2,'',0.0000,560.0000),(5,3,36,'',350.0000,0.0000),(6,3,1,'',0.0000,350.0000),(7,4,41,'',35000.0000,0.0000),(8,4,2,'',0.0000,35000.0000);
/*!40000 ALTER TABLE `journal_entry_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_info`
--

DROP TABLE IF EXISTS `journal_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_info` (
  `journal_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `txn_no` varchar(55) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `supplier_id` int(11) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `book_type` varchar(20) DEFAULT '',
  `date_txn` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `payment_method_id` int(11) DEFAULT '0',
  `bank` varchar(10) DEFAULT '',
  `check_no` varchar(20) DEFAULT '',
  `check_date` date DEFAULT '0000-00-00',
  `ref_type` varchar(4) DEFAULT '',
  `ref_no` varchar(25) DEFAULT '',
  `amount` decimal(10,2) DEFAULT '0.00',
  `or_no` varchar(50) DEFAULT '',
  `check_status` tinyint(4) DEFAULT '0',
  `accounting_period_id` bigint(20) DEFAULT '0',
  `is_replenished` tinyint(1) DEFAULT '0',
  `batch_id` int(11) DEFAULT '0',
  `bank_id` int(11) DEFAULT '0',
  `is_reconciled` tinyint(4) DEFAULT '0',
  `is_sales` tinyint(4) DEFAULT '0',
  `pos_integration_id` bigint(20) DEFAULT '0',
  `hotel_integration_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`journal_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_info`
--

LOCK TABLES `journal_info` WRITE;
/*!40000 ALTER TABLE `journal_info` DISABLE KEYS */;
INSERT INTO `journal_info` VALUES (1,'TXN-20181003-1',1,1,0,'','GJE','2018-10-03','2018-10-03 17:37:29',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(2,'TXN-20181003-2',1,3,0,'Recording of Sales - AR','SJE','2018-10-03','2018-10-03 17:38:15',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(3,'TXN-20181003-3',1,2,0,'','CRJ','2018-10-03','2018-10-03 17:40:02',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'',NULL,'1970-01-01','',NULL,193040.00,'',0,0,0,0,NULL,0,0,0,0),(4,'TXN-20181003-4',1,0,4,'','PJE','2018-10-03','2018-10-03 17:41:27',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(5,'TXN-20181003-5',1,0,12,'Office Supplies','PJE','2018-10-03','2018-10-03 17:41:57',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(7,'TXN-20181003-7',1,0,7,'Payment for the Month of September','CDJ','2018-10-03','2018-10-03 17:44:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','001',5250.00,'',0,0,0,0,NULL,0,0,0,0),(8,'TXN-20181003-8',1,0,8,'','CDJ','2018-10-03','2018-10-03 17:45:12',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','342342342423','2018-10-10','CV','002',560.00,'',1,0,0,0,4,1,0,0,0),(9,'TXN-20181003-9',1,0,15,'Delivery Fee','CDJ','2018-10-03','2018-10-03 17:46:01',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','004',350.00,'',0,0,0,0,NULL,0,0,0,0),(10,'TXN-20181003-10',1,0,1,'Recording of Salaries of Admin Personnel for the Month of September ','CDJ','2018-10-03','2018-10-03 17:47:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','005',95000.00,'',0,0,0,0,NULL,0,0,0,0),(11,'TXN-20181003-11',2,0,1,'Setting  up of Petty Cash to Accounting Department','CDJ','2018-10-03','2018-10-03 17:47:58',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','006',15000.00,'',0,0,0,0,NULL,0,0,0,0),(12,'TXN-20181003-12',3,0,1,'Petty Cash for HR','CDJ','2018-10-03','2018-10-03 17:48:40',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','007',16000.00,'',0,0,0,0,NULL,0,0,0,0),(13,'PCV-20181004-13',2,0,12,'Worsheets 15Pcs','PCV','2018-10-04','2018-10-04 08:41:38',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-01',3500.00,'',0,0,0,0,0,0,0,0,0),(14,'PCV-20181004-14',2,0,15,'Delivery Fee ','PCV','2018-10-04','2018-10-04 08:42:35',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-02',350.00,'',0,0,0,0,0,0,0,0,0),(15,'PCV-20181004-15',2,0,5,'Office Snacks and Coffee','PCV','2018-10-04','2018-10-04 08:43:20',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-03',900.00,'',0,0,0,0,0,0,0,0,0),(16,'PCV-20181004-16',2,0,12,'If you do care how the remaining % are split up can you do this dynamically at runtime by taking the total static px (in this example 450px) subtract it from the current width of the table and then use that as a guide to determine the remaining percentages for the columns.\r\nFor example if i had a datatable that was 1000px','PCV','2018-10-04','2018-10-04 08:47:31',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','PCV-04',750.00,'',0,0,0,0,0,0,0,0,0),(17,'TXN-20181004-17',1,0,1,'Capital - Added By Owner','GJE','2018-10-04','2018-10-04 08:59:27',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(18,'TXN-20181004-18',2,3,0,'','GJE','2018-10-04','2018-10-04 13:32:17',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(19,'TXN-20181011-19',1,0,4,'','CDJ','2018-10-11','2018-10-11 09:28:49',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','1005',100000.00,'',0,0,0,0,NULL,0,0,0,0),(20,'TXN-20181011-20',1,0,4,'','GJE','2018-10-10','2018-10-11 09:33:14',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(21,'TXN-20181011-21',1,0,14,'Record Purchases of IT Equipments as Accounts Payable','PJE','2018-10-11','2018-10-11 10:49:58',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','P-INV-20181011-2',0.00,'',0,0,0,0,0,0,0,0,0),(22,'TXN-20181011-22',1,0,12,'Record with Withholding Tax of 250.00','CDJ','2018-10-11','2018-10-11 10:59:40',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01',NULL,NULL,8000.00,'',0,0,0,0,NULL,0,0,0,0),(23,'TXN-20181011-23',1,1,0,'','GJE','2018-10-11','2018-10-11 11:11:02',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(24,'TXN-20181011-24',1,1,0,'','GJE','2018-10-11','2018-10-11 11:11:26',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(25,'TXN-20181011-25',1,1,0,'','GJE','2018-10-01','2018-10-11 11:14:23',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(26,'TXN-20181016-26',1,1,0,'','CRJ','2018-10-16','2018-10-16 08:48:43',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','745983745','2018-10-16','',NULL,10000.00,'43634534',0,0,0,0,4,1,0,0,0),(27,'TXN-20181016-27',1,0,3,'','CDJ','2018-10-16','2018-10-16 08:57:52',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','2234234','2018-10-17','CV','23',15000.00,'',1,0,0,0,4,1,0,0,0),(28,'TXN-20181016-28',1,0,3,'','CDJ','2018-10-16','2018-10-16 09:17:41',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','12',12.00,'',0,0,0,0,NULL,0,0,0,0),(29,'TXN-20181016-29',5,0,4,'','CDJ','2018-10-16','2018-10-16 09:20:42',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','12121','2018-10-31','CV','12',25000.00,'',1,0,0,0,NULL,0,0,0,0),(30,'TXN-20181016-30',2,0,1,'','CDJ','2018-10-16','2018-10-16 13:31:00',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','2312123','2018-10-16','CV','12',35000.00,'',0,0,0,0,NULL,1,0,0,0),(31,'TXN-20181016-31',1,0,1,'','CDJ','2018-10-16','2018-10-16 13:31:32',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2018-10-16 13:33:27',1,'\0','\0',1,'','','1970-01-01','CV','123',10000.00,'',0,0,0,0,NULL,0,0,0,0),(32,'TXN-20181016-32',1,0,1,'','CDJ','2018-10-16','2018-10-16 13:31:52',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'2018-10-16 13:33:25',1,'\0','\0',1,'','','1970-01-01','CV','1212',13000.00,'',0,0,0,0,NULL,0,0,0,0),(33,'TXN-20181016-33',1,3,0,'','CRJ','2018-10-16','2018-10-16 13:32:54',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','131313','2018-10-16','',NULL,12.00,'',0,0,0,0,2,1,0,0,0),(34,'TXN-20181016-34',1,0,1,'','CDJ','2018-10-16','2018-10-16 13:33:21',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','12','1970-01-01','CV','123213',35000.00,'',0,0,0,0,1,1,0,0,0),(35,'TXN-20181016-35',1,0,15,'','CDJ','2018-10-16','2018-10-16 13:34:13',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','132313','2018-10-17','CV','12',350.00,'',0,0,0,0,NULL,1,0,0,0),(36,'TXN-20181016-36',1,0,15,'','CDJ','2018-10-16','2018-10-16 13:34:43',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','21312321','2018-10-14','CV','1212',1350.00,'',0,0,0,0,NULL,1,0,0,0),(37,'TXN-20181019-37',1,3,0,'','SJE','2018-10-19','2018-10-19 09:15:36',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(38,'TXN-20181025-38',1,0,1,'','CDJ','2018-10-25','2018-10-25 11:32:14',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','01',23.00,'',0,0,0,0,NULL,0,0,0,0),(39,'TXN-20181025-39',1,1,0,'','SJE','2018-10-17','2018-10-25 11:45:55',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SAL-INV-20181017-1',0.00,'',0,0,0,0,0,0,1,0,0),(40,'TXN-20181029-40',1,2,0,'','CRJ','2018-10-29','2018-10-29 11:55:44',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','','CI-INV-20181029-1',0.00,NULL,0,0,0,0,NULL,0,0,0,0),(41,'TXN-20181211-41',1,1,0,'','SJE','2018-12-11','2018-12-11 14:51:37',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(42,'TXN-20181211-42',4,0,1,'','PJE','2018-11-05','2018-12-11 14:55:08',2,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','P-INV-20181105-15',0.00,'',0,0,0,0,0,0,0,0,0),(43,'TXN-20181217-43',1,2,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n Customer : Various Customers\r\n Address : Various Customers\r\n Email : Various Customers\r\n Telephone : Variou','SJE','2018-12-17','2018-12-17 12:11:46',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(44,'TXN-20181217-44',2,2,0,'','SJE','2018-12-17','2018-12-17 12:11:52',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SAL-INV-20181217-3',0.00,'',0,0,0,0,0,0,1,0,0),(45,'TXN-20181217-45',1,0,1,'To Replenish Petty Cash on or before 2018-12-17','CDJ','2018-12-17','2018-12-17 12:18:30',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','','',5500.00,'',0,0,1,1,0,0,0,0,0),(46,'TXN-20181218-46',2,0,6,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ','GJE','2018-12-18','2018-12-18 09:11:54',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(47,'TXN-20181218-47',2,0,2,'sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','CDJ','2018-12-18','2018-12-18 10:18:10',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','123','2018-12-06','CV','1',12.00,'',0,0,0,0,1,0,0,0,0),(48,'TXN-20181218-48',4,0,3,'sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','CDJ','2018-12-18','2018-12-18 10:18:33',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','123121','2018-12-12','CV','123',121.00,'',0,0,0,0,1,0,0,0,0),(49,'TXN-20181218-49',2,0,2,'sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','PJE','2018-11-05','2018-12-18 10:26:25',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','P-INV-20181105-16',0.00,'',0,0,0,0,0,0,0,0,0),(50,'TXN-20181218-50',1,2,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','CRJ','2018-12-17','2018-12-18 10:32:45',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','','CI-INV-20181217-2',0.00,NULL,0,0,0,0,NULL,0,0,0,0),(51,'TXN-20181218-51',1,2,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','SJE','2018-12-18','2018-12-18 10:54:50',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SER-INV-20181218-2',0.00,'',0,0,0,0,0,0,0,0,0),(52,'TXN-20181219-52',1,0,22,'Purchases for the Month of February','CDJ','2018-12-19','2018-12-19 11:53:00',7,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','100250',37500.00,'',0,0,0,0,NULL,0,0,0,0),(53,'TXN-20181219-53',6,0,6,'','PJE','2018-12-19','2018-12-19 13:37:22',7,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',7,'\0','\0',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(54,'TXN-20181228-54',2,0,2,'','PJE','2018-12-28','2018-12-28 15:18:00',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(55,'TXN-20181228-55',2,1,0,'','SJE','2018-12-13','2018-12-28 15:18:46',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SAL-INV-20181213-2',0.00,'',0,0,0,0,0,0,1,0,0),(56,'TXN-20190103-56',1,0,6,'','GJE','2019-01-03','2019-01-03 12:11:28',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(57,'TXN-20190103-57',1,0,4,'','GJE','2018-12-18','2019-01-03 16:13:00',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(58,'TXN-20190103-58',1,2,0,'12','CRJ','2019-01-03','2019-01-03 16:47:13',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','','CI-INV-20190103-4',0.00,NULL,0,0,0,0,NULL,0,0,0,0),(59,'TXN-20190206-59',2,3,0,'None','SJE','2019-02-06','2019-02-06 12:17:58',1,'2019-02-18 11:02:05',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,1,0,0),(60,'TXN-20190218-60',3,1,0,'','CRJ','2019-02-18','2019-02-18 10:58:34',1,'2019-02-18 11:00:18',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','',NULL,12000.00,'',0,0,0,0,3,0,0,0,0),(61,'TXN-20190218-61',1,0,3,'','PJE','2019-02-18','2019-02-18 11:04:11',1,'2019-02-18 11:05:02',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','',NULL,0.00,'',0,0,0,0,0,0,0,0,0),(62,'TXN-20190218-62',1,0,2,'None','CDJ','2019-02-18','2019-02-18 11:08:38',1,'2019-02-18 11:11:09',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',1,'','','1970-01-01','CV','10002',15000.00,'',0,0,0,0,NULL,0,0,0,0),(63,'TXN-20190218-63',1,1,0,'None','GJE','2019-02-18','2019-02-18 11:11:40',1,'2019-02-18 11:50:45',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','',0.00,'',0,0,0,0,0,0,0,0,0),(64,'TXN-20190322-64',3,2,0,'','SJE','2019-03-22','2019-03-22 13:54:19',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',0,'','','0000-00-00','','SAL-INV-20190322-10',0.00,'',0,0,0,0,0,0,1,0,0),(65,'TXN-20190510-65',4,0,2,'','CDJ','2019-05-10','2019-05-10 11:45:08',1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'\0','',2,'','123123','2019-05-07','CV','123',2751.08,'',1,0,0,0,NULL,0,0,0,0);
/*!40000 ALTER TABLE `journal_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_templates_info`
--

DROP TABLE IF EXISTS `journal_templates_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_templates_info` (
  `template_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template_code` varchar(155) DEFAULT '',
  `payee` varchar(1000) DEFAULT '',
  `template_description` varchar(1000) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `method_id` bigint(20) DEFAULT '0',
  `amount` decimal(20,4) DEFAULT '0.0000',
  `remarks` varchar(1000) DEFAULT '',
  `posted_by` int(11) DEFAULT NULL,
  `book_type` varchar(5) DEFAULT '',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`template_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_templates_info`
--

LOCK TABLES `journal_templates_info` WRITE;
/*!40000 ALTER TABLE `journal_templates_info` DISABLE KEYS */;
INSERT INTO `journal_templates_info` VALUES (1,'Converge ICT Solutions INC.','',NULL,7,0,0,0.0000,'Payment for the Month of September',1,'CDJ',1,0),(2,'Balibago Waterworks System, INC','',NULL,8,0,0,0.0000,'',1,'CDJ',1,0),(3,'FedEx','',NULL,15,0,0,0.0000,'Delivery Fee',1,'CDJ',1,0),(4,'N/A','',NULL,1,0,0,0.0000,'',1,'CDJ',1,0);
/*!40000 ALTER TABLE `journal_templates_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`location_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Admin Office','\0',''),(2,'Central Warehouse','\0','');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_commercial`
--

DROP TABLE IF EXISTS `matrix_commercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matrix_commercial` (
  `matrix_commercial_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(145) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `other_details` varchar(445) DEFAULT '',
  `matrix_commercial_code` varchar(445) DEFAULT '',
  PRIMARY KEY (`matrix_commercial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_commercial`
--

LOCK TABLES `matrix_commercial` WRITE;
/*!40000 ALTER TABLE `matrix_commercial` DISABLE KEYS */;
INSERT INTO `matrix_commercial` VALUES (1,'Matrix 2019','','','Matrix May 2019 to May 2020',''),(2,NULL,'','','',''),(4,NULL,'','','123',''),(5,'1111','','','11',''),(6,'123','','','123',''),(7,'Matriz','','','Matriz',''),(8,'1','','','1',''),(9,'1123131312312','','','Updated',''),(11,'123','','','123','CCM-2019-11'),(12,'123','','\0','123','MATRIX-COMM-2019-12'),(13,'Matrix for 2020 January to May','','\0','Commence in January 2020 to May 2020','MATRIX-COMM-2019-13');
/*!40000 ALTER TABLE `matrix_commercial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_commercial_items`
--

DROP TABLE IF EXISTS `matrix_commercial_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matrix_commercial_items` (
  `matrix_commercial_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `matrix_commercial_id` int(11) DEFAULT '0',
  `matrix_commercial_from` int(11) DEFAULT '0',
  `matrix_commercial_to` int(11) DEFAULT '0',
  `matrix_commercial_amount` decimal(20,2) DEFAULT '0.00',
  `is_fixed_amount` bit(1) DEFAULT b'0',
  PRIMARY KEY (`matrix_commercial_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_commercial_items`
--

LOCK TABLES `matrix_commercial_items` WRITE;
/*!40000 ALTER TABLE `matrix_commercial_items` DISABLE KEYS */;
INSERT INTO `matrix_commercial_items` VALUES (1,0,0,10,200.00,''),(2,0,11,20,20.50,'\0'),(3,0,21,30,20.75,'\0'),(4,0,31,40,30.00,'\0'),(5,0,41,50,30.50,'\0'),(6,0,51,52,31.00,'\0'),(7,4,1,1,1.00,'\0'),(8,5,1,1,1.00,'\0'),(9,6,11,1231,123.00,'\0'),(10,6,123,123,123.00,'\0'),(11,6,123,123,123.00,'\0'),(12,7,1,1,1.00,'\0'),(13,7,2,2,2.00,'\0'),(14,7,3,3,3.00,'\0'),(15,7,4,4,4.00,'\0'),(16,7,5,5,5.00,'\0'),(17,8,1,1,0.00,'\0'),(18,8,2,2,0.00,''),(35,9,11,11,0.00,''),(36,9,123,123,0.00,'\0'),(37,9,123,123,0.00,'\0'),(38,9,123,123,0.00,''),(40,11,1,1,0.00,'\0'),(41,12,24234,234234,0.00,'\0'),(44,13,1,10,200.00,''),(45,13,11,20,30.50,'\0');
/*!40000 ALTER TABLE `matrix_commercial_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_residential`
--

DROP TABLE IF EXISTS `matrix_residential`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matrix_residential` (
  `matrix_residential_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(145) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `other_details` varchar(445) DEFAULT '',
  `matrix_residential_code` varchar(445) DEFAULT '',
  PRIMARY KEY (`matrix_residential_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_residential`
--

LOCK TABLES `matrix_residential` WRITE;
/*!40000 ALTER TABLE `matrix_residential` DISABLE KEYS */;
INSERT INTO `matrix_residential` VALUES (4,'123','','','123','MATRIX-RESI-2019-4'),(5,'Residential Rate 2019','','\0','Hahahaha','MATRIX-RESI-2019-5'),(6,'ay ang pogi ko','','\0','tama yan. I agree','MATRIX-RESI-2019-6');
/*!40000 ALTER TABLE `matrix_residential` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_residential_items`
--

DROP TABLE IF EXISTS `matrix_residential_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matrix_residential_items` (
  `matrix_residential_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `matrix_residential_id` int(11) DEFAULT '0',
  `matrix_residential_from` int(11) DEFAULT '0',
  `matrix_residential_to` int(11) DEFAULT '0',
  `matrix_residential_amount` decimal(20,2) DEFAULT '0.00',
  `is_fixed_amount` bit(1) DEFAULT b'0',
  PRIMARY KEY (`matrix_residential_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_residential_items`
--

LOCK TABLES `matrix_residential_items` WRITE;
/*!40000 ALTER TABLE `matrix_residential_items` DISABLE KEYS */;
INSERT INTO `matrix_residential_items` VALUES (1,0,0,10,200.00,''),(2,0,11,20,20.50,'\0'),(3,0,21,30,20.75,'\0'),(4,0,31,41,30.00,'\0'),(5,0,41,50,30.50,'\0'),(6,0,51,1000,31.00,'\0'),(10,4,123,123,123.00,''),(11,4,1,1,1.00,'\0'),(12,4,1,1,1.00,''),(16,5,1,10,200.00,''),(17,5,11,20,30.25,'\0'),(18,5,21,30,32.20,'\0'),(20,6,12,23,24343.00,'');
/*!40000 ALTER TABLE `matrix_residential_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` int(11) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`chat_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meter_inventory`
--

DROP TABLE IF EXISTS `meter_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter_inventory` (
  `meter_inventory_id` int(12) NOT NULL AUTO_INCREMENT,
  `meter_code` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `meter_description` text,
  `customer_id` int(12) DEFAULT '0',
  `created_by` int(12) DEFAULT '0',
  `modified_by` int(12) DEFAULT '0',
  `date_created` date DEFAULT '0000-00-00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `meter_status_id` tinyint(1) DEFAULT '2',
  `is_new` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`meter_inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_inventory`
--

LOCK TABLES `meter_inventory` WRITE;
/*!40000 ALTER TABLE `meter_inventory` DISABLE KEYS */;
INSERT INTO `meter_inventory` VALUES (1,'MC-20190517-1','01145887558','Joash Noble',13,8,0,'2019-05-17','\0','',2,0);
/*!40000 ALTER TABLE `meter_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meter_reading_input`
--

DROP TABLE IF EXISTS `meter_reading_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter_reading_input` (
  `meter_reading_input_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `meter_reading_period_id` bigint(20) DEFAULT '0',
  `batch_no` varchar(145) DEFAULT '',
  `month_id` int(11) DEFAULT '0',
  `year_id` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`meter_reading_input_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_reading_input`
--

LOCK TABLES `meter_reading_input` WRITE;
/*!40000 ALTER TABLE `meter_reading_input` DISABLE KEYS */;
/*!40000 ALTER TABLE `meter_reading_input` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meter_reading_period`
--

DROP TABLE IF EXISTS `meter_reading_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter_reading_period` (
  `meter_reading_period_id` int(11) NOT NULL AUTO_INCREMENT,
  `meter_reading_period_start` date DEFAULT '0000-00-00',
  `meter_reading_period_end` date DEFAULT '0000-00-00',
  `month_id` int(11) DEFAULT '0',
  `meter_reading_year` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `created_by` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`meter_reading_period_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_reading_period`
--

LOCK TABLES `meter_reading_period` WRITE;
/*!40000 ALTER TABLE `meter_reading_period` DISABLE KEYS */;
INSERT INTO `meter_reading_period` VALUES (6,'2019-02-01','2019-02-28',2,2019,'','',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(7,'2019-05-01','2019-05-31',5,2019,'','',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(8,'2019-05-01','2019-05-31',5,2019,'','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(9,'2019-01-01','2019-01-31',1,2019,'','',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(10,'2019-06-01','2019-06-30',6,2019,'','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(11,'2019-07-01','2019-07-31',7,2019,'','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `meter_reading_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meter_status`
--

DROP TABLE IF EXISTS `meter_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter_status` (
  `meter_status_id` int(12) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`meter_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_status`
--

LOCK TABLES `meter_status` WRITE;
/*!40000 ALTER TABLE `meter_status` DISABLE KEYS */;
INSERT INTO `meter_status` VALUES (1,'Active',0,1),(2,'Inactive',0,1),(3,'On Float',0,1);
/*!40000 ALTER TABLE `meter_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_layout`
--

DROP TABLE IF EXISTS `module_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_layout` (
  `module_layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) DEFAULT '0',
  `display_text` varchar(100) DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `pos_top` decimal(10,0) DEFAULT NULL,
  `pos_bottom` decimal(10,0) DEFAULT NULL,
  `pos_left` decimal(10,0) DEFAULT NULL,
  `pos_right` decimal(10,0) DEFAULT NULL,
  `font` varchar(100) DEFAULT NULL,
  `font_color` varchar(45) DEFAULT NULL,
  `font_size` decimal(10,0) DEFAULT NULL,
  `is_bold` varchar(120) DEFAULT '0',
  `is_italic` varchar(120) DEFAULT '0',
  `height` decimal(10,0) DEFAULT NULL,
  `width` decimal(10,0) DEFAULT NULL,
  `tag` varchar(45) DEFAULT NULL,
  `parent` varchar(50) DEFAULT 'header',
  PRIMARY KEY (`module_layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_layout`
--

LOCK TABLES `module_layout` WRITE;
/*!40000 ALTER TABLE `module_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `months`
--

DROP TABLE IF EXISTS `months`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `months` (
  `month_id` int(12) NOT NULL AUTO_INCREMENT,
  `month_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `months`
--

LOCK TABLES `months` WRITE;
/*!40000 ALTER TABLE `months` DISABLE KEYS */;
INSERT INTO `months` VALUES (1,'January'),(2,'February'),(3,'March'),(4,'April'),(5,'May'),(6,'June'),(7,'July'),(8,'August'),(9,'September'),(10,'October'),(11,'November'),(12,'December');
/*!40000 ALTER TABLE `months` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationality`
--

DROP TABLE IF EXISTS `nationality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nationality` (
  `nationality_id` int(11) NOT NULL AUTO_INCREMENT,
  `nationality_name` varchar(445) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`nationality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationality`
--

LOCK TABLES `nationality` WRITE;
/*!40000 ALTER TABLE `nationality` DISABLE KEYS */;
INSERT INTO `nationality` VALUES (1,'Filipino','','\0'),(2,'Korean','','\0'),(3,'American','','\0'),(4,'Japanese','','\0'),(5,'Chinese','','\0'),(6,'Vietnamese','','\0'),(7,'Russian','','\0');
/*!40000 ALTER TABLE `nationality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_source`
--

DROP TABLE IF EXISTS `order_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_source` (
  `order_source_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_source_name` varchar(145) DEFAULT '',
  `order_source_description` varchar(145) DEFAULT '',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`order_source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_source`
--

LOCK TABLES `order_source` WRITE;
/*!40000 ALTER TABLE `order_source` DISABLE KEYS */;
INSERT INTO `order_source` VALUES (1,'Walk In','Walk In','\0',''),(2,'Lazada','','',''),(3,'Facebook','','\0',''),(4,'Shoppee','','\0',''),(5,'Alibaba','','\0',''),(6,'edi','wow','',''),(7,'11','11','',''),(8,'aa','aa','',''),(9,'Viber','Viber','\0','');
/*!40000 ALTER TABLE `order_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status` varchar(75) DEFAULT '',
  `order_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`order_status_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'Open','','','\0'),(2,'Closed','','','\0'),(3,'Partially received','','','\0');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other_charges`
--

DROP TABLE IF EXISTS `other_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other_charges` (
  `other_charge_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `other_charge_no` varchar(75) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT NULL,
  `total_amount` decimal(25,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_amount_after_discount` decimal(20,4) DEFAULT '0.0000',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_due` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `remarks` text,
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `contact_person` varchar(175) DEFAULT NULL,
  `connection_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`other_charge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_charges`
--

LOCK TABLES `other_charges` WRITE;
/*!40000 ALTER TABLE `other_charges` DISABLE KEYS */;
INSERT INTO `other_charges` VALUES (1,'OTH-CHR-20190515-1',0,0,0,'12',4600.00,0.0000,0.0000,4600.0000,'2019-05-15','2019-05-15','2019-05-15 10:24:30','0000-00-00 00:00:00','2019-05-15 11:37:56',7,7,0,'','','','\0',0,'12',2),(2,'OTH-CHR-20190515-2',0,0,0,'12',3100.00,0.0000,0.0000,3100.0000,'2019-05-15','0000-00-00','2019-05-15 10:20:35','0000-00-00 00:00:00','2019-05-15 11:37:58',7,7,0,'','','','\0',0,'12',1),(3,'OTH-CHR-20190515-3',0,0,0,'awe',2850.00,0.0000,0.0000,2850.0000,'2019-05-16','0000-00-00','2019-05-15 10:29:13','0000-00-00 00:00:00','0000-00-00 00:00:00',7,0,0,'','\0','111','\0',0,'awe',1),(4,'OTH-CHR-20190515-4',0,0,0,NULL,1350.00,0.0000,0.0000,1350.0000,'2019-05-15','0000-00-00','2019-05-15 11:36:53','0000-00-00 00:00:00','0000-00-00 00:00:00',7,0,0,'','\0','','\0',0,NULL,1);
/*!40000 ALTER TABLE `other_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other_charges_items`
--

DROP TABLE IF EXISTS `other_charges_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other_charges_items` (
  `other_charge_item_id` bigint(25) NOT NULL AUTO_INCREMENT,
  `other_charge_id` bigint(25) DEFAULT '0',
  `charge_id` int(11) DEFAULT '0',
  `charge_unit_id` int(11) DEFAULT '0',
  `charge_amount` decimal(25,2) DEFAULT '0.00',
  `charge_qty` int(11) DEFAULT '0',
  `charge_line_total` decimal(25,2) DEFAULT '0.00',
  `charge_line_total_after_global` decimal(25,4) DEFAULT '0.0000',
  PRIMARY KEY (`other_charge_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_charges_items`
--

LOCK TABLES `other_charges_items` WRITE;
/*!40000 ALTER TABLE `other_charges_items` DISABLE KEYS */;
INSERT INTO `other_charges_items` VALUES (15,2,4,2,1750.00,1,1750.00,1750.0000),(16,2,5,2,1350.00,1,1350.00,1350.0000),(17,1,3,2,1500.00,1,1500.00,1500.0000),(18,1,4,2,1750.00,1,1750.00,1750.0000),(19,1,5,2,1350.00,1,1350.00,1350.0000),(20,3,3,2,1500.00,1,1500.00,1500.0000),(21,3,5,2,1350.00,1,1350.00,1350.0000),(27,4,5,2,1350.00,1,1350.00,1350.0000);
/*!40000 ALTER TABLE `other_charges_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payable_payments`
--

DROP TABLE IF EXISTS `payable_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payable_payments` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(75) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT '',
  `department_id` bigint(20) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments`
--

LOCK TABLES `payable_payments` WRITE;
/*!40000 ALTER TABLE `payable_payments` DISABLE KEYS */;
INSERT INTO `payable_payments` VALUES (1,'REC01',12,22,'',1,1,1,'0000-00-00','','Record with Withholding Tax of 250.00',8000.00,'2018-10-11','2018-10-11 10:59:04','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,'','','\0',''),(2,'12',1,0,'',9,1,1,'0000-00-00','',' sectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',10.00,'2018-12-18','2018-12-18 10:21:24','0000-00-00 00:00:00','2019-01-09 11:20:26',1,1,0,'\0','\0','\0','\0'),(3,'12',2,0,'',3,1,1,'0000-00-00','','',1000.00,'2019-01-09','2019-01-09 11:21:13','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,'\0','','\0','\0');
/*!40000 ALTER TABLE `payable_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payable_payments_list`
--

DROP TABLE IF EXISTS `payable_payments_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) DEFAULT '0',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `payable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`payment_list_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments_list`
--

LOCK TABLES `payable_payments_list` WRITE;
/*!40000 ALTER TABLE `payable_payments_list` DISABLE KEYS */;
INSERT INTO `payable_payments_list` VALUES (1,1,5,13500.00,8000.00),(2,2,42,150.00,10.00),(3,3,49,28690.00,1000.00);
/*!40000 ALTER TABLE `payable_payments_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(100) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_method_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Cash','','\0'),(2,'Check','','\0'),(3,'Card','','\0');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `po_attachments`
--

DROP TABLE IF EXISTS `po_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po_attachments` (
  `po_attachment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `orig_file_name` varchar(255) DEFAULT '',
  `server_file_directory` varchar(800) DEFAULT '',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`po_attachment_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `po_attachments`
--

LOCK TABLES `po_attachments` WRITE;
/*!40000 ALTER TABLE `po_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `po_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `po_messages`
--

DROP TABLE IF EXISTS `po_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po_messages` (
  `po_message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `message` text,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`po_message_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `po_messages`
--

LOCK TABLES `po_messages` WRITE;
/*!40000 ALTER TABLE `po_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `po_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prime_hotel_integration`
--

DROP TABLE IF EXISTS `prime_hotel_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prime_hotel_integration` (
  `prime_hotel_integration_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(45) DEFAULT '',
  `shift_date` date DEFAULT '0000-00-00',
  `adv_cash_total` decimal(20,5) DEFAULT '0.00000',
  `adv_check_total` decimal(20,5) DEFAULT '0.00000',
  `adv_card_total` decimal(20,5) DEFAULT '0.00000',
  `adv_charge_total` decimal(20,5) DEFAULT '0.00000',
  `adv_bank_dep_total` decimal(20,5) DEFAULT '0.00000',
  `cash_sales` decimal(20,5) DEFAULT '0.00000',
  `check_sales` decimal(20,5) DEFAULT '0.00000',
  `card_sales` decimal(20,5) DEFAULT '0.00000',
  `charge_sales` decimal(20,5) DEFAULT '0.00000',
  `bank_dep_sales` decimal(20,5) DEFAULT '0.00000',
  `room_sales` decimal(20,5) DEFAULT '0.00000',
  `bar_sales` decimal(20,5) DEFAULT '0.00000',
  `other_sales` decimal(20,5) DEFAULT '0.00000',
  `adv_sales` decimal(20,5) DEFAULT '0.00000',
  `guest_id` bigint(20) DEFAULT '0',
  `guest_name` varchar(245) DEFAULT '',
  `ar_guest_id` bigint(20) DEFAULT '0',
  `ar_guest_name` varchar(245) DEFAULT '',
  `check_no` varchar(145) DEFAULT '',
  `check_date` date DEFAULT '0000-00-00',
  `check_type_id` bigint(20) DEFAULT '0',
  `check_type_name` varchar(145) DEFAULT '',
  `card_no` varchar(45) DEFAULT '',
  `card_type_name` varchar(45) DEFAULT '',
  `or_no` varchar(145) DEFAULT '',
  `folio_no` varchar(145) DEFAULT '',
  `receipt_no` varchar(145) DEFAULT '',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `posted_by_user` bigint(20) DEFAULT '0',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `journal_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`prime_hotel_integration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prime_hotel_integration`
--

LOCK TABLES `prime_hotel_integration` WRITE;
/*!40000 ALTER TABLE `prime_hotel_integration` DISABLE KEYS */;
/*!40000 ALTER TABLE `prime_hotel_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prime_hotel_integration_settings`
--

DROP TABLE IF EXISTS `prime_hotel_integration_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prime_hotel_integration_settings` (
  `prime_hotel_integration_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adv_cash_id` bigint(20) DEFAULT '0',
  `adv_check_id` bigint(20) DEFAULT '0',
  `adv_card_id` bigint(20) DEFAULT '0',
  `adv_charge_id` bigint(20) DEFAULT '0',
  `adv_bank_dep_id` bigint(20) DEFAULT '0',
  `cash_id` bigint(20) DEFAULT '0',
  `check_id` bigint(20) DEFAULT '0',
  `card_id` bigint(20) DEFAULT '0',
  `charge_id` bigint(20) DEFAULT '0',
  `bank_dep_id` bigint(20) DEFAULT '0',
  `room_sales_id` bigint(20) DEFAULT '0',
  `bar_sales_id` bigint(20) DEFAULT '0',
  `other_sales_id` bigint(20) DEFAULT '0',
  `adv_sales_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`prime_hotel_integration_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prime_hotel_integration_settings`
--

LOCK TABLES `prime_hotel_integration_settings` WRITE;
/*!40000 ALTER TABLE `prime_hotel_integration_settings` DISABLE KEYS */;
INSERT INTO `prime_hotel_integration_settings` VALUES (1,46,47,48,49,50,1,52,53,5,54,19,21,20,51,1,1);
/*!40000 ALTER TABLE `prime_hotel_integration_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print_layout`
--

DROP TABLE IF EXISTS `print_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `print_layout` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_name` varchar(755) NOT NULL,
  `layout_description` varchar(1000) DEFAULT NULL,
  `is_portrait` bit(1) NOT NULL DEFAULT b'1',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_layout`
--

LOCK TABLES `print_layout` WRITE;
/*!40000 ALTER TABLE `print_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `print_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_batch_inventory`
--

DROP TABLE IF EXISTS `product_batch_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_batch_inventory` (
  `product_key` varchar(100) NOT NULL,
  `product_id` bigint(20) DEFAULT '0',
  `batch_no` varchar(55) DEFAULT '',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_exp_on_hand` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`product_key`) USING BTREE,
  UNIQUE KEY `product_key` (`product_key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_batch_inventory`
--

LOCK TABLES `product_batch_inventory` WRITE;
/*!40000 ALTER TABLE `product_batch_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_batch_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT '',
  `product_desc` varchar(255) DEFAULT '',
  `product_desc1` varchar(255) DEFAULT '',
  `is_bulk` tinyint(1) DEFAULT '0',
  `primary_unit` bit(1) DEFAULT b'1',
  `parent_unit_id` bigint(20) DEFAULT '0',
  `child_unit_desc` varchar(175) DEFAULT '0',
  `child_unit_id` bigint(20) DEFAULT '0',
  `size` varchar(255) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `tax_type_id` bigint(20) DEFAULT '0',
  `refproduct_id` int(10) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '2' COMMENT '1 - Hotel , 2 -  POS',
  `equivalent_points` decimal(20,2) DEFAULT '0.00',
  `product_warn` decimal(16,2) DEFAULT '0.00',
  `product_ideal` decimal(16,2) DEFAULT '0.00',
  `purchase_cost` decimal(20,4) DEFAULT '0.0000',
  `purchase_cost_2` decimal(20,4) DEFAULT '0.0000',
  `markup_percent` decimal(16,4) DEFAULT '0.0000',
  `sale_price` decimal(16,4) DEFAULT '0.0000',
  `whole_sale` decimal(16,4) DEFAULT '0.0000',
  `retailer_price` decimal(16,4) DEFAULT '0.0000',
  `special_disc` decimal(16,4) DEFAULT '0.0000',
  `discounted_price` decimal(16,4) DEFAULT '0.0000',
  `dealer_price` decimal(16,4) DEFAULT '0.0000',
  `distributor_price` decimal(16,4) DEFAULT '0.0000',
  `public_price` decimal(16,4) DEFAULT '0.0000',
  `valued_customer` decimal(16,4) DEFAULT '0.0000',
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `on_hand` decimal(20,2) DEFAULT '0.00',
  `item_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_inventory` bit(1) DEFAULT b'1',
  `is_tax_exempt` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `brand_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'P101','Computer Ribbon RED ','Computer Ribbon RED ',1,'',1,'10',2,NULL,3,1,NULL,1,2,0.00,20.00,500.00,150.0000,0.0000,0.0000,210.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,19,41,31.00,1,'2018-10-11 10:41:06','2019-01-23 10:51:52','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1),(2,'P102','Delli Imported  Wine From France','Delli Imported  Wine From France',0,'',1,'0',NULL,NULL,11,2,NULL,1,2,0.00,30.00,30.00,28540.0000,0.0000,0.0000,36500.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,19,41,1.00,1,'2018-10-11 10:43:35','2019-01-23 10:51:57','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1),(3,'P103','Sugar and Spice ','Sugar and Spice ',0,'',1,'0',NULL,NULL,1,1,NULL,4,2,0.00,25.00,50.00,85.0000,0.0000,0.0000,125.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,19,41,1.00,1,'2018-10-11 10:45:00','2019-01-23 10:52:05','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1),(4,'83239','San Mig Lights 12ml','San Mig Lights 12ml',0,'',1,'0',NULL,NULL,19,2,NULL,2,2,0.00,100.00,300.00,35.0000,0.0000,0.0000,50.0000,0.0000,0.0000,0.0000,45.0000,45.0000,45.0000,23.0000,0.0000,19,0,0.00,1,'2018-10-18 11:54:57','2019-01-23 10:51:48','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1),(5,'SMB22','SMB PALE PILSEN ','SMB PALE PILSEN ',0,'',1,'0',NULL,NULL,3,2,NULL,2,2,0.00,0.00,0.00,50.0000,0.0000,0.0000,86.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,19,41,0.00,1,'2018-10-18 11:56:21','2019-01-23 10:52:10','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1),(6,'11','TSHIRT V COLLAR  40','TSHIRT V COLLAR  40',0,'',1,'0',NULL,NULL,5,2,NULL,3,2,0.00,0.00,0.00,1120.0000,0.0000,0.0000,200.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,19,0,2.00,1,'2018-10-18 12:00:57','2019-03-22 13:51:13','0000-00-00 00:00:00',1,1,0,'','\0','\0','',1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoice`
--

DROP TABLE IF EXISTS `proforma_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proforma_invoice` (
  `proforma_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `proforma_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `customer_name` varchar(175) NOT NULL,
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`proforma_invoice_id`) USING BTREE,
  UNIQUE KEY `proforma_inv_no` (`proforma_inv_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoice`
--

LOCK TABLES `proforma_invoice` WRITE;
/*!40000 ALTER TABLE `proforma_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proforma_invoice_items`
--

DROP TABLE IF EXISTS `proforma_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proforma_invoice_items` (
  `proforma_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `proforma_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`proforma_item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proforma_invoice_items`
--

LOCK TABLES `proforma_invoice_items` WRITE;
/*!40000 ALTER TABLE `proforma_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `proforma_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order` (
  `purchase_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(75) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(55) DEFAULT '',
  `deliver_to_address` varchar(755) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `contact_person` varchar(100) DEFAULT '',
  `remarks` varchar(775) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `approval_id` int(11) DEFAULT '2',
  `order_status_id` int(11) DEFAULT '1',
  `is_email_sent` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_approved` datetime DEFAULT '0000-00-00 00:00:00',
  `approved_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`purchase_order_id`) USING BTREE,
  UNIQUE KEY `po_no` (`po_no`) USING BTREE,
  UNIQUE KEY `po_no_2` (`po_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` VALUES (1,'PO-20181018-1','',NULL,'12',1,1,1,'','',0.0000,120.5400,14.4600,135.0000,0.0000,0.0000,135.0000,1,1,'\0','','\0','2018-10-18 15:02:20','2018-10-18 07:02:42','0000-00-00 00:00:00','2018-10-18 15:02:42',1,1,0,0),(2,'PO-20181022-2','12',NULL,'12',3,2,1,'','',0.0000,31.2500,3.7500,35.0000,0.0000,0.0000,35.0000,2,1,'\0','','\0','2018-10-22 11:31:01','2018-10-22 03:31:01','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,0),(3,'PO-20181023-3','',NULL,'12',1,1,1,'','',3.5000,25.3100,3.0400,31.5000,10.0000,3.1500,28.3500,1,1,'\0','','\0','2018-10-23 08:44:10','2018-10-23 00:44:32','0000-00-00 00:00:00','2018-10-23 08:44:32',1,1,0,0),(4,'PO-20181023-4','12',NULL,'12',1,1,1,'12','',3.5000,25.3100,3.0400,28.3500,10.0000,2.8400,25.5200,2,1,'\0','','\0','2018-10-23 08:48:15','2018-10-23 00:48:15','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,0),(5,'PO-20181023-5','12',NULL,'12',2,1,1,'12','',3.5000,160.3100,3.0400,181.5000,10.0000,18.1500,163.3500,2,1,'\0','','\0','2018-10-23 09:03:00','2018-10-23 01:06:54','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,1),(6,'PO-20181023-6','12',NULL,'12',1,2,1,'12','',6.0000,63.4800,7.6200,71.1000,10.0000,7.9000,71.1000,1,1,'\0','','\0','2018-10-23 09:32:47','2018-11-05 04:10:17','0000-00-00 00:00:00','2018-10-23 09:54:13',1,1,0,1),(7,'PO-20181023-7','',NULL,'123',1,1,1,'','',3.5000,25.3100,3.0400,28.3500,10.0000,3.1500,28.3500,1,2,'\0','','\0','2018-10-23 10:42:17','2018-10-23 02:49:08','0000-00-00 00:00:00','2018-10-23 10:42:29',1,1,0,0),(8,'PO-20181218-8','',NULL,'1',1,2,1,'','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.0000,31.2500,3.7500,35.0000,0.0000,0.0000,35.0000,2,1,'\0','','\0','2018-12-18 11:51:10','2018-12-18 03:55:16','0000-00-00 00:00:00','0000-00-00 00:00:00',0,1,0,1);
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order_items` (
  `po_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `is_parent` int(11) DEFAULT '1',
  `unit_id` int(11) DEFAULT '0',
  `po_price` decimal(20,4) DEFAULT '0.0000',
  `po_discount` decimal(20,4) DEFAULT '0.0000',
  `po_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `po_tax_rate` decimal(11,4) DEFAULT '0.0000',
  `po_qty` decimal(20,2) DEFAULT '0.00',
  `po_line_total` decimal(20,4) DEFAULT '0.0000',
  `tax_amount` decimal(20,4) DEFAULT '0.0000',
  `non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `po_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  PRIMARY KEY (`po_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_items`
--

LOCK TABLES `purchase_order_items` WRITE;
/*!40000 ALTER TABLE `purchase_order_items` DISABLE KEYS */;
INSERT INTO `purchase_order_items` VALUES (1,1,4,1,1,135.0000,0.0000,0.0000,12.0000,1.00,135.0000,14.4600,120.5400,0.0000),(2,2,4,1,1,35.0000,0.0000,0.0000,12.0000,1.00,35.0000,3.7500,31.2500,0.0000),(3,3,4,1,1,35.0000,10.0000,3.5000,12.0000,1.00,31.5000,3.0400,25.3100,0.0000),(4,4,4,1,1,35.0000,10.0000,3.5000,12.0000,1.00,28.3500,3.0400,25.3100,0.0000),(7,5,4,1,1,35.0000,10.0000,3.5000,12.0000,1.00,31.5000,3.0400,25.3100,28.3500),(8,5,1,1,1,150.0000,0.0000,0.0000,0.0000,1.00,150.0000,0.0000,135.0000,135.0000),(15,6,4,1,1,35.0000,10.0000,3.5000,12.0000,1.00,31.5000,3.0400,25.3100,28.3500),(16,6,5,1,1,50.0000,5.0000,2.5000,12.0000,1.00,47.5000,4.5800,38.1700,42.7500),(17,7,4,1,1,35.0000,10.0000,3.5000,12.0000,1.00,31.5000,3.0400,25.3100,28.3500),(19,8,4,1,1,35.0000,0.0000,0.0000,12.0000,1.00,35.0000,3.7500,31.2500,35.0000);
/*!40000 ALTER TABLE `purchase_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchasing_integration`
--

DROP TABLE IF EXISTS `purchasing_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchasing_integration` (
  `purchasing_integration_id` int(11) NOT NULL DEFAULT '0',
  `iss_supplier_id` bigint(20) DEFAULT '0',
  `iss_debit_id` bigint(20) DEFAULT '0',
  `iss_credit_id` bigint(20) DEFAULT '0',
  `adj_supplier_id` bigint(20) DEFAULT '0',
  `adj_debit_id` bigint(20) DEFAULT '0',
  `adj_credit_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`purchasing_integration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchasing_integration`
--

LOCK TABLES `purchasing_integration` WRITE;
/*!40000 ALTER TABLE `purchasing_integration` DISABLE KEYS */;
INSERT INTO `purchasing_integration` VALUES (1,4,33,0,6,24,1);
/*!40000 ALTER TABLE `purchasing_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_types`
--

DROP TABLE IF EXISTS `rate_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_types` (
  `rate_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_type_name` varchar(145) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`rate_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_types`
--

LOCK TABLES `rate_types` WRITE;
/*!40000 ALTER TABLE `rate_types` DISABLE KEYS */;
INSERT INTO `rate_types` VALUES (1,'Meter Reading','','\0'),(2,'Flat Rate','','\0');
/*!40000 ALTER TABLE `rate_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receivable_payments`
--

DROP TABLE IF EXISTS `receivable_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receivable_payments` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(20) DEFAULT '',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT 'AR',
  `department_id` int(11) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments`
--

LOCK TABLES `receivable_payments` WRITE;
/*!40000 ALTER TABLE `receivable_payments` DISABLE KEYS */;
INSERT INTO `receivable_payments` VALUES (1,'001',3,0,'AR',1,1,1,'0000-00-00','','',2500.00,'2018-10-19','2018-10-19 09:18:13','0000-00-00 00:00:00','0000-00-00 00:00:00','2018-10-19 09:19:38',1,1,0,0,'\0','\0','\0','\0'),(2,'12',3,0,'AR',1,1,1,'0000-00-00','','',5000.00,'2018-10-19','2018-10-19 09:27:51','0000-00-00 00:00:00','0000-00-00 00:00:00','2019-02-06 12:28:44',1,1,0,0,'\0','\0','\0','\0'),(3,'111',3,0,'AR',1,1,1,'0000-00-00','','',12.00,'2018-10-19','2018-10-19 09:32:08','0000-00-00 00:00:00','0000-00-00 00:00:00','2019-02-06 12:28:42',1,1,0,0,'\0','\0','\0','\0'),(4,'1',3,0,'AR',1,1,1,'0000-00-00','','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',111.00,'2018-12-18','2018-12-18 10:31:43','0000-00-00 00:00:00','0000-00-00 00:00:00','2019-02-06 12:28:41',1,1,0,0,'\0','\0','\0','\0');
/*!40000 ALTER TABLE `receivable_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receivable_payments_list`
--

DROP TABLE IF EXISTS `receivable_payments_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receivable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) DEFAULT '0',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `service_invoice_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receivable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`payment_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments_list`
--

LOCK TABLES `receivable_payments_list` WRITE;
/*!40000 ALTER TABLE `receivable_payments_list` DISABLE KEYS */;
INSERT INTO `receivable_payments_list` VALUES (1,1,0,0,2,37650.00,0.00),(2,1,0,0,37,10000.00,2500.00),(3,2,0,0,37,10000.00,5000.00),(4,3,0,0,37,5000.00,12.00),(5,4,0,0,2,37650.00,111.00);
/*!40000 ALTER TABLE `receivable_payments_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refcustomertype`
--

DROP TABLE IF EXISTS `refcustomertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refcustomertype` (
  `refcustomertype_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`refcustomertype_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refcustomertype`
--

LOCK TABLES `refcustomertype` WRITE;
/*!40000 ALTER TABLE `refcustomertype` DISABLE KEYS */;
/*!40000 ALTER TABLE `refcustomertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refdiscounttype`
--

DROP TABLE IF EXISTS `refdiscounttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refdiscounttype` (
  `discount_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_type_code` varchar(65) DEFAULT '',
  `discount_type_name` varchar(254) DEFAULT '',
  `discount_type_desc` varchar(500) DEFAULT '',
  `discount_percent` decimal(19,5) DEFAULT '0.00000',
  `sort_key` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT '0',
  `modified_datetime` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT '0',
  `deleted_datetime` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`discount_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refdiscounttype`
--

LOCK TABLES `refdiscounttype` WRITE;
/*!40000 ALTER TABLE `refdiscounttype` DISABLE KEYS */;
INSERT INTO `refdiscounttype` VALUES (1,'SC','Senior Citizen','Senior Citizen',20.00000,-1,0,NULL,0,NULL,1,NULL,0),(2,'MD','Manual Discount','Manual Discount',0.00000,0,0,NULL,1,'2017-08-11 12:01:36',1,'2017-08-11 12:01:42',0),(3,'5% Percent','5% Percent','5% Percent',5.00000,0,1,'2017-08-11 12:02:10',1,'2018-03-27 10:12:16',0,NULL,0),(4,'10% Percent','10% Percent','10% Percent',10.00000,0,1,'2018-03-27 10:12:32',0,NULL,0,NULL,0),(5,'15% Percent','15% Percent','15% Percent',15.00000,0,1,'2018-03-27 10:12:49',0,NULL,0,NULL,0);
/*!40000 ALTER TABLE `refdiscounttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refproduct`
--

DROP TABLE IF EXISTS `refproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refproduct` (
  `refproduct_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`refproduct_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refproduct`
--

LOCK TABLES `refproduct` WRITE;
/*!40000 ALTER TABLE `refproduct` DISABLE KEYS */;
INSERT INTO `refproduct` VALUES (1,'Companion Animals','Common house pets',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0),(2,'Livestock Animals','Farm animals',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0),(3,'All Product type','',0,0,'2017-07-05 11:51:47','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `refproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rights_links`
--

DROP TABLE IF EXISTS `rights_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rights_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_code` varchar(100) DEFAULT '',
  `link_code` varchar(20) DEFAULT NULL,
  `link_name` varchar(255) DEFAULT '',
  PRIMARY KEY (`link_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights_links`
--

LOCK TABLES `rights_links` WRITE;
/*!40000 ALTER TABLE `rights_links` DISABLE KEYS */;
INSERT INTO `rights_links` VALUES (1,'1','1-1','General Journal'),(2,'1','1-2','Cash Disbursement'),(3,'1','1-3','Purchase Journal'),(4,'1','1-4','Sales Journal'),(5,'1','1-5','Cash Receipt'),(6,'2','2-1','Purchase Order'),(7,'2','2-2','Purchase Invoice'),(8,'2','2-3','Record Payment'),(10,'15','15-3','Item Adjustment'),(11,'3','3-1','Sales Order'),(12,'3','3-2','Sales Invoice'),(13,'3','3-3','Record Payment'),(14,'4','4-2','Category Management'),(15,'4','4-3','Department Management'),(16,'4','4-4','Unit Management'),(17,'5','5-1','Product Management'),(18,'5','5-2','Supplier Management'),(19,'5','5-3','Customer Management'),(20,'6','6-1','Setup Tax'),(21,'6','6-2','Setup Chart of Accounts'),(22,'6','6-3','Account Integration'),(23,'6','6-4','Setup User Group'),(24,'6','6-5','Create User Account'),(25,'6','6-6','Setup Company Info'),(26,'7','7-1','Purchase Order for Approval'),(27,'9','9-1','Balance Sheet Report'),(28,'9','9-2','Income Statement'),(29,'4','4-1','Account Classification'),(30,'8','8-1','Sales Report'),(31,'15','15-4','Inventory Report'),(32,'5','5-4','Salesperson Management'),(33,'2','2-6','Item Adjustment (Out)'),(34,'8','8-3','Export Sales Summary'),(35,'9','9-3','Export Trial Balance'),(36,'6','6-7','Setup Check Layout'),(37,'9','9-4','AR Schedule'),(38,'9','9-6','Customer Subsidiary'),(39,'9','9-8','Account Subsidiary'),(40,'9','9-7','Supplier Subsidiary'),(41,'9','9-5','AP Schedule'),(42,'8','8-4','Purchase Invoice Report'),(43,'4','4-5','Locations Management'),(44,'10','10-1','Fixed Asset Management'),(45,'9','9-9','Annual Income Statement'),(46,'6','6-8','Recurring Template'),(47,'9','9-10','VAT Relief Report'),(48,'1','1-6','Petty Cash Journal'),(49,'9','9-13','Replenishment Report'),(50,'6','6-9','Backup Database'),(51,'9','9-14','Book of Accounts'),(52,'9','9-16','Comparative Income'),(53,'4','4-6','Bank Reference Management'),(54,'10','10-2','Depreciation Expense Report'),(55,'11','11-1','Bank Reconciliation'),(57,'12','12-1','Voucher Registry Report'),(58,'12','12-2','Check Registry Report'),(59,'12','12-3','Collection List Report'),(60,'12','12-4','Open Purchase Report'),(61,'12','12-5','Open Sales Report'),(62,'9','9-11','Schedule of Expense'),(63,'9','9-15','AR Reports'),(64,'9','9-12','Cost of Goods'),(65,'13','13-1','Service Invoice'),(66,'13','13-2','Service Journal'),(67,'13','13-3','Service Unit Management'),(68,'13','13-4','Service Management'),(69,'9','9-17','Aging of Receivables'),(70,'9','9-18','Aging of Payables'),(71,'9','9-19','Statement of Account'),(72,'6','6-10','Email Settings'),(73,'14','14-1','Treasury'),(74,'9','9-20','Replenishment Batch Report'),(75,'9','9-21','General Ledger'),(76,'6','6-11','Email Report'),(77,'12','12-6','Product Reorder (Pick-list)'),(78,'12','12-7','Product List Report'),(79,'2','2-8','Purchase History'),(80,'2','2-7','Purchase Monitoring'),(81,'6','6-12','Puchasing Integration'),(82,'15','15-1','Product Management (Inventory Tab)'),(83,'3','3-4','Cash Invoice'),(84,'6','6-13','Audit Trail'),(85,'15','15-5','Item Transfer to Department'),(86,'15','15-6','Stock Card / Bin Card'),(87,'3','3-5','Warehouse Dispatching'),(88,'4','4-7','Brands'),(89,'16','16-1','Monthly Percentage Tax Return'),(90,'16','16-2','Quarterly Percentage Tax Return'),(91,'16','16-3','Certificate of Creditable Tax'),(92,'6','6-14','Statement of Accounts Settings'),(93,'5','5-5','Meter Inventory Management');
/*!40000 ALTER TABLE `rights_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoice`
--

DROP TABLE IF EXISTS `sales_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoice` (
  `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  `for_dispatching` bit(1) DEFAULT b'0',
  `closing_reason` varchar(445) DEFAULT '',
  `closed_by_user` bigint(20) DEFAULT '0',
  `is_closed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`sales_invoice_id`) USING BTREE,
  UNIQUE KEY `sales_inv_no` (`sales_inv_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice`
--

LOCK TABLES `sales_invoice` WRITE;
/*!40000 ALTER TABLE `sales_invoice` DISABLE KEYS */;
INSERT INTO `sales_invoice` VALUES (1,'SAL-INV-20181017-1',0,'',2,1,NULL,1,39,0,'',0.0000,0.0000,0.0000,2100.0000,2100.0000,0.0000,2100.0000,'2018-10-17','2018-10-17','2018-10-17 14:44:53','0000-00-00 00:00:00','2019-02-06 06:12:57',1,0,0,'\0','','\0','',0,1,2,'N/A','N/A',0,0,'\0','',0,'\0'),(2,'SAL-INV-20181213-2',0,'',1,2,NULL,1,55,0,'',0.0000,0.0000,0.0000,50.0000,44.6400,5.3600,50.0000,'2018-12-13','2018-12-13','2018-12-13 10:31:40','0000-00-00 00:00:00','2019-02-06 06:12:57',1,0,0,'\0','','\0','',0,1,2,'N/A','N/A',0,0,'\0','',0,'\0'),(3,'SAL-INV-20181217-3',0,'',1,2,NULL,2,44,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.0000,0.0000,0.0000,100.0000,89.2900,10.7100,100.0000,'2018-12-17','2018-12-17','2018-12-17 11:19:25','0000-00-00 00:00:00','2019-02-06 06:12:57',1,0,1,'\0','','\0','',0,1,1,'Various Customers','Various Customers',0,0,'\0','',0,'\0'),(4,'SAL-INV-20190103-4',0,'',1,1,NULL,1,0,0,'',0.0000,0.0000,0.0000,200.0000,178.5700,21.4300,200.0000,'2019-01-03','2019-01-03','2019-01-03 11:36:12','0000-00-00 00:00:00','2019-02-06 06:12:24',1,0,1,'\0','','\0','\0',0,1,1,'N/A','N/A',0,0,'\0','Close Sales',1,''),(10,'SAL-INV-20190322-10',0,'',1,3,NULL,2,64,0,'',0.0000,0.0000,0.0000,250.0000,223.2100,26.7900,250.0000,'2019-03-22','2019-03-22','2019-03-22 13:54:08','0000-00-00 00:00:00','2019-03-22 05:54:19',1,0,0,'\0','','\0','',0,1,NULL,'Various Customers Various Customers Various Customers Various Customers Various Customers Various Customers','Various Customers',0,0,'\0','',0,'\0'),(11,'SAL-INV-20190322-11',0,'',1,2,NULL,2,0,0,'12',0.0000,0.0000,0.0000,200.0000,178.5700,21.4300,200.0000,'2019-03-22','2019-03-22','2019-03-22 13:54:44','0000-00-00 00:00:00','2019-03-22 05:54:45',1,0,0,'\0','','\0','\0',0,1,2,'Various Customers Various Customers Various Customers Various Customers Various Customers Various Customers','Various Customers',0,0,'\0','',0,'\0');
/*!40000 ALTER TABLE `sales_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoice_items`
--

DROP TABLE IF EXISTS `sales_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoice_items` (
  `sales_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `is_parent` tinyint(1) DEFAULT '1',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,2) DEFAULT '0.00',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`sales_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice_items`
--

LOCK TABLES `sales_invoice_items` WRITE;
/*!40000 ALTER TABLE `sales_invoice_items` DISABLE KEYS */;
INSERT INTO `sales_invoice_items` VALUES (1,1,1,1,1,210.0000,0.0000,0.0000,0.0000,0.0000,0.0000,10.00,2100.0000,2100.0000,0.0000,2100.0000,2100.0000,NULL,NULL,'0000-00-00',''),(2,2,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,50.0000,50.0000,5.3600,44.6400,50.0000,NULL,NULL,'0000-00-00',''),(4,3,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,2.00,100.0000,100.0000,10.7143,89.2857,100.0000,NULL,NULL,'0000-00-00',''),(6,4,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,200.0000,200.0000,21.4286,178.5714,200.0000,NULL,NULL,'0000-00-00',''),(7,10,4,1,1,50.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,50.0000,50.0000,5.3600,44.6400,50.0000,NULL,NULL,'0000-00-00',''),(8,10,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,200.0000,200.0000,21.4300,178.5700,200.0000,NULL,NULL,'0000-00-00',''),(9,11,6,1,1,200.0000,0.0000,0.0000,0.0000,12.0000,0.0000,1.00,200.0000,200.0000,21.4300,178.5700,200.0000,NULL,NULL,'0000-00-00','');
/*!40000 ALTER TABLE `sales_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order` (
  `sales_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `so_no` varchar(75) DEFAULT '',
  `customer_id` bigint(20) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `order_status_id` int(11) DEFAULT '1',
  `date_order` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `salesperson_id` int(11) DEFAULT '0',
  `customer_type_id` bigint(20) DEFAULT '0',
  `order_source_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`sales_order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
INSERT INTO `sales_order` VALUES (1,'SO-20181217-1',1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0.00,0.0000,0.0000,44.64,50.00,50.0000,5.36,1,'2018-12-17','2018-12-17 11:48:51',NULL,'0000-00-00 00:00:00',1,0,0,'','\0',NULL,0,0);
/*!40000 ALTER TABLE `sales_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order_items`
--

DROP TABLE IF EXISTS `sales_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order_items` (
  `sales_order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT '1',
  `so_qty` decimal(20,2) DEFAULT '0.00',
  `so_price` decimal(20,4) DEFAULT '0.0000',
  `so_discount` decimal(20,4) DEFAULT '0.0000',
  `so_gross` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `so_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `so_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `so_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `dr_invoice_id` int(11) DEFAULT NULL,
  `batch_no` varchar(55) DEFAULT '',
  PRIMARY KEY (`sales_order_item_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_items`
--

LOCK TABLES `sales_order_items` WRITE;
/*!40000 ALTER TABLE `sales_order_items` DISABLE KEYS */;
INSERT INTO `sales_order_items` VALUES (1,1,4,1,1,1.00,50.0000,0.0000,50.0000,0.0000,12.0000,50.0000,5.3600,44.6400,'1970-01-01',NULL,NULL);
/*!40000 ALTER TABLE `sales_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salesperson`
--

DROP TABLE IF EXISTS `salesperson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salesperson` (
  `salesperson_id` int(11) NOT NULL AUTO_INCREMENT,
  `salesperson_code` varchar(55) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `acr_name` varchar(10) DEFAULT NULL,
  `contact_no` varchar(100) NOT NULL,
  `department_id` int(2) NOT NULL,
  `tin_no` varchar(100) NOT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`salesperson_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salesperson`
--

LOCK TABLES `salesperson` WRITE;
/*!40000 ALTER TABLE `salesperson` DISABLE KEYS */;
INSERT INTO `salesperson` VALUES (1,'Rafael Manalo','Rafael ','','Manalo',NULL,'',1,'','','\0','2019-02-06 14:11:59','0000-00-00 00:00:00',1),(2,'Joash Noble','Joash','','Noble',NULL,'',1,'','','\0','2019-02-06 14:12:21','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `salesperson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sched_expense_integration`
--

DROP TABLE IF EXISTS `sched_expense_integration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sched_expense_integration` (
  `sched_expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  PRIMARY KEY (`sched_expense_id`) USING BTREE,
  UNIQUE KEY `account_id` (`account_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sched_expense_integration`
--

LOCK TABLES `sched_expense_integration` WRITE;
/*!40000 ALTER TABLE `sched_expense_integration` DISABLE KEYS */;
/*!40000 ALTER TABLE `sched_expense_integration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_connection`
--

DROP TABLE IF EXISTS `service_connection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_connection` (
  `connection_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_no` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT '0',
  `account_no` varchar(255) DEFAULT NULL,
  `contract_type_id` int(12) DEFAULT '0',
  `service_date` date DEFAULT NULL,
  `connection_date` date DEFAULT NULL,
  `receipt_name` varchar(255) DEFAULT NULL,
  `target_date` date DEFAULT '0000-00-00',
  `target_time` time DEFAULT '00:00:00',
  `rate_type_id` int(12) DEFAULT '0',
  `initial_meter_reading` varchar(255) DEFAULT NULL,
  `attended_by` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT '0000-00-00',
  `created_by` int(12) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `status_id` int(12) DEFAULT '1',
  `current_id` bigint(20) DEFAULT '0',
  `meter_inventory_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`connection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='current_id  is the log for the current status id';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_connection`
--

LOCK TABLES `service_connection` WRITE;
/*!40000 ALTER TABLE `service_connection` DISABLE KEYS */;
INSERT INTO `service_connection` VALUES (1,'SCN-20190517-1',13,'ACN-20190517-1',1,'2019-05-17','2019-05-17','Joash Jezreel L. Noble','2019-05-31','15:00:00',1,'34234','Joash','2019-05-17',8,'\0','',2,2,1);
/*!40000 ALTER TABLE `service_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_disconnection`
--

DROP TABLE IF EXISTS `service_disconnection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_disconnection` (
  `disconnection_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `disconnection_code` varchar(445) DEFAULT '',
  `connection_id` bigint(20) DEFAULT '0',
  `service_date` date DEFAULT '0000-00-00',
  `date_disconnection_date` date DEFAULT '0000-00-00',
  `disconnection_reason_id` int(11) DEFAULT '0',
  `last_meter_reading` bigint(20) DEFAULT '0',
  `disconnection_notes` varchar(45) DEFAULT '',
  `date_created` date DEFAULT '0000-00-00',
  `created_by` int(12) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `service_no` varchar(255) DEFAULT NULL,
  `previous_id` bigint(20) DEFAULT '0',
  `previous_status_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`disconnection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_disconnection`
--

LOCK TABLES `service_disconnection` WRITE;
/*!40000 ALTER TABLE `service_disconnection` DISABLE KEYS */;
INSERT INTO `service_disconnection` VALUES (1,'SDN-20190517-1',1,'2019-05-17','2019-05-17',1,243245324,'','2019-05-17',8,'','\0','SCN-20190517-1',1,1),(2,'SDN-20190517-2',1,'2019-05-17','2019-05-17',1,32,'','2019-05-17',8,'','\0','SDN-20190517-1',1,3);
/*!40000 ALTER TABLE `service_disconnection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice`
--

DROP TABLE IF EXISTS `service_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_invoice` (
  `service_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_invoice_no` varchar(75) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT NULL,
  `total_amount` decimal(25,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_amount_after_discount` decimal(20,4) DEFAULT '0.0000',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_due` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `remarks` text,
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `contact_person` varchar(175) DEFAULT NULL,
  PRIMARY KEY (`service_invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice`
--

LOCK TABLES `service_invoice` WRITE;
/*!40000 ALTER TABLE `service_invoice` DISABLE KEYS */;
INSERT INTO `service_invoice` VALUES (1,'SER-INV-20181218-1',3,1,NULL,'N/A',12.00,0.0000,0.0000,12.0000,'2018-12-18','2018-12-18','2018-12-18 10:38:58','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','\0',0,'N/A'),(2,'SER-INV-20181218-2',1,2,NULL,'Various Customers',12.00,0.0000,0.0000,12.0000,'2018-12-18','2018-12-18','2018-12-18 10:45:53','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','',51,'Various Customers');
/*!40000 ALTER TABLE `service_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice_items`
--

DROP TABLE IF EXISTS `service_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_invoice_items` (
  `service_item_id` bigint(25) NOT NULL AUTO_INCREMENT,
  `service_invoice_id` bigint(25) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `service_unit` int(11) DEFAULT '0',
  `service_price` decimal(25,2) DEFAULT '0.00',
  `service_qty` int(11) DEFAULT '0',
  `service_line_total` decimal(25,2) DEFAULT '0.00',
  `service_line_total_after_global` decimal(25,4) DEFAULT '0.0000',
  PRIMARY KEY (`service_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice_items`
--

LOCK TABLES `service_invoice_items` WRITE;
/*!40000 ALTER TABLE `service_invoice_items` DISABLE KEYS */;
INSERT INTO `service_invoice_items` VALUES (1,1,1,1,12.00,1,12.00,12.0000),(2,2,1,1,12.00,1,12.00,12.0000);
/*!40000 ALTER TABLE `service_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_reconnection`
--

DROP TABLE IF EXISTS `service_reconnection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_reconnection` (
  `reconnection_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reconnection_code` varchar(255) DEFAULT NULL,
  `service_date` date DEFAULT '0000-00-00',
  `disconnection_id` bigint(20) DEFAULT '0',
  `date_connection_target` date DEFAULT '0000-00-00',
  `time_connection_target` varchar(255) DEFAULT NULL,
  `rate_type_id` int(12) DEFAULT '0',
  `date_created` date DEFAULT '0000-00-00',
  `created_by` int(12) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`reconnection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_reconnection`
--

LOCK TABLES `service_reconnection` WRITE;
/*!40000 ALTER TABLE `service_reconnection` DISABLE KEYS */;
INSERT INTO `service_reconnection` VALUES (1,'SDN-20190517-1','2019-05-17',1,'2019-05-17','15:00',1,'2019-05-17',8,1,0);
/*!40000 ALTER TABLE `service_reconnection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_unit`
--

DROP TABLE IF EXISTS `service_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_unit` (
  `service_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_unit_name` varchar(255) DEFAULT NULL,
  `service_unit_desc` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`service_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_unit`
--

LOCK TABLES `service_unit` WRITE;
/*!40000 ALTER TABLE `service_unit` DISABLE KEYS */;
INSERT INTO `service_unit` VALUES (1,'Unit','Unit','\0','');
/*!40000 ALTER TABLE `service_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `service_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_code` varchar(255) DEFAULT NULL,
  `service_desc` varchar(255) DEFAULT NULL,
  `service_unit` varchar(255) DEFAULT NULL,
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `service_amount` decimal(25,2) DEFAULT '0.00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'12','12','1',0,0,12.00,'','\0',0,0,0);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sex`
--

DROP TABLE IF EXISTS `sex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sex` (
  `sex_id` int(11) NOT NULL AUTO_INCREMENT,
  `sex_name` varchar(45) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`sex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sex`
--

LOCK TABLES `sex` WRITE;
/*!40000 ALTER TABLE `sex` DISABLE KEYS */;
INSERT INTO `sex` VALUES (1,'Male','','\0'),(2,'Female','','\0');
/*!40000 ALTER TABLE `sex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soa_settings`
--

DROP TABLE IF EXISTS `soa_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soa_settings` (
  `soa_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `soa_account_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`soa_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soa_settings`
--

LOCK TABLES `soa_settings` WRITE;
/*!40000 ALTER TABLE `soa_settings` DISABLE KEYS */;
INSERT INTO `soa_settings` VALUES (1,5),(2,6),(3,59);
/*!40000 ALTER TABLE `soa_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(12) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'New Meter','','\0'),(2,'Connected','','\0'),(3,'Disconnected','','\0'),(4,'Reconnected','','\0');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_photos`
--

DROP TABLE IF EXISTS `supplier_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`photo_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_photos`
--

LOCK TABLES `supplier_photos` WRITE;
/*!40000 ALTER TABLE `supplier_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(125) DEFAULT '',
  `supplier_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(255) DEFAULT '',
  `tin_no` varchar(255) DEFAULT '',
  `term` varchar(255) DEFAULT '',
  `tax_type_id` int(11) DEFAULT '1',
  `photo_path` varchar(500) DEFAULT '',
  `total_payable_amount` decimal(19,2) DEFAULT '0.00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `credit_limit` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `tax_output` int(11) DEFAULT '0',
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'N/A','N/A','','','','','','','',1,'',1483.35,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(2,'','Owners','Owners','','Owners','Owners','Owners','Owners','',1,'assets/img/anonymous-icon.png',30080.00,1,'2018-10-03 17:27:14','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(3,'','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','','Don\'s Original Spanish Original Churros\r\nDon\'s Original Spanish Original Churros\r\nDon\'s Original Spanish Original Churros\r\nDon\'s Original Spanish Original Churros\r\nDon\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','Don\'s Original Spanish Original Churros','',1,'assets/img/anonymous-icon.png',300.00,1,'2018-10-03 17:28:06','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(4,'','NCR Construction Supply','NCR Construction Supply','','Angeles City, Pampanga','NCR Construction Supply','NCR Construction Supply','321645987000','',2,'assets/img/anonymous-icon.png',31535.00,1,'2018-10-03 17:28:20','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(5,'','Jenra Supermarket','Jenra Supermarket','','Jenra Supermarket','Jenra Supermarket','Jenra Supermarket','Jenra Supermarket','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:29:52','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(6,'','JAMM Fire Extinguisher Enterprise','JAMM Fire Extinguisher Enterprise','','JAMM Fire Extinguisher Enterprise','JAMM Fire Extinguisher Enterprise','JAMM Fire Extinguisher Enterprise','JAMM Fire Extinguisher Enterprise','',1,'assets/img/anonymous-icon.png',1120.00,1,'2018-10-03 17:30:38','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(7,'','Converge ICT Solutions INC.','Converge ICT Solutions INC.','','Converge ICT Solutions INC.','Converge ICT Solutions INC.','Converge ICT Solutions INC.','Converge ICT Solutions INC.','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:30:57','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(8,'','Balibago Waterworks System, INC','Balibago Waterworks System, INC','','Balibago Waterworks System, INC','Balibago Waterworks System, INC','Balibago Waterworks System, INC','Balibago Waterworks System, INC','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:31:23','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(9,'','Angeles Electric Corporation','Angeles Electric Corporation','','Angeles Electric Corporation','Angeles Electric Corporation','Angeles Electric Corporation','Angeles Electric Corporation','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:31:42','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(10,'','LA Purified Drinking Water','LA Purified Drinking Water','','LA Purified Drinking Water','LA Purified Drinking Water','LA Purified Drinking Water','LA Purified Drinking Water','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:31:59','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(11,'','Fornax Facility Supplies and Services Inc.','Fornax Facility Supplies and Services Inc.','','Fornax Facility Supplies and Services Inc.','Fornax Facility Supplies and Services Inc.','Fornax Facility Supplies and Services Inc.','Fornax Facility Supplies and Services Inc.','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:32:11','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(12,'','Book One Office Supply','Book One Office Supply','','Book One Office Supply','Book One Office Supply','Book One Office Supply','Book One Office Supply','',1,'assets/img/anonymous-icon.png',-8000.00,1,'2018-10-03 17:32:22','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(13,'','Digiworx Computer & Office Solutions, Inc.','Digiworx Computer & Office Solutions, Inc.','','Digiworx Computer & Office Solutions, Inc.','Digiworx Computer & Office Solutions, Inc.','Digiworx Computer & Office Solutions, Inc.','Digiworx Computer & Office Solutions, Inc.','',1,'assets/img/anonymous-icon.png',719790.00,1,'2018-10-03 17:32:47','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(14,'','Office Warehouse Inc.','Office Warehouse Inc.','','Office Warehouse Inc.','Office Warehouse Inc.','Office Warehouse Inc.','Office Warehouse Inc.','',1,'assets/img/anonymous-icon.png',287025.00,1,'2018-10-03 17:33:06','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(15,'','FedEx','FedEx','','FedEx','FedEx','FedEx','FedEx','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:33:17','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(16,'','Puregold','Puregold','','Puregold','Puregold','Puregold','Puregold','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-03 17:33:33','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(17,'','aa','aa','','aa','aa','aa','aa','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-04 09:41:03','0000-00-00 00:00:00',NULL,'','',1,'2018-10-11 09:36:02',1),(18,'','qwe','qwe','','qwe','qwe','qwe','we','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-10-04 13:32:02','0000-00-00 00:00:00',NULL,'','',1,'2018-10-11 09:36:06',0),(19,'','SAN MIGUEL BEER INC','JEFERSON HALILI','','SAN FERNANDO BREWERY ','SANMIGUEL@GMAIL.COM','09125643678','213-098-121-001','',2,'assets/img/anonymous-icon.png',0.00,1,'2018-10-18 11:51:08','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',NULL),(20,'','234','234','','234','234','234','234','',2,'assets/img/anonymous-icon.png',0.00,1,'2018-10-19 09:54:47','0000-00-00 00:00:00',NULL,'','',1,'2018-10-19 09:54:59',234),(21,'','deleted','deleted','','deleted','deleted','deleted','deleted','',1,'assets/img/anonymous-icon.png',0.00,1,'2018-11-15 11:06:05','0000-00-00 00:00:00',NULL,'','',1,'2018-11-15 11:06:08',0),(22,'','JDEV OFFICE SOLUTION INC','JDEV OFFICE SOLUTION INC','','JDEV OFFICE SOLUTION INC','JDEV OFFICE SOLUTION INC',NULL,'JDEV OFFICE SOLUTION INC','',1,'assets/img/anonymous-icon.png',0.00,7,'2018-12-19 11:52:05','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0),(23,'','ID Factory Inc','OIC','','mobile_no','mobile_no',NULL,'24324','',1,'assets/img/anonymous-icon.png',0.00,1,'2019-02-18 12:05:15','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',12),(24,'','Supplier Name','Contact Person','','Address','jdevtechsolution@gmail.com','0945351510520','6135263510','',1,'assets/img/anonymous-icon.png',0.00,1,'2019-03-27 11:06:53','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_types`
--

DROP TABLE IF EXISTS `tax_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax_types` (
  `tax_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_type` varchar(155) DEFAULT '',
  `tax_rate` decimal(11,2) DEFAULT '0.00',
  `description` varchar(555) DEFAULT '',
  `is_default` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`tax_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_types`
--

LOCK TABLES `tax_types` WRITE;
/*!40000 ALTER TABLE `tax_types` DISABLE KEYS */;
INSERT INTO `tax_types` VALUES (1,'Non-vat',0.00,'','\0','\0'),(2,'Vatted',12.00,'','','\0');
/*!40000 ALTER TABLE `tax_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans`
--

DROP TABLE IF EXISTS `trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0',
  `trans_key_id` bigint(20) DEFAULT NULL,
  `trans_type_id` bigint(20) DEFAULT NULL,
  `trans_log` varchar(745) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=681 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans`
--

LOCK TABLES `trans` WRITE;
/*!40000 ALTER TABLE `trans` DISABLE KEYS */;
INSERT INTO `trans` VALUES (1,1,1,52,'Created a new customer: N/A','2018-10-03 17:18:41'),(2,1,1,52,'Created a new customer: Various Customers','2018-10-03 17:20:20'),(3,1,1,46,'Created Department: Accounting','2018-10-03 17:20:30'),(4,1,1,46,'Created Department: Human Resources','2018-10-03 17:20:42'),(5,1,1,46,'Created Department: IT ','2018-10-03 17:21:14'),(6,1,1,46,'Created Department: Restaurant','2018-10-03 17:22:00'),(7,1,1,46,'Created Department: Purchasing','2018-10-03 17:23:17'),(8,1,1,46,'Created Department: Audio Visual','2018-10-03 17:24:22'),(9,1,1,46,'Created Department: Treasury','2018-10-03 17:25:54'),(10,1,1,46,'Created Department: Maintenance','2018-10-03 17:26:38'),(11,1,1,51,'Created a Supplier: Owners','2018-10-03 17:27:14'),(12,1,1,51,'Created a Supplier: Don\'s Original Spanish Original Churros','2018-10-03 17:28:06'),(13,1,1,51,'Created a Supplier: Hotel ABC','2018-10-03 17:28:20'),(14,1,2,51,'Updated a Supplier : NCR Construction Supply ID(4)','2018-10-03 17:29:35'),(15,1,1,51,'Created a Supplier: Jenra Supermarket','2018-10-03 17:29:52'),(16,1,1,51,'Created a Supplier: JAMM Fire Extinguisher Enterprise','2018-10-03 17:30:38'),(17,1,1,51,'Created a Supplier: Converge ICT Solutions INC.','2018-10-03 17:30:57'),(18,1,1,51,'Created a Supplier: Balibago Waterworks System, INC','2018-10-03 17:31:23'),(19,1,1,51,'Created a Supplier: Angeles Electric Corporation','2018-10-03 17:31:42'),(20,1,1,51,'Created a Supplier: LA Purified Drinking Water','2018-10-03 17:31:59'),(21,1,1,51,'Created a Supplier: Fornax Facility Supplies and Services Inc.','2018-10-03 17:32:11'),(22,1,1,51,'Created a Supplier: Book One Office Supply','2018-10-03 17:32:22'),(23,1,1,51,'Created a Supplier: Digiworx Computer & Office Solutions, Inc.','2018-10-03 17:32:47'),(24,1,1,51,'Created a Supplier: Office Warehouse Inc.','2018-10-03 17:33:06'),(25,1,1,51,'Created a Supplier: FedEx','2018-10-03 17:33:17'),(26,1,1,51,'Created a Supplier: Puregold','2018-10-03 17:33:33'),(27,1,1,52,'Created a new customer: Cristina Joy Punzalan','2018-10-03 17:34:14'),(28,1,7,43,'User Log Out :System  Administrator','2018-10-03 17:35:29'),(29,1,6,43,'User Log in: System  Administrator','2018-10-03 17:35:35'),(30,1,3,56,'Deleted Account: Cash Advances','2018-10-03 17:36:19'),(31,1,3,56,'Deleted Account: Check Advances','2018-10-03 17:36:21'),(32,1,3,56,'Deleted Account: Card Advances','2018-10-03 17:36:24'),(33,1,3,56,'Deleted Account: Charge Advances','2018-10-03 17:36:26'),(34,1,3,56,'Deleted Account: Advance Bank Deposit','2018-10-03 17:36:28'),(35,1,3,56,'Deleted Account: Advance Sales','2018-10-03 17:36:32'),(36,1,1,1,'Created General Journal TXN-20181003-1','2018-10-03 17:37:29'),(37,1,1,4,'Created Sales Journal Entry TXN-20181003-2','2018-10-03 17:38:15'),(38,1,1,6,'Created Cash Receipt Journal Entry TXN-20181003-3','2018-10-03 17:40:02'),(39,1,1,49,'Created Bank: Security Bank','2018-10-03 17:40:11'),(40,1,1,49,'Created Bank: Banco De Oro','2018-10-03 17:40:24'),(41,1,1,49,'Created Bank: Maybank','2018-10-03 17:40:40'),(42,1,1,3,'Created Purchase Journal Entry TXN-20181003-4','2018-10-03 17:41:27'),(43,1,1,3,'Created Purchase Journal Entry TXN-20181003-5','2018-10-03 17:41:57'),(44,1,1,3,'Created Purchase Journal Entry TXN-20181003-6','2018-10-03 17:42:30'),(45,1,1,2,'Created Cash Disbursement Entry TXN-20181003-7','2018-10-03 17:44:20'),(46,1,1,49,'Created Bank: GRB','2018-10-03 17:44:54'),(47,1,1,2,'Created Cash Disbursement Entry TXN-20181003-8','2018-10-03 17:45:12'),(48,1,1,2,'Created Cash Disbursement Entry TXN-20181003-9','2018-10-03 17:46:01'),(49,1,1,2,'Created Cash Disbursement Entry TXN-20181003-10','2018-10-03 17:47:20'),(50,1,1,2,'Created Cash Disbursement Entry TXN-20181003-11','2018-10-03 17:47:58'),(51,1,1,2,'Created Cash Disbursement Entry TXN-20181003-12','2018-10-03 17:48:40'),(52,1,2,60,'Modified Company Information','2018-10-03 17:49:56'),(53,1,2,43,'Updated User : admin ID(1)','2018-10-03 17:50:10'),(54,1,7,43,'User Log Out :System  Administrator','2018-10-03 17:50:13'),(55,1,6,43,'User Log in: System  Administrator','2018-10-03 17:50:17'),(56,1,6,43,'User Log in: System  Administrator','2018-10-04 08:35:02'),(57,1,1,5,'Posted Petty Cash Journal Entry PCV-20181004-13','2018-10-04 08:41:38'),(58,1,1,5,'Posted Petty Cash Journal Entry PCV-20181004-14','2018-10-04 08:42:35'),(59,1,1,5,'Posted Petty Cash Journal Entry PCV-20181004-15','2018-10-04 08:43:20'),(60,1,1,5,'Posted Petty Cash Journal Entry PCV-20181004-16','2018-10-04 08:47:31'),(61,1,2,5,'Updated Petty Cash Journal Entry PCV-20181004-15','2018-10-04 08:47:42'),(62,1,1,1,'Created General Journal TXN-20181004-17','2018-10-04 08:59:28'),(63,1,1,52,'Created a new customer: asd','2018-10-04 09:39:44'),(64,1,1,51,'Created a Supplier: aa','2018-10-04 09:41:03'),(65,1,6,43,'User Log in: System  Administrator','2018-10-04 12:14:24'),(66,1,1,52,'Created a new customer: ','2018-10-04 12:15:58'),(67,1,1,52,'Created a new customer: 123123123','2018-10-04 12:16:07'),(68,1,1,52,'Created a new customer: qwe','2018-10-04 13:31:37'),(69,1,1,46,'Created Department: qwe','2018-10-04 13:31:47'),(70,1,1,51,'Created a Supplier: qwe','2018-10-04 13:32:03'),(71,1,1,1,'Created General Journal TXN-20181004-18','2018-10-04 13:32:17'),(72,0,10,43,'Login Attempt using username: admin','2018-10-11 09:19:22'),(73,1,6,43,'User Log in: System  Administrator','2018-10-11 09:19:28'),(74,1,1,56,'Created a new Account : Withholding Tax Payable','2018-10-11 09:25:24'),(75,1,2,57,'Updated Supplier Configuration','2018-10-11 09:25:32'),(76,1,2,51,'Updated a Supplier : NCR Construction Supply ID(4)','2018-10-11 09:26:53'),(77,1,1,2,'Created Cash Disbursement Entry TXN-20181011-19','2018-10-11 09:28:50'),(78,1,7,43,'User Log Out :System  Administrator','2018-10-11 09:30:41'),(79,1,6,43,'User Log in: System  Administrator','2018-10-11 09:30:47'),(80,1,2,60,'Modified Company Information','2018-10-11 09:32:28'),(81,1,7,43,'User Log Out :System  Administrator','2018-10-11 09:32:32'),(82,1,6,43,'User Log in: System  Administrator','2018-10-11 09:32:35'),(83,1,1,1,'Created General Journal TXN-20181011-20','2018-10-11 09:33:15'),(84,1,3,51,'Deleted Supplier: aa','2018-10-11 09:36:02'),(85,1,3,51,'Deleted Supplier: qwe','2018-10-11 09:36:07'),(86,1,3,52,'Deleted : asd','2018-10-11 10:35:53'),(87,1,3,52,'Deleted : asd','2018-10-11 10:35:53'),(88,1,3,52,'Deleted : 1','2018-10-11 10:35:57'),(89,1,3,52,'Deleted : 123','2018-10-11 10:36:00'),(90,1,3,52,'Deleted : qwe','2018-10-11 10:36:03'),(91,1,2,43,'Updated User : admin ID(1)','2018-10-11 10:36:30'),(92,1,7,43,'User Log Out :System  Administrator','2018-10-11 10:37:42'),(93,1,6,43,'User Log in: System  Administrator','2018-10-11 10:37:47'),(94,1,1,45,'Created Category: Hardware','2018-10-11 10:40:21'),(95,1,1,47,'Created  Unit: Piece','2018-10-11 10:40:32'),(96,1,1,50,'Created a new Product: Computer Keyboard','2018-10-11 10:41:06'),(97,1,1,50,'Created a new Product: Dell Laptop i5 1TB Storage','2018-10-11 10:43:35'),(98,1,1,50,'Created a new Product: Computer Mouse','2018-10-11 10:45:00'),(99,1,1,11,'Created Purchase Order No: PO-20181011-1','2018-10-11 10:46:00'),(100,1,1,11,'Created Purchase Order No: PO-20181011-2','2018-10-11 10:46:40'),(101,1,1,11,'Created Purchase Order No: PO-20181011-3','2018-10-11 10:48:08'),(102,1,1,12,'Created Purchase Invoice No: P-INV-20181011-1','2018-10-11 10:48:37'),(103,1,1,12,'Created Purchase Invoice No: P-INV-20181011-2','2018-10-11 10:49:17'),(104,1,8,12,'Finalized Purchase Invoice No.P-INV-20181011-2 For Purchase Journal Entry TXN-20181011-21','2018-10-11 10:49:59'),(105,1,1,3,'Created Purchase Journal Entry TXN-20181011-21','2018-10-11 10:49:59'),(106,1,1,16,'Created Sales Order No: SO-20181011-1','2018-10-11 10:50:53'),(107,1,1,65,'Created Cash Invoice No: CI-INV-20181011-1','2018-10-11 10:51:30'),(108,1,1,17,'Created Sales Invoice No: SAL-INV-20181011-1','2018-10-11 10:52:15'),(109,1,2,65,'Updated Cash Invoice No: CI-INV-20181011-1','2018-10-11 10:52:32'),(110,1,1,12,'Created Purchase Invoice No: P-INV-20181011-3','2018-10-11 10:53:10'),(111,1,1,15,'Created Adjustment No: ADJ-20181011-1','2018-10-11 10:54:12'),(112,1,1,66,'Created Issuance No: TRN-20181011-1','2018-10-11 10:55:11'),(113,1,3,46,'Deleted Department: qwe','2018-10-11 10:57:45'),(114,1,1,13,'Posted Payment No: REC01 to Record Payment','2018-10-11 10:59:04'),(115,1,8,13,'Finalized Payment No.REC01 (1)For Cash Disbursement','2018-10-11 10:59:40'),(116,1,1,2,'Created Cash Disbursement Entry TXN-20181011-22','2018-10-11 10:59:40'),(117,1,1,48,'Created Location: Admin Office','2018-10-11 11:05:25'),(118,1,1,48,'Created Location: Central Warehouse','2018-10-11 11:06:19'),(119,1,1,1,'Created General Journal TXN-20181011-23','2018-10-11 11:11:02'),(120,1,1,1,'Created General Journal TXN-20181011-24','2018-10-11 11:11:27'),(121,1,1,1,'Created General Journal TXN-20181011-25','2018-10-11 11:14:24'),(122,1,6,43,'User Log in: System  Administrator','2018-10-11 14:05:26'),(123,1,7,43,'User Log Out :System  Administrator','2018-10-11 14:05:41'),(124,1,6,43,'User Log in: System  Administrator','2018-10-11 14:05:47'),(125,1,7,43,'User Log Out :System  Administrator','2018-10-11 14:05:52'),(126,1,6,43,'User Log in: System  Administrator','2018-10-11 14:12:32'),(127,1,7,43,'User Log Out :System  Administrator','2018-10-11 15:12:28'),(128,0,10,43,'Login Attempt using username: admin','2018-10-12 11:12:04'),(129,1,6,43,'User Log in: System  Administrator','2018-10-12 11:12:07'),(130,1,6,43,'User Log in: System  Administrator','2018-10-12 11:28:06'),(131,1,7,43,'User Log Out :System  Administrator','2018-10-12 11:40:06'),(132,0,10,43,'Login Attempt using username: admin','2018-10-12 11:40:09'),(133,1,6,43,'User Log in: System  Administrator','2018-10-12 11:40:12'),(134,0,10,43,'Login Attempt using username: admin','2018-10-12 11:40:45'),(135,1,6,43,'User Log in: System  Administrator','2018-10-12 11:40:47'),(136,1,7,43,'User Log Out :System  Administrator','2018-10-12 11:44:07'),(137,1,6,43,'User Log in: System  Administrator','2018-10-12 11:44:27'),(138,1,2,60,'Modified Company Information','2018-10-12 11:51:16'),(139,1,7,43,'User Log Out :System  Administrator','2018-10-12 11:51:19'),(140,1,6,43,'User Log in: System  Administrator','2018-10-12 11:51:24'),(141,1,2,60,'Modified Company Information','2018-10-12 11:52:03'),(142,1,7,43,'User Log Out :System  Administrator','2018-10-12 11:52:05'),(143,1,6,43,'User Log in: System  Administrator','2018-10-12 11:52:09'),(144,1,6,43,'User Log in: System  Administrator','2018-10-15 09:17:31'),(145,1,6,43,'User Log in: System  Administrator','2018-10-15 09:45:51'),(146,1,6,43,'User Log in: System  Administrator','2018-10-16 08:37:11'),(147,1,7,43,'User Log Out :System  Administrator','2018-10-16 08:38:42'),(148,1,6,43,'User Log in: System  Administrator','2018-10-16 08:38:47'),(149,1,1,6,'Created Cash Receipt Journal Entry TXN-20181016-26','2018-10-16 08:48:43'),(150,1,1,2,'Created Cash Disbursement Entry TXN-20181016-27','2018-10-16 08:57:52'),(151,1,1,2,'Created Cash Disbursement Entry TXN-20181016-28','2018-10-16 09:17:41'),(152,1,1,2,'Created Cash Disbursement Entry TXN-20181016-29','2018-10-16 09:20:43'),(153,1,1,2,'Created Cash Disbursement Entry TXN-20181016-30','2018-10-16 13:31:00'),(154,1,1,2,'Created Cash Disbursement Entry TXN-20181016-31','2018-10-16 13:31:32'),(155,1,1,2,'Created Cash Disbursement Entry TXN-20181016-32','2018-10-16 13:31:53'),(156,1,1,6,'Created Cash Receipt Journal Entry TXN-20181016-33','2018-10-16 13:32:54'),(157,1,1,2,'Created Cash Disbursement Entry TXN-20181016-34','2018-10-16 13:33:21'),(158,1,4,2,'Cancelled Cash Disbursement Entry : TXN-20181016-32','2018-10-16 13:33:25'),(159,1,4,2,'Cancelled Cash Disbursement Entry : TXN-20181016-31','2018-10-16 13:33:27'),(160,1,1,2,'Created Cash Disbursement Entry TXN-20181016-35','2018-10-16 13:34:13'),(161,1,1,2,'Created Cash Disbursement Entry TXN-20181016-36','2018-10-16 13:34:43'),(162,1,7,43,'User Log Out :System  Administrator','2018-10-16 13:50:08'),(163,1,6,43,'User Log in: System  Administrator','2018-10-16 13:50:14'),(164,1,6,43,'User Log in: System  Administrator','2018-10-16 13:50:14'),(165,1,1,47,'Created  Unit: Retail','2018-10-16 16:35:20'),(166,1,2,50,'Updated Product : Computer Keyboard ID(1)','2018-10-16 16:35:22'),(167,1,1,12,'Created Purchase Invoice No: P-INV-20181016-4','2018-10-16 16:46:19'),(168,1,2,12,'Updated Purchase Invoice No: P-INV-20181016-4','2018-10-16 16:48:27'),(169,1,2,12,'Updated Purchase Invoice No: P-INV-20181016-4','2018-10-16 16:50:21'),(170,1,2,12,'Updated Purchase Invoice No: P-INV-20181016-4','2018-10-16 17:29:13'),(171,1,1,12,'Created Purchase Invoice No: P-INV-20181016-5','2018-10-16 17:29:34'),(172,1,6,43,'User Log in: System  Administrator','2018-10-17 08:46:07'),(173,1,3,66,'Deleted Transfer Issuance No: TRN-20181011-1','2018-10-17 10:13:44'),(174,1,3,15,'Deleted Adjustment No: ADJ-20181011-1','2018-10-17 10:13:48'),(175,1,3,17,'Deleted Sales Invoice No: SAL-INV-20181011-1','2018-10-17 10:14:03'),(176,1,3,65,'Deleted Cash Invoice No: CI-INV-20181011-1','2018-10-17 10:14:07'),(177,1,1,15,'Created Adjustment No: ADJ-20181017-2','2018-10-17 10:22:46'),(178,1,2,15,'Updated Adjustment No: ADJ-20181017-2','2018-10-17 10:23:07'),(179,1,2,15,'Updated Adjustment No: ADJ-20181017-2','2018-10-17 10:23:19'),(180,1,1,15,'Created Adjustment No: ADJ-20181017-3','2018-10-17 10:24:29'),(181,1,2,15,'Updated Adjustment No: ADJ-20181017-3','2018-10-17 10:24:54'),(182,1,1,15,'Created Adjustment No: ADJ-20181017-4','2018-10-17 10:26:38'),(183,1,1,15,'Created Adjustment No: ADJ-20181017-5','2018-10-17 10:26:54'),(184,1,1,66,'Created Issuance No: TRN-20181017-2','2018-10-17 10:35:13'),(185,1,1,66,'Created Issuance No: TRN-20181017-3','2018-10-17 10:35:38'),(186,1,2,66,'Updated Issuance No: TRN-20181017-3','2018-10-17 10:37:57'),(187,1,1,65,'Created Cash Invoice No: CI-INV-20181017-2','2018-10-17 10:59:26'),(188,1,1,65,'Created Cash Invoice No: CI-INV-20181017-3','2018-10-17 11:00:14'),(189,1,1,17,'Created Sales Invoice No: SAL-INV-20181017-2','2018-10-17 11:11:53'),(190,1,1,17,'Created Sales Invoice No: SAL-INV-20181017-3','2018-10-17 11:12:40'),(191,1,1,12,'Created Purchase Invoice No: P-INV-20181017-6','2018-10-17 14:05:56'),(192,1,1,12,'Created Purchase Invoice No: P-INV-20181017-1','2018-10-17 14:42:56'),(193,1,1,12,'Created Purchase Invoice No: P-INV-20181017-2','2018-10-17 14:43:08'),(194,1,2,12,'Updated Purchase Invoice No: P-INV-20181017-2','2018-10-17 14:43:40'),(195,1,1,12,'Created Purchase Invoice No: P-INV-20181017-3','2018-10-17 14:44:12'),(196,1,1,17,'Created Sales Invoice No: SAL-INV-20181017-1','2018-10-17 14:44:53'),(197,1,1,15,'Created Adjustment No: ADJ-20181017-1','2018-10-17 14:46:15'),(198,1,1,15,'Created Adjustment No: ADJ-20181017-2','2018-10-17 14:46:27'),(199,1,6,43,'User Log in: System  Administrator','2018-10-18 08:50:29'),(200,1,6,43,'User Log in: System  Administrator','2018-10-18 08:50:29'),(201,1,7,43,'User Log Out :JDEV  ADMINISTRATOR','2018-10-18 11:39:32'),(202,1,6,43,'User Log in: System  Administrator','2018-10-18 11:39:36'),(203,1,6,43,'User Log in: System  Administrator','2018-10-18 11:44:17'),(204,1,7,43,'User Log Out :System  Administrator','2018-10-18 11:44:21'),(205,5,6,43,'User Log in: raf  raf','2018-10-18 11:44:24'),(206,1,1,51,'Created a Supplier: SAN MIGUEL BEER INC','2018-10-18 11:51:08'),(207,1,1,45,'Created Category: DRINKS','2018-10-18 11:51:25'),(208,1,1,50,'Created a new Product: San Mig Lights 12ml','2018-10-18 11:54:57'),(209,1,1,50,'Created a new Product: SMB PALE PILSEN ','2018-10-18 11:56:21'),(210,1,1,45,'Created Category: FASHION','2018-10-18 11:57:11'),(211,1,1,50,'Created a new Product: TSHIRT V COLLAR  40','2018-10-18 12:00:57'),(212,1,2,50,'Updated Product : Computer Ribbon RED  ID(1)','2018-10-18 12:02:33'),(213,1,2,50,'Updated Product : Delli Imported  Wine From France ID(2)','2018-10-18 12:03:44'),(214,1,1,45,'Created Category: FOOD','2018-10-18 12:04:28'),(215,1,2,50,'Updated Product : Sugar and Spice  ID(3)','2018-10-18 12:04:34'),(216,1,7,43,'User Log Out :JDEV  ADMINISTRATOR','2018-10-18 13:28:25'),(217,1,6,43,'User Log in: System  Administrator','2018-10-18 13:28:29'),(218,1,7,43,'User Log Out :JDEV  ADMINISTRATOR','2018-10-18 13:36:39'),(219,1,6,43,'User Log in: System  Administrator','2018-10-18 13:36:57'),(220,1,7,43,'User Log Out :JDEV  ADMINISTRATOR','2018-10-18 14:40:43'),(221,1,6,43,'User Log in: System  Administrator','2018-10-18 14:40:47'),(222,1,7,43,'User Log Out :System  Administrator','2018-10-18 14:42:41'),(223,1,6,43,'User Log in: System  Administrator','2018-10-18 14:42:44'),(224,1,1,11,'Created Purchase Order No: PO-20181018-1','2018-10-18 15:02:20'),(225,1,2,50,'Updated Product : TSHIRT V COLLAR  40 ID(6)','2018-10-18 15:03:51'),(226,1,2,50,'Updated Product : Computer Ribbon RED  ID(1)','2018-10-18 15:06:46'),(227,1,1,12,'Created Purchase Invoice No: P-INV-20181018-4','2018-10-18 15:14:41'),(228,1,2,50,'Updated Product : Sugar and Spice  ID(3)','2018-10-18 15:16:30'),(229,1,2,12,'Updated Purchase Invoice No: P-INV-20181018-4','2018-10-18 15:17:03'),(230,1,6,43,'User Log in: System  Administrator','2018-10-19 08:49:12'),(231,1,1,4,'Created Sales Journal Entry TXN-20181019-37','2018-10-19 09:15:36'),(232,1,1,18,'Posted Payment No: 001 to Collection Entry','2018-10-19 09:18:13'),(233,1,4,18,'Cancelled Payment No: 001 from Collection Entry','2018-10-19 09:19:38'),(234,1,1,18,'Posted Payment No: 12 to Collection Entry','2018-10-19 09:27:51'),(235,1,1,18,'Posted Payment No: 111 to Collection Entry','2018-10-19 09:32:08'),(236,1,7,43,'User Log Out :System  Administrator','2018-10-19 09:51:35'),(237,1,6,43,'User Log in: System  Administrator','2018-10-19 09:51:39'),(238,1,1,51,'Created a Supplier: 234','2018-10-19 09:54:47'),(239,1,3,51,'Deleted Supplier: 234','2018-10-19 09:54:59'),(240,1,7,43,'User Log Out :System  Administrator','2018-10-19 09:59:43'),(241,1,6,43,'User Log in: System  Administrator','2018-10-19 09:59:51'),(242,1,7,43,'User Log Out :System  Administrator','2018-10-19 14:31:09'),(243,1,6,43,'User Log in: System  Administrator','2018-10-19 14:31:13'),(244,1,2,12,'Updated Purchase Invoice No: P-INV-20181018-4','2018-10-19 14:31:44'),(245,1,6,43,'User Log in: System  Administrator','2018-10-22 08:41:20'),(246,1,2,12,'Updated Purchase Invoice No: P-INV-20181018-4','2018-10-22 10:22:08'),(247,1,2,12,'Updated Purchase Invoice No: P-INV-20181018-4','2018-10-22 10:27:12'),(248,1,1,11,'Created Purchase Order No: PO-20181022-2','2018-10-22 11:31:01'),(249,0,10,43,'Login Attempt using username: admin','2018-10-23 08:41:32'),(250,1,6,43,'User Log in: System  Administrator','2018-10-23 08:41:34'),(251,1,1,11,'Created Purchase Order No: PO-20181023-3','2018-10-23 08:44:10'),(252,1,1,11,'Created Purchase Order No: PO-20181023-4','2018-10-23 08:48:15'),(253,1,1,11,'Created Purchase Order No: PO-20181023-5','2018-10-23 09:03:00'),(254,1,2,11,'Updated Purchase Order No: PO-20181023-5','2018-10-23 09:06:54'),(255,1,1,11,'Created Purchase Order No: PO-20181023-6','2018-10-23 09:32:47'),(256,1,2,11,'Updated Purchase Order No: PO-20181023-6','2018-10-23 09:48:15'),(257,1,2,11,'Updated Purchase Order No: PO-20181023-6','2018-10-23 09:58:32'),(258,1,2,11,'Updated Purchase Order No: PO-20181023-6','2018-10-23 10:00:25'),(259,1,2,11,'Updated Purchase Order No: PO-20181023-6','2018-10-23 10:18:12'),(260,1,1,12,'Created Purchase Invoice No: P-INV-20181023-5','2018-10-23 10:25:28'),(261,1,2,12,'Updated Purchase Invoice No: P-INV-20181023-5','2018-10-23 10:27:50'),(262,1,1,11,'Created Purchase Order No: PO-20181023-7','2018-10-23 10:42:17'),(263,1,1,12,'Created Purchase Invoice No: P-INV-20181023-6','2018-10-23 10:49:08'),(264,1,7,43,'User Log Out :System  Administrator','2018-10-23 11:08:37'),(265,1,6,43,'User Log in: System  Administrator','2018-10-23 11:08:40'),(266,1,6,43,'User Log in: System  Administrator','2018-10-25 10:58:08'),(267,1,1,2,'Created Cash Disbursement Entry TXN-20181025-38','2018-10-25 11:32:15'),(268,1,8,17,'Finalized Sales Invoice No.SAL-INV-20181017-1 For Sales Journal Entry TXN-20181025-39','2018-10-25 11:45:55'),(269,1,1,4,'Created Sales Journal Entry TXN-20181025-39','2018-10-25 11:45:55'),(270,1,7,43,'User Log Out :System  Administrator','2018-10-25 11:46:40'),(271,1,6,43,'User Log in: System  Administrator','2018-10-25 11:46:45'),(272,1,7,43,'User Log Out :System  Administrator','2018-10-25 11:47:14'),(273,0,10,43,'Login Attempt using username: admin','2018-10-25 11:47:19'),(274,1,6,43,'User Log in: System  Administrator','2018-10-25 11:47:22'),(275,1,6,43,'User Log in: System  Administrator','2018-10-29 08:38:50'),(276,1,7,43,'User Log Out :System  Administrator','2018-10-29 10:47:15'),(277,1,6,43,'User Log in: System  Administrator','2018-10-29 10:47:43'),(278,1,1,65,'Created Cash Invoice No: CI-INV-20181029-1','2018-10-29 11:55:33'),(279,1,7,43,'User Log Out :JDEV  ADMINISTRATOR','2018-10-30 09:46:07'),(280,1,6,43,'User Log in: System  Administrator','2018-10-30 09:46:28'),(281,1,6,43,'User Log in: System  Administrator','2018-11-05 08:25:37'),(282,1,1,12,'Created Purchase Invoice No: P-INV-20181105-7','2018-11-05 08:42:20'),(283,1,1,12,'Created Purchase Invoice No: P-INV-20181105-8','2018-11-05 08:42:25'),(284,1,1,12,'Created Purchase Invoice No: P-INV-20181105-9','2018-11-05 08:42:32'),(285,1,1,12,'Created Purchase Invoice No: P-INV-20181105-10','2018-11-05 08:42:38'),(286,1,1,12,'Created Purchase Invoice No: P-INV-20181105-11','2018-11-05 08:42:50'),(287,1,2,12,'Updated Purchase Invoice No: P-INV-20181017-1','2018-11-05 08:42:54'),(288,1,2,12,'Updated Purchase Invoice No: P-INV-20181017-1','2018-11-05 08:42:59'),(289,1,2,12,'Updated Purchase Invoice No: P-INV-20181017-1','2018-11-05 08:43:14'),(290,1,1,12,'Created Purchase Invoice No: P-INV-20181105-12','2018-11-05 08:43:46'),(291,1,3,12,'Deleted Purchase Invoice No: P-INV-20181017-1','2018-11-05 08:44:06'),(292,1,1,12,'Created Purchase Invoice No: P-INV-20181105-13','2018-11-05 08:44:23'),(293,1,3,12,'Deleted Purchase Invoice No: P-INV-20181017-2','2018-11-05 08:44:29'),(294,1,1,12,'Created Purchase Invoice No: P-INV-20181105-14','2018-11-05 11:45:39'),(295,1,3,12,'Deleted Purchase Invoice No: P-INV-20181018-4','2018-11-05 11:45:46'),(296,1,1,12,'Created Purchase Invoice No: P-INV-20181105-15','2018-11-05 11:46:14'),(297,1,3,12,'Deleted Purchase Invoice No: P-INV-20181017-3','2018-11-05 11:46:25'),(298,1,1,12,'Created Purchase Invoice No: P-INV-20181105-16','2018-11-05 12:10:06'),(299,1,3,12,'Deleted Purchase Invoice No: P-INV-20181023-5','2018-11-05 12:10:17'),(300,1,6,43,'User Log in: System  Administrator','2018-11-15 11:05:39'),(301,1,1,51,'Created a Supplier: deleted','2018-11-15 11:06:05'),(302,1,3,51,'Deleted Supplier: deleted','2018-11-15 11:06:08'),(303,1,1,52,'Created a new customer: deleted','2018-11-15 11:06:17'),(304,1,3,52,'Deleted : deleted','2018-11-15 11:06:20'),(305,1,7,43,'User Log Out :System Administrator ','2018-12-11 14:50:45'),(306,0,10,43,'Login Attempt using username: admin','2018-12-11 14:50:50'),(307,1,6,43,'User Log in: System  Administrator','2018-12-11 14:50:54'),(308,1,1,4,'Created Sales Journal Entry TXN-20181211-41','2018-12-11 14:51:37'),(309,1,8,12,'Finalized Purchase Invoice No.P-INV-20181105-15 For Purchase Journal Entry TXN-20181211-42','2018-12-11 14:55:09'),(310,1,1,3,'Created Purchase Journal Entry TXN-20181211-42','2018-12-11 14:55:09'),(311,1,7,43,'User Log Out :System  Administrator','2018-12-12 12:15:00'),(312,1,6,43,'User Log in: System  Administrator','2018-12-12 12:15:04'),(313,1,2,12,'Updated Purchase Invoice No: P-INV-20181105-16','2018-12-12 12:32:12'),(314,1,6,43,'User Log in: System  Administrator','2018-12-13 09:58:12'),(315,1,1,17,'Created Sales Invoice No: SAL-INV-20181213-2','2018-12-13 10:31:41'),(316,1,6,43,'User Log in: System  Administrator','2018-12-17 10:01:58'),(317,1,1,66,'Created Issuance No: TRN-20181217-1','2018-12-17 11:14:43'),(318,1,2,58,'Updated System Purchasing Configuration Adjustments','2018-12-17 11:16:21'),(319,1,2,58,'Updated System Purchasing Configuration Adjustments','2018-12-17 11:16:29'),(320,1,1,17,'Created Sales Invoice No: SAL-INV-20181217-3','2018-12-17 11:19:25'),(321,1,2,50,'Updated Product : SMB PALE PILSEN  ID(5)','2018-12-17 11:22:22'),(322,1,2,50,'Updated Product : SMB PALE PILSEN  ID(5)','2018-12-17 11:22:40'),(323,1,2,50,'Updated Product : San Mig Lights 12ml ID(4)','2018-12-17 11:22:51'),(324,1,2,17,'Updated Sales Invoice No: SAL-INV-20181217-3','2018-12-17 11:26:25'),(325,1,1,16,'Created Sales Order No: SO-20181217-1','2018-12-17 11:48:51'),(326,1,1,65,'Created Cash Invoice No: CI-INV-20181217-2','2018-12-17 11:53:58'),(327,1,1,4,'Created Sales Journal Entry TXN-20181217-43','2018-12-17 12:11:47'),(328,1,8,17,'Finalized Sales Invoice No.SAL-INV-20181217-3 For Sales Journal Entry TXN-20181217-44','2018-12-17 12:11:53'),(329,1,1,4,'Created Sales Journal Entry TXN-20181217-44','2018-12-17 12:11:53'),(330,1,2,5,'Updated Petty Cash Journal Entry PCV-20181217-16','2018-12-17 12:14:09'),(331,1,8,5,'Replenished Petty Cash from transactions on or before 2018-12-17 and Posted Journal Entry TXN-20181217-45','2018-12-17 12:18:30'),(332,1,6,43,'User Log in: System  Administrator','2018-12-18 08:52:25'),(333,1,1,15,'Created Adjustment No: ADJ-20181218-3','2018-12-18 09:02:21'),(334,1,2,15,'Updated Adjustment No: ADJ-20181218-3','2018-12-18 09:05:22'),(335,1,2,15,'Updated Adjustment No: ADJ-20181218-3','2018-12-18 09:05:50'),(336,1,2,15,'Updated Adjustment No: ADJ-20181218-3','2018-12-18 09:06:04'),(337,1,1,66,'Created Issuance No: TRN-20181218-2','2018-12-18 09:09:28'),(338,1,2,66,'Updated Issuance No: TRN-20181218-2','2018-12-18 09:09:39'),(339,1,8,15,'Finalized Adjustment No. ADJ-20181218-3 For General Journal Entry TXN-20181218-46','2018-12-18 09:11:54'),(340,1,1,1,'Created General Journal TXN-20181218-46','2018-12-18 09:11:54'),(341,1,2,66,'Updated Issuance No: TRN-20181218-2','2018-12-18 09:13:50'),(342,1,2,66,'Updated Issuance No: TRN-20181218-2','2018-12-18 09:13:55'),(343,1,2,66,'Updated Issuance No: TRN-20181218-2','2018-12-18 09:14:00'),(344,1,1,2,'Created Cash Disbursement Entry TXN-20181218-47','2018-12-18 10:18:10'),(345,1,1,2,'Created Cash Disbursement Entry TXN-20181218-48','2018-12-18 10:18:34'),(346,1,1,13,'Posted Payment No: 12 to Record Payment','2018-12-18 10:21:24'),(347,1,2,12,'Updated Purchase Invoice No: P-INV-20181105-16','2018-12-18 10:23:43'),(348,1,8,12,'Finalized Purchase Invoice No.P-INV-20181105-16 For Purchase Journal Entry TXN-20181218-49','2018-12-18 10:26:25'),(349,1,1,3,'Created Purchase Journal Entry TXN-20181218-49','2018-12-18 10:26:25'),(350,1,2,65,'Updated Cash Invoice No: CI-INV-20181217-2','2018-12-18 10:28:09'),(351,1,1,18,'Posted Payment No: 1 to Collection Entry','2018-12-18 10:31:43'),(352,1,1,11,'Created Purchase Order No: PO-20181218-8','2018-12-18 11:51:10'),(353,1,2,11,'Updated Purchase Order No: PO-20181218-8','2018-12-18 11:55:16'),(354,1,6,43,'User Log in: System  Administrator','2018-12-18 15:34:28'),(355,1,6,43,'User Log in: System  Administrator','2018-12-19 08:51:10'),(356,1,2,51,'Updated a Supplier : Don\'s Original Spanish Original Churros ID(3)','2018-12-19 10:19:17'),(357,1,2,52,'Updated customer: Various Customers ID(2)','2018-12-19 10:19:40'),(358,1,1,43,'Created User: rafael','2018-12-19 10:33:40'),(359,1,2,43,'Updated User : rafael ID(7)','2018-12-19 10:41:21'),(360,1,7,43,'User Log Out :System  Administrator','2018-12-19 10:41:56'),(361,7,6,43,'User Log in: Rafael  Bulatao Manalo','2018-12-19 10:42:02'),(362,7,1,51,'Created a Supplier: JDEV OFFICE SOLUTION INC','2018-12-19 11:52:05'),(363,7,1,2,'Created Cash Disbursement Entry TXN-20181219-52','2018-12-19 11:53:00'),(364,7,1,3,'Created Purchase Journal Entry TXN-20181219-53','2018-12-19 13:37:23'),(365,7,4,3,'Cancelled Purchase Journal Entry : TXN-20181219-53','2018-12-19 13:37:29'),(366,7,2,43,'Updated User : rafael ID(7)','2018-12-19 13:57:20'),(367,7,2,43,'Updated User : jason ID(2)','2018-12-19 13:59:01'),(368,7,2,43,'Updated User : joy ID(4)','2018-12-19 13:59:48'),(369,1,6,43,'User Log in: System  Administrator','2018-12-20 08:45:26'),(370,1,2,43,'Updated Password of : Jason Joson ID(2)','2018-12-20 09:11:53'),(371,1,7,43,'User Log Out :System  Administrator','2018-12-20 09:12:02'),(372,0,10,43,'Login Attempt using username: jason','2018-12-20 09:12:09'),(373,0,10,43,'Login Attempt using username: jason','2018-12-20 09:12:11'),(374,0,10,43,'Login Attempt using username: jason','2018-12-20 09:12:13'),(375,0,10,43,'Login Attempt using username: jason','2018-12-20 09:12:15'),(376,1,6,43,'User Log in: System  Administrator','2018-12-20 09:12:20'),(377,1,2,43,'Updated Password of : Jason Joson ID(2)','2018-12-20 09:12:32'),(378,1,7,43,'User Log Out :System  Administrator','2018-12-20 09:12:37'),(379,0,10,43,'Login Attempt using username: jason','2018-12-20 09:12:42'),(380,1,6,43,'User Log in: System  Administrator','2018-12-20 09:12:48'),(381,1,2,43,'Updated Password of : Hans De Guzman ID(3)','2018-12-20 09:13:05'),(382,1,7,43,'User Log Out :System  Administrator','2018-12-20 09:13:07'),(383,0,10,43,'Login Attempt using username: hans','2018-12-20 09:13:13'),(384,0,10,43,'Login Attempt using username: hans','2018-12-20 09:13:18'),(385,0,10,43,'Login Attempt using username: hans','2018-12-20 09:13:21'),(386,1,6,43,'User Log in: System  Administrator','2018-12-20 09:13:34'),(387,1,2,43,'Updated Password of : Hans De Guzman ID(3)','2018-12-20 09:13:58'),(388,1,2,43,'Updated Password of : Jason Joson ID(2)','2018-12-20 09:14:33'),(389,1,7,43,'User Log Out :System  Administrator','2018-12-20 09:14:38'),(390,2,6,43,'User Log in: Jason  Joson','2018-12-20 09:14:44'),(391,2,7,43,'User Log Out :Jason  Joson','2018-12-20 09:21:39'),(392,1,6,43,'User Log in: System  Administrator','2018-12-20 09:21:45'),(393,1,3,43,'Deleted User: hans (ID3)','2018-12-20 09:24:16'),(394,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:33:39'),(395,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:33:50'),(396,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:35:00'),(397,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:35:04'),(398,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:36:58'),(399,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-20 09:41:37'),(400,0,10,43,'Login Attempt using username: admin','2018-12-28 15:02:46'),(401,1,6,43,'User Log in: System  Administrator','2018-12-28 15:05:19'),(402,1,6,43,'User Log in: System  Administrator','2018-12-28 15:09:43'),(403,1,2,43,'Change the Password of : Jason Joson ID(2)','2018-12-28 15:11:31'),(404,1,2,43,'Updated User : raf ID(7)','2018-12-28 15:11:57'),(405,1,1,3,'Created Purchase Journal Entry TXN-20181228-54','2018-12-28 15:18:00'),(406,1,8,17,'Finalized Sales Invoice No.SAL-INV-20181213-2 For Sales Journal Entry TXN-20181228-55','2018-12-28 15:18:46'),(407,1,1,4,'Created Sales Journal Entry TXN-20181228-55','2018-12-28 15:18:46'),(408,1,1,65,'Created Cash Invoice No: CI-INV-20181228-3','2018-12-28 15:26:11'),(409,1,2,50,'Updated Product : San Mig Lights 12ml ID(4)','2018-12-28 15:26:30'),(410,1,7,43,'User Log Out :System Administrator ','2019-01-03 11:34:45'),(411,1,6,43,'User Log in: System  Administrator','2019-01-03 11:34:51'),(412,1,2,50,'Updated Product : DONT POST ID(6)','2019-01-03 11:35:35'),(413,1,1,17,'Created Sales Invoice No: SAL-INV-20190103-4','2019-01-03 11:36:13'),(414,1,1,15,'Created Adjustment No: ADJ-20190103-4','2019-01-03 11:46:16'),(415,1,1,15,'Created Adjustment No: ADJ-20190103-5','2019-01-03 11:47:25'),(416,1,1,12,'Created Purchase Invoice No: P-INV-20190103-17','2019-01-03 11:50:36'),(417,1,1,65,'Created Cash Invoice No: CI-INV-20190103-4','2019-01-03 11:51:59'),(418,1,8,15,'Finalized Adjustment No. ADJ-20190103-5 For General Journal Entry TXN-20190103-56','2019-01-03 12:11:28'),(419,1,1,1,'Created General Journal TXN-20190103-56','2019-01-03 12:11:28'),(420,1,11,15,'Closed/Did Not Post Adjustment No: ADJ-20190103-4 from General Journal Pending with reason: 123123123','2019-01-03 12:11:39'),(421,0,10,43,'Login Attempt using username: admin','2019-01-03 15:35:54'),(422,1,6,43,'User Log in: System  Administrator','2019-01-03 15:35:56'),(423,1,11,15,'Closed/Did Not Post Adjustment No: ADJ-20190103-4 from General Journal Pending with reason: 123','2019-01-03 15:40:37'),(424,1,11,15,'Closed/Did Not Post Adjustment No: ADJ-20181017-2 from General Journal Pending with reason: Close po','2019-01-03 15:41:35'),(425,1,11,66,'Closed/Did Not Post Issuance Department  : TRN-20181218-2 from General Journal Pending with reason: To','2019-01-03 16:12:18'),(426,1,8,14,'Finalized Issuance Transfer Item  Tranfer No.TRN-20181218-2 For General Journal Entry TXN-20190103-57','2019-01-03 16:13:01'),(427,1,1,1,'Created General Journal TXN-20190103-57','2019-01-03 16:13:01'),(428,1,11,66,'Closed/Did Not Post Issuance Department From : TRN-20181218-2 from General Journal Pending with reason: Close From','2019-01-03 16:13:15'),(429,1,11,66,'Closed/Did Not Post Issuance Department To : TRN-20181217-1 from General Journal Pending with reason: Closed To','2019-01-03 16:13:50'),(430,1,11,12,'Closed/ Did Not Post Purchase Invoice No: P-INV-20190103-17 from Accounts Payable Pending with reason: Clsing Remarks DR','2019-01-03 16:21:52'),(431,1,11,12,'Closed/ Did Not Post Purchase Invoice No: P-INV-20190103-17 from Accounts Payable Pending with reason: Clsing Remarks DR','2019-01-03 16:22:02'),(432,1,11,12,'Closed/ Did Not Post Purchase Invoice No: P-INV-20190103-17 from Accounts Payable Pending with reason: Clsing Remarks DR','2019-01-03 16:22:36'),(433,1,11,12,'Closed/ Did Not Post Purchase Invoice No: P-INV-20181105-14 from Accounts Payable Pending with reason: closed due to already recorded','2019-01-03 16:24:39'),(434,1,11,66,'Closed/Did Not Post Issuance Department From : TRN-20181218-2 from General Journal Pending with reason: qwe','2019-01-03 16:28:02'),(435,1,11,17,'Closed/ Did Not Post Sales Invoice No: SAL-INV-20190103-4 from Accounts Receivable Pending with reason: Close Sales','2019-01-03 16:33:18'),(436,1,11,65,'Closed/ Did Not Post Cash Invoice No: CI-INV-20181228-3 from Cash Receipt Pending with reason: Close Sales','2019-01-03 16:48:11'),(437,1,6,43,'User Log in: System  Administrator','2019-01-04 08:33:20'),(438,1,6,43,'User Log in: System  Administrator','2019-01-07 09:20:31'),(439,1,11,66,'Closed/Did Not Post Issuance Department From : TRN-20181217-1 from General Journal Pending with reason: Closing Due to irrelevant Details','2019-01-07 09:21:16'),(440,1,6,43,'User Log in: System  Administrator','2019-01-07 11:28:20'),(441,1,7,43,'User Log Out :System Administrator ','2019-01-09 11:17:18'),(442,1,6,43,'User Log in: System  Administrator','2019-01-09 11:17:33'),(443,1,4,13,'Cancelled Payment No: 12 from Record Payment','2019-01-09 11:20:27'),(444,1,1,13,'Posted Payment No: 12 to Record Payment','2019-01-09 11:21:13'),(445,1,6,43,'User Log in: System  Administrator','2019-01-09 11:35:18'),(446,1,6,43,'User Log in: System  Administrator','2019-01-09 14:08:41'),(447,1,6,43,'User Log in: System  Administrator','2019-01-14 09:08:04'),(448,0,10,43,'Login Attempt using username: admin','2019-01-14 14:57:07'),(449,1,6,43,'User Log in: System  Administrator','2019-01-16 12:13:55'),(450,1,6,43,'User Log in: System  Administrator','2019-01-16 15:26:00'),(451,1,6,43,'User Log in: System  Administrator','2019-01-17 09:31:48'),(452,2,7,43,'User Log Out :Demo System   Administrator','2019-01-23 10:51:09'),(453,1,6,43,'User Log in: System  Administrator','2019-01-23 10:51:15'),(454,1,2,50,'Updated Product : TSHIRT V COLLAR  40 ID(6)','2019-01-23 10:51:43'),(455,1,2,50,'Updated Product : San Mig Lights 12ml ID(4)','2019-01-23 10:51:48'),(456,1,2,50,'Updated Product : Computer Ribbon RED  ID(1)','2019-01-23 10:51:53'),(457,1,2,50,'Updated Product : Delli Imported  Wine From France ID(2)','2019-01-23 10:51:57'),(458,1,2,50,'Updated Product : Sugar and Spice  ID(3)','2019-01-23 10:52:05'),(459,1,2,50,'Updated Product : SMB PALE PILSEN  ID(5)','2019-01-23 10:52:10'),(460,0,10,43,'Login Attempt using username: admin','2019-02-03 20:15:19'),(461,1,6,43,'User Log in: System  Administrator','2019-02-03 20:15:21'),(462,1,6,43,'User Log in: System  Administrator','2019-02-06 12:17:18'),(463,1,1,4,'Created Sales Journal Entry TXN-20190206-59','2019-02-06 12:17:58'),(464,1,4,18,'Cancelled Payment No: 1 from Collection Entry','2019-02-06 12:28:41'),(465,1,4,18,'Cancelled Payment No: 111 from Collection Entry','2019-02-06 12:28:42'),(466,1,4,18,'Cancelled Payment No: 12 from Collection Entry','2019-02-06 12:28:44'),(467,1,1,53,'Created Salesperson: Rafael   Manalo','2019-02-06 14:11:59'),(468,1,1,53,'Created Salesperson: Joash  Noble','2019-02-06 14:12:21'),(469,1,2,17,'Updated Sales Invoice No: SAL-INV-20190103-4','2019-02-06 14:12:24'),(470,1,3,17,'Deleted Sales Invoice No: ','2019-02-06 14:31:57'),(471,1,6,43,'User Log in: System  Administrator','2019-02-12 17:10:53'),(472,1,6,43,'User Log in: System  Administrator','2019-02-15 13:40:51'),(473,1,6,43,'User Log in: System  Administrator','2019-02-18 10:57:23'),(474,1,1,6,'Created Cash Receipt Journal Entry TXN-20190218-60','2019-02-18 10:58:34'),(475,1,1,3,'Created Purchase Journal Entry TXN-20190218-61','2019-02-18 11:04:12'),(476,1,1,2,'Created Cash Disbursement Entry TXN-20190218-62','2019-02-18 11:08:38'),(477,1,1,1,'Created General Journal TXN-20190218-63','2019-02-18 11:11:41'),(478,1,1,51,'Created a Supplier: ID Factory Inc','2019-02-18 12:05:15'),(479,1,1,52,'Created a new customer: None','2019-02-18 14:04:56'),(480,1,1,52,'Created a new customer: None','2019-02-18 14:07:27'),(481,1,6,43,'User Log in: System  Administrator','2019-03-06 09:42:54'),(482,1,1,66,'Created Issuance No: TRN-20190306-3','2019-03-06 09:43:47'),(483,1,1,15,'Created Adjustment No: ADJ-20190306-6','2019-03-06 09:43:57'),(484,1,11,15,'Closed/Did Not Post Adjustment No: ADJ-20190306-6 from General Journal Pending with reason: Rafael Manalo','2019-03-06 09:44:51'),(485,1,11,66,'Closed/Did Not Post Issuance Department To : TRN-20190306-3 from General Journal Pending with reason: To','2019-03-06 09:44:56'),(486,1,6,43,'User Log in: System  Administrator','2019-03-07 08:52:24'),(487,1,7,43,'User Log Out :System  Administrator','2019-03-15 14:15:44'),(488,0,10,43,'Login Attempt using username: admin','2019-03-15 14:15:52'),(489,0,10,43,'Login Attempt using username: admin','2019-03-15 14:15:57'),(490,1,6,43,'User Log in: System  Administrator','2019-03-15 14:16:01'),(491,0,10,43,'Login Attempt using username: admin','2019-03-18 08:48:08'),(492,1,6,43,'User Log in: System  Administrator','2019-03-18 08:48:11'),(493,1,6,43,'User Log in: System  Administrator','2019-03-18 13:46:40'),(494,1,6,43,'User Log in: System  Administrator','2019-03-22 10:35:35'),(495,0,10,43,'Login Attempt using username: admin','2019-03-22 13:50:17'),(496,1,6,43,'User Log in: System  Administrator','2019-03-22 13:50:21'),(497,1,2,50,'Updated Product : TSHIRT V COLLAR  40 ID(6)','2019-03-22 13:51:14'),(498,1,1,17,'Created Sales Invoice No: SAL-INV-20190322-10','2019-03-22 13:54:08'),(499,1,8,17,'Finalized Sales Invoice No.SAL-INV-20190322-10 For Sales Journal Entry TXN-20190322-64','2019-03-22 13:54:20'),(500,1,1,4,'Created Sales Journal Entry TXN-20190322-64','2019-03-22 13:54:20'),(501,1,1,17,'Created Sales Invoice No: SAL-INV-20190322-11','2019-03-22 13:54:45'),(502,1,6,43,'User Log in: System  Administrator','2019-03-25 09:00:11'),(503,0,10,43,'Login Attempt using username: admin','2019-03-27 09:33:12'),(504,0,10,43,'Login Attempt using username: admin','2019-03-27 09:33:16'),(505,0,10,43,'Login Attempt using username: admin','2019-03-27 09:33:20'),(506,0,10,43,'Login Attempt using username: jdev','2019-03-27 09:33:27'),(507,0,10,43,'Login Attempt using username: admin','2019-03-27 09:33:31'),(508,0,10,43,'Login Attempt using username: admin','2019-03-27 09:33:38'),(509,1,6,43,'User Log in: System  Administrator','2019-03-27 09:33:41'),(510,1,6,43,'User Log in: System  Administrator','2019-03-27 09:33:42'),(511,1,6,43,'User Log in: System  Administrator','2019-03-27 09:33:42'),(512,1,1,51,'Created a Supplier: Supplier Name','2019-03-27 11:06:53'),(513,0,10,43,'Login Attempt using username: admin','2019-03-28 14:07:33'),(514,1,6,43,'User Log in: System  Administrator','2019-03-28 14:07:37'),(515,1,6,43,'User Log in: System  Administrator','2019-05-06 14:05:14'),(516,1,7,43,'User Log Out :System  Administrator','2019-05-06 14:06:06'),(517,1,6,43,'User Log in: System  Administrator','2019-05-06 14:11:49'),(518,1,2,60,'Modified Company Information','2019-05-06 14:12:59'),(519,1,7,43,'User Log Out :System  Administrator','2019-05-06 14:13:01'),(520,0,10,43,'Login Attempt using username: admin','2019-05-06 14:59:12'),(521,0,10,43,'Login Attempt using username: admin','2019-05-06 14:59:17'),(522,1,6,43,'User Log in: System  Administrator','2019-05-06 14:59:19'),(523,0,10,43,'Login Attempt using username: admin','2019-05-08 09:01:59'),(524,0,10,43,'Login Attempt using username: admin','2019-05-08 09:02:01'),(525,0,10,43,'Login Attempt using username: jdev','2019-05-08 09:02:04'),(526,1,6,43,'User Log in: System  Administrator','2019-05-08 09:02:09'),(527,1,3,43,'Deleted User: raf (ID5)','2019-05-08 09:02:26'),(528,1,3,43,'Deleted User: joy (ID4)','2019-05-08 09:02:28'),(529,1,3,43,'Deleted User: jason (ID2)','2019-05-08 09:02:30'),(530,1,3,43,'Deleted User: rhia (ID6)','2019-05-08 09:02:33'),(531,1,1,43,'Created User: ash','2019-05-08 09:02:57'),(532,1,7,43,'User Log Out :System  Administrator','2019-05-08 09:03:00'),(533,0,10,43,'Login Attempt using username: raf','2019-05-08 09:03:03'),(534,0,10,43,'Login Attempt using username: raf','2019-05-08 09:03:06'),(535,0,10,43,'Login Attempt using username: raf','2019-05-08 09:03:09'),(536,0,10,43,'Login Attempt using username: raf','2019-05-08 09:03:14'),(537,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-08 09:03:18'),(538,8,2,43,'Change the Password of : Rafael  BulataoManalo ID(7)','2019-05-08 09:03:33'),(539,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-05-08 09:03:35'),(540,7,6,43,'User Log in: Rafael  Bulatao Manalo','2019-05-08 09:03:39'),(541,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-08 12:15:45'),(542,7,6,43,'User Log in: Rafael  Bulatao Manalo','2019-05-08 13:35:13'),(543,7,1,52,'Created a new customer: contact person','2019-05-08 14:26:33'),(544,7,1,52,'Created a new customer: 123','2019-05-08 14:28:06'),(545,7,2,52,'Updated customer: 123 ID(12)','2019-05-08 14:36:00'),(546,7,2,52,'Updated customer: raf ID(11)','2019-05-08 14:36:26'),(547,7,2,52,'Updated customer: raf ID(11)','2019-05-08 14:36:44'),(548,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-08 14:37:05'),(549,7,2,52,'Updated customer: Erick Pecson ID(12)','2019-05-08 15:05:49'),(550,7,2,52,'Updated customer: Rafael Manalo ID(11)','2019-05-08 15:07:14'),(551,8,1,68,'Created Meter Inventory: MC-20190508-3 - Various Customers','2019-05-08 15:08:01'),(552,8,1,68,'Created Meter Inventory: MC-20190508-1 - Various Customers','2019-05-08 15:09:17'),(553,8,2,68,'Updated Meter Inventory: ID(1)','2019-05-08 15:09:37'),(554,8,2,68,'Updated Meter Inventory: ID(1)','2019-05-08 15:09:43'),(555,8,2,68,'Updated Meter Inventory: ID(1)','2019-05-08 15:09:48'),(556,8,3,68,'Deleted Meter Inventory: ID(1)','2019-05-08 15:09:53'),(557,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-05-08 15:34:35'),(558,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-08 15:34:41'),(559,8,1,68,'Created Meter Inventory: MC-20190508-2 - Various Customers','2019-05-08 15:48:21'),(560,8,2,68,'Updated Meter Inventory: ID(2)','2019-05-08 15:48:41'),(561,8,2,68,'Updated Meter Inventory: ID(2)','2019-05-08 15:48:54'),(562,7,6,43,'User Log in: Rafael  Bulatao Manalo','2019-05-09 08:34:11'),(563,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-09 08:54:56'),(564,8,2,68,'Updated Meter Inventory: ID(2)','2019-05-09 09:37:09'),(565,8,1,52,'Created a new customer: Noel M. Noble','2019-05-09 10:41:30'),(566,8,1,68,'Created Meter Inventory: MC-20190509-3 - Joash Jezreel L. Noble','2019-05-09 10:42:04'),(567,8,2,68,'Updated Meter Inventory: ID(3)','2019-05-09 10:42:19'),(568,8,2,68,'Updated Meter Inventory: ID(3)','2019-05-09 10:42:39'),(569,8,1,52,'Created a new customer: ','2019-05-09 10:44:05'),(570,8,2,68,'Updated Meter Inventory: ID(3)','2019-05-09 10:44:31'),(571,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-09 13:35:20'),(572,8,1,68,'Created Meter Inventory: MC-20190509-4 - Rafael Manalo','2019-05-09 13:46:04'),(573,8,2,68,'Updated Meter Inventory: ID(1)','2019-05-09 13:46:18'),(574,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-09 17:31:22'),(575,0,10,43,'Login Attempt using username: admin','2019-05-10 08:49:30'),(576,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-10 08:49:34'),(577,1,6,43,'User Log in: System  Administrator','2019-05-10 09:22:23'),(578,8,2,68,'Updated Meter Inventory: ID(2)','2019-05-10 09:37:57'),(579,8,2,68,'Updated Meter Inventory: ID(3)','2019-05-10 09:38:00'),(580,1,1,46,'Created Department: ','2019-05-10 10:35:43'),(581,1,1,2,'Created Cash Disbursement Entry TXN-20190510-65','2019-05-10 11:45:09'),(582,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-10 16:41:18'),(583,1,6,43,'User Log in: System  Administrator','2019-05-14 08:44:50'),(584,1,7,43,'User Log Out :System  Administrator','2019-05-14 08:44:56'),(585,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-14 08:45:00'),(586,7,6,43,'User Log in: Rafael  Bulatao Manalo','2019-05-14 08:47:02'),(587,8,1,68,'Created Meter Inventory: MC-20190514-5 - N/A','2019-05-14 08:54:47'),(588,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-14 11:10:10'),(589,8,1,69,'Created New Connection: SN-20190514-1 - Joash Jezreel L. Noble (0012558) ','2019-05-14 11:49:03'),(590,8,1,69,'Created New Connection: SCN-20190514-1 - Joash Jezreel L. Noble (0012558) ','2019-05-14 11:55:15'),(591,8,2,68,'Updated Meter Inventory: ID(1)','2019-05-14 11:58:53'),(592,8,2,69,'Updated Service Connection:  - Rafael Manalo (1123345667) ','2019-05-14 12:02:48'),(593,8,2,69,'Updated Service Connection: SCN-20190514-1 - Rafael Manalo (1123345667) ','2019-05-14 12:03:39'),(594,8,2,69,'Updated Service Connection: SCN-20190514-1 - Rafael Manalo (1123345667) ','2019-05-14 12:05:32'),(595,8,2,69,'Updated Service Connection: SCN-20190514-1 - Rafael Manalo (1123345667) ','2019-05-14 12:06:02'),(596,8,3,69,'Deleted Connection : ID(1)','2019-05-14 12:07:39'),(597,8,1,69,'Created New Connection: SCN-20190514-2 - Joash Jezreel L. Noble (0012558) ','2019-05-14 12:13:13'),(598,8,1,68,'Created Meter Inventory: MC-20190514-1 - Joash Jezreel L. Noble','2019-05-14 12:21:01'),(599,8,1,68,'Created Meter Inventory: MC-20190514-2 - Rafael Manalo','2019-05-14 14:37:05'),(600,8,1,69,'Created New Connection: SCN-20190514-1 - Joash Jezreel L. Noble (11231996) ','2019-05-14 14:39:53'),(601,8,1,69,'Created New Connection: SCN-20190514-2 - Rafael Manalo (011452874) ','2019-05-14 14:40:33'),(602,7,1,46,'Created Department: qwe','2019-05-14 14:53:43'),(603,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-15 09:19:26'),(604,7,6,43,'User Log in: Rafael  Bulatao Manalo','2019-05-15 09:21:07'),(605,0,10,43,'Login Attempt using username: ash','2019-05-15 14:04:08'),(606,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-15 14:04:56'),(607,8,1,70,'Created New Disconnection: SDN-20190515-1 - Joash Jezreel L. Noble (11231996) ','2019-05-15 16:06:43'),(608,8,1,70,'Created New Disconnection: SDN-20190515-2 - Rafael Manalo (011452874) ','2019-05-15 16:29:25'),(609,8,1,68,'Created Meter Inventory: MC-20190515-1 - Joash Jezreel L. Noble','2019-05-15 17:02:54'),(610,8,1,68,'Created Meter Inventory: MC-20190515-2 - Rafael Manalo','2019-05-15 17:09:40'),(611,8,1,52,'Created a new customer: ','2019-05-15 17:10:13'),(612,8,1,68,'Created Meter Inventory: MC-20190515-3 - Jason Patawaran','2019-05-15 17:10:15'),(613,8,1,69,'Created New Connection: SCN-20190515-0 - Jason Patawaran (01145887558) ','2019-05-15 17:12:08'),(614,8,3,69,'Deleted Connection : ID(0)','2019-05-15 17:12:52'),(615,8,1,68,'Created Meter Inventory: MC-20190515-1 - Joash Jezreel L. Noble','2019-05-15 17:42:32'),(616,8,1,68,'Created Meter Inventory: MC-20190515-2 - Rafael Manalo','2019-05-15 17:42:42'),(617,8,1,68,'Created Meter Inventory: MC-20190515-3 - Jason Patawaran','2019-05-15 17:42:53'),(618,8,1,69,'Created New Connection: SCN-20190515-1 - Joash Jezreel L. Noble (11231996) ','2019-05-15 17:43:23'),(619,8,1,68,'Created Meter Inventory: MC-20190515-1 - Joash Jezreel L. Noble','2019-05-15 17:45:10'),(620,8,1,69,'Created New Connection: SCN-20190515-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-15 17:45:28'),(621,8,1,68,'Created Meter Inventory: MC-20190515-2 - Rafael Manalo','2019-05-15 17:46:02'),(622,8,1,68,'Created Meter Inventory: MC-20190515-3 - Jason Patawaran','2019-05-15 17:46:16'),(623,8,1,69,'Created New Connection: SCN-20190515-2 - Jason Patawaran (41445755966) ','2019-05-15 17:46:45'),(624,8,3,68,'Deleted Meter Inventory: ID(1)','2019-05-15 17:47:14'),(625,8,3,68,'Deleted Meter Inventory: ID(2)','2019-05-15 17:51:08'),(626,8,3,68,'Deleted Meter Inventory: ID(2)','2019-05-15 17:51:41'),(627,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-16 09:30:24'),(628,8,1,70,'Created New Disconnection: SDN-20190516-1 - Jason Patawaran (41445755966) ','2019-05-16 10:26:11'),(629,8,2,70,'Updated Disconnection: SDN-20190516-1 - Jason Patawaran (41445755966) ','2019-05-16 11:22:18'),(630,8,2,70,'Updated Disconnection: SDN-20190516-1 - Jason Patawaran (41445755966) ','2019-05-16 11:22:22'),(631,8,2,70,'Updated Disconnection: SDN-20190516-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-16 11:22:27'),(632,8,2,70,'Updated Disconnection: SDN-20190516-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-16 11:22:35'),(633,8,2,70,'Updated Disconnection: SDN-20190516-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-16 11:23:12'),(634,8,2,70,'Updated Disconnection: SDN-20190516-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-16 11:39:19'),(635,8,1,69,'Created New Connection: SCN-20190516-1 - Jason Patawaran (41445755966) ','2019-05-16 11:54:08'),(636,8,2,69,'Updated Service Connection: SCN-20190516-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-16 11:54:22'),(637,8,2,69,'Updated Service Connection: SCN-20190516-1 - Rafael Manalo (11255854758) ','2019-05-16 11:55:04'),(638,8,2,69,'Updated Service Connection: SCN-20190516-1 - Jason Patawaran (41445755966) ','2019-05-16 11:57:21'),(639,8,2,69,'Updated Service Connection: SCN-20190516-1 - Rafael Manalo (11255854758) ','2019-05-16 11:57:32'),(640,8,1,69,'Created New Connection: SCN-20190516-2 - Jason Patawaran (41445755966) ','2019-05-16 12:04:53'),(641,8,2,69,'Updated Service Connection: SCN-20190516-2 - Joash Jezreel L. Noble (41445755966) ','2019-05-16 12:17:12'),(642,8,1,69,'Created New Connection: SCN-20190516-3 - Jason Patawaran (41445755966) ','2019-05-16 12:17:34'),(643,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-17 08:53:28'),(644,8,1,70,'Created New Disconnection: SDN-20190517-1 - Rafael Manalo () ','2019-05-17 09:06:54'),(645,8,1,70,'Created New Disconnection: SDN-20190517-2 - Joash Jezreel L. Noble () ','2019-05-17 09:07:04'),(646,8,1,70,'Created New Disconnection: SDN-20190517-3 - Jason Patawaran (41445755966) ','2019-05-17 09:15:59'),(647,8,1,68,'Created Meter Inventory: MC-20190517-1 - Joash Jezreel L. Noble','2019-05-17 09:41:56'),(648,8,1,69,'Created New Connection: SCN-20190517-1 - Joash Jezreel L. Noble (11231996) ','2019-05-17 09:42:24'),(649,8,1,70,'Created New Disconnection: SDN-20190517-1 - Joash Jezreel L. Noble (11231996) ','2019-05-17 09:42:41'),(650,8,1,68,'Created Meter Inventory: MC-20190517-1 - Joash Jezreel L. Noble','2019-05-17 09:47:11'),(651,8,1,69,'Created New Connection: SCN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 09:48:42'),(652,8,1,70,'Created New Disconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 09:49:27'),(653,8,1,71,'Created New Reconnection: SDN-20190517-0 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 10:13:38'),(654,8,2,70,'Updated Disconnection: SDN-20190517-1 - Joash Jezreel L. Noble () ','2019-05-17 10:18:46'),(655,8,1,68,'Created Meter Inventory: MC-20190517-1 - Joash Jezreel L. Noble','2019-05-17 10:25:49'),(656,8,1,68,'Created Meter Inventory: MC-20190517-2 - Rafael Manalo','2019-05-17 10:26:03'),(657,8,1,68,'Created Meter Inventory: MC-20190517-3 - Jason Patawaran','2019-05-17 10:26:19'),(658,8,1,69,'Created New Connection: SCN-20190517-1 - Jason Patawaran (4458774549) ','2019-05-17 10:26:52'),(659,8,1,69,'Created New Connection: SCN-20190517-2 - Rafael Manalo (00112544785) ','2019-05-17 10:27:24'),(660,8,2,69,'Updated Service Connection: SCN-20190517-1 - Jason Patawaran (4458774549) ','2019-05-17 10:27:30'),(661,8,1,70,'Created New Disconnection: SDN-20190517-1 - Jason Patawaran (4458774549) ','2019-05-17 10:28:57'),(662,8,2,70,'Updated Disconnection: SDN-20190517-1 - Jason Patawaran () ','2019-05-17 10:29:18'),(663,8,1,71,'Created New Reconnection: SDN-20190517-1 - Jason Patawaran (4458774549) ','2019-05-17 10:29:45'),(664,8,1,70,'Created New Disconnection: SDN-20190517-2 - Rafael Manalo (00112544785) ','2019-05-17 10:30:02'),(665,8,2,70,'Updated Disconnection: SDN-20190517-1 - Jason Patawaran () ','2019-05-17 10:30:16'),(666,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-05-17 15:29:07'),(667,8,1,68,'Created Meter Inventory: MC-20190517-1 - Joash Jezreel L. Noble','2019-05-17 15:29:25'),(668,8,1,69,'Created New Connection: SCN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:29:48'),(669,8,1,70,'Created New Disconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:31:33'),(670,8,1,71,'Created New Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:32:14'),(671,8,2,71,'Updated Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:33:55'),(672,8,2,71,'Updated Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:34:07'),(673,8,2,71,'Updated Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:35:32'),(674,8,2,71,'Updated Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:35:51'),(675,8,1,70,'Created New Disconnection: SDN-20190517-2 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:40:28'),(676,8,1,68,'Created Meter Inventory: MC-20190517-1 - Joash Jezreel L. Noble','2019-05-17 15:42:43'),(677,8,1,69,'Created New Connection: SCN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:43:14'),(678,8,1,70,'Created New Disconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:43:42'),(679,8,1,71,'Created New Reconnection: SDN-20190517-1 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:45:28'),(680,8,1,70,'Created New Disconnection: SDN-20190517-2 - Joash Jezreel L. Noble (01145887558) ','2019-05-17 15:47:33');
/*!40000 ALTER TABLE `trans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_key`
--

DROP TABLE IF EXISTS `trans_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_key` (
  `trans_key_id` bigint(20) NOT NULL,
  `trans_key_desc` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`trans_key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_key`
--

LOCK TABLES `trans_key` WRITE;
/*!40000 ALTER TABLE `trans_key` DISABLE KEYS */;
INSERT INTO `trans_key` VALUES (1,'Create'),(2,'Update'),(3,'Delete'),(4,'Cancel'),(6,'Log In'),(7,'Log Out'),(8,'Finalize'),(9,'Uncancel'),(10,'Login Attempts');
/*!40000 ALTER TABLE `trans_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_type`
--

DROP TABLE IF EXISTS `trans_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_type` (
  `trans_type_id` bigint(20) NOT NULL,
  `trans_type_desc` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`trans_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_type`
--

LOCK TABLES `trans_type` WRITE;
/*!40000 ALTER TABLE `trans_type` DISABLE KEYS */;
INSERT INTO `trans_type` VALUES (1,'General Journal'),(2,'Cash Disbursement'),(3,'Purchase Journal'),(4,'Sales Journal'),(5,'Petty Cash Journal'),(6,'Cash Receipt Journal'),(7,'Service Invoice'),(8,'Service Journal'),(9,'Service Unit'),(10,'Services'),(11,'Purchase Order'),(12,'Purchase Invoice'),(13,'Record Payment'),(14,'Item Issuance'),(15,'Item Adjustment'),(16,'Sales Order'),(17,'Sales Invoice'),(18,'Collection Entry'),(43,'User Accounts'),(44,'Account Classification'),(45,'Category Management'),(46,'Department Management'),(47,'Unit Management'),(48,'Locations Management'),(49,'Bank Management'),(50,'Product Management'),(51,'Supplier Management'),(52,'Customer Management'),(53,'Salesperson Management'),(54,'Fixed Asset Management'),(55,'Setup Tax'),(56,'Setup Chart of Accounts'),(57,'General Configuration'),(58,'Purchasing Configuration'),(59,'User Rights'),(60,'Company Info'),(61,'Check Layout'),(62,'Recurring Template'),(63,'Email Settings'),(64,'Email Report Settings'),(65,'Cash Invoice'),(66,'Issuance to Department'),(67,'Order Source'),(68,'Meter Inventory Management'),(69,'Service Connection'),(70,'Service Disconnection'),(71,'Service Reconnection');
/*!40000 ALTER TABLE `trans_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unit_code` bigint(20) DEFAULT NULL,
  `unit_name` varchar(255) DEFAULT NULL,
  `unit_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`unit_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,NULL,'Piece','Piece',NULL,'0000-00-00 00:00:00','\0',''),(2,NULL,'Retail','Retail',NULL,'0000-00-00 00:00:00','\0','');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT '',
  `user_pword` varchar(500) DEFAULT '',
  `user_lname` varchar(100) DEFAULT '',
  `user_fname` varchar(100) DEFAULT '',
  `user_mname` varchar(100) DEFAULT '',
  `user_address` varchar(155) DEFAULT '',
  `user_email` varchar(100) DEFAULT '',
  `user_mobile` varchar(100) DEFAULT '',
  `user_telephone` varchar(100) DEFAULT '',
  `user_bdate` date DEFAULT '0000-00-00',
  `user_group_id` int(11) DEFAULT '0',
  `photo_path` varchar(555) DEFAULT '',
  `file_directory` varchar(666) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_online` tinyint(4) DEFAULT '0',
  `last_seen` datetime DEFAULT NULL,
  `token_id` text NOT NULL,
  `user_department` bigint(20) DEFAULT '0',
  `journal_prepared_by` varchar(145) DEFAULT '',
  `journal_approved_by` varchar(145) DEFAULT '',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_accounts`
--

LOCK TABLES `user_accounts` WRITE;
/*!40000 ALTER TABLE `user_accounts` DISABLE KEYS */;
INSERT INTO `user_accounts` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Administrator','System','','Angeles City, Pampanga','jdevtechsolution@gmail.com','0955-283-3018','','1970-01-01',1,'assets/img/user/5bbeb72d2a234.png',NULL,'','\0',NULL,'2019-05-14 00:44:56',0,1,0,0,0,'2019-05-14 08:44:52','93ff82f712bbf6cb188b43fecc088dff',0,'Rafael Manalo','Rafael Manalo'),(2,'jason','356a192b7913b04c54574d18c28d46e6395428ab','Joson','Jason','','','','','','2018-07-18',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:12','2019-05-08 01:02:30',2147483647,7,1,1,0,'2018-12-20 09:14:53','16ff758e8efcc362badc7e02872dd704',0,'',''),(3,'hans','da39a3ee5e6b4b0d3255bfef95601890afd80709','De Guzman','Hans','','','','','','1970-01-01',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:29','2018-12-20 01:24:16',2147483647,0,1,1,1,'2018-07-18 10:07:18','34115363e8d2820cc15d1a2ace336df7',0,'',''),(4,'joy','c7d56fc0723a766824f554c4d00f28ea16c2c36b','Damasco','Joy','','','','','','1970-01-01',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:48','2019-05-08 01:02:28',2147483647,7,1,1,1,'2018-07-18 10:09:58','f7472d0e1dd62c5348b2cbb560666fd9',0,'',''),(5,'raf','3cc95b3704d4ac1c0d7712092f1b60c7f2e53a75','raf','raf','','','','','','2018-07-18',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:49:13','2019-05-08 01:02:26',2147483647,0,1,1,1,'2018-10-18 13:16:04','e5101e4c88fd93232d5a35cbf295282c',0,'',''),(6,'rhia','40bd001563085fc35165329ea1ff5c5ecbdbbeef','Corporation','Rhia','','','','','','2018-08-07',2,'assets/img/anonymous-icon.png',NULL,'','','2018-08-07 11:06:49','2019-05-08 01:02:33',2147483647,0,1,1,0,'2018-08-07 11:06:57','bbded0536a67611435721cea86da29e0',0,'',''),(7,'raf','3cc95b3704d4ac1c0d7712092f1b60c7f2e53a75','Manalo','Rafael ','Bulatao','11-6 Justice Mejia St., Villa Gloria Subdivision, Barangay San Jose, Angeles City, Pampanga 2009','manaloraf03@gmail.com','09559762739','9003988','1997-02-03',1,'assets/img/user/5c19afcfead1b.jpg',NULL,'','\0','2018-12-19 10:33:40','2019-05-15 09:38:41',0,1,1,0,1,'2019-05-15 17:38:41','32edc2317485e1d402ddc7f2733c40a1',0,'',''),(8,'ash','cb101192dff2cc1ddd0272f73de307c89bebc181','Noble','Joash Jezreel','Lucas','','','','','2019-05-08',1,'assets/img/anonymous-icon.png',NULL,'','\0','2019-05-08 09:02:57','2019-05-17 08:06:35',0,0,1,0,1,'2019-05-17 16:06:35','a81914145b88637f515511dffecb0424',0,'','');
/*!40000 ALTER TABLE `user_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_rights`
--

DROP TABLE IF EXISTS `user_group_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group_rights` (
  `user_rights_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) DEFAULT '0',
  `link_code` varchar(20) DEFAULT '',
  PRIMARY KEY (`user_rights_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_rights`
--

LOCK TABLES `user_group_rights` WRITE;
/*!40000 ALTER TABLE `user_group_rights` DISABLE KEYS */;
INSERT INTO `user_group_rights` VALUES (1,1,'1-1'),(2,1,'1-2'),(3,1,'1-3'),(4,1,'1-4'),(5,1,'1-5'),(6,1,'2-1'),(7,1,'2-2'),(8,1,'2-3'),(10,1,'15-3'),(11,1,'3-1'),(12,1,'3-2'),(13,1,'3-3'),(14,1,'4-2'),(15,1,'4-3'),(16,1,'4-4'),(17,1,'5-1'),(18,1,'5-2'),(19,1,'5-3'),(20,1,'6-1'),(21,1,'6-2'),(22,1,'6-3'),(23,1,'6-4'),(24,1,'6-5'),(25,1,'6-6'),(26,1,'7-1'),(27,1,'9-1'),(28,1,'9-2'),(29,1,'4-1'),(30,1,'8-1'),(31,1,'15-4'),(32,1,'5-4'),(33,1,'2-6'),(34,1,'8-3'),(35,1,'9-3'),(36,1,'6-7'),(37,1,'9-4'),(38,1,'9-6'),(39,1,'9-8'),(40,1,'9-7'),(41,1,'9-5'),(42,1,'8-4'),(43,1,'4-5'),(44,1,'10-1'),(45,1,'9-9'),(46,1,'6-8'),(47,1,'9-10'),(48,1,'1-6'),(49,1,'9-13'),(50,1,'6-9'),(51,1,'9-14'),(52,1,'9-16'),(53,1,'4-6'),(54,1,'10-2'),(55,1,'11-1'),(57,1,'12-1'),(58,1,'12-2'),(59,1,'12-3'),(60,1,'12-4'),(61,1,'12-5'),(62,1,'9-11'),(63,1,'9-15'),(64,1,'9-12'),(65,1,'13-1'),(66,1,'13-2'),(67,1,'13-3'),(68,1,'13-4'),(69,1,'9-17'),(70,1,'9-18'),(71,1,'9-19'),(72,1,'6-10'),(73,1,'14-1'),(74,1,'9-20'),(75,1,'9-21'),(76,1,'6-11'),(77,1,'12-6'),(78,1,'12-7'),(79,1,'2-8'),(80,1,'2-7'),(81,1,'6-12'),(82,1,'15-1'),(83,1,'3-4'),(84,1,'6-13'),(85,1,'15-5'),(86,1,'15-6'),(87,1,'3-5'),(88,1,'4-7'),(89,1,'16-1'),(90,1,'16-2'),(91,1,'16-3'),(92,1,'6-14'),(93,1,'5-5'),(94,2,'3-4');
/*!40000 ALTER TABLE `user_group_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` varchar(135) DEFAULT '',
  `user_group_desc` varchar(500) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_group_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'System Administrator','Can access all features.','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Encoder 123','Encoder 123','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'waterbilling2019'
--

--
-- Dumping routines for database 'waterbilling2019'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-17 17:41:52
