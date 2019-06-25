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
  `default_matrix_residential_id` bigint(20) DEFAULT '0',
  `default_matrix_commercial_id` bigint(20) DEFAULT '0',
  `billing_meter_account_id` bigint(20) DEFAULT '0',
  `billing_penalty_account_id` bigint(20) DEFAULT '0',
  `billing_department_id` bigint(20) DEFAULT '0',
  `billing_customer_id` bigint(20) DEFAULT '0',
  `billing_security_deposit_account_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`integration_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_integration`
--

LOCK TABLES `account_integration` WRITE;
/*!40000 ALTER TABLE `account_integration` DISABLE KEYS */;
INSERT INTO `account_integration` VALUES (1,55,16,57,2,55,5,57,1,18,3,'',7,8,1,NULL,'','\0',62,1,1,19,20,2,1,63);
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_titles`
--

LOCK TABLES `account_titles` WRITE;
/*!40000 ALTER TABLE `account_titles` DISABLE KEYS */;
INSERT INTO `account_titles` VALUES (1,'1000','Cash on Hand',1,0,1,'','2018-04-18 11:47:31','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(2,'1100','Cash in Bank - GRB',1,0,2,'','2018-04-18 11:47:48','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(3,'1100','Petty Cash Fund',1,0,3,'','2018-04-18 11:48:04','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(4,'1120','Revolving Fund',1,0,4,'','2018-04-18 11:48:50','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(5,'1200','Account Receivable',1,0,5,'','2018-04-18 11:49:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(6,'1210','Account Receivable OTH',1,0,6,'','2018-04-18 11:49:33','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(7,'1300','Furniture and Fixture',2,0,7,'','2018-04-18 11:50:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(8,'1301','Accumulative Depreciation',2,0,8,'','2018-04-18 11:50:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(9,'1400','Service Vehicles',2,0,9,'','2018-04-18 11:51:11','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(10,'1500','Kitchen Equipment',2,0,10,'','2018-04-18 11:51:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(11,'1600','Computer and Electronic Equipment',2,0,11,'','2018-04-18 11:52:23','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(12,'1700','Appliances and Other Electronic Gadgets',2,0,12,'','2018-04-18 11:52:57','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(13,'2000','Liability',3,0,13,'','2018-04-18 11:53:13','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(14,'2001','Long Term Loan',3,0,14,'','2018-04-18 11:53:34','2018-04-18 11:53:44','0000-00-00 00:00:00',1,1,0,'','\0'),(15,'2002','Short Term Loan',3,0,15,'','2018-04-18 11:54:10','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(16,'2200','Account Payable - Trade Supplier',3,0,16,'','2018-04-18 11:54:41','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(17,'3000','Capital - Equity',5,0,17,'','2018-04-18 11:55:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(18,'3010','Retained Earnings',5,0,18,'','2018-04-18 11:55:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(19,'4000','Sales',7,0,19,'','2018-04-18 12:03:37','2018-07-18 09:23:39','0000-00-00 00:00:00',1,1,0,'','\0'),(20,'4010','Other Income',7,0,20,'','2018-04-18 12:04:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(21,'4020','Service Income',7,0,21,'','2018-04-18 12:04:33','2019-06-11 09:26:02','0000-00-00 00:00:00',1,7,0,'','\0'),(22,'4030','Yearly Maintenance Income',7,0,22,'','2018-04-18 12:04:49','2019-06-11 09:26:37','0000-00-00 00:00:00',1,7,0,'','\0'),(23,'4040','Meter Charges Income',7,0,23,'','2018-04-18 12:05:12','2019-06-11 09:26:16','0000-00-00 00:00:00',1,7,0,'','\0'),(24,'5000','Expenses',6,0,24,'','2018-04-18 12:05:42','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(25,'5010','Labor',6,0,25,'','2018-04-18 12:06:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(26,'5020','Repair and Maintenance',6,0,26,'','2018-04-18 12:06:35','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(27,'5030','Salaries and Wages - Admin',6,0,27,'','2018-04-18 12:06:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(28,'5031','Salaries and Wages - Agency and Security',6,0,28,'','2018-04-18 12:07:17','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(29,'5032','Salaries and Wages - Hotel Personnel',6,0,29,'','2018-04-18 12:07:45','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(30,'5040','Office Supplies',6,0,30,'','2018-04-18 12:08:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(31,'5050','Commissions - Massage / Vehicle',6,0,31,'','2018-04-18 12:08:32','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(32,'5060','Gas and Oil',6,0,32,'','2018-04-18 12:09:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(33,'5070','Telephone and Communication and Internet',6,0,33,'','2018-04-18 12:09:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(34,'5080','Garbage Expense and Sewerage',6,0,34,'','2018-04-18 12:09:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(35,'5090','Water Consumption',6,0,35,'','2018-04-18 12:10:02','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(36,'5100','Miscellaneous Expense',6,0,36,'','2018-04-18 12:10:29','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(37,'5200','Construction Maintenance',6,0,37,'','2018-04-18 12:10:58','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(38,'5300','Utility Expenses and Plumbing',6,0,38,'','2018-04-18 12:11:21','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(39,'5400','Janitorial Expense',6,0,39,'','2018-04-18 12:11:40','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(40,'550','Rental and Occupancy Expense',6,0,40,'','2018-04-18 12:12:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(41,'5600','Purchases and Wet Market Purchases',6,0,41,'','2018-04-18 12:12:37','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(42,'5700','Groceries',6,0,42,'','2018-04-18 12:12:49','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(43,'5800','Hotel Supplies',6,0,43,'','2018-04-18 12:12:59','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(44,'5900','Toiletries',6,0,44,'','2018-04-18 12:13:08','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(45,'5901','Donation and Contribution',6,0,45,'','2018-06-05 01:27:06','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(46,'t01','Cash Advances',1,0,46,'','2018-06-20 14:20:18','0000-00-00 00:00:00','2018-10-03 17:36:19',1,0,1,'',''),(47,'t02','Check Advances',1,0,47,'','2018-06-20 14:20:31','0000-00-00 00:00:00','2018-10-03 17:36:21',1,0,1,'',''),(48,'t03','Card Advances',1,0,48,'','2018-06-20 14:20:45','0000-00-00 00:00:00','2018-10-03 17:36:24',1,0,1,'',''),(49,'t04','Charge Advances',1,0,49,'','2018-06-20 14:20:58','0000-00-00 00:00:00','2018-10-03 17:36:26',1,0,1,'',''),(50,'tr05','Advance Bank Deposit',1,0,50,'','2018-06-20 14:21:13','0000-00-00 00:00:00','2018-10-03 17:36:28',1,0,1,'',''),(51,'t06','Advance Sales',7,0,51,'','2018-06-20 14:22:15','0000-00-00 00:00:00','2018-10-03 17:36:32',1,0,1,'',''),(52,'100','Bank - Check',1,0,52,'','2018-06-20 14:23:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(53,'110','Bank - Card',1,0,53,'','2018-06-20 14:23:45','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(54,'130','Bank  -Bank Deposit',1,0,54,'','2018-06-20 14:24:01','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(55,'2010','Tax',1,0,55,'','2018-07-10 16:21:28','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(56,'2011','INVENTORY',1,0,56,'','2018-07-18 09:00:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(57,'5902','Discounts',6,0,57,'','2018-07-31 09:26:12','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(58,'101','Bank - Current BDO ACT#9837459879',1,0,58,'','2018-08-07 10:13:50','2018-08-07 11:00:28','0000-00-00 00:00:00',1,1,0,'','\0'),(59,'1200-1','Accounts Receivable  - Trade',1,5,5,'','2018-08-07 10:15:27','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(60,'5903','Training Expense',6,0,60,'','2018-08-07 10:21:20','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(61,'5903','Electric and Power Consumption',6,0,61,'','2018-08-07 10:59:56','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(62,'2300','Withholding Tax Payable',3,0,62,'','2018-10-11 09:25:24','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,0,'','\0'),(63,'2400','Security Deposit',4,0,63,'','2019-06-17 12:17:41','0000-00-00 00:00:00','0000-00-00 00:00:00',7,0,0,'','\0');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_info`
--

LOCK TABLES `adjustment_info` WRITE;
/*!40000 ALTER TABLE `adjustment_info` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adjustment_items`
--

LOCK TABLES `adjustment_items` WRITE;
/*!40000 ALTER TABLE `adjustment_items` DISABLE KEYS */;
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
-- Table structure for table `attendant`
--

DROP TABLE IF EXISTS `attendant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendant` (
  `attendant_id` int(12) NOT NULL AUTO_INCREMENT,
  `attendant_code` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `department_id` int(12) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `date_created` date DEFAULT '0000-00-00',
  `posted_by_user` int(12) DEFAULT '0',
  PRIMARY KEY (`attendant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendant`
--

LOCK TABLES `attendant` WRITE;
/*!40000 ALTER TABLE `attendant` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendant` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation`
--

LOCK TABLES `bank_reconciliation` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_reconciliation_details`
--

LOCK TABLES `bank_reconciliation_details` WRITE;
/*!40000 ALTER TABLE `bank_reconciliation_details` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batch_info`
--

LOCK TABLES `batch_info` WRITE;
/*!40000 ALTER TABLE `batch_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `batch_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing`
--

DROP TABLE IF EXISTS `billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing` (
  `billing_id` int(12) NOT NULL AUTO_INCREMENT,
  `control_no` varchar(255) DEFAULT NULL,
  `connection_id` bigint(12) DEFAULT '0',
  `default_matrix_id` int(12) DEFAULT '0',
  `meter_reading_input_id` bigint(20) DEFAULT '0',
  `meter_reading_period_id` int(12) DEFAULT '0',
  `due_date` date DEFAULT '0000-00-00',
  `reading_date` date DEFAULT '0000-00-00',
  `previous_month` varchar(255) DEFAULT NULL,
  `previous_reading` int(12) DEFAULT '0',
  `current_reading` int(12) DEFAULT '0',
  `total_consumption` int(12) DEFAULT '0',
  `amount_due` decimal(20,2) DEFAULT '0.00',
  `rate_amount` decimal(20,2) DEFAULT '0.00',
  `penalty_amount` decimal(20,2) DEFAULT '0.00',
  `charges_amount` decimal(20,2) DEFAULT '0.00',
  `grand_total_amount` decimal(20,2) DEFAULT '0.00',
  `is_fixed` bit(1) DEFAULT b'0',
  `arrears_month_id` int(12) DEFAULT '0',
  `arrears_amount` decimal(20,2) DEFAULT '0.00',
  `date_processed` date DEFAULT '0000-00-00',
  `processed_by` int(12) DEFAULT '0',
  `arrears_penalty_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`billing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing`
--

LOCK TABLES `billing` WRITE;
/*!40000 ALTER TABLE `billing` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing_charges`
--

DROP TABLE IF EXISTS `billing_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing_charges` (
  `billing_charge_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `billing_id` bigint(20) DEFAULT '0',
  `meter_reading_input_id` int(12) DEFAULT '0',
  `other_charge_id` int(12) DEFAULT '0',
  `other_charge_item_id` int(12) DEFAULT '0',
  `charge_id` int(12) DEFAULT '0',
  `charge_unit_id` int(12) DEFAULT '0',
  `charge_amount` decimal(20,2) DEFAULT '0.00',
  `charge_qty` decimal(20,2) DEFAULT '0.00',
  `charge_line_total` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`billing_charge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_charges`
--

LOCK TABLES `billing_charges` WRITE;
/*!40000 ALTER TABLE `billing_charges` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing_payment_batch`
--

DROP TABLE IF EXISTS `billing_payment_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing_payment_batch` (
  `billing_payment_batch_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT '0000-00-00',
  `end_date` date DEFAULT '0000-00-00',
  `batch_code` varchar(145) DEFAULT '',
  `batch_total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `batch_total_paid_cash` decimal(20,2) DEFAULT '0.00',
  `batch_total_paid_check` decimal(20,2) DEFAULT '0.00',
  `batch_total_paid_card` decimal(20,2) DEFAULT '0.00',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `batch_total_paid_deposit` decimal(20,2) DEFAULT '0.00',
  `batch_total_deposit_refund` decimal(20,2) DEFAULT '0.00',
  `posted_by_user_id` bigint(20) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`billing_payment_batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_payment_batch`
--

LOCK TABLES `billing_payment_batch` WRITE;
/*!40000 ALTER TABLE `billing_payment_batch` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing_payment_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing_payment_items`
--

DROP TABLE IF EXISTS `billing_payment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing_payment_items` (
  `billing_payment_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `billing_payment_id` bigint(20) DEFAULT '0',
  `billing_id` bigint(20) DEFAULT '0',
  `disconnection_id` bigint(20) DEFAULT '0',
  `receivable_amount` decimal(20,2) DEFAULT '0.00',
  `deposit_payment` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`billing_payment_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_payment_items`
--

LOCK TABLES `billing_payment_items` WRITE;
/*!40000 ALTER TABLE `billing_payment_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing_payment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing_payments`
--

DROP TABLE IF EXISTS `billing_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing_payments` (
  `billing_payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `connection_id` bigint(20) DEFAULT NULL,
  `date_paid` date DEFAULT '0000-00-00',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(145) DEFAULT '',
  `remarks` varchar(7755) DEFAULT '',
  `deposit_allowed` decimal(20,2) DEFAULT '0.00',
  `total_deposit_amount` decimal(20,2) DEFAULT '0.00',
  `remaining_deposit` decimal(20,2) DEFAULT '0.00',
  `is_refund` bit(1) DEFAULT b'0',
  `total_payment_amount` decimal(20,2) DEFAULT '0.00',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` bigint(20) DEFAULT '0',
  `cancelled_by_user` bigint(20) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `receipt_no` varchar(545) DEFAULT '',
  `billing_payment_batch_id` bigint(20) DEFAULT '0',
  `refund_amount` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`billing_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_payments`
--

LOCK TABLES `billing_payments` WRITE;
/*!40000 ALTER TABLE `billing_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing_payments` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice`
--

LOCK TABLES `cash_invoice` WRITE;
/*!40000 ALTER TABLE `cash_invoice` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_invoice_items`
--

LOCK TABLES `cash_invoice_items` WRITE;
/*!40000 ALTER TABLE `cash_invoice_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charge_unit`
--

LOCK TABLES `charge_unit` WRITE;
/*!40000 ALTER TABLE `charge_unit` DISABLE KEYS */;
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
  `income_account_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`charge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charges`
--

LOCK TABLES `charges` WRITE;
/*!40000 ALTER TABLE `charges` DISABLE KEYS */;
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
INSERT INTO `company_info` VALUES (1,'Friendship Plaza Waterworks','Friendship Plaza Clubhouse, Kanlaon Street, Friendship Plaza, Angeles City','donpepehenson@yahoo.com / dphe.finaceandacctg@gmail.com','','(045) 888-1023 / (045) 409-0225','469299358000',1,'JDEV OFFICE SOLUTIONS INC.','assets/img/company/5cff2a2dc76bb.png','057','Service',1,'4776 Montang Ave., Service Rd, Diamond Subd., Balibago, Angeles City','2009','9003988 ','Service');
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
-- Table structure for table `customer_account_type`
--

DROP TABLE IF EXISTS `customer_account_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_account_type` (
  `customer_account_type_id` int(12) NOT NULL AUTO_INCREMENT,
  `customer_account_type_desc` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`customer_account_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_account_type`
--

LOCK TABLES `customer_account_type` WRITE;
/*!40000 ALTER TABLE `customer_account_type` DISABLE KEYS */;
INSERT INTO `customer_account_type` VALUES (1,'Individual','\0',''),(2,'Corporation','\0','');
/*!40000 ALTER TABLE `customer_account_type` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_photos`
--

LOCK TABLES `customer_photos` WRITE;
/*!40000 ALTER TABLE `customer_photos` DISABLE KEYS */;
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
  `customer_account_type_id` bigint(20) DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice`
--

LOCK TABLES `delivery_invoice` WRITE;
/*!40000 ALTER TABLE `delivery_invoice` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_invoice_items`
--

LOCK TABLES `delivery_invoice_items` WRITE;
/*!40000 ALTER TABLE `delivery_invoice_items` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'','Admin','','',1,'2018-10-03 17:08:47','0000-00-00 00:00:00','\0',''),(2,'','Accounting','Accounting',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(3,'','Human Resources','Human Resources',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(4,'','IT ','IT ',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(5,'','Restaurant','Restaurant',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(6,'','Purchasing','Purchasing',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(7,'','Audio Visual','Audio Visual',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(8,'','Treasury','Treasury',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(9,'','Maintenance','Maintenance',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(10,'','qwe','qwe',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','',''),(11,'',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(12,'','qwe','qwe',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(13,'','IT Department','IT Department',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0',''),(14,'','Department 101','',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','\0','');
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
-- Table structure for table `disconnection_reason`
--

DROP TABLE IF EXISTS `disconnection_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disconnection_reason` (
  `disconnection_reason_id` int(12) NOT NULL AUTO_INCREMENT,
  `reason_desc` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`disconnection_reason_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disconnection_reason`
--

LOCK TABLES `disconnection_reason` WRITE;
/*!40000 ALTER TABLE `disconnection_reason` DISABLE KEYS */;
INSERT INTO `disconnection_reason` VALUES (1,'Automatic Disconnection','','\0'),(2,'Owners Discretion','','\0');
/*!40000 ALTER TABLE `disconnection_reason` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice`
--

LOCK TABLES `dispatching_invoice` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatching_invoice_items`
--

LOCK TABLES `dispatching_invoice_items` WRITE;
/*!40000 ALTER TABLE `dispatching_invoice_items` DISABLE KEYS */;
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
INSERT INTO `email_settings` VALUES (1,'manaloraf03@gmail.com','xxseunghyunk216','','JDEV IT BUSINESS SOLUTION','This is the Default message from the Accounting System of JDEV Office Solutions',NULL),(2,'jdevofficesolutioninc@gmail.com','!jdev123*','','JDEV OFFICE SOLUTION INC','This is a system generation report sent to you from the Accounting System of JDEV Office Solution Inc.','noblejjoash@gmail.com');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixed_assets`
--

LOCK TABLES `fixed_assets` WRITE;
/*!40000 ALTER TABLE `fixed_assets` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_info`
--

LOCK TABLES `issuance_department_info` WRITE;
/*!40000 ALTER TABLE `issuance_department_info` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_department_items`
--

LOCK TABLES `issuance_department_items` WRITE;
/*!40000 ALTER TABLE `issuance_department_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_accounts`
--

LOCK TABLES `journal_accounts` WRITE;
/*!40000 ALTER TABLE `journal_accounts` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry_templates`
--

LOCK TABLES `journal_entry_templates` WRITE;
/*!40000 ALTER TABLE `journal_entry_templates` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_info`
--

LOCK TABLES `journal_info` WRITE;
/*!40000 ALTER TABLE `journal_info` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_templates_info`
--

LOCK TABLES `journal_templates_info` WRITE;
/*!40000 ALTER TABLE `journal_templates_info` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_commercial`
--

LOCK TABLES `matrix_commercial` WRITE;
/*!40000 ALTER TABLE `matrix_commercial` DISABLE KEYS */;
INSERT INTO `matrix_commercial` VALUES (1,'Commercial Fare Matrix for 2019','','\0','Commercial Fare Matrix for 2019','MATRIX-COMM-2019-1'),(2,'12','','','12','MATRIX-COMM-2019-2');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_commercial_items`
--

LOCK TABLES `matrix_commercial_items` WRITE;
/*!40000 ALTER TABLE `matrix_commercial_items` DISABLE KEYS */;
INSERT INTO `matrix_commercial_items` VALUES (1,1,1,10,200.00,''),(2,1,11,20,20.50,'\0'),(3,1,21,30,20.75,'\0'),(4,1,31,40,30.00,'\0'),(5,1,41,40,30.50,'\0'),(6,1,51,1000,31.00,'\0'),(8,2,12,12,12.00,'\0');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_residential`
--

LOCK TABLES `matrix_residential` WRITE;
/*!40000 ALTER TABLE `matrix_residential` DISABLE KEYS */;
INSERT INTO `matrix_residential` VALUES (1,'Residential Fare Matrix for June 2019','','\0','Residential  Fare Matrix for June 2019','MATRIX-RESI-2019-1'),(2,'12','','','12','MATRIX-RESI-2019-2');
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
INSERT INTO `matrix_residential_items` VALUES (13,1,1,10,200.00,''),(14,1,11,20,20.50,'\0'),(15,1,21,30,20.75,'\0'),(16,1,31,40,30.00,'\0'),(17,1,41,50,30.50,'\0'),(18,1,51,1000,31.00,'\0'),(20,2,1,1,1.00,'\0');
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
  `created_by` int(12) DEFAULT '0',
  `modified_by` int(12) DEFAULT '0',
  `date_created` date DEFAULT '0000-00-00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `meter_status_id` tinyint(1) DEFAULT '2',
  `is_new` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`meter_inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_inventory`
--

LOCK TABLES `meter_inventory` WRITE;
/*!40000 ALTER TABLE `meter_inventory` DISABLE KEYS */;
INSERT INTO `meter_inventory` VALUES (1,'MC-20190611-1','0619418','',1,0,'2019-06-19','\0','',2,1),(2,'MC-20190611-2','0619414','',1,0,'2019-06-19','\0','',2,1),(3,'MC-20190611-3','0700534','',1,0,'2019-06-19','\0','',2,1),(4,'MC-20190611-4','0619419','',1,0,'2019-06-19','\0','',2,1),(5,'MC-20190611-5','0701377','',1,0,'2019-06-19','\0','',2,1),(6,'MC-20190611-6','0700529','',1,0,'2019-06-19','\0','',2,1),(7,'MC-20190611-7','0720573','',1,0,'2019-06-19','\0','',2,1),(8,'MC-20190611-8','0720418','',1,0,'2019-06-19','\0','',2,1),(9,'MC-20190611-9','0720564','',1,0,'2019-06-19','\0','',2,1),(10,'MC-20190611-10','0720561','',1,0,'2019-06-19','\0','',2,1),(11,'MC-20190611-11','0720568','',1,0,'2019-06-19','\0','',2,1),(12,'MC-20190611-12','0720420','',1,0,'2019-06-19','\0','',2,1),(13,'MC-20190611-13','0720419','',1,0,'2019-06-19','\0','',2,1),(14,'MC-20190611-14','0720566','',1,0,'2019-06-19','\0','',2,1),(15,'MC-20190611-15','0700527','',1,0,'2019-06-19','\0','',2,1),(16,'MC-20190611-16','0700540','',1,0,'2019-06-19','\0','',2,1),(17,'MC-20190611-17','0700521','',1,0,'2019-06-19','\0','',2,1),(18,'MC-20190611-18','0700523','',1,0,'2019-06-19','\0','',2,1),(19,'MC-20190611-19','0720569','',1,0,'2019-06-19','\0','',2,1),(20,'MC-20190611-20','0720562','',1,0,'2019-06-19','\0','',2,1),(21,'MC-20190611-21','0720565','',1,0,'2019-06-19','\0','',2,1),(22,'MC-20190611-22','0619416','',1,0,'2019-06-19','\0','',2,1),(23,'MC-20190611-23','0619420','',1,0,'2019-06-19','\0','',2,1),(24,'MC-20190611-24','0700522','',1,0,'2019-06-19','\0','',2,1),(25,'MC-20190611-25','0619411','',1,0,'2019-06-19','\0','',2,1),(26,'MC-20190611-26','0619413','',1,0,'2019-06-19','\0','',2,1),(27,'MC-20190611-27','0700535','',1,0,'2019-06-19','\0','',2,1),(28,'MC-20190611-28','0619412','',1,0,'2019-06-19','\0','',2,1),(29,'MC-20190611-29','0720570','',1,0,'2019-06-19','\0','',2,1),(30,'MC-20190611-30','0700526','',1,0,'2019-06-19','\0','',2,1),(31,'MC-20190611-31','0720567','',1,0,'2019-06-19','\0','',2,1),(32,'MC-20190611-32','0700532','',1,0,'2019-06-19','\0','',2,1),(33,'MC-20190611-33','0700528','',1,0,'2019-06-19','\0','',2,1),(34,'MC-20190611-34','0700539','',1,0,'2019-06-19','\0','',2,1),(35,'MC-20190611-35','0700536','',1,0,'2019-06-19','\0','',2,1),(36,'MC-20190611-36','0701379','',1,0,'2019-06-19','\0','',2,1),(37,'MC-20190611-37','0700530','',1,0,'2019-06-19','\0','',2,1),(38,'MC-20190611-38','0700531','',1,0,'2019-06-19','\0','',2,1),(39,'MC-20190611-39','0700538','',1,0,'2019-06-19','\0','',2,1),(40,'MC-20190611-40','0700533','',1,0,'2019-06-19','\0','',2,1),(41,'MC-20190611-41','0700524','',1,0,'2019-06-19','\0','',2,1),(42,'MC-20190611-42','0700537','',1,0,'2019-06-19','\0','',2,1),(43,'MC-20190611-43','0720575','',1,0,'2019-06-19','\0','',2,1),(44,'MC-20190611-44','0720417','',1,0,'2019-06-19','\0','',2,1),(45,'MC-20190611-45','0700525','',1,0,'2019-06-19','\0','',2,1),(46,'MC-20190611-46','1234567','',1,0,'2019-06-19','\0','',2,1),(47,'MC-20190611-47','0720580','',1,0,'2019-06-19','\0','',2,1),(48,'MC-20190611-48','0720572','',1,0,'2019-06-19','\0','',2,1),(49,'MC-20190611-49','0720574','',1,0,'2019-06-19','\0','',2,1),(50,'MC-20190611-50','0720578','',1,0,'2019-06-19','\0','',2,1),(51,'MC-20190611-51','0701376','',1,0,'2019-06-19','\0','',2,1),(52,'MC-20190611-52','0619417','',1,0,'2019-06-19','\0','',2,1),(53,'MC-20190611-53','0720576','',1,0,'2019-06-19','\0','',2,1),(54,'MC-20190611-54','0720579','',1,0,'2019-06-19','\0','',2,1),(55,'MC-20190611-55','0720571','',1,0,'2019-06-19','\0','',2,1),(56,'MC-20190611-56','0720577','',1,0,'2019-06-19','\0','',2,1),(57,'MC-20190611-57','0701380','',1,0,'2019-06-19','\0','',2,1),(58,'MC-20190611-58','0836331','',1,0,'2019-06-19','\0','',2,1),(59,'MC-20190611-59','0836334','',1,0,'2019-06-19','\0','',2,1),(60,'MC-20190611-60','0619415','',1,0,'2019-06-19','\0','',2,1),(61,'MC-20190611-61','0836332','',1,0,'2019-06-19','\0','',2,1),(62,'MC-20190611-62','0836333','',1,0,'2019-06-19','\0','',2,1),(63,'MC-20190611-63','0836335','',1,0,'2019-06-19','\0','',2,1),(64,'MC-20190611-64','0836336','',1,0,'2019-06-19','\0','',2,1),(65,'MC-20190611-65','0836211','',1,0,'2019-06-19','\0','',2,1),(66,'MC-20190611-66','0836212','',1,0,'2019-06-19','\0','',2,1),(67,'MC-20190611-67','0836213','',1,0,'2019-06-19','\0','',2,1),(68,'MC-20190611-68','0836337','',1,0,'2019-06-19','\0','',2,1),(69,'MC-20190611-69','0836214','',1,0,'2019-06-19','\0','',2,1),(70,'MC-20190611-70','0836215','',1,0,'2019-06-19','\0','',2,1),(71,'MC-20190611-71','0836216','',1,0,'2019-06-19','\0','',2,1),(72,'MC-20190611-72','0836217','',1,0,'2019-06-19','\0','',2,1),(73,'MC-20190611-73','0836338','',1,0,'2019-06-19','\0','',2,1),(74,'MC-20190611-74','0836339','',1,0,'2019-06-19','\0','',2,1),(75,'MC-20190611-75','0836340','',1,0,'2019-06-19','\0','',2,1),(76,'MC-20190611-76','0836224','',1,0,'2019-06-19','\0','',2,1),(77,'MC-20190611-77','0836222','',1,0,'2019-06-19','\0','',2,1),(78,'MC-20190611-78','0836225','',1,0,'2019-06-19','\0','',2,1),(79,'MC-20190611-79','0836218','',1,0,'2019-06-19','\0','',2,1),(80,'MC-20190611-80','0836221','',1,0,'2019-06-19','\0','',2,1),(81,'MC-20190611-81','0836230','',1,0,'2019-06-19','\0','',2,1),(82,'MC-20190611-82','0836227','',1,0,'2019-06-19','\0','',2,1),(83,'MC-20190611-83','0836228','',1,0,'2019-06-19','\0','',2,1),(84,'MC-20190611-84','0836229','',1,0,'2019-06-19','\0','',2,1),(85,'MC-20190611-85','0836226','',1,0,'2019-06-19','\0','',2,1),(86,'MC-20190611-86','0836391','',1,0,'2019-06-19','\0','',2,1),(87,'MC-20190611-87','0836219','',1,0,'2019-06-19','\0','',2,1),(88,'MC-20190611-88','0836283','',1,0,'2019-06-19','\0','',2,1),(89,'MC-20190611-89','0836282','',1,0,'2019-06-19','\0','',2,1),(90,'MC-20190611-90','0836281','',1,0,'2019-06-19','\0','',2,1),(91,'MC-20190611-91','0836284','',1,0,'2019-06-19','\0','',2,1),(92,'MC-20190611-92','0836285','',1,0,'2019-06-19','\0','',2,1),(93,'MC-20190611-93','0836290','',1,0,'2019-06-19','\0','',2,1),(94,'MC-20190611-94','1104921','',1,0,'2019-06-19','\0','',2,1),(95,'MC-20190611-95','0836286','',1,0,'2019-06-19','\0','',2,1),(96,'MC-20190611-96','1104923','',1,0,'2019-06-19','\0','',2,1),(97,'MC-20190611-97','0836220','',1,0,'2019-06-19','\0','',2,1),(98,'MC-20190611-98','0836287','',1,0,'2019-06-19','\0','',2,1),(99,'MC-20190611-99','0836288','',1,0,'2019-06-19','\0','',2,1),(100,'MC-20190611-100','0836289','',1,0,'2019-06-19','\0','',2,1),(101,'MC-20190611-101','0836392','',1,0,'2019-06-19','\0','',2,1),(102,'MC-20190611-102','0836393','',1,0,'2019-06-19','\0','',2,1),(103,'MC-20190611-103','1104929','',1,0,'2019-06-19','\0','',2,1),(104,'MC-20190611-104','0836394','',1,0,'2019-06-19','\0','',2,1),(105,'MC-20190611-105','0836397','',1,0,'2019-06-19','\0','',2,1),(106,'MC-20190611-106','0836400','',1,0,'2019-06-19','\0','',2,1),(107,'MC-20190611-107','0836395','',1,0,'2019-06-19','\0','',2,1),(108,'MC-20190611-108','0836396','',1,0,'2019-06-19','\0','',2,1),(109,'MC-20190611-109','0836398','',1,0,'2019-06-19','\0','',2,1),(110,'MC-20190611-110','0836399','',1,0,'2019-06-19','\0','',2,1),(111,'MC-20190611-111','1104922','',1,0,'2019-06-19','\0','',2,1),(112,'MC-20190611-112','1104924','',1,0,'2019-06-19','\0','',2,1),(113,'MC-20190611-113','1104926','',1,0,'2019-06-19','\0','',2,1),(114,'MC-20190611-114','1104831','',1,0,'2019-06-19','\0','',2,1),(115,'MC-20190611-115','1104832','',1,0,'2019-06-19','\0','',2,1),(116,'MC-20190611-116','1104927','',1,0,'2019-06-19','\0','',2,1),(117,'MC-20190611-117','1104928','',1,0,'2019-06-19','\0','',2,1),(118,'MC-20190611-118','1104930','',1,0,'2019-06-19','\0','',2,1),(119,'MC-20190611-119','1104833','',1,0,'2019-06-19','\0','',2,1),(120,'MC-20190611-120','1104834','',1,0,'2019-06-19','\0','',2,1),(121,'MC-20190611-121','1104835','',1,0,'2019-06-19','\0','',2,1),(122,'MC-20190611-122','1104836','',1,0,'2019-06-19','\0','',2,1),(123,'MC-20190611-123','1104837','',1,0,'2019-06-19','\0','',2,1),(124,'MC-20190611-124','1104838','',1,0,'2019-06-19','\0','',2,1),(125,'MC-20190611-125','1104839','',1,0,'2019-06-19','\0','',2,1),(126,'MC-20190611-126','1105031','',1,0,'2019-06-19','\0','',2,1),(127,'MC-20190611-127','1104840','',1,0,'2019-06-19','\0','',2,1),(128,'MC-20190611-128','1105032','',1,0,'2019-06-19','\0','',2,1),(129,'MC-20190611-129','1105033','',1,0,'2019-06-19','\0','',2,1),(130,'MC-20190611-130','1105034','',1,0,'2019-06-19','\0','',2,1),(131,'MC-20190611-131','1105035','',1,0,'2019-06-19','\0','',1,1),(132,'MC-20190611-132','1105036','',1,0,'2019-06-19','\0','',2,1),(133,'MC-20190611-133','1105039','',1,0,'2019-06-19','\0','',2,1),(134,'MC-20190611-134','1104925','',1,0,'2019-06-19','\0','',2,1),(135,'MC-20190611-135','1105040','',1,0,'2019-06-19','\0','',2,1),(136,'MC-20190611-136','1105052','',1,0,'2019-06-19','\0','',2,1),(137,'MC-20190611-137','1105053','',1,0,'2019-06-19','\0','',2,1),(138,'MC-20190611-138','1105054','',1,0,'2019-06-19','\0','',2,1),(139,'MC-20190611-139','1105055','',1,0,'2019-06-19','\0','',2,1),(140,'MC-20190611-140','1105056','',1,0,'2019-06-19','\0','',2,1),(141,'MC-20190611-141','1105057','',1,0,'2019-06-19','\0','',2,1),(142,'MC-20190611-142','1105058','',1,0,'2019-06-19','\0','',2,1),(143,'MC-20190611-143','1105059','',1,0,'2019-06-19','\0','',2,1),(144,'MC-20190611-144','1105051','',1,0,'2019-06-19','\0','',2,1),(145,'MC-20190611-145','1105141','',1,0,'2019-06-19','\0','',2,1),(146,'MC-20190611-146','1105142','',1,0,'2019-06-19','\0','',2,1),(147,'MC-20190611-147','1105143','',1,0,'2019-06-19','\0','',2,1),(148,'MC-20190611-148','1105144','',1,0,'2019-06-19','\0','',2,1),(149,'MC-20190611-149','1105145','',1,0,'2019-06-19','\0','',2,1),(150,'MC-20190611-150','1105146','',1,0,'2019-06-19','\0','',2,1),(151,'MC-20190611-151','1105147','',1,0,'2019-06-19','\0','',2,1),(152,'MC-20190611-152','1105148','',1,0,'2019-06-19','\0','',2,1),(153,'MC-20190611-153','1105149','',1,0,'2019-06-19','\0','',2,1),(154,'MC-20190611-154','1105150','',1,0,'2019-06-19','\0','',2,1),(155,'MC-20190611-155','140922','',1,0,'2019-06-19','\0','',2,1),(156,'MC-20190611-156','140812','',1,0,'2019-06-19','\0','',2,1),(157,'MC-20190611-157','46902','',1,0,'2019-06-19','\0','',2,1),(158,'MC-20190611-158','140920','',1,0,'2019-06-19','\0','',2,1),(159,'MC-20190611-159','140926','',1,0,'2019-06-19','\0','',2,1),(160,'MC-20190611-160','140929','',1,0,'2019-06-19','\0','',2,1),(161,'MC-20190611-161','140927','',1,0,'2019-06-19','\0','',2,1),(162,'MC-20190611-162','140771','',1,0,'2019-06-19','\0','',2,1),(163,'MC-20190611-163','140850','',1,0,'2019-06-19','\0','',2,1),(164,'MC-20190611-164','140762','',1,0,'2019-06-19','\0','',2,1),(165,'MC-20190611-165','140868','',1,0,'2019-06-19','\0','',2,1),(166,'MC-20190611-166','140768','',1,0,'2019-06-19','\0','',2,1),(167,'MC-20190611-167','140809','',1,0,'2019-06-19','\0','',2,1),(168,'MC-20190611-168','140872','',1,0,'2019-06-19','\0','',2,1),(169,'MC-20190611-169','140811','',1,0,'2019-06-19','\0','',2,1),(170,'MC-20190611-170','140847','',1,0,'2019-06-19','\0','',2,1),(171,'MC-20190611-171','140810','',1,0,'2019-06-19','\0','',2,1),(172,'MC-20190611-172','46860','',1,0,'2019-06-19','\0','',1,0),(173,'MC-20190611-173','46858','',1,0,'2019-06-19','\0','',2,1),(174,'MC-20190611-174','46910','',1,0,'2019-06-19','\0','',2,1),(175,'MC-20190611-175','46906','',1,0,'2019-06-19','\0','',2,1),(176,'MC-20190611-176','46901','',1,0,'2019-06-19','\0','',2,1),(177,'MC-20190611-177','46070','',1,0,'2019-06-19','\0','',2,1),(178,'MC-20190611-178','46069','',1,0,'2019-06-19','\0','',2,1),(179,'MC-20190611-179','46062','',1,0,'2019-06-19','\0','',2,1),(180,'MC-20190611-180','46061','',1,0,'2019-06-19','\0','',2,1),(181,'MC-20190611-181','46066','',1,0,'2019-06-19','\0','',2,1),(182,'MC-20190611-182','46903','',1,0,'2019-06-19','\0','',2,1),(183,'MC-20190611-183','46904','',1,0,'2019-06-19','\0','',2,1),(184,'MC-20190611-184','46905','',1,0,'2019-06-19','\0','',2,1),(185,'MC-20190611-185','46907','',1,0,'2019-06-19','\0','',1,0),(186,'MC-20190611-186','46908','',1,0,'2019-06-19','\0','',1,0),(187,'MC-20190611-187','46909','',1,0,'2019-06-19','\0','',1,0);
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
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_input` date DEFAULT '0000-00-00',
  `posted_by_user` bigint(20) DEFAULT '0',
  `remarks` varchar(445) DEFAULT '',
  `is_processed` bit(1) DEFAULT b'0',
  `is_sent` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `batch_total_amount` decimal(20,2) DEFAULT '0.00',
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
-- Table structure for table `meter_reading_input_items`
--

DROP TABLE IF EXISTS `meter_reading_input_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meter_reading_input_items` (
  `meter_reading_input_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `meter_reading_input_id` bigint(20) DEFAULT '0',
  `connection_id` bigint(20) DEFAULT '0',
  `previous_reading` bigint(20) DEFAULT '0',
  `current_reading` bigint(20) DEFAULT '0',
  `total_consumption` bigint(20) DEFAULT '0',
  `previous_month` varchar(245) DEFAULT '',
  PRIMARY KEY (`meter_reading_input_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_reading_input_items`
--

LOCK TABLES `meter_reading_input_items` WRITE;
/*!40000 ALTER TABLE `meter_reading_input_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `meter_reading_input_items` ENABLE KEYS */;
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
  `is_closed` bit(1) DEFAULT b'0',
  `created_by` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`meter_reading_period_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meter_reading_period`
--

LOCK TABLES `meter_reading_period` WRITE;
/*!40000 ALTER TABLE `meter_reading_period` DISABLE KEYS */;
INSERT INTO `meter_reading_period` VALUES (1,'2018-12-01','2018-12-31',1,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(2,'2019-01-01','2019-01-31',2,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(3,'2019-02-01','2019-02-28',3,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(4,'2019-03-01','2019-03-31',4,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(5,'2019-04-01','2019-04-30',5,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6,'2019-05-01','2019-05-31',6,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(7,'2019-06-01','2019-06-30',7,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(8,'2019-07-01','2019-07-31',8,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(9,'2019-08-01','2019-08-31',9,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(10,'2019-09-01','2019-09-30',10,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(11,'2019-10-01','2019-10-31',11,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(12,'2019-11-01','2019-11-30',12,2019,'','\0','\0',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(13,'2020-05-01','2020-05-31',12,2020,'','','',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00');
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
  `quarterly` int(12) DEFAULT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `months`
--

LOCK TABLES `months` WRITE;
/*!40000 ALTER TABLE `months` DISABLE KEYS */;
INSERT INTO `months` VALUES (1,'January',1),(2,'February',1),(3,'March',1),(4,'April',2),(5,'May',2),(6,'June',2),(7,'July',3),(8,'August',3),(9,'September',3),(10,'October',4),(11,'November',4),(12,'December',4);
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
  `is_processed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`other_charge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_charges`
--

LOCK TABLES `other_charges` WRITE;
/*!40000 ALTER TABLE `other_charges` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other_charges_items`
--

LOCK TABLES `other_charges_items` WRITE;
/*!40000 ALTER TABLE `other_charges_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments`
--

LOCK TABLES `payable_payments` WRITE;
/*!40000 ALTER TABLE `payable_payments` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payable_payments_list`
--

LOCK TABLES `payable_payments_list` WRITE;
/*!40000 ALTER TABLE `payable_payments_list` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_items`
--

LOCK TABLES `purchase_order_items` WRITE;
/*!40000 ALTER TABLE `purchase_order_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments`
--

LOCK TABLES `receivable_payments` WRITE;
/*!40000 ALTER TABLE `receivable_payments` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receivable_payments_list`
--

LOCK TABLES `receivable_payments_list` WRITE;
/*!40000 ALTER TABLE `receivable_payments_list` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights_links`
--

LOCK TABLES `rights_links` WRITE;
/*!40000 ALTER TABLE `rights_links` DISABLE KEYS */;
INSERT INTO `rights_links` VALUES (1,'1','1-1','General Journal'),(2,'1','1-2','Cash Disbursement'),(3,'1','1-3','Purchase Journal'),(4,'1','1-4','Sales Journal'),(5,'1','1-5','Cash Receipt'),(6,'2','2-1','Purchase Order'),(7,'2','2-2','Purchase Invoice'),(8,'2','2-3','Record Payment'),(10,'15','15-3','Item Adjustment'),(11,'3','3-1','Sales Order'),(12,'3','3-2','Sales Invoice'),(13,'3','3-3','Record Payment'),(14,'4','4-2','Category Management'),(15,'4','4-3','Department Management'),(16,'4','4-4','Unit Management'),(17,'5','5-1','Product Management'),(18,'5','5-2','Supplier Management'),(19,'5','5-3','Customer Management'),(20,'6','6-1','Setup Tax'),(21,'6','6-2','Setup Chart of Accounts'),(22,'6','6-3','Account Integration'),(23,'6','6-4','Setup User Group'),(24,'6','6-5','Create User Account'),(25,'6','6-6','Setup Company Info'),(26,'7','7-1','Purchase Order for Approval'),(27,'9','9-1','Balance Sheet Report'),(28,'9','9-2','Income Statement'),(29,'4','4-1','Account Classification'),(30,'8','8-1','Sales Report'),(31,'15','15-4','Inventory Report'),(32,'5','5-4','Salesperson Management'),(33,'2','2-6','Item Adjustment (Out)'),(34,'8','8-3','Export Sales Summary'),(35,'9','9-3','Export Trial Balance'),(36,'6','6-7','Setup Check Layout'),(37,'9','9-4','AR Schedule'),(38,'9','9-6','Customer Subsidiary'),(39,'9','9-8','Account Subsidiary'),(40,'9','9-7','Supplier Subsidiary'),(41,'9','9-5','AP Schedule'),(42,'8','8-4','Purchase Invoice Report'),(43,'4','4-5','Locations Management'),(44,'10','10-1','Fixed Asset Management'),(45,'9','9-9','Annual Income Statement'),(46,'6','6-8','Recurring Template'),(47,'9','9-10','VAT Relief Report'),(48,'1','1-6','Petty Cash Journal'),(49,'9','9-13','Replenishment Report'),(50,'6','6-9','Backup Database'),(51,'9','9-14','Book of Accounts'),(52,'9','9-16','Comparative Income'),(53,'4','4-6','Bank Reference Management'),(54,'10','10-2','Depreciation Expense Report'),(55,'11','11-1','Bank Reconciliation'),(57,'12','12-1','Voucher Registry Report'),(58,'12','12-2','Check Registry Report'),(59,'12','12-3','Collection List Report'),(60,'12','12-4','Open Purchase Report'),(61,'12','12-5','Open Sales Report'),(62,'9','9-11','Schedule of Expense'),(63,'9','9-15','AR Reports'),(64,'9','9-12','Cost of Goods'),(65,'13','13-1','Service Invoice'),(66,'13','13-2','Service Journal'),(67,'13','13-3','Service Unit Management'),(68,'13','13-4','Service Management'),(69,'9','9-17','Aging of Receivables'),(70,'9','9-18','Aging of Payables'),(71,'9','9-19','Statement of Account'),(72,'6','6-10','Email Settings'),(73,'14','14-1','Treasury'),(74,'9','9-20','Replenishment Batch Report'),(75,'9','9-21','General Ledger'),(76,'6','6-11','Email Report'),(77,'12','12-6','Product Reorder (Pick-list)'),(78,'12','12-7','Product List Report'),(79,'2','2-8','Purchase History'),(80,'2','2-7','Purchase Monitoring'),(81,'6','6-12','Puchasing Integration'),(82,'15','15-1','Product Management (Inventory Tab)'),(83,'3','3-4','Cash Invoice'),(84,'6','6-13','Audit Trail'),(85,'15','15-5','Item Transfer to Department'),(86,'15','15-6','Stock Card / Bin Card'),(87,'3','3-5','Warehouse Dispatching'),(88,'4','4-7','Brands'),(89,'16','16-1','Monthly Percentage Tax Return'),(90,'16','16-2','Quarterly Percentage Tax Return'),(91,'16','16-3','Certificate of Creditable Tax'),(92,'6','6-14','Statement of Accounts Settings'),(93,'5','5-5','Meter Inventory Management'),(94,'17','17-1','Service Connection'),(95,'17','17-2','Service Disconnection'),(96,'17','17-3','Service Reconnection'),(97,'18','18-1','Meter Reading Entry'),(98,'18','18-2','Process Billing'),(99,'18','18-3','Billing Payments'),(100,'19','19-1','Charges Management'),(101,'19','19-2','Charge Unit Management'),(102,'19','19-3','Other Charges'),(103,'20','20-1','Residential Rate Matrix'),(104,'20','20-2','Commercial Rate Matrix'),(105,'20','20-3','Meter Inventory'),(106,'20','20-4','Meter Reading Period'),(107,'20','20-5','Attendant Management'),(108,'21','21-1','Service Trail'),(109,'21','21-2','Consumption History'),(110,'21','21-3','Billing Statement'),(111,'22','22-1','Billing Sending'),(112,'22','22-2','Payment Sending'),(113,'21','21-4','Customer Billing Subsidiary'),(114,'21','21-5','Batch Payment Report'),(115,'22','22-3','Connection Deposits Sending'),(116,'21','21-6','Batch Connection Deposits Report'),(117,'23','23-1','Create Service Connection'),(118,'23','23-2','Edit Service Connection'),(119,'23','23-3','Delete Service Connection'),(120,'24','24-1','Create Service Disconnection'),(121,'24','24-2','Edit Service Disconnection'),(122,'24','24-3','Delete Service Disconnection'),(123,'25','25-1','Create Service Reconnection'),(124,'25','25-2','Edit Service Reconnection'),(125,'25','25-3','Delete Service Reconnection'),(126,'26','26-1','Create Meter Reading Entry'),(127,'26','26-2','Edit Meter Reading Entry'),(128,'26','26-3','Delete Meter Reading Entry'),(129,'27','27-1','Process Billing Statement'),(130,'28','28-1','Create Billing Payment'),(131,'28','28-2','Cancel Billing Payment'),(132,'29','29-1','Create Charges Management'),(133,'29','29-2','Edit Charges Management'),(134,'29','29-3','Delete Charges Management'),(135,'30','30-1','Create Charges Unit Management'),(136,'30','30-2','Edit Charges Unit Management'),(137,'30','30-3','Delete Charges Unit Management'),(138,'31','31-1','Create Other Charges'),(139,'31','31-2','Edit Other Charges'),(140,'31','31-3','Delete Other Charges'),(141,'32','32-1','Create Residential Rate Matrix'),(142,'32','32-2','Edit Residential Rate Matrix'),(143,'32','32-3','Delete Residential Rate Matrix'),(144,'33','33-1','Create Commercial Rate Matrix'),(145,'33','33-2','Edit Commercial Rate Matrix'),(146,'33','33-3','Delete Commercial Rate Matrix'),(147,'34','34-1','Create Meter Inventory'),(148,'34','34-2','Edit Meter Inventory'),(149,'34','34-3','Delete Meter Inventory'),(150,'35','35-1','Create Meter Reading Period'),(151,'35','35-2','Edit Meter Reading Period'),(152,'35','35-3','Delete Meter Reading Period'),(153,'35','35-4','Close Meter Reading Period'),(154,'36','36-1','Create Attendant Management'),(155,'36','36-2','Edit Attendant Management'),(156,'36','36-3','Delete Attendant Management'),(157,'37','37-1','Send to Accounting Connection Deposits'),(158,'38','38-1','Send to Accounting Billing'),(159,'39','39-1','Send to Accounting Payments'),(160,'21','21-7','Customer Billing Receivables');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice`
--

LOCK TABLES `sales_invoice` WRITE;
/*!40000 ALTER TABLE `sales_invoice` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice_items`
--

LOCK TABLES `sales_invoice_items` WRITE;
/*!40000 ALTER TABLE `sales_invoice_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_items`
--

LOCK TABLES `sales_order_items` WRITE;
/*!40000 ALTER TABLE `sales_order_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salesperson`
--

LOCK TABLES `salesperson` WRITE;
/*!40000 ALTER TABLE `salesperson` DISABLE KEYS */;
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
  `receipt_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `target_date` date DEFAULT '0000-00-00',
  `target_time` time DEFAULT '00:00:00',
  `rate_type_id` int(12) DEFAULT '0',
  `initial_meter_deposit` decimal(20,2) DEFAULT '0.00',
  `initial_meter_reading` bigint(20) DEFAULT '0',
  `attendant_id` int(12) DEFAULT '0',
  `date_created` date DEFAULT '0000-00-00',
  `created_by` int(12) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `status_id` int(12) DEFAULT '1',
  `current_id` bigint(20) DEFAULT '0',
  `meter_inventory_id` bigint(20) DEFAULT '0',
  `service_connection_batch_id` bigint(20) DEFAULT '0',
  PRIMARY KEY (`connection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='current_id  is the log for the current status id';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_connection`
--

LOCK TABLES `service_connection` WRITE;
/*!40000 ALTER TABLE `service_connection` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_connection_batch`
--

DROP TABLE IF EXISTS `service_connection_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_connection_batch` (
  `service_connection_batch_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT '0000-00-00',
  `end_date` date DEFAULT '0000-00-00',
  `batch_code` varchar(145) DEFAULT '',
  `batch_total_deposit` decimal(20,2) DEFAULT '0.00',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `posted_by_user_id` bigint(20) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`service_connection_batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_connection_batch`
--

LOCK TABLES `service_connection_batch` WRITE;
/*!40000 ALTER TABLE `service_connection_batch` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_connection_batch` ENABLE KEYS */;
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
  `disconnection_notes` varchar(45) DEFAULT '',
  `date_created` date DEFAULT '0000-00-00',
  `created_by` int(12) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `service_no` varchar(255) DEFAULT NULL,
  `previous_id` bigint(20) DEFAULT '0',
  `previous_status_id` bigint(20) DEFAULT '0',
  `previous_month` varchar(145) DEFAULT '0',
  `previous_reading` bigint(20) DEFAULT '0',
  `last_meter_reading` bigint(20) DEFAULT '0',
  `total_consumption` bigint(20) DEFAULT '0',
  `rate_amount` decimal(20,2) DEFAULT '0.00',
  `meter_amount_due` decimal(20,2) DEFAULT '0.00',
  `charges_amount` decimal(20,2) DEFAULT '0.00',
  `grand_total_amount` decimal(20,2) DEFAULT '0.00',
  `default_matrix_id` bigint(20) DEFAULT '0',
  `is_fixed` bit(1) DEFAULT b'0',
  `arrears_amount` decimal(20,2) DEFAULT '0.00',
  `arrears_penalty_amount` decimal(20,2) DEFAULT '0.00',
  `remaining_deposit` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`disconnection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_disconnection`
--

LOCK TABLES `service_disconnection` WRITE;
/*!40000 ALTER TABLE `service_disconnection` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_disconnection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_disconnection_charges`
--

DROP TABLE IF EXISTS `service_disconnection_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_disconnection_charges` (
  `service_disconnection_charge_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `disconnection_id` bigint(20) DEFAULT '0',
  `other_charge_id` int(12) DEFAULT '0',
  `other_charge_item_id` int(12) DEFAULT '0',
  `charge_id` int(12) DEFAULT '0',
  `charge_unit_id` int(12) DEFAULT '0',
  `charge_amount` decimal(20,2) DEFAULT '0.00',
  `charge_qty` decimal(20,2) DEFAULT '0.00',
  `charge_line_total` decimal(20,2) DEFAULT '0.00',
  PRIMARY KEY (`service_disconnection_charge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_disconnection_charges`
--

LOCK TABLES `service_disconnection_charges` WRITE;
/*!40000 ALTER TABLE `service_disconnection_charges` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_disconnection_charges` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice`
--

LOCK TABLES `service_invoice` WRITE;
/*!40000 ALTER TABLE `service_invoice` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice_items`
--

LOCK TABLES `service_invoice_items` WRITE;
/*!40000 ALTER TABLE `service_invoice_items` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_reconnection`
--

LOCK TABLES `service_reconnection` WRITE;
/*!40000 ALTER TABLE `service_reconnection` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'N/A','N/A','','','','','','','',1,'',0.00,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'\0','',0,'0000-00-00 00:00:00',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans`
--

LOCK TABLES `trans` WRITE;
/*!40000 ALTER TABLE `trans` DISABLE KEYS */;
INSERT INTO `trans` VALUES (1,1,1,75,'Created New Meter Reading Period : December 2020 (05/01/2020 - 05/31/2020)','2019-06-19 12:00:20'),(2,1,2,75,'Updated Meter Reading Period : ID(13)','2019-06-19 12:00:29'),(3,1,13,75,'Close Meter Reading Period : ID(13)','2019-06-19 12:00:35'),(4,1,13,75,'Close Meter Reading Period : ID(13)','2019-06-19 12:00:41'),(5,1,3,75,'Deleted Meter Reading Period : ID(13)','2019-06-19 12:00:45'),(6,1,1,72,'Created Attendant: 12 12 12','2019-06-19 12:04:37'),(7,1,2,72,'Updated Attendant: ID(2)','2019-06-19 12:04:43'),(8,1,3,72,'Deleted Attendant: ID(2)','2019-06-19 12:04:45'),(9,1,12,84,'Transfered Batch Meter Reading to Accounting: (12)','2019-06-19 12:05:22'),(10,1,12,84,'Transfered Batch Meter Reading to Accounting: (13)','2019-06-19 12:06:12'),(11,1,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201907-2)','2019-06-19 12:06:28'),(12,1,1,81,'Created New Billing Payment: (15)','2019-06-19 12:08:27'),(13,1,12,83,'Transfered Billing Payments to Accounting: (06/19/2019 to 06/19/2019) ID(6)','2019-06-19 12:08:35'),(14,0,10,43,'Login Attempt using username: admin','2019-06-20 08:39:03'),(15,1,6,43,'User Log in: System  Administrator','2019-06-20 08:39:06'),(16,1,8,84,'Finalized Connection Deposit Batch No. BATCH-DEPOSIT-13 For General Journal Entry TXN-20190620-88','2019-06-20 09:12:58'),(17,1,1,1,'Created General Journal TXN-20190620-88','2019-06-20 09:12:58'),(18,1,1,81,'Created New Billing Payment: (16)','2019-06-20 09:36:46'),(19,1,1,81,'Created New Billing Payment: (17)','2019-06-20 09:37:08'),(20,1,7,43,'User Log Out :System  Administrator','2019-06-20 11:05:02'),(21,1,6,43,'User Log in: System  Administrator','2019-06-20 11:05:08'),(22,1,7,43,'User Log Out :System  Administrator','2019-06-20 11:06:16'),(23,1,6,43,'User Log in: System  Administrator','2019-06-20 11:06:20'),(24,1,1,52,'Created a new customer: ','2019-06-20 11:06:36'),(25,1,1,52,'Created a new customer: ','2019-06-20 11:07:24'),(26,1,1,52,'Created a new customer: ','2019-06-20 11:08:57'),(27,1,1,52,'Created a new customer: ','2019-06-20 11:09:17'),(28,1,1,52,'Created a new customer: ','2019-06-20 11:09:32'),(29,1,1,52,'Created a new customer: ','2019-06-20 11:10:06'),(30,1,1,52,'Created a new customer: ','2019-06-20 11:10:31'),(31,1,1,69,'Created New Connection: SCN-20190620-1 - NEMOTO, FLORDELISA (1105142) ','2019-06-20 11:13:49'),(32,1,1,69,'Created New Connection: SCN-20190620-2 - LOUIE NEY NEPOMUCENO (0720569) ','2019-06-20 11:14:26'),(33,1,1,69,'Created New Connection: SCN-20190620-3 - DIZON DANIEL H (0720579) ','2019-06-20 11:15:00'),(34,1,1,69,'Created New Connection: SCN-20190620-4 - ORLEANS MALONES (0836332) ','2019-06-20 11:15:34'),(35,1,1,69,'Created New Connection: SCN-20190620-5 - YOUNG CHANG INC. (1105035) ','2019-06-20 11:16:37'),(36,1,1,69,'Created New Connection: SCN-20190620-6 - YOUNG CHANG INC. (1105036) ','2019-06-20 11:17:09'),(37,1,1,69,'Created New Connection: SCN-20190620-7 - YOUNG CHANG INC. (1105039) ','2019-06-20 11:17:37'),(38,1,1,69,'Created New Connection: SCN-20190620-8 - YOUNG CHANG INC. (1104925) ','2019-06-20 11:18:03'),(39,1,2,75,'Updated Meter Reading Period : ID(7)','2019-06-20 11:26:10'),(40,1,2,75,'Updated Meter Reading Period : ID(6)','2019-06-20 11:26:18'),(41,1,2,75,'Updated Meter Reading Period : ID(8)','2019-06-20 11:26:31'),(42,1,2,75,'Updated Meter Reading Period : ID(9)','2019-06-20 11:26:38'),(43,1,2,75,'Updated Meter Reading Period : ID(10)','2019-06-20 11:26:47'),(44,1,2,75,'Updated Meter Reading Period : ID(11)','2019-06-20 11:26:56'),(45,1,2,75,'Updated Meter Reading Period : ID(12)','2019-06-20 11:27:05'),(46,1,1,79,'Created New Batch Meter Reading: BCH-201907-1','2019-06-20 11:27:35'),(47,1,11,80,'Process Billing (July 2019)','2019-06-20 11:46:05'),(48,1,1,81,'Created New Billing Payment: (1)','2019-06-20 11:51:53'),(49,1,1,81,'Created New Billing Payment: (2)','2019-06-20 11:56:00'),(50,1,1,81,'Created New Billing Payment: (3)','2019-06-20 11:56:08'),(51,1,1,81,'Created New Billing Payment: (4)','2019-06-20 11:56:13'),(52,1,1,81,'Created New Billing Payment: (5)','2019-06-20 11:56:24'),(53,1,1,79,'Created New Batch Meter Reading: BCH-201908-1','2019-06-20 12:01:53'),(54,1,11,80,'Process Billing (August 2019)','2019-06-20 12:02:07'),(55,1,12,84,'Transfered Batch Meter Reading to Accounting: (1)','2019-06-20 12:02:23'),(56,1,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201907-1)','2019-06-20 12:02:32'),(57,1,12,83,'Transfered Billing Payments to Accounting: (06/20/2019 to 06/20/2019) ID(1)','2019-06-20 12:02:57'),(58,1,2,57,'Updated Water Billing System Configuration','2019-06-20 12:05:30'),(59,1,2,57,'Updated Water Billing System Configuration','2019-06-20 12:05:32'),(60,1,8,82,'Finalized Meter Entry Batch No.BCH-201907-1 For Sales Journal Entry TXN-20190620-89','2019-06-20 12:05:43'),(61,1,1,4,'Created Sales Journal Entry TXN-20190620-89','2019-06-20 12:05:43'),(62,1,8,84,'Finalized Connection Deposit Batch No. BATCH-DEPOSIT-1 For General Journal Entry TXN-20190620-90','2019-06-20 12:07:11'),(63,1,1,1,'Created General Journal TXN-20190620-90','2019-06-20 12:07:11'),(64,1,8,83,'Finalized Billing Payment Batch No.BATCH-PAYMENT-1 (1) For Cash Receipt Journal TXN-20190620-91','2019-06-20 12:08:30'),(65,1,1,6,'Created Cash Receipt Journal Entry TXN-20190620-91','2019-06-20 12:08:30'),(66,1,11,80,'Process Billing (August 2019)','2019-06-20 12:24:08'),(67,1,3,79,'Deleted Batch Meter Reading: ID(2)','2019-06-20 12:33:02'),(68,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-06-20 12:36:41'),(69,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-20 12:36:45'),(70,1,1,79,'Created New Batch Meter Reading: BCH-201908-2','2019-06-20 14:31:04'),(71,1,11,80,'Process Billing (August 2019)','2019-06-20 14:31:32'),(72,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-20 15:49:42'),(73,1,6,43,'User Log in: System  Administrator','2019-06-21 09:23:22'),(74,1,1,52,'Created a new customer: ','2019-06-21 10:07:14'),(75,1,1,69,'Created New Connection: SCN-20190621-9 - JOHN DOE (46909) ','2019-06-21 10:08:24'),(76,1,1,52,'Created a new customer: ','2019-06-21 10:09:18'),(77,1,1,69,'Created New Connection: SCN-20190621-10 - ALYZZA OLMOS (46908) ','2019-06-21 10:09:46'),(78,1,1,52,'Created a new customer: ','2019-06-21 10:10:30'),(79,1,1,69,'Created New Connection: SCN-20190621-11 - ART MAPAGMAHAL SA BAYAN (46860) ','2019-06-21 10:10:54'),(80,0,10,43,'Login Attempt using username: ADMIN','2019-07-02 10:11:53'),(81,1,6,43,'User Log in: System  Administrator','2019-07-02 10:11:58'),(82,1,1,79,'Created New Batch Meter Reading: BCH-201907-2','2019-07-02 10:12:47'),(83,1,11,80,'Process Billing (July 2019)','2019-07-02 10:13:14'),(84,1,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201907-2)','2019-07-02 10:16:48'),(85,1,8,82,'Finalized Meter Entry Batch No.BCH-201907-2 For Sales Journal Entry TXN-20190702-92','2019-07-02 10:17:03'),(86,1,1,4,'Created Sales Journal Entry TXN-20190702-92','2019-07-02 10:17:03'),(87,1,1,81,'Created New Billing Payment: (6)','2019-07-02 10:18:15'),(88,1,1,81,'Created New Billing Payment: (7)','2019-07-02 10:18:34'),(89,1,1,81,'Created New Billing Payment: (8)','2019-07-02 10:18:47'),(90,1,12,83,'Transfered Billing Payments to Accounting: (07/02/2019 to 07/02/2019) ID(2)','2019-07-02 10:19:07'),(91,1,8,83,'Finalized Billing Payment Batch No.BATCH-PAYMENT-2 (2) For Cash Receipt Journal TXN-20190702-93','2019-07-02 10:19:52'),(92,1,1,6,'Created Cash Receipt Journal Entry TXN-20190702-93','2019-07-02 10:19:52'),(93,1,6,43,'User Log in: System  Administrator','2019-08-02 10:23:38'),(94,1,1,79,'Created New Batch Meter Reading: BCH-201908-3','2019-08-02 10:24:34'),(95,1,11,80,'Process Billing (August 2019)','2019-08-02 10:24:52'),(96,1,2,79,'Updated Batch Meter Reading: ID(5)','2019-08-02 10:25:21'),(97,1,11,80,'Process Billing (August 2019)','2019-08-02 10:25:35'),(98,1,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201908-3)','2019-08-02 10:29:21'),(99,1,8,82,'Finalized Meter Entry Batch No.BCH-201908-3 For Sales Journal Entry TXN-20190802-94','2019-08-02 10:29:55'),(100,1,1,4,'Created Sales Journal Entry TXN-20190802-94','2019-08-02 10:29:55'),(101,1,1,81,'Created New Billing Payment: (9)','2019-08-02 10:30:37'),(102,1,1,81,'Created New Billing Payment: (10)','2019-08-02 10:30:56'),(103,1,1,81,'Created New Billing Payment: (11)','2019-08-02 10:31:08'),(104,1,12,83,'Transfered Billing Payments to Accounting: (08/02/2019 to 08/02/2019) ID(3)','2019-08-02 10:31:34'),(105,1,8,83,'Finalized Billing Payment Batch No.BATCH-PAYMENT-3 (3) For Cash Receipt Journal TXN-20190802-95','2019-08-02 10:31:54'),(106,1,1,6,'Created Cash Receipt Journal Entry TXN-20190802-95','2019-08-02 10:31:55'),(107,1,12,84,'Transfered Batch Meter Reading to Accounting: (2)','2019-08-02 10:33:54'),(108,1,8,84,'Finalized Connection Deposit Batch No. BATCH-DEPOSIT-2 For General Journal Entry TXN-20190802-96','2019-08-02 10:34:26'),(109,1,1,1,'Created General Journal TXN-20190802-96','2019-08-02 10:34:26'),(110,1,1,81,'Created New Billing Payment: (12)','2019-08-02 10:34:58'),(111,1,12,83,'Transfered Billing Payments to Accounting: (08/02/2019 to 08/02/2019) ID(4)','2019-08-02 10:35:18'),(112,1,8,83,'Finalized Billing Payment Batch No.BATCH-PAYMENT-4 (4) For Cash Receipt Journal TXN-20190802-97','2019-08-02 10:36:01'),(113,1,1,6,'Created Cash Receipt Journal Entry TXN-20190802-97','2019-08-02 10:36:01'),(114,1,1,59,'Created User Group : Jude','2019-08-02 10:36:32'),(115,1,2,59,'Updated User Rights Links: ID(5)','2019-08-02 10:37:35'),(116,1,1,43,'Created User: jude','2019-08-02 10:37:59'),(117,1,7,43,'User Log Out :System  Administrator','2019-08-02 10:38:01'),(118,9,6,43,'User Log in: Jude  Olmos','2019-08-02 10:38:04'),(119,9,7,43,'User Log Out :Jude  Olmos','2019-08-02 10:38:57'),(120,0,10,43,'Login Attempt using username: admin','2019-08-02 10:38:59'),(121,1,6,43,'User Log in: System  Administrator','2019-08-02 10:39:02'),(122,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-06-21 11:32:54'),(123,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-21 11:32:58'),(124,8,2,69,'Updated Service Connection: ID(1)','2019-06-21 12:19:05'),(125,8,2,69,'Updated Service Connection: ID(1)','2019-06-21 12:19:29'),(126,8,2,52,'Updated customer: NEMOTO FLORDELISA ID(2)','2019-06-21 12:20:09'),(127,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-24 09:07:03'),(128,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-06-24 10:00:00'),(129,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-24 10:00:02'),(130,8,1,77,'Created Charge Unit: (Fee)','2019-06-24 10:32:52'),(131,8,1,76,'Created Charge: (CC101)','2019-06-24 10:32:59'),(132,8,1,78,'Created New Other Charges Invoice: (OTH-CHR-20190624-1)','2019-06-24 10:33:12'),(133,8,1,52,'Created a new customer: ','2019-06-24 11:04:47'),(134,0,10,43,'Login Attempt using username: sah','2019-06-25 08:27:13'),(135,8,6,43,'User Log in: Joash Jezreel Lucas Noble','2019-06-25 08:27:15'),(136,8,1,70,'Created New Disconnection: SDN-20190625-1 - YOUNG CHANG INC. (1105035) ','2019-06-25 08:30:33'),(137,8,1,71,'Created New Reconnection: SRN-20190625-1 - YOUNG CHANG INC. (1105035) ','2019-06-25 08:34:12'),(138,8,1,69,'Created New Connection: SCN-20190625-12 - DIZON DANIEL H (46907) ','2019-06-25 09:48:33'),(139,8,2,69,'Updated Service Connection: ID(12)','2019-06-25 09:49:51'),(140,8,1,79,'Created New Batch Meter Reading: BCH-201908-4','2019-06-25 09:50:53'),(141,8,11,80,'Process Billing (August 2019)','2019-06-25 09:51:09'),(142,8,1,81,'Created New Billing Payment: (13)','2019-06-25 09:57:17'),(143,8,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201908-4)','2019-06-25 09:58:58'),(144,8,12,83,'Transfered Billing Payments to Accounting: (06/25/2019 to 06/25/2019) ID(5)','2019-06-25 09:59:07'),(145,8,12,82,'Transfered Batch Meter Reading to Accounting: (BCH-201908-2)','2019-06-25 09:59:29'),(146,8,12,84,'Transfered Batch Meter Reading to Accounting: (3)','2019-06-25 09:59:41'),(147,8,1,59,'Created User Group : yza','2019-06-25 10:10:55'),(148,8,1,59,'Created User Group : tan','2019-06-25 10:11:03'),(149,8,1,59,'Created User Group : art','2019-06-25 10:11:07'),(150,8,3,59,'Deleted User Group: ID(8)','2019-06-25 10:11:15'),(151,8,3,59,'Deleted User Group: ID(7)','2019-06-25 10:11:17'),(152,8,3,59,'Deleted User Group: ID(6)','2019-06-25 10:11:20'),(153,8,2,59,'Updated User Group: ojt ID (5)','2019-06-25 10:11:26'),(154,8,2,59,'Updated User Group: Intern ID (5)','2019-06-25 10:11:31'),(155,8,2,59,'Updated User Rights Links: ID(5)','2019-06-25 10:14:50'),(156,8,2,43,'Updated User : jude ID(9)','2019-06-25 10:15:11'),(157,8,1,43,'Created User: tan','2019-06-25 10:15:37'),(158,8,1,43,'Created User: art','2019-06-25 10:15:58'),(159,8,1,43,'Created User: yza','2019-06-25 10:16:18'),(160,8,7,43,'User Log Out :Joash Jezreel Lucas Noble','2019-06-25 10:16:31'),(161,9,6,43,'User Log in: Jude  Matthew','2019-06-25 10:16:35'),(162,9,7,43,'User Log Out :Jude  Matthew','2019-06-25 10:16:59'),(163,11,6,43,'User Log in: Art  art','2019-06-25 10:17:04'),(164,11,7,43,'User Log Out :Art  art','2019-06-25 10:17:07'),(165,10,6,43,'User Log in: Tan  Tan','2019-06-25 10:17:11'),(166,10,7,43,'User Log Out :Tan  Tan','2019-06-25 10:17:15'),(167,12,6,43,'User Log in: Allyza  Olmos','2019-06-25 10:17:21'),(168,12,7,43,'User Log Out :Allyza  Olmos','2019-06-25 10:17:27');
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
INSERT INTO `trans_key` VALUES (1,'Create'),(2,'Update'),(3,'Delete'),(4,'Cancel'),(6,'Log In'),(7,'Log Out'),(8,'Finalize'),(9,'Uncancel'),(10,'Login Attempts'),(11,'Process'),(12,'Transfer'),(13,'Close');
/*!40000 ALTER TABLE `trans_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_key_services`
--

DROP TABLE IF EXISTS `trans_key_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_key_services` (
  `trans_key_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_key_desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trans_key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_key_services`
--

LOCK TABLES `trans_key_services` WRITE;
/*!40000 ALTER TABLE `trans_key_services` DISABLE KEYS */;
INSERT INTO `trans_key_services` VALUES (1,'Create'),(2,'Delete');
/*!40000 ALTER TABLE `trans_key_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_services`
--

DROP TABLE IF EXISTS `trans_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_services` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(12) DEFAULT '0',
  `trans_key_id` int(12) DEFAULT '0',
  `trans_type_id` int(12) DEFAULT '0',
  `connection_id` int(12) DEFAULT '0',
  `trans_log` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_services`
--

LOCK TABLES `trans_services` WRITE;
/*!40000 ALTER TABLE `trans_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_services` ENABLE KEYS */;
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
INSERT INTO `trans_type` VALUES (1,'General Journal'),(2,'Cash Disbursement'),(3,'Purchase Journal'),(4,'Sales Journal'),(5,'Petty Cash Journal'),(6,'Cash Receipt Journal'),(7,'Service Invoice'),(8,'Service Journal'),(9,'Service Unit'),(10,'Services'),(11,'Purchase Order'),(12,'Purchase Invoice'),(13,'Record Payment'),(14,'Item Issuance'),(15,'Item Adjustment'),(16,'Sales Order'),(17,'Sales Invoice'),(18,'Collection Entry'),(43,'User Accounts'),(44,'Account Classification'),(45,'Category Management'),(46,'Department Management'),(47,'Unit Management'),(48,'Locations Management'),(49,'Bank Management'),(50,'Product Management'),(51,'Supplier Management'),(52,'Customer Management'),(53,'Salesperson Management'),(54,'Fixed Asset Management'),(55,'Setup Tax'),(56,'Setup Chart of Accounts'),(57,'General Configuration'),(58,'Purchasing Configuration'),(59,'User Rights'),(60,'Company Info'),(61,'Check Layout'),(62,'Recurring Template'),(63,'Email Settings'),(64,'Email Report Settings'),(65,'Cash Invoice'),(66,'Issuance to Department'),(67,'Order Source'),(68,'Meter Inventory Management'),(69,'Service Connection'),(70,'Service Disconnection'),(71,'Service Reconnection'),(72,'Attendant Management'),(73,'Residential Rate Matrix'),(74,'Commercial Rate Matrix'),(75,'Meter Reading Period'),(76,'Charges Management'),(77,'Charge Unit Management'),(78,'Other Charges'),(79,'Meter Reading Entry'),(80,'Process Billing'),(81,'Billing Payments'),(82,'Meter Entry Batch'),(83,'Billing Batch Payment'),(84,'Billing Batch Deposits');
/*!40000 ALTER TABLE `trans_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_type_services`
--

DROP TABLE IF EXISTS `trans_type_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trans_type_services` (
  `trans_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_type_desc` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`trans_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_type_services`
--

LOCK TABLES `trans_type_services` WRITE;
/*!40000 ALTER TABLE `trans_type_services` DISABLE KEYS */;
INSERT INTO `trans_type_services` VALUES (1,'Service Connection'),(2,'Service Disconnection'),(3,'Service Reconnection');
/*!40000 ALTER TABLE `trans_type_services` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_accounts`
--

LOCK TABLES `user_accounts` WRITE;
/*!40000 ALTER TABLE `user_accounts` DISABLE KEYS */;
INSERT INTO `user_accounts` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Administrator','System','','Angeles City, Pampanga','jdevtechsolution@gmail.com','0955-283-3018','','1970-01-01',1,'assets/img/user/5bbeb72d2a234.png',NULL,'','\0',NULL,'2019-06-21 03:31:05',0,1,0,0,1,'2019-06-21 11:31:05','4dac2d300abc5eff17c90877daec3759',0,'Rafael Manalo','Rafael Manalo'),(2,'jason','356a192b7913b04c54574d18c28d46e6395428ab','Joson','Jason','','','','','','2018-07-18',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:12','2019-05-08 01:02:30',2147483647,7,1,1,0,'2018-12-20 09:14:53','16ff758e8efcc362badc7e02872dd704',0,'',''),(3,'hans','da39a3ee5e6b4b0d3255bfef95601890afd80709','De Guzman','Hans','','','','','','1970-01-01',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:29','2018-12-20 01:24:16',2147483647,0,1,1,1,'2018-07-18 10:07:18','34115363e8d2820cc15d1a2ace336df7',0,'',''),(4,'joy','c7d56fc0723a766824f554c4d00f28ea16c2c36b','Damasco','Joy','','','','','','1970-01-01',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:41:48','2019-05-08 01:02:28',2147483647,7,1,1,1,'2018-07-18 10:09:58','f7472d0e1dd62c5348b2cbb560666fd9',0,'',''),(5,'raf','3cc95b3704d4ac1c0d7712092f1b60c7f2e53a75','raf','raf','','','','','','2018-07-18',1,'assets/img/anonymous-icon.png',NULL,'','','2018-07-18 08:49:13','2019-05-08 01:02:26',2147483647,0,1,1,1,'2018-10-18 13:16:04','e5101e4c88fd93232d5a35cbf295282c',0,'',''),(6,'rhia','40bd001563085fc35165329ea1ff5c5ecbdbbeef','Corporation','Rhia','','','','','','2018-08-07',2,'assets/img/anonymous-icon.png',NULL,'','','2018-08-07 11:06:49','2019-05-08 01:02:33',2147483647,0,1,1,0,'2018-08-07 11:06:57','bbded0536a67611435721cea86da29e0',0,'',''),(7,'raf','3cc95b3704d4ac1c0d7712092f1b60c7f2e53a75','Manalo','Rafael ','Bulatao','11-6 Justice Mejia St., Villa Gloria Subdivision, Barangay San Jose, Angeles City, Pampanga 2009','manaloraf03@gmail.com','09559762739','9003988','1997-02-03',4,'assets/img/user/5c19afcfead1b.jpg',NULL,'','\0','2018-12-19 10:33:40','2019-06-19 03:37:14',0,1,1,0,1,'2019-06-19 11:37:14','324a1366aac2f5ce85d57657ea7af37c',0,'',''),(8,'ash','cb101192dff2cc1ddd0272f73de307c89bebc181','Noble','Joash Jezreel','Lucas','','','','','2019-05-08',1,'assets/img/anonymous-icon.png',NULL,'','\0','2019-05-08 09:02:57','2019-06-25 02:16:31',0,0,1,0,0,'2019-06-25 10:14:59','0cd5b39d1cd61f189717af33e173f4be',0,'',''),(9,'jude','5a40e8519ec50bab677669ed17dc3de3d8ac770d','Matthew','Jude','','','','','','2019-08-02',5,'assets/img/anonymous-icon.png',NULL,'','\0','2019-08-02 10:37:59','2019-06-25 02:16:59',0,8,1,0,0,'2019-06-25 10:16:36','8e7d7864cbf233c02a22276dca98ab51',0,'',''),(10,'tan','35ca8cf12ff7ebe96d1bd7602a1968f756f4af33','Tan','Tan','','','','','','1970-01-01',5,'assets/img/anonymous-icon.png',NULL,'','\0','2019-06-25 10:15:37','2019-06-25 02:17:15',0,0,8,0,0,'2019-06-25 10:17:12','c6f0577d0d3f79bac9613b7d0bcb4669',0,'',''),(11,'art','4f468a6824d620bf0f58640c0bc423bcb35dc48f','art','Art','','','','','','1970-01-01',5,'assets/img/anonymous-icon.png',NULL,'','\0','2019-06-25 10:15:58','2019-06-25 02:17:07',0,0,8,0,0,'2019-06-25 10:17:05','351f391140d0d89f0d758a1a897e9600',0,'',''),(12,'yza','fd8752e3e193182921bbe6b8635db275a7fa1d50','Olmos','Allyza','','','','','','1970-01-01',5,'assets/img/anonymous-icon.png',NULL,'','\0','2019-06-25 10:16:18','2019-06-25 02:17:27',0,0,8,0,0,'2019-06-25 10:17:22','d15ce93fca75b57a6ea0419b148d0131',0,'','');
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
) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_rights`
--

LOCK TABLES `user_group_rights` WRITE;
/*!40000 ALTER TABLE `user_group_rights` DISABLE KEYS */;
INSERT INTO `user_group_rights` VALUES (1,1,'1-1'),(2,1,'1-2'),(3,1,'1-3'),(4,1,'1-4'),(5,1,'1-5'),(6,1,'2-1'),(7,1,'2-2'),(8,1,'2-3'),(10,1,'15-3'),(11,1,'3-1'),(12,1,'3-2'),(13,1,'3-3'),(14,1,'4-2'),(15,1,'4-3'),(16,1,'4-4'),(17,1,'5-1'),(18,1,'5-2'),(19,1,'5-3'),(20,1,'6-1'),(21,1,'6-2'),(22,1,'6-3'),(23,1,'6-4'),(24,1,'6-5'),(25,1,'6-6'),(26,1,'7-1'),(27,1,'9-1'),(28,1,'9-2'),(29,1,'4-1'),(30,1,'8-1'),(31,1,'15-4'),(32,1,'5-4'),(33,1,'2-6'),(34,1,'8-3'),(35,1,'9-3'),(36,1,'6-7'),(37,1,'9-4'),(38,1,'9-6'),(39,1,'9-8'),(40,1,'9-7'),(41,1,'9-5'),(42,1,'8-4'),(43,1,'4-5'),(44,1,'10-1'),(45,1,'9-9'),(46,1,'6-8'),(47,1,'9-10'),(48,1,'1-6'),(49,1,'9-13'),(50,1,'6-9'),(51,1,'9-14'),(52,1,'9-16'),(53,1,'4-6'),(54,1,'10-2'),(55,1,'11-1'),(57,1,'12-1'),(58,1,'12-2'),(59,1,'12-3'),(60,1,'12-4'),(61,1,'12-5'),(62,1,'9-11'),(63,1,'9-15'),(64,1,'9-12'),(65,1,'13-1'),(66,1,'13-2'),(67,1,'13-3'),(68,1,'13-4'),(69,1,'9-17'),(70,1,'9-18'),(71,1,'9-19'),(72,1,'6-10'),(73,1,'14-1'),(74,1,'9-20'),(75,1,'9-21'),(76,1,'6-11'),(77,1,'12-6'),(78,1,'12-7'),(79,1,'2-8'),(80,1,'2-7'),(81,1,'6-12'),(82,1,'15-1'),(83,1,'3-4'),(84,1,'6-13'),(85,1,'15-5'),(86,1,'15-6'),(87,1,'3-5'),(88,1,'4-7'),(89,1,'16-1'),(90,1,'16-2'),(91,1,'16-3'),(92,1,'6-14'),(93,1,'5-5'),(94,1,'17-1'),(95,1,'17-2'),(96,1,'17-3'),(97,1,'18-1'),(98,1,'18-2'),(99,1,'18-3'),(100,1,'19-1'),(101,1,'19-2'),(102,1,'19-3'),(103,1,'20-1'),(104,1,'20-2'),(105,1,'20-3'),(106,1,'20-4'),(107,1,'20-5'),(108,1,'21-1'),(109,1,'21-2'),(110,1,'21-3'),(111,1,'22-1'),(112,1,'22-2'),(113,1,'21-4'),(114,1,'21-5'),(115,1,'22-3'),(116,1,'21-6'),(117,1,'23-1'),(118,1,'23-2'),(119,1,'23-3'),(120,1,'24-1'),(121,1,'24-2'),(122,1,'24-3'),(123,1,'25-1'),(124,1,'25-2'),(125,1,'25-3'),(126,1,'26-1'),(127,1,'26-2'),(128,1,'26-3'),(129,1,'27-1'),(130,1,'28-1'),(131,1,'28-2'),(132,1,'29-1'),(133,1,'29-2'),(134,1,'29-3'),(135,1,'30-1'),(136,1,'30-2'),(137,1,'30-3'),(138,1,'31-1'),(139,1,'31-2'),(140,1,'31-3'),(141,1,'32-1'),(142,1,'32-2'),(143,1,'32-3'),(144,1,'33-1'),(145,1,'33-2'),(146,1,'33-3'),(147,1,'34-1'),(148,1,'34-2'),(149,1,'34-3'),(150,1,'35-1'),(151,1,'35-2'),(152,1,'35-3'),(153,1,'35-4'),(154,1,'36-1'),(155,1,'36-2'),(156,1,'36-3'),(157,1,'37-1'),(158,1,'38-1'),(159,1,'39-1'),(160,1,'21-7'),(200,3,'1-1'),(201,3,'1-2'),(202,3,'1-3'),(203,3,'1-4'),(204,3,'1-5'),(205,3,'1-6'),(206,3,'5-3'),(207,3,'6-1'),(208,3,'6-2'),(209,3,'6-3'),(210,3,'6-4'),(211,3,'6-5'),(212,3,'6-6'),(213,3,'6-7'),(214,3,'6-8'),(215,3,'6-9'),(216,3,'6-10'),(217,3,'6-11'),(218,3,'6-13'),(219,3,'6-14'),(220,3,'9-1'),(221,3,'9-2'),(222,3,'9-3'),(223,3,'9-4'),(224,3,'9-5'),(225,3,'9-6'),(226,3,'9-7'),(227,3,'9-8'),(228,3,'9-9'),(229,3,'9-13'),(230,3,'9-14'),(231,3,'9-15'),(232,3,'9-16'),(233,3,'9-17'),(234,3,'9-18'),(235,3,'9-19'),(236,3,'9-20'),(237,3,'9-21'),(238,3,'10-1'),(239,3,'10-2'),(240,3,'16-1'),(241,3,'16-2'),(242,3,'16-3'),(243,3,'17-1'),(244,3,'17-2'),(245,3,'17-3'),(246,3,'18-1'),(247,3,'18-2'),(248,3,'18-3'),(249,3,'19-1'),(250,3,'19-2'),(251,3,'19-3'),(252,3,'20-1'),(253,3,'20-2'),(254,3,'20-3'),(255,3,'20-4'),(256,3,'20-5'),(257,3,'21-1'),(258,3,'21-2'),(259,3,'21-3'),(260,3,'22-1'),(261,3,'22-2'),(305,5,'1-1'),(306,5,'1-4'),(307,5,'1-5'),(308,5,'5-3'),(309,5,'17-1'),(310,5,'17-2'),(311,5,'17-3'),(312,5,'18-1'),(313,5,'18-2'),(314,5,'18-3'),(315,5,'19-1'),(316,5,'19-2'),(317,5,'19-3'),(318,5,'20-1'),(319,5,'20-2'),(320,5,'20-3'),(321,5,'20-4'),(322,5,'20-5'),(323,5,'21-1'),(324,5,'21-2'),(325,5,'21-3'),(326,5,'21-4'),(327,5,'21-5'),(328,5,'21-6'),(329,5,'21-7'),(330,5,'22-1'),(331,5,'22-2'),(332,5,'22-3'),(333,5,'23-1'),(334,5,'23-2'),(335,5,'23-3'),(336,5,'24-1'),(337,5,'24-2'),(338,5,'24-3'),(339,5,'25-1'),(340,5,'25-2'),(341,5,'25-3'),(342,5,'26-1'),(343,5,'26-2'),(344,5,'26-3'),(345,5,'27-1'),(346,5,'28-1'),(347,5,'28-2'),(348,5,'29-1'),(349,5,'29-2'),(350,5,'29-3'),(351,5,'30-1'),(352,5,'30-2'),(353,5,'30-3'),(354,5,'31-1'),(355,5,'31-2'),(356,5,'31-3'),(357,5,'32-1'),(358,5,'32-2'),(359,5,'32-3'),(360,5,'33-1'),(361,5,'33-2'),(362,5,'33-3'),(363,5,'34-1'),(364,5,'34-2'),(365,5,'34-3'),(366,5,'35-1'),(367,5,'35-2'),(368,5,'35-3'),(369,5,'35-4'),(370,5,'36-1'),(371,5,'36-2'),(372,5,'36-3'),(373,5,'37-1'),(374,5,'38-1'),(375,5,'39-1');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'System Administrator','Can access all features.','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Encoder 123','Encoder 123','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Billing','Billing','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'raf','raf','','\0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'Intern','Intern','','\0','0000-00-00 00:00:00','2019-06-25 02:11:31'),(6,'yza','yza','','','0000-00-00 00:00:00','2019-06-25 02:11:20'),(7,'tan','tan','','','0000-00-00 00:00:00','2019-06-25 02:11:17'),(8,'art','art','','','0000-00-00 00:00:00','2019-06-25 02:11:15');
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

-- Dump completed on 2019-06-25 10:19:24
