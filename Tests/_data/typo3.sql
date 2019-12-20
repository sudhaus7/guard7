-- MySQL dump 10.13  Distrib 5.7.28, for osx10.15 (x86_64)
--
-- Host: localhost    Database: guard7testdb
-- ------------------------------------------------------
-- Server version	5.7.28

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
-- Table structure for table `backend_layout`
--

DROP TABLE IF EXISTS `backend_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_layout` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci,
  `config` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_layout`
--

LOCK TABLES `backend_layout` WRITE;
/*!40000 ALTER TABLE `backend_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `backend_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_groups`
--

DROP TABLE IF EXISTS `be_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_groups` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `non_exclude_fields` text COLLATE utf8_unicode_ci,
  `explicit_allowdeny` text COLLATE utf8_unicode_ci,
  `allowed_languages` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `custom_options` text COLLATE utf8_unicode_ci,
  `db_mountpoints` text COLLATE utf8_unicode_ci,
  `pagetypes_select` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tables_select` text COLLATE utf8_unicode_ci,
  `tables_modify` text COLLATE utf8_unicode_ci,
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `groupMods` text COLLATE utf8_unicode_ci,
  `file_mountpoints` text COLLATE utf8_unicode_ci,
  `file_permissions` text COLLATE utf8_unicode_ci,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lockToDomain` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `TSconfig` text COLLATE utf8_unicode_ci,
  `subgroup` text COLLATE utf8_unicode_ci,
  `hide_in_lists` smallint(6) NOT NULL DEFAULT '0',
  `workspace_perms` smallint(6) NOT NULL DEFAULT '1',
  `category_perms` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_groups`
--

LOCK TABLES `be_groups` WRITE;
/*!40000 ALTER TABLE `be_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `be_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_sessions`
--

DROP TABLE IF EXISTS `be_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_sessions` (
  `ses_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ses_iplock` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ses_userid` int(10) unsigned NOT NULL DEFAULT '0',
  `ses_tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `ses_data` longblob,
  `ses_backuserid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ses_id`),
  KEY `ses_tstamp` (`ses_tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_sessions`
--

LOCK TABLES `be_sessions` WRITE;
/*!40000 ALTER TABLE `be_sessions` DISABLE KEYS */;
INSERT INTO `be_sessions` VALUES ('13edf719023da70b02ae296d6e3309f1','127.0.0.1',1,1576675416,_binary 'a:4:{s:26:\"formProtectionSessionToken\";s:64:\"8bb6777022e46a53c8af444a55df0c67d66c8db66a6ac2d45a640ed223030cb9\";s:31:\"TYPO3\\CMS\\Recordlist\\RecordList\";a:1:{s:12:\"search_field\";N;}s:27:\"core.template.flashMessages\";N;s:80:\"extbase.flashmessages.tx_extensionmanager_tools_extensionmanagerextensionmanager\";N;}',0);
/*!40000 ALTER TABLE `be_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_users`
--

DROP TABLE IF EXISTS `be_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avatar` int(10) unsigned NOT NULL DEFAULT '0',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usergroup` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `disable` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `db_mountpoints` text COLLATE utf8_unicode_ci,
  `options` smallint(5) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `realName` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userMods` text COLLATE utf8_unicode_ci,
  `allowed_languages` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uc` mediumblob,
  `file_mountpoints` text COLLATE utf8_unicode_ci,
  `file_permissions` text COLLATE utf8_unicode_ci,
  `workspace_perms` smallint(6) NOT NULL DEFAULT '1',
  `lockToDomain` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `disableIPlock` smallint(5) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `TSconfig` text COLLATE utf8_unicode_ci,
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `createdByAction` int(11) NOT NULL DEFAULT '0',
  `usergroup_cached_list` text COLLATE utf8_unicode_ci,
  `workspace_id` int(11) NOT NULL DEFAULT '0',
  `workspace_preview` smallint(6) NOT NULL DEFAULT '1',
  `category_perms` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_users`
--

LOCK TABLES `be_users` WRITE;
/*!40000 ALTER TABLE `be_users` DISABLE KEYS */;
INSERT INTO `be_users` VALUES (1,0,1576060768,'admin','',0,'$pbkdf2-sha256$25000$LcElZYMUdue0vZjDBe0LAw$jq1JnWS9nj/JcAqkgQ2W7KwH3.X9Px9HdkvGc0CS/LA',1,'',0,0,0,'','',NULL,0,1576060768,0,'',NULL,'',_binary 'a:16:{s:14:\"interfaceSetup\";s:7:\"backend\";s:10:\"moduleData\";a:8:{s:10:\"web_layout\";a:2:{s:8:\"function\";s:1:\"1\";s:8:\"language\";s:1:\"0\";}s:8:\"web_list\";a:0:{}s:10:\"FormEngine\";a:2:{i:0;a:1:{s:32:\"b42871b88360c6a052cdc3198647d200\";a:4:{i:0;s:19:\"<em>[No title]</em>\";i:1;a:6:{s:4:\"edit\";a:1:{s:10:\"tt_content\";a:1:{i:4;s:4:\"edit\";}}s:7:\"defVals\";a:1:{s:10:\"tt_content\";a:3:{s:6:\"colPos\";s:1:\"0\";s:16:\"sys_language_uid\";s:1:\"0\";s:5:\"CType\";s:5:\"login\";}}s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:174:\"&edit[tt_content][4]=edit&defVals[tt_content][colPos]=0&defVals[tt_content][sys_language_uid]=0&defVals[tt_content][CType]=login&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:10:\"tt_content\";s:3:\"uid\";i:4;s:3:\"pid\";i:1;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}}i:1;s:32:\"b4073d8794f838ac09b6a2f3ef151ce7\";}s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";a:0:{}s:16:\"opendocs::recent\";a:5:{s:32:\"b4073d8794f838ac09b6a2f3ef151ce7\";a:4:{i:0;s:19:\"<em>[No title]</em>\";i:1;a:6:{s:4:\"edit\";a:1:{s:10:\"tt_content\";a:1:{i:4;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:80:\"&edit[tt_content][4]=edit&defVals=&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:10:\"tt_content\";s:3:\"uid\";i:4;s:3:\"pid\";i:1;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}s:32:\"d7bdce8c3011e049eaf2f5e3ed740014\";a:4:{i:0;s:7:\"Ichbins\";i:1;a:6:{s:4:\"edit\";a:1:{s:36:\"tx_workshopblog_domain_model_comment\";a:1:{i:1;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:106:\"&edit[tx_workshopblog_domain_model_comment][1]=edit&defVals=&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:36:\"tx_workshopblog_domain_model_comment\";s:3:\"uid\";i:1;s:3:\"pid\";i:2;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}s:32:\"7a640de9dabd3c9e6fa4dc25d71f93f3\";a:4:{i:0;s:8:\"testuser\";i:1;a:6:{s:4:\"edit\";a:1:{s:8:\"fe_users\";a:1:{i:1;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:78:\"&edit[fe_users][1]=edit&defVals=&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:8:\"fe_users\";s:3:\"uid\";i:1;s:3:\"pid\";i:2;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}s:32:\"4028c7082d751ae3dcb5c883aeeb77bd\";a:4:{i:0;s:9:\"testgroup\";i:1;a:6:{s:4:\"edit\";a:1:{s:9:\"fe_groups\";a:1:{i:1;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:79:\"&edit[fe_groups][1]=edit&defVals=&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:9:\"fe_groups\";s:3:\"uid\";i:1;s:3:\"pid\";i:2;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}s:32:\"1b7c56c2b940487231e4b11491739fa7\";a:4:{i:0;s:4:\"User\";i:1;a:6:{s:4:\"edit\";a:1:{s:5:\"pages\";a:1:{i:2;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:75:\"&edit[pages][2]=edit&defVals=&overrideVals=&columnsOnly=&noView=&workspace=\";i:3;a:5:{s:5:\"table\";s:5:\"pages\";s:3:\"uid\";i:2;s:3:\"pid\";i:1;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}}s:18:\"list/displayFields\";a:2:{s:8:\"fe_users\";a:3:{i:0;s:0:\"\";i:1;s:4:\"name\";i:2;s:9:\"last_name\";}s:33:\"tx_workshopblog_domain_model_blog\";a:3:{i:0;s:0:\"\";i:1;s:6:\"teaser\";i:2;s:8:\"bodytext\";}}s:16:\"browse_links.php\";N;s:6:\"web_ts\";a:7:{s:8:\"function\";s:87:\"TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateObjectBrowserModuleFunctionController\";s:19:\"constant_editor_cat\";s:7:\"content\";s:15:\"ts_browser_type\";s:5:\"setup\";s:16:\"ts_browser_const\";s:1:\"0\";s:19:\"ts_browser_fixedLgd\";s:1:\"1\";s:23:\"ts_browser_showComments\";s:1:\"1\";s:25:\"tsbrowser_depthKeys_setup\";a:7:{s:10:\"tt_content\";i:1;s:15:\"tt_content.list\";i:1;s:18:\"tt_content.list.20\";i:1;s:36:\"tt_content.list.20.workshopblog_list\";i:1;s:6:\"plugin\";i:1;s:22:\"plugin.tx_workshopblog\";i:1;s:34:\"plugin.tx_workshopblog.persistence\";i:1;}}}s:19:\"thumbnailsByDefault\";i:1;s:14:\"emailMeAtLogin\";i:0;s:11:\"startModule\";s:22:\"help_AboutAboutmodules\";s:8:\"titleLen\";i:50;s:8:\"edit_RTE\";s:1:\"1\";s:20:\"edit_docModuleUpload\";s:1:\"1\";s:15:\"resizeTextareas\";i:1;s:25:\"resizeTextareas_MaxHeight\";i:500;s:24:\"resizeTextareas_Flexible\";i:0;s:4:\"lang\";s:0:\"\";s:19:\"firstLoginTimeStamp\";i:1576060824;s:15:\"moduleSessionID\";a:8:{s:10:\"web_layout\";s:32:\"6f5e9b18bcf6a15bd9597e41423edd94\";s:8:\"web_list\";s:32:\"15ffad5451a3850fd40e29631f09642d\";s:10:\"FormEngine\";s:32:\"13edf719023da70b02ae296d6e3309f1\";s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";s:32:\"13edf719023da70b02ae296d6e3309f1\";s:16:\"opendocs::recent\";s:32:\"13edf719023da70b02ae296d6e3309f1\";s:18:\"list/displayFields\";s:32:\"0a9bbff20b5b57264c85c2c3b1a154e9\";s:16:\"browse_links.php\";s:32:\"13edf719023da70b02ae296d6e3309f1\";s:6:\"web_ts\";s:32:\"0a9bbff20b5b57264c85c2c3b1a154e9\";}s:17:\"BackendComponents\";a:1:{s:6:\"States\";a:1:{s:8:\"Pagetree\";a:1:{s:9:\"stateHash\";a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";s:4:\"root\";s:1:\"1\";s:16:\"lastSelectedNode\";s:2:\"p1\";}}}}s:11:\"browseTrees\";a:1:{s:11:\"browsePages\";s:32:\"a:1:{i:0;a:2:{i:0;i:1;i:1;i:1;}}\";}}',NULL,NULL,1,'',0,0,NULL,1576674869,0,NULL,0,1,NULL),(2,0,1576060789,'_cli_','',0,'$pbkdf2-sha256$25000$AK4gQi5mEM8nLdVisjFWzg$Vh6TD8SaCobvvzcWSEf1rovfeFtdg6lzAVRpD9Cu93w',1,'',0,0,0,'','',NULL,0,1576060789,0,'',NULL,'',_binary 'a:13:{s:14:\"interfaceSetup\";s:0:\"\";s:10:\"moduleData\";a:0:{}s:19:\"thumbnailsByDefault\";i:1;s:14:\"emailMeAtLogin\";i:0;s:11:\"startModule\";s:22:\"help_AboutAboutmodules\";s:8:\"titleLen\";i:50;s:8:\"edit_RTE\";s:1:\"1\";s:20:\"edit_docModuleUpload\";s:1:\"1\";s:15:\"resizeTextareas\";i:1;s:25:\"resizeTextareas_MaxHeight\";i:500;s:24:\"resizeTextareas_Flexible\";i:0;s:4:\"lang\";s:0:\"\";s:19:\"firstLoginTimeStamp\";i:1576060789;}',NULL,NULL,1,'',0,0,NULL,0,0,NULL,0,1,NULL);
/*!40000 ALTER TABLE `be_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_md5params`
--

DROP TABLE IF EXISTS `cache_md5params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_md5params` (
  `md5hash` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `params` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`md5hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_md5params`
--

LOCK TABLES `cache_md5params` WRITE;
/*!40000 ALTER TABLE `cache_md5params` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_md5params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_treelist`
--

DROP TABLE IF EXISTS `cache_treelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_treelist` (
  `md5hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `treelist` mediumtext COLLATE utf8_unicode_ci,
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`md5hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_treelist`
--

LOCK TABLES `cache_treelist` WRITE;
/*!40000 ALTER TABLE `cache_treelist` DISABLE KEYS */;
INSERT INTO `cache_treelist` VALUES ('c373cd924082a227e6db995fe80a9f39',2,'2',1576675425,0),('d1d27434ee02e7200f2bca0a45f9be23',2,'2',1576675450,0);
/*!40000 ALTER TABLE `cache_treelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_hash`
--

DROP TABLE IF EXISTS `cf_cache_hash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_hash`
--

LOCK TABLES `cf_cache_hash` WRITE;
/*!40000 ALTER TABLE `cf_cache_hash` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_hash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_hash_tags`
--

DROP TABLE IF EXISTS `cf_cache_hash_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_hash_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_hash_tags`
--

LOCK TABLES `cf_cache_hash_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_hash_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_hash_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_imagesizes`
--

DROP TABLE IF EXISTS `cf_cache_imagesizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_imagesizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_imagesizes`
--

LOCK TABLES `cf_cache_imagesizes` WRITE;
/*!40000 ALTER TABLE `cf_cache_imagesizes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_imagesizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_imagesizes_tags`
--

DROP TABLE IF EXISTS `cf_cache_imagesizes_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_imagesizes_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_imagesizes_tags`
--

LOCK TABLES `cf_cache_imagesizes_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_imagesizes_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_imagesizes_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pages`
--

DROP TABLE IF EXISTS `cf_cache_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pages`
--

LOCK TABLES `cf_cache_pages` WRITE;
/*!40000 ALTER TABLE `cf_cache_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pages_tags`
--

DROP TABLE IF EXISTS `cf_cache_pages_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pages_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pages_tags`
--

LOCK TABLES `cf_cache_pages_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_pages_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_pages_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pagesection`
--

DROP TABLE IF EXISTS `cf_cache_pagesection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pagesection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pagesection`
--

LOCK TABLES `cf_cache_pagesection` WRITE;
/*!40000 ALTER TABLE `cf_cache_pagesection` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_pagesection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pagesection_tags`
--

DROP TABLE IF EXISTS `cf_cache_pagesection_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pagesection_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pagesection_tags`
--

LOCK TABLES `cf_cache_pagesection_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_pagesection_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_pagesection_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_rootline`
--

DROP TABLE IF EXISTS `cf_cache_rootline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_rootline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_rootline`
--

LOCK TABLES `cf_cache_rootline` WRITE;
/*!40000 ALTER TABLE `cf_cache_rootline` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_rootline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_rootline_tags`
--

DROP TABLE IF EXISTS `cf_cache_rootline_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_rootline_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_rootline_tags`
--

LOCK TABLES `cf_cache_rootline_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_rootline_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_rootline_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_datamapfactory_datamap`
--

DROP TABLE IF EXISTS `cf_extbase_datamapfactory_datamap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_datamapfactory_datamap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_datamapfactory_datamap`
--

LOCK TABLES `cf_extbase_datamapfactory_datamap` WRITE;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_datamapfactory_datamap_tags`
--

DROP TABLE IF EXISTS `cf_extbase_datamapfactory_datamap_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_datamapfactory_datamap_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_datamapfactory_datamap_tags`
--

LOCK TABLES `cf_extbase_datamapfactory_datamap_tags` WRITE;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_object`
--

DROP TABLE IF EXISTS `cf_extbase_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_object` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_object`
--

LOCK TABLES `cf_extbase_object` WRITE;
/*!40000 ALTER TABLE `cf_extbase_object` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_object_tags`
--

DROP TABLE IF EXISTS `cf_extbase_object_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_object_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_object_tags`
--

LOCK TABLES `cf_extbase_object_tags` WRITE;
/*!40000 ALTER TABLE `cf_extbase_object_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_object_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_reflection`
--

DROP TABLE IF EXISTS `cf_extbase_reflection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_reflection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_reflection`
--

LOCK TABLES `cf_extbase_reflection` WRITE;
/*!40000 ALTER TABLE `cf_extbase_reflection` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_reflection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_reflection_tags`
--

DROP TABLE IF EXISTS `cf_extbase_reflection_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_reflection_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`),
  KEY `cache_tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_reflection_tags`
--

LOCK TABLES `cf_extbase_reflection_tags` WRITE;
/*!40000 ALTER TABLE `cf_extbase_reflection_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_reflection_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_groups`
--

DROP TABLE IF EXISTS `fe_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_groups` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tx_extbase_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lockToDomain` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `subgroup` tinytext COLLATE utf8_unicode_ci,
  `TSconfig` text COLLATE utf8_unicode_ci,
  `felogin_redirectPid` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_groups`
--

LOCK TABLES `fe_groups` WRITE;
/*!40000 ALTER TABLE `fe_groups` DISABLE KEYS */;
INSERT INTO `fe_groups` VALUES (1,'0',2,1576075910,1576075910,1,'testgroup',0,'',0,'','','',NULL);
/*!40000 ALTER TABLE `fe_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_sessions`
--

DROP TABLE IF EXISTS `fe_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_sessions` (
  `ses_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ses_iplock` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ses_userid` int(10) unsigned NOT NULL DEFAULT '0',
  `ses_tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `ses_data` mediumblob,
  `ses_permanent` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ses_anonymous` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ses_id`),
  KEY `ses_tstamp` (`ses_tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_sessions`
--

LOCK TABLES `fe_sessions` WRITE;
/*!40000 ALTER TABLE `fe_sessions` DISABLE KEYS */;
INSERT INTO `fe_sessions` VALUES ('587a65d26ee4c2369e802fb4cc1bee2b','127.0',1,1576675450,'',0,0);
/*!40000 ALTER TABLE `fe_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_users`
--

DROP TABLE IF EXISTS `fe_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tx_extbase_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usergroup` tinytext COLLATE utf8_unicode_ci,
  `disable` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(160) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `middle_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telephone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lockToDomain` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `uc` blob,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `www` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image` tinytext COLLATE utf8_unicode_ci,
  `TSconfig` text COLLATE utf8_unicode_ci,
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `is_online` int(10) unsigned NOT NULL DEFAULT '0',
  `tx_guard7_publickey` text COLLATE utf8_unicode_ci,
  `tx_guard7_privatekey` text COLLATE utf8_unicode_ci,
  `felogin_redirectPid` tinytext COLLATE utf8_unicode_ci,
  `felogin_forgotHash` varchar(80) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`username`),
  KEY `username` (`username`),
  KEY `is_online` (`is_online`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_users`
--

LOCK TABLES `fe_users` WRITE;
/*!40000 ALTER TABLE `fe_users` DISABLE KEYS */;
INSERT INTO `fe_users` VALUES (1,'0',2,1576076580,'testuser','$pbkdf2-sha256$25000$gzglKR.RPgStgb5E7jv/ew$mEgpQTYP5Ugn4ComAyWb5P7GvRt3w8iOnOj3GfMhD1k','1',0,0,0,'&#128274;','','','&#128274;','&#128274;','','','',1576076580,1,'',0,'',_binary 'a:1:{s:20:\"tx_guard7_privatekey\";s:3272:\"-----BEGIN PRIVATE KEY-----\n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\nuqFveypfR93md5w6f2BKoGeXtFz4KQ==\n-----END PRIVATE KEY-----\n\";}','','','','','','&#128274;',NULL,'',1576675450,1576675450,'-----BEGIN PUBLIC KEY-----\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAn2diQjdKr9yrOjpnj157\ny+ALQcPhi2UH0MjVJaqnOvfRdOj3Iiu7YE71QMFObHITBnsbTcUVnQU/V6nTrywp\nPw/gaEBt5uGdFE5++fQxTUfYE/aVtJnpKB2OKLdYcwKQ6pg5jWTZV8FVlvmlviAl\niV9hcQf34bMYjp+aGpl/x32A+CnF2WUMXtg/bQdTKzzn5UTD0/qL8ag/PWY8YlSZ\nTzj3W4wxI1a7XmdKkppkePFCI/fZIt8B2Pb3+abt2pVCXbPPZSHPVwjZfY5hARfP\nKHV2Swr8kUWKX1J/krnMIE1D4EyRUAYsNKpPFdpbLJ/cavZ9s6ya/GUa8N87fVzb\nPXNHn97L7b+bJo4WtXc/yq1pdM2YWqUQf6t/Cx1jPhx1Z4jPg5owb9mnHQgKIx7e\nbAEcKDfsFIf1qPiAPFR3vl9J7y8WWtJnSfk2c+ij1xMqWhHLAka0PS15F/Ijr0/c\nOgwq+BTHUXgkGeuQWwQrxW5/vybFEYeE0ZWvQ6+Cwgz9k/ODmjYb/PN3LN6eaMlW\nvv7i5PSIelD5DisXw5fWvOmss0dajS1wE7RPUkJPk5nCcOCxL3YJ+JaXdNqbiIqR\nCY+wNaWJSqlqSlWpT5ukwpuCj7EfUBwchGUSDMjIit4vlFFKjevlOpfRIWUjYxYO\n9y+Zi81lEyvjNucKvu1cCLcCAwEAAQ==\n-----END PUBLIC KEY-----\n','-----BEGIN ENCRYPTED PRIVATE KEY-----\n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\nGo/SsdsbVaIslu4PULTs7w==\n-----END ENCRYPTED PRIVATE KEY-----\n',NULL,'');
/*!40000 ALTER TABLE `fe_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `perms_userid` int(10) unsigned NOT NULL DEFAULT '0',
  `perms_groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `perms_user` smallint(5) unsigned NOT NULL DEFAULT '0',
  `perms_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  `perms_everybody` smallint(5) unsigned NOT NULL DEFAULT '0',
  `editlock` smallint(5) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `doktype` int(10) unsigned NOT NULL DEFAULT '0',
  `TSconfig` text COLLATE utf8_unicode_ci,
  `is_siteroot` smallint(6) NOT NULL DEFAULT '0',
  `php_tree_stop` smallint(6) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `urltype` smallint(5) unsigned NOT NULL DEFAULT '0',
  `shortcut` int(10) unsigned NOT NULL DEFAULT '0',
  `shortcut_mode` int(10) unsigned NOT NULL DEFAULT '0',
  `no_cache` int(10) unsigned NOT NULL DEFAULT '0',
  `fe_group` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `layout` int(10) unsigned NOT NULL DEFAULT '0',
  `target` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `media` int(10) unsigned NOT NULL DEFAULT '0',
  `lastUpdated` int(10) unsigned NOT NULL DEFAULT '0',
  `keywords` text COLLATE utf8_unicode_ci,
  `cache_timeout` int(10) unsigned NOT NULL DEFAULT '0',
  `cache_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `newUntil` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `no_search` smallint(5) unsigned NOT NULL DEFAULT '0',
  `SYS_LASTCHANGED` int(10) unsigned NOT NULL DEFAULT '0',
  `abstract` text COLLATE utf8_unicode_ci,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extendToSubpages` smallint(5) unsigned NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nav_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nav_hide` smallint(6) NOT NULL DEFAULT '0',
  `content_from_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `mount_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `mount_pid_ol` smallint(6) NOT NULL DEFAULT '0',
  `alias` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `l18n_cfg` smallint(6) NOT NULL DEFAULT '0',
  `fe_login_mode` smallint(6) NOT NULL DEFAULT '0',
  `backend_layout` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `backend_layout_next_level` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tsconfig_includes` text COLLATE utf8_unicode_ci,
  `categories` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`deleted`,`sorting`),
  KEY `alias` (`alias`),
  KEY `determineSiteRoot` (`is_siteroot`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,0,0,0,'',0,0,0,0,0,0,1576060780,0,0,1,1,31,31,1,0,1576060780,1,0,'Home',1,NULL,1,0,'',0,0,0,0,0,0,'0','',0,'',0,0,NULL,0,'',0,NULL,0,1576675413,NULL,'',0,'','','',0,0,0,0,'',0,0,'','',NULL,0),(2,1,0,0,0,'',0,0,0,0,0,0,1576075085,256,0,1,0,31,27,0,0,1576075006,1,0,'User',254,NULL,0,0,'',0,0,1,0,0,0,'0','',0,'',0,0,NULL,0,'',0,NULL,0,0,NULL,'fe_users',0,'','','',0,0,0,0,'',0,0,'','','EXT:guard7/Configuration/PageTSconfig/feuser.typoscript',0),(3,1,0,0,0,'',0,0,0,0,0,0,1576164597,512,0,1,0,31,27,0,0,1576164579,1,0,'Detail',1,NULL,0,0,'',0,0,1,0,0,0,'','',0,'',0,0,NULL,0,'',0,NULL,0,1576240162,NULL,'',0,'','','',1,0,0,0,'',0,0,'','',NULL,0);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_language_overlay`
--

DROP TABLE IF EXISTS `pages_language_overlay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_language_overlay` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `doktype` int(10) unsigned NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nav_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `media` int(10) unsigned NOT NULL DEFAULT '0',
  `keywords` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `abstract` text COLLATE utf8_unicode_ci,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `l18n_diffsource` mediumblob,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `urltype` smallint(5) unsigned NOT NULL DEFAULT '0',
  `shortcut` int(10) unsigned NOT NULL DEFAULT '0',
  `shortcut_mode` int(10) unsigned NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`sys_language_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_language_overlay`
--

LOCK TABLES `pages_language_overlay` WRITE;
/*!40000 ALTER TABLE `pages_language_overlay` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages_language_overlay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_be_shortcuts`
--

DROP TABLE IF EXISTS `sys_be_shortcuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_be_shortcuts` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `module_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` text COLLATE utf8_unicode_ci,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `sc_group` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `event` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_be_shortcuts`
--

LOCK TABLES `sys_be_shortcuts` WRITE;
/*!40000 ALTER TABLE `sys_be_shortcuts` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_be_shortcuts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_category`
--

DROP TABLE IF EXISTS `sys_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_category` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `hidden` smallint(6) NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumblob,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parent` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `category_parent` (`parent`),
  KEY `category_list` (`pid`,`deleted`,`sys_language_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_category`
--

LOCK TABLES `sys_category` WRITE;
/*!40000 ALTER TABLE `sys_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_category_record_mm`
--

DROP TABLE IF EXISTS `sys_category_record_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_category_record_mm` (
  `uid_local` int(11) NOT NULL DEFAULT '0',
  `uid_foreign` int(11) NOT NULL DEFAULT '0',
  `tablenames` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fieldname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `sorting_foreign` int(11) NOT NULL DEFAULT '0',
  KEY `uid_local_foreign` (`uid_local`,`uid_foreign`),
  KEY `uid_foreign_tablefield` (`uid_foreign`,`tablenames`(40),`fieldname`(3),`sorting_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_category_record_mm`
--

LOCK TABLES `sys_category_record_mm` WRITE;
/*!40000 ALTER TABLE `sys_category_record_mm` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_category_record_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_collection`
--

DROP TABLE IF EXISTS `sys_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_collection` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumtext COLLATE utf8_unicode_ci,
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `hidden` smallint(6) NOT NULL DEFAULT '0',
  `starttime` int(11) NOT NULL DEFAULT '0',
  `endtime` int(11) NOT NULL DEFAULT '0',
  `fe_group` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `title` tinytext COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'static',
  `table_name` tinytext COLLATE utf8_unicode_ci,
  `items` int(11) NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_collection`
--

LOCK TABLES `sys_collection` WRITE;
/*!40000 ALTER TABLE `sys_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_collection_entries`
--

DROP TABLE IF EXISTS `sys_collection_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_collection_entries` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uid_local` int(11) NOT NULL DEFAULT '0',
  `uid_foreign` int(11) NOT NULL DEFAULT '0',
  `tablenames` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_collection_entries`
--

LOCK TABLES `sys_collection_entries` WRITE;
/*!40000 ALTER TABLE `sys_collection_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_collection_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_domain`
--

DROP TABLE IF EXISTS `sys_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_domain` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `domainName` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `redirectTo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `redirectHttpStatusCode` int(10) unsigned NOT NULL DEFAULT '301',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `prepend_params` int(11) NOT NULL DEFAULT '0',
  `forced` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `getSysDomain` (`redirectTo`,`hidden`),
  KEY `getDomainStartPage` (`pid`,`hidden`,`domainName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_domain`
--

LOCK TABLES `sys_domain` WRITE;
/*!40000 ALTER TABLE `sys_domain` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file`
--

DROP TABLE IF EXISTS `sys_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `last_indexed` int(11) NOT NULL DEFAULT '0',
  `missing` smallint(6) NOT NULL DEFAULT '0',
  `storage` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metadata` int(11) NOT NULL DEFAULT '0',
  `identifier` text COLLATE utf8_unicode_ci,
  `identifier_hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `folder_hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mime_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext COLLATE utf8_unicode_ci,
  `sha1` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `creation_date` int(11) NOT NULL DEFAULT '0',
  `modification_date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `sel01` (`storage`,`identifier_hash`),
  KEY `folder` (`storage`,`folder_hash`),
  KEY `tstamp` (`tstamp`),
  KEY `lastindex` (`last_indexed`),
  KEY `sha1` (`sha1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file`
--

LOCK TABLES `sys_file` WRITE;
/*!40000 ALTER TABLE `sys_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_collection`
--

DROP TABLE IF EXISTS `sys_file_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_collection` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumtext COLLATE utf8_unicode_ci,
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `hidden` smallint(6) NOT NULL DEFAULT '0',
  `starttime` int(11) NOT NULL DEFAULT '0',
  `endtime` int(11) NOT NULL DEFAULT '0',
  `title` tinytext COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'static',
  `files` int(11) NOT NULL DEFAULT '0',
  `storage` int(11) NOT NULL DEFAULT '0',
  `folder` text COLLATE utf8_unicode_ci,
  `recursive` smallint(6) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_collection`
--

LOCK TABLES `sys_file_collection` WRITE;
/*!40000 ALTER TABLE `sys_file_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_metadata`
--

DROP TABLE IF EXISTS `sys_file_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_metadata` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumblob,
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `file` int(11) NOT NULL DEFAULT '0',
  `title` tinytext COLLATE utf8_unicode_ci,
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `alternative` text COLLATE utf8_unicode_ci,
  `l10n_state` text COLLATE utf8_unicode_ci,
  `categories` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `pid` (`pid`),
  KEY `file` (`file`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `fal_filelist` (`l10n_parent`,`sys_language_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_metadata`
--

LOCK TABLES `sys_file_metadata` WRITE;
/*!40000 ALTER TABLE `sys_file_metadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_processedfile`
--

DROP TABLE IF EXISTS `sys_file_processedfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_processedfile` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `storage` int(11) NOT NULL DEFAULT '0',
  `original` int(11) NOT NULL DEFAULT '0',
  `identifier` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext COLLATE utf8_unicode_ci,
  `configuration` text COLLATE utf8_unicode_ci,
  `configurationsha1` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `originalfilesha1` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `task_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `checksum` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `width` int(11) DEFAULT '0',
  `height` int(11) DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `combined_1` (`original`,`task_type`,`configurationsha1`),
  KEY `identifier` (`storage`,`identifier`(199))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_processedfile`
--

LOCK TABLES `sys_file_processedfile` WRITE;
/*!40000 ALTER TABLE `sys_file_processedfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_processedfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_reference`
--

DROP TABLE IF EXISTS `sys_file_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_reference` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `hidden` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l10n_parent` int(11) NOT NULL DEFAULT '0',
  `l10n_diffsource` mediumblob,
  `uid_local` int(11) NOT NULL DEFAULT '0',
  `uid_foreign` int(11) NOT NULL DEFAULT '0',
  `tablenames` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fieldname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sorting_foreign` int(11) NOT NULL DEFAULT '0',
  `table_local` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` tinytext COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `alternative` text COLLATE utf8_unicode_ci,
  `link` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `crop` varchar(4000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `autoplay` smallint(6) NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`),
  KEY `tablenames_fieldname` (`tablenames`(32),`fieldname`(12)),
  KEY `deleted` (`deleted`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`),
  KEY `combined_1` (`l10n_parent`,`t3ver_oid`,`t3ver_wsid`,`t3ver_state`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_reference`
--

LOCK TABLES `sys_file_reference` WRITE;
/*!40000 ALTER TABLE `sys_file_reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_storage`
--

DROP TABLE IF EXISTS `sys_file_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_storage` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `cruser_id` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci,
  `driver` tinytext COLLATE utf8_unicode_ci,
  `configuration` text COLLATE utf8_unicode_ci,
  `is_default` smallint(6) NOT NULL DEFAULT '0',
  `is_browsable` smallint(6) NOT NULL DEFAULT '0',
  `is_public` smallint(6) NOT NULL DEFAULT '0',
  `is_writable` smallint(6) NOT NULL DEFAULT '0',
  `is_online` smallint(6) NOT NULL DEFAULT '1',
  `auto_extract_metadata` smallint(6) NOT NULL DEFAULT '1',
  `processingfolder` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_storage`
--

LOCK TABLES `sys_file_storage` WRITE;
/*!40000 ALTER TABLE `sys_file_storage` DISABLE KEYS */;
INSERT INTO `sys_file_storage` VALUES (1,0,1576075012,1576075012,0,0,'fileadmin/ (auto-created)','This is the local fileadmin/ directory. This storage mount has been created automatically by TYPO3.','Local','<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"basePath\">\n                    <value index=\"vDEF\">fileadmin/</value>\n                </field>\n                <field index=\"pathType\">\n                    <value index=\"vDEF\">relative</value>\n                </field>\n                <field index=\"caseSensitive\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',1,1,1,1,1,1,NULL);
/*!40000 ALTER TABLE `sys_file_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_filemounts`
--

DROP TABLE IF EXISTS `sys_filemounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_filemounts` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `base` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `read_only` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_filemounts`
--

LOCK TABLES `sys_filemounts` WRITE;
/*!40000 ALTER TABLE `sys_filemounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_filemounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_history`
--

DROP TABLE IF EXISTS `sys_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_history` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `sys_log_uid` int(11) NOT NULL DEFAULT '0',
  `history_data` mediumtext COLLATE utf8_unicode_ci,
  `fieldlist` text COLLATE utf8_unicode_ci,
  `recuid` int(11) NOT NULL DEFAULT '0',
  `tablename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `history_files` mediumtext COLLATE utf8_unicode_ci,
  `snapshot` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `recordident_1` (`tablename`,`recuid`),
  KEY `recordident_2` (`tablename`,`tstamp`),
  KEY `sys_log_uid` (`sys_log_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_history`
--

LOCK TABLES `sys_history` WRITE;
/*!40000 ALTER TABLE `sys_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_language`
--

DROP TABLE IF EXISTS `sys_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_language` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flag` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_isocode` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `static_lang_isocode` int(10) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_language`
--

LOCK TABLES `sys_language` WRITE;
/*!40000 ALTER TABLE `sys_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_lockedrecords`
--

DROP TABLE IF EXISTS `sys_lockedrecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_lockedrecords` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `record_table` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `record_uid` int(11) NOT NULL DEFAULT '0',
  `record_pid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `feuserid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `event` (`userid`,`tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_lockedrecords`
--

LOCK TABLES `sys_lockedrecords` WRITE;
/*!40000 ALTER TABLE `sys_lockedrecords` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_lockedrecords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_log`
--

DROP TABLE IF EXISTS `sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_log` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `action` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recuid` int(10) unsigned NOT NULL DEFAULT '0',
  `tablename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recpid` int(11) NOT NULL DEFAULT '0',
  `error` smallint(5) unsigned NOT NULL DEFAULT '0',
  `details` text COLLATE utf8_unicode_ci,
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `details_nr` smallint(6) NOT NULL DEFAULT '0',
  `IP` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_data` text COLLATE utf8_unicode_ci,
  `event_pid` int(11) NOT NULL DEFAULT '-1',
  `workspace` int(11) NOT NULL DEFAULT '0',
  `NEWid` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `request_id` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time_micro` double NOT NULL DEFAULT '0',
  `component` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level` smallint(5) unsigned NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `event` (`userid`,`event_pid`),
  KEY `recuidIdx` (`recuid`),
  KEY `user_auth` (`type`,`action`,`tstamp`),
  KEY `request` (`request_id`),
  KEY `combined_1` (`tstamp`,`type`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_log`
--

LOCK TABLES `sys_log` WRITE;
/*!40000 ALTER TABLE `sys_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_news`
--

DROP TABLE IF EXISTS `sys_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_news` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_news`
--

LOCK TABLES `sys_news` WRITE;
/*!40000 ALTER TABLE `sys_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_refindex`
--

DROP TABLE IF EXISTS `sys_refindex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_refindex` (
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tablename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recuid` int(11) NOT NULL DEFAULT '0',
  `field` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flexpointer` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `softref_key` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `softref_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL DEFAULT '0',
  `workspace` int(11) NOT NULL DEFAULT '0',
  `ref_table` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ref_uid` int(11) NOT NULL DEFAULT '0',
  `ref_string` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`hash`),
  KEY `lookup_rec` (`tablename`(240),`recuid`),
  KEY `lookup_uid` (`ref_table`(240),`ref_uid`),
  KEY `lookup_string` (`ref_string`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_refindex`
--

LOCK TABLES `sys_refindex` WRITE;
/*!40000 ALTER TABLE `sys_refindex` DISABLE KEYS */;
INSERT INTO `sys_refindex` VALUES ('072ac4f9749d3f869e909828f294a826','tt_content',4,'pi_flexform','sDEF/lDEF/pages/vDEF/','','',0,0,0,'pages',2,''),('1f6a86319ee272ca02c75a96ed971df3','tt_content',4,'pi_flexform','s_redirect/lDEF/redirectPageLogin/vDEF/','','',0,0,0,'pages',1,''),('58387149e60f8666aee52377719f8966','tt_content',1,'pi_flexform','sDEF/lDEF/settings.detailPage/vDEF/','','',0,0,0,'pages',3,''),('71bc83e5ad0c7737dfc2bd1b2f170a29','tt_content',4,'pi_flexform','s_redirect/lDEF/redirectPageLogout/vDEF/','','',0,0,0,'pages',1,''),('7fae339e620a71be9066dd57e6b84643','tt_content',2,'pages','','','',0,0,0,'pages',2,''),('8ba01abd3ce16dc75b77e3c3906d7713','fe_users',1,'usergroup','','','',0,0,0,'fe_groups',1,''),('cca7ab90d092f4ead7e8b51a7a476f92','tt_content',1,'pages','','','',0,0,0,'pages',2,''),('eb2f70d037f6acb1a9a691fbdd4b1bdd','tt_content',4,'pi_flexform','s_redirect/lDEF/redirectPageLoginError/vDEF/','','',0,0,0,'pages',1,'');
/*!40000 ALTER TABLE `sys_refindex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_registry`
--

DROP TABLE IF EXISTS `sys_registry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_registry` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_namespace` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_value` mediumblob,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `entry_identifier` (`entry_namespace`,`entry_key`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_registry`
--

LOCK TABLES `sys_registry` WRITE;
/*!40000 ALTER TABLE `sys_registry` DISABLE KEYS */;
INSERT INTO `sys_registry` VALUES (1,'installUpdate','TYPO3\\CMS\\Install\\Updates\\AccessRightParametersUpdate',_binary 'i:1;'),(2,'installUpdate','TYPO3\\CMS\\Install\\Updates\\LanguageIsoCodeUpdate',_binary 'i:1;'),(3,'installUpdate','TYPO3\\CMS\\Install\\Updates\\PageShortcutParentUpdate',_binary 'i:1;'),(4,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateShortcutUrlsAgainUpdate',_binary 'i:1;'),(5,'installUpdate','TYPO3\\CMS\\Install\\Updates\\ProcessedFileChecksumUpdate',_binary 'i:1;'),(6,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FilesReplacePermissionUpdate',_binary 'i:1;'),(7,'installUpdate','TYPO3\\CMS\\Install\\Updates\\TableFlexFormToTtContentFieldsUpdate',_binary 'i:1;'),(8,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FileListInAccessModuleListUpdate',_binary 'i:1;'),(9,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FileListIsStartModuleUpdate',_binary 'i:1;'),(10,'installUpdate','TYPO3\\CMS\\Install\\Updates\\WorkspacesNotificationSettingsUpdate',_binary 'i:1;'),(11,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateMediaToAssetsForTextMediaCe',_binary 'i:1;'),(12,'installUpdate','TYPO3\\CMS\\Install\\Updates\\Compatibility6ExtractionUpdate',_binary 'i:1;'),(13,'installUpdate','TYPO3\\CMS\\Install\\Updates\\OpenidExtractionUpdate',_binary 'i:1;'),(14,'installUpdate','TYPO3\\CMS\\Install\\Updates\\ExtensionManagerTables',_binary 'i:1;'),(15,'installUpdate','TYPO3\\CMS\\Install\\Updates\\WizardDoneToRegistry',_binary 'i:1;'),(16,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BackendUserStartModuleUpdate',_binary 'i:1;'),(17,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FrontendUserImageUpdateWizard',_binary 'i:1;'),(18,'installUpdate','TYPO3\\CMS\\Install\\Updates\\DatabaseRowsUpdateWizard',_binary 'i:1;'),(19,'installUpdate','TYPO3\\CMS\\Install\\Updates\\CommandLineBackendUserRemovalUpdate',_binary 'i:1;'),(20,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FillTranslationSourceField',_binary 'i:1;'),(21,'installUpdate','TYPO3\\CMS\\Install\\Updates\\SectionFrameToFrameClassUpdate',_binary 'i:1;'),(22,'installUpdate','TYPO3\\CMS\\Install\\Updates\\SplitMenusUpdate',_binary 'i:1;'),(23,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BulletContentElementUpdate',_binary 'i:1;'),(24,'installUpdate','TYPO3\\CMS\\Install\\Updates\\UploadContentElementUpdate',_binary 'i:1;'),(25,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateCscStaticTemplateUpdate',_binary 'i:1;'),(26,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateFscStaticTemplateUpdate',_binary 'i:1;'),(27,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FileReferenceUpdate',_binary 'i:1;'),(28,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateFeSessionDataUpdate',_binary 'i:1;'),(29,'installUpdate','TYPO3\\CMS\\Install\\Updates\\Compatibility7ExtractionUpdate',_binary 'i:1;'),(30,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FormLegacyExtractionUpdate',_binary 'i:1;'),(31,'installUpdate','TYPO3\\CMS\\Install\\Updates\\RteHtmlAreaExtractionUpdate',_binary 'i:1;'),(32,'installUpdate','TYPO3\\CMS\\Install\\Updates\\LanguageSortingUpdate',_binary 'i:1;'),(33,'extensionDataImport','typo3/sysext/core/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(34,'extensionDataImport','typo3/sysext/scheduler/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(35,'extensionDataImport','typo3/sysext/extbase/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(36,'extensionDataImport','typo3/sysext/fluid/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(37,'extensionDataImport','typo3/sysext/install/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(38,'extensionDataImport','typo3/sysext/extensionmanager/ext_tables_static+adt.sql',_binary 's:32:\"6d9cccf73eaea1454a066f0cf626974d\";'),(39,'extensionDataImport','typo3/sysext/lang/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(40,'extensionDataImport','typo3/sysext/backend/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(41,'extensionDataImport','typo3/sysext/cshmanual/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(42,'extensionDataImport','typo3/sysext/filelist/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(43,'extensionDataImport','typo3/sysext/frontend/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(44,'extensionDataImport','typo3/sysext/recordlist/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(45,'extensionDataImport','typo3/sysext/saltedpasswords/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(46,'extensionDataImport','typo3/sysext/sv/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(47,'core','formProtectionSessionToken:1',_binary 's:64:\"8bb6777022e46a53c8af444a55df0c67d66c8db66a6ac2d45a640ed223030cb9\";'),(48,'extensionDataImport','typo3conf/ext/guard7/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(49,'extensionDataImport','typo3conf/ext/backend_debug/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(50,'extensionDataImport','typo3conf/ext/workshop_blog/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(51,'extensionDataImport','typo3/sysext/fluid_styled_content/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(52,'extensionDataImport','typo3/sysext/tstemplate/ext_tables_static+adt.sql',_binary 's:0:\"\";'),(53,'extensionDataImport','typo3/sysext/felogin/ext_tables_static+adt.sql',_binary 's:0:\"\";');
/*!40000 ALTER TABLE `sys_registry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_template`
--

DROP TABLE IF EXISTS `sys_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_template` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sitetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `root` smallint(5) unsigned NOT NULL DEFAULT '0',
  `clear` smallint(5) unsigned NOT NULL DEFAULT '0',
  `include_static_file` text COLLATE utf8_unicode_ci,
  `constants` text COLLATE utf8_unicode_ci,
  `config` text COLLATE utf8_unicode_ci,
  `nextLevel` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci,
  `basedOn` tinytext COLLATE utf8_unicode_ci,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `includeStaticAfterBasedOn` smallint(5) unsigned NOT NULL DEFAULT '0',
  `static_file_mode` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`deleted`,`hidden`,`sorting`),
  KEY `roottemplate` (`deleted`,`hidden`,`root`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_template`
--

LOCK TABLES `sys_template` WRITE;
/*!40000 ALTER TABLE `sys_template` DISABLE KEYS */;
INSERT INTO `sys_template` VALUES (1,1,0,0,0,'',0,0,0,0,0,0,1576237323,0,1576060780,1,'Main TypoScript Rendering','Guard7 Testdb',0,0,0,1,1,'EXT:fluid_styled_content/Configuration/TypoScript/,EXT:fluid_styled_content/Configuration/TypoScript/Styling/','','page = PAGE\r\npage.100 =< styles.content.get','','This is an Empty Site Package TypoScript template.\r\n\r\nFor each website you need a TypoScript template on the main page of your website (on the top level). For better maintenance all TypoScript should be extracted into external files via <INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:site_myproject/Configuration/TypoScript/setup.typoscript\">.',NULL,0,0,0);
/*!40000 ALTER TABLE `sys_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_content`
--

DROP TABLE IF EXISTS `tt_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_content` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `t3ver_state` smallint(6) NOT NULL DEFAULT '0',
  `t3ver_stage` int(11) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `editlock` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `CType` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `header` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `header_position` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rowDescription` text COLLATE utf8_unicode_ci,
  `bodytext` mediumtext COLLATE utf8_unicode_ci,
  `bullets_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploads_description` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uploads_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `assets` int(10) unsigned NOT NULL DEFAULT '0',
  `image` int(10) unsigned NOT NULL DEFAULT '0',
  `imagewidth` int(10) unsigned NOT NULL DEFAULT '0',
  `imageorient` smallint(5) unsigned NOT NULL DEFAULT '0',
  `imagecols` smallint(5) unsigned NOT NULL DEFAULT '0',
  `imageborder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `media` int(10) unsigned NOT NULL DEFAULT '0',
  `layout` int(10) unsigned NOT NULL DEFAULT '0',
  `frame_class` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cols` int(10) unsigned NOT NULL DEFAULT '0',
  `spaceBefore` smallint(5) unsigned NOT NULL DEFAULT '0',
  `spaceAfter` smallint(5) unsigned NOT NULL DEFAULT '0',
  `space_before_class` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `space_after_class` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `records` text COLLATE utf8_unicode_ci,
  `pages` text COLLATE utf8_unicode_ci,
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `colPos` int(10) unsigned NOT NULL DEFAULT '0',
  `subheader` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fe_group` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `header_link` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_zoom` smallint(5) unsigned NOT NULL DEFAULT '0',
  `header_layout` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `list_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sectionIndex` smallint(5) unsigned NOT NULL DEFAULT '0',
  `linkToTop` smallint(5) unsigned NOT NULL DEFAULT '0',
  `file_collections` text COLLATE utf8_unicode_ci,
  `filelink_size` smallint(5) unsigned NOT NULL DEFAULT '0',
  `filelink_sorting` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `recursive` smallint(5) unsigned NOT NULL DEFAULT '0',
  `imageheight` int(10) unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `pi_flexform` mediumtext COLLATE utf8_unicode_ci,
  `accessibility_title` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `accessibility_bypass` smallint(5) unsigned NOT NULL DEFAULT '0',
  `accessibility_bypass_text` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `l18n_parent` int(11) NOT NULL DEFAULT '0',
  `l18n_diffsource` mediumblob,
  `l10n_source` int(11) NOT NULL DEFAULT '0',
  `selected_categories` text COLLATE utf8_unicode_ci,
  `category_field` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `table_class` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `table_caption` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_delimiter` smallint(5) unsigned NOT NULL DEFAULT '0',
  `table_enclosure` smallint(5) unsigned NOT NULL DEFAULT '0',
  `table_header_position` smallint(5) unsigned NOT NULL DEFAULT '0',
  `table_tfoot` smallint(5) unsigned NOT NULL DEFAULT '0',
  `l10n_state` text COLLATE utf8_unicode_ci,
  `categories` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`sorting`),
  KEY `language` (`l18n_parent`,`sys_language_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_content`
--

LOCK TABLES `tt_content` WRITE;
/*!40000 ALTER TABLE `tt_content` DISABLE KEYS */;
INSERT INTO `tt_content` VALUES (1,1,0,0,0,'',0,0,0,0,0,0,1576237732,1576164567,1,0,0,256,'list','','','',NULL,0,0,0,0,0,0,0,2,0,0,0,'default',0,0,0,0,'','',NULL,'2',0,0,0,'','','',0,'0','workshopblog_list',1,0,NULL,0,'','',0,0,0,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"settings.detailPage\">\n                    <value index=\"vDEF\">3</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>','',0,'',0,_binary 'a:26:{s:5:\"CType\";N;s:6:\"colPos\";N;s:6:\"header\";N;s:13:\"header_layout\";N;s:15:\"header_position\";N;s:4:\"date\";N;s:11:\"header_link\";N;s:9:\"subheader\";N;s:9:\"list_type\";N;s:11:\"pi_flexform\";N;s:5:\"pages\";N;s:9:\"recursive\";N;s:6:\"layout\";N;s:11:\"frame_class\";N;s:18:\"space_before_class\";N;s:17:\"space_after_class\";N;s:12:\"sectionIndex\";N;s:9:\"linkToTop\";N;s:16:\"sys_language_uid\";N;s:6:\"hidden\";N;s:9:\"starttime\";N;s:7:\"endtime\";N;s:8:\"fe_group\";N;s:8:\"editlock\";N;s:10:\"categories\";N;s:14:\"rowDescription\";N;}',0,NULL,'','',NULL,124,0,0,0,NULL,0),(2,3,0,0,0,'',0,0,0,0,0,0,1576240162,1576164643,1,0,0,256,'list','','','',NULL,0,0,0,0,0,0,0,2,0,0,0,'default',0,0,0,0,'','',NULL,'2',0,0,0,'','','',0,'0','workshopblog_detail',1,0,NULL,0,'','',0,0,0,0,NULL,'',0,'',0,_binary 'a:25:{s:5:\"CType\";N;s:6:\"colPos\";N;s:6:\"header\";N;s:13:\"header_layout\";N;s:15:\"header_position\";N;s:4:\"date\";N;s:11:\"header_link\";N;s:9:\"subheader\";N;s:9:\"list_type\";N;s:5:\"pages\";N;s:9:\"recursive\";N;s:6:\"layout\";N;s:11:\"frame_class\";N;s:18:\"space_before_class\";N;s:17:\"space_after_class\";N;s:12:\"sectionIndex\";N;s:9:\"linkToTop\";N;s:16:\"sys_language_uid\";N;s:6:\"hidden\";N;s:9:\"starttime\";N;s:7:\"endtime\";N;s:8:\"fe_group\";N;s:8:\"editlock\";N;s:10:\"categories\";N;s:14:\"rowDescription\";N;}',0,NULL,'','',NULL,124,0,0,0,NULL,0),(3,1,0,0,0,'',0,0,0,0,0,0,1576237113,1576237113,1,0,0,128,'text','Welcome','','','',0,0,0,0,0,0,0,2,0,0,0,'default',0,0,0,0,'','',NULL,NULL,0,0,0,'','','',0,'0','',1,0,NULL,0,'','',0,0,0,0,NULL,'',0,'',0,'',0,NULL,'','',NULL,124,0,0,0,NULL,0),(4,1,0,0,0,'',0,0,0,0,0,0,1576675413,1576675404,1,0,0,512,'login','','','',NULL,0,0,0,0,0,0,0,2,0,0,0,'default',0,0,0,0,'','',NULL,NULL,0,0,0,'','','',0,'0','',1,0,NULL,0,'','',0,0,0,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"showForgotPassword\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"showPermaLogin\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"showLogoutFormAfterLogin\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"pages\">\n                    <value index=\"vDEF\">2</value>\n                </field>\n                <field index=\"recursive\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n        <sheet index=\"s_redirect\">\n            <language index=\"lDEF\">\n                <field index=\"redirectMode\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"redirectFirstMethod\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"redirectPageLogin\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n                <field index=\"redirectPageLoginError\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n                <field index=\"redirectPageLogout\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n                <field index=\"redirectDisable\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n            </language>\n        </sheet>\n        <sheet index=\"s_messages\">\n            <language index=\"lDEF\">\n                <field index=\"welcome_header\">\n                    <value index=\"vDEF\">Log in</value>\n                </field>\n                <field index=\"welcome_message\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"success_header\">\n                    <value index=\"vDEF\">You are logged in</value>\n                </field>\n                <field index=\"success_message\">\n                    <value index=\"vDEF\">You are logged in</value>\n                </field>\n                <field index=\"error_header\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"error_message\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"status_header\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"status_message\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"logout_header\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"logout_message\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"forgot_header\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"forgot_reset_message\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>','',0,'',0,_binary 'a:23:{s:5:\"CType\";N;s:6:\"colPos\";N;s:6:\"header\";N;s:13:\"header_layout\";N;s:15:\"header_position\";N;s:4:\"date\";N;s:11:\"header_link\";N;s:9:\"subheader\";N;s:11:\"pi_flexform\";N;s:6:\"layout\";N;s:11:\"frame_class\";N;s:18:\"space_before_class\";N;s:17:\"space_after_class\";N;s:12:\"sectionIndex\";N;s:9:\"linkToTop\";N;s:16:\"sys_language_uid\";N;s:6:\"hidden\";N;s:9:\"starttime\";N;s:7:\"endtime\";N;s:8:\"fe_group\";N;s:8:\"editlock\";N;s:10:\"categories\";N;s:14:\"rowDescription\";N;}',0,NULL,'','',NULL,124,0,0,0,NULL,0);
/*!40000 ALTER TABLE `tt_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_extensionmanager_domain_model_extension`
--

DROP TABLE IF EXISTS `tx_extensionmanager_domain_model_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_extensionmanager_domain_model_extension` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `extension_key` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `repository` int(10) unsigned NOT NULL DEFAULT '1',
  `version` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alldownloadcounter` int(10) unsigned NOT NULL DEFAULT '0',
  `downloadcounter` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `state` int(11) NOT NULL DEFAULT '0',
  `review_state` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  `last_updated` int(10) unsigned NOT NULL DEFAULT '0',
  `serialized_dependencies` mediumtext COLLATE utf8_unicode_ci,
  `author_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ownerusername` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `md5hash` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `update_comment` mediumtext COLLATE utf8_unicode_ci,
  `authorcompany` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `integer_version` int(11) NOT NULL DEFAULT '0',
  `current_version` int(11) NOT NULL DEFAULT '0',
  `lastreviewedversion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `versionextrepo` (`extension_key`,`version`,`repository`),
  KEY `index_extrepo` (`extension_key`,`repository`),
  KEY `index_versionrepo` (`integer_version`,`repository`,`extension_key`),
  KEY `index_currentversions` (`current_version`,`review_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_extensionmanager_domain_model_extension`
--

LOCK TABLES `tx_extensionmanager_domain_model_extension` WRITE;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_extension` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_extension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_extensionmanager_domain_model_repository`
--

DROP TABLE IF EXISTS `tx_extensionmanager_domain_model_repository`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_extensionmanager_domain_model_repository` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `wsdl_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mirror_list_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `extension_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_extensionmanager_domain_model_repository`
--

LOCK TABLES `tx_extensionmanager_domain_model_repository` WRITE;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_repository` DISABLE KEYS */;
INSERT INTO `tx_extensionmanager_domain_model_repository` VALUES (1,0,'TYPO3.org Main Repository','Main repository on typo3.org. This repository has some mirrors configured which are available with the mirror url.','https://typo3.org/wsdl/tx_ter_wsdl.php','https://repositories.typo3.org/mirrors.xml.gz',1346191200,0);
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_guard7_domain_model_data`
--

DROP TABLE IF EXISTS `tx_guard7_domain_model_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_guard7_domain_model_data` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) NOT NULL DEFAULT '0',
  `tablename` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tableuid` int(11) NOT NULL DEFAULT '0',
  `fieldname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `secretdata` longtext COLLATE utf8_unicode_ci,
  `needsreencode` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `idxmain` (`tablename`,`tableuid`,`fieldname`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_guard7_domain_model_data`
--

LOCK TABLES `tx_guard7_domain_model_data` WRITE;
/*!40000 ALTER TABLE `tx_guard7_domain_model_data` DISABLE KEYS */;
INSERT INTO `tx_guard7_domain_model_data` VALUES (1,0,0,'fe_users',1,'company','rc4::eyJlNTAyN2E5NGUzZjI2MDg3NTg1Mzc4MzliNzc5ZTYzMWQ5ZTlhN2IwIjoiYzBsOU9ISUw0UnFmTnVGbDM5d2IrR1BYcE5sbEkzNUVSNHRwMDFabGRJVGtRUklieXVFTjg3R1NSdEpaZEw4b09GUjErZ2FpRjJDQUNYUVl0NlwvK3RSMkRhRG5QSnNudUVuelk1c21ZMEdYYTBzbVpmdWR4MWdrU2hDSHVIeFlcL2xWNG1YWStGOVM5ZE5ZeVwva2RTS1lWeHZFVlh4WUdwTnVhaDJCazh6a0R4dWJ4NGx3c04xcHdCWWo5czNveU4wZEVaSW9IdzQ0T3F1OVpURDFDcE1QT1wvQkc1MnlwaUdKNlJvWlJNcDR4bTUzRmlvUzV2YnkzbU0xRVU3cFdTTUpsUVhMZmQ1T3BhTG1YTjJSR1oxUWVUcDRkTjF3ZWZyMER6dGJaVDFad2lTXC9MS1NacEFhWFhFVWFJdDZzUDhkeXZHS0JPUGhIeTF4WGFleEN2M2V0M1hBSXQzYTVIM1RUbkxZbk5oMFRDT0pGcFpxSFJrWDMzQkRVWllQR1M3N01OZkVPalwvQndJR09KR0YyVjYybGJzdHRxckFjWHhuWWVRbmN1UHQyZFBOV3dNVFwvMHdibmY5UXVZdDE5M0Y0SjM0XC9Bb3QraHZpXC91V0dqTm9obDNRczQ4YVwvSFh4K1kxdWh2UzloOTgzYXRxbG5oQmhpZTRkeE1aSk5Yek1DbUtYYXdzK2ZNZEZrb2pWZlwvMkFHN21aNGNFS2ZjVTZpSWxsSG1RUmVobzFHRlo4YUR1WFFOXC96UzZqRFwvSWlwaXN5cllqT0hTRWNlRG5IXC9LekY4SEtlVWcwU3hHdWt0UE8rVWtsY1JBQ2lWNDVxNXZ5RHNwK2hXUlVHbHNqVHhuUHg0Mkw1aGlrMmNmUGdxUkluMDFoMnJHWWZ6S251c3NLS1JXMWFUQWtcL1BWOVE9IiwiZWU3NjYwYTc0ZmE4MTk0ZGVlMTQ3NTlmNWM2NDExNTMxMWVhMWNmNSI6IkIxXC9hVlVcLzVpMlNsaTNZd1J4UDZpQWlQTlpEV1haODQ2elQwSERuM1RcL2xBNDdXMjJpZTRuQkQ4aWExOWt5UE95VmZvcVVwTFNYNnc4SXhnK3ZVWWpYd2hmRlE4N3FnOHFxSFwvUGN0Z21INVdvd2VDb0huRHVBU3hqXC9ZeXdLR00yZXl6OUIwREkxSnk2SkF4eUdTK2hZOG9MTzRPQWczWXdJb2VcL3BxS29JTlBaXC8xYzExZGJmR2FUTmdnRG9iY0xQd0V0dHpiS1VmXC9hSFl4VlM3SHV5cWs2UWE1bjFXRlRPQnUyaWxcL2VBTEdZdG5aQW54Sm5HdXFjRTdMVXl1aEFna2hnYk8wS2F2UCtaUiswOUFjWk4zVlB4NHRQcDN2UkhYVEhxMXpNWmM4SmRKXC9lWWppQVhxMWRta296U1RXQVlLMGtnYUo2cmRLdkdLNzM4d1k5b21DaGZNc2dkN2ptWkYwWmM5dlRhS2MzQ1hKNXhHdW1HOVVQTGlCbzk0U0NrM1N5N2VJU2tQRUtIbCsyNmkrY2UranBqdXlOWDVpYTNuME1tQWJsTzFcL1BJdkxReENrQmdmUHVXa3N6RCtTd0VpXC9TZHU1TWdvWThrMGZQR2toUXBDamZ5dHhndm9jRzY2S1dMZzNHVmllRENuTmc5dTBsdkQxekloNmthZkFXOFhsN2lmK2xJVXVLSzBSOUtDNjVjbnpGaWxDRVk3NWdqdUVcL3c3dnBnclB1RWV6M0pHQTNGeXNHekw2NGFDTm5BYlh4TVFVbzBJVloxWnhmbk40cHIrMkVlU0VPdDVJbjZSZTgxbmxOVTd2dUlCaThSTFFaV1RNZEkxcVZSQ3dTbHFkUVB2SWdVWGRTeTR6ZnlcL3RpYmg0bWZCVjFMb21DdGY3aWt6OG9tS2M9In0=:i+xdTSGqDeE=',0),(2,0,0,'fe_users',1,'name','rc4::eyJlNTAyN2E5NGUzZjI2MDg3NTg1Mzc4MzliNzc5ZTYzMWQ5ZTlhN2IwIjoiVXp3ZGlEbGl3dzNRd3h2NGZPTEVvZDlIdVwvNEFjdTVLTU5XTFZiXC9QbFNLTDM4aURzdVM0TGtUaEJcL05reGgrOHU5VzBocDlleDVhbEQ3cVVGdEdjNDlETkF3dlkyYTBYN3RoWW1YVkt6SHJFSGkwQ1wvWXVXNDhPdExuV1dCNG5saENOdmg3WXVJSHNPQWVcLzlSbFpSeWUybUxXcEdYK2xxYTNJeEEwRVl4dWQ4UVRrNVloNStaTEY0NFJrZTNoN3NuRU00ZVRhZktYbTd6bmdiSW9WS3hjdXcxSStWQnRNUlE4dXFsSHQzdW90YUJ2M2k0dGJcLzQwY0tsNUtZNitETmFMSjY0R1wvWDNLZ2lITHR6Z2RpTU84MThnTDlyWHNcL1h3XC9Rb0tGZzZrMGpGUHM1OXdxTzhJaUl0T0pBQjVVUVBJdTZtYnVNalZFclhRQmVKTXVHK2ZHbHZ6bWxXdUFwcUFET0tKb0I3amVXYU0xdzZmbkZkWW1HZVdneGpobjJHaVBzSm54WnVPSjczZUl0Qk9iY2hKVlNZNmVUS3dCTThCcUtOSGlaUVdRY3Z3RkpJNkNiM3ZnTGFLZVU5dVByS2ZUc1lvUFI2QkJuY2dPanEwZGYzem43a3VCTEw4XC81TnN5dUZOV1lqcjR4dDJWcmZSQUFjSkI3emZHbHE4TUNlb1wvc0xFMWVyWWh4QUN6aEdhRVwvdXVYR095YXZBb0p2RDZiS0dZN2o2a1NLcU9jaWxLOWJlZDBMWVRWbzFrWVhsbG95MEt3Rk51SmZnUWQ2d2FIZUtnXC9wKzAyNmFINGhqM0pBa05GMFBLNzg1Q2V6a0NKNG9ONmNheEZUQmVMNHBha09RdmdrVzBYVnBrZ1I1Z2pzWERNMXkyXC9xK0VZenVySmxBQkZFdFRaND0iLCJlZTc2NjBhNzRmYTgxOTRkZWUxNDc1OWY1YzY0MTE1MzExZWExY2Y1IjoicHFFZGRNaVVCV1BJSFwvUG9vR0tCYVBZejYxeWxnWER3SGdcLzhDRDJqeExuRkpEbDlvVnhQRWlEbzM1S0lmQnQ3VFhsWThneDBVeG5RZ2RNRFBNMDY4RkxrbGRtVW9EK05LcWlHUzR6MUxMM1wvVlJmM2ZObHRMSVREYkR2aFJMMm1yenhmdGIzMzdlRWRhWXdKVzFyT2xxK3RxTHk2RUErb0pTaXpBWmZmR214Z1dUdG13MkFMdXFiUmlaSHpGa3hTYlA1UWg5RElmY2NLSU1FeGZzN0VmZFcxMFErWWZyWU1ZNmc0Nm9TN1wvb1wvMGxGUmVyYmFmYU1PMEl4eStkWVYzazAxZW1oNzk5bGRlcnBsbHNlWXlzY05VK1ZqUU9EWmsrNWxaZXluYndyYU5vRlgxekY3dVRzdjZSQjFLTWtmUW9HRVpUV0V1UG84b1QrQ0NRN1R6OVpDcEFpclVVblViZ0hMOG1ES1AwelRIM1RzTGZXWlwvMExkY3ZjU3orZ085R05SdWs3bGFDZ1pCR0xDT3h1SlpxenMzWjRBWDExd0lDNTFtOURhMmFESFptR1N2dXY3UWlQYUNaT05zK1lYV09mbEVCTUpjVmJmZndqeUhidHo0eE02MFVBaWswZ2VmMUMzQ2phTERlaGl4WXVDbFdDWTh1b1BnY1wvRWs0YXJPVkNoNGw0c0Z5VWNPY1RmNHBUZ0tlcjZHVVVIZlwvcU1ldzd3cHlZekdqTXpHMTUyd1FEOFMxRmRMSVgzR3BhRFJRTGI1ekpiVnJxNVpnYTg1VzF0S1FFdkdCZDBIY2YwajNCaHA2ZThlSmVGYTZwdkMxK2dvdDJyMDUwTTZyMTFYc0ZqMEF3dmZtRlNIcXptUUhDaXVxNjFBWnJ6ck5Za0huUkFaRktwTHZSbz0ifQ==:0Ipk3U+BwbjORCxxLORrsA==',0),(3,0,0,'fe_users',1,'last_name','rc4::eyJlNTAyN2E5NGUzZjI2MDg3NTg1Mzc4MzliNzc5ZTYzMWQ5ZTlhN2IwIjoibGJDK09MZWY0MExyR3l4Rkpuc2lTQ1pvUXg0RjdldEZ4TXd6NlZaVElrWUJSNk45UVwvOWVXQTNZNUZ3UkgycDhTSHN3XC9KN0Q3aFJTanBydk81NTk5SHlKZm16V0pcL1ZrZldsbUlBaUozUGp3OXVzMHBDUWp5SGhOQkJFSlB6OFBDN2Y4bXJ2XC9YWFljODBhVndQV2YzYmcyQURyaU9OSWEySGZaY0lPbnVVcVJWRFlYZHpoYStmQ0ZMTE9cL1RUSm1JMUMyRlhKTTZIRFdMWXpsRVVqaUxaZ2ZWdHQ1OElwaFpsMTQxUXRCZDdpQThzelRhTmhkUEJhOWZubE9vZThVN2ZWRnVCMzFpalVsZzZxUGl2blMyZU5nOVlqT3hmYXB2XC9LSHRQNnRibGZkbDVoelFFUHNcL282RG5tbTZoM3FiVmhvT1VrRzkrSWFjT2RhcTNQQ0orU201YnZQQ3UzRWZFXC9xNk4xWDN2WWpcL2pcL1ZsQ2NcL01PcDdKV1hpV3N3cHMzVmN2STJGajJ1QmdMZFVHQlJJSHQzMTJwZVZBdHVYRVVCdnJiTXdzRnJ6bWE5SVNaZ3NtZTRodFcxMEhERG5mQ20xdXU3Mmk2ejhpeXpibFdCXC9Hak8wVGlNMHFKU2psQVJuS0w5aDZsbkVyWVJJa08weTBWaEI2eGh3REJod3RzV1dMc3czZzhlR1djWVo4OTZZN2EzUXFTVEZhXC9hYnNRMXA0UUFPXC9NWmxVUTg4b1hLOVwvc0w0amQ4YWZJXC9JZjJkc1NSd0kwNWlcLzJ2NHZrYmFBT1NaV1FJWU52RnUyTmQxK1MzdlVCeFNQK1VhSTRxRnR1NUc0V1hibmNUbWhyeFBSVUJoYTkrditvb1B1Vm5OOENJTFpzXC9sMWxMT01uNjhOOTR4QXZMWG89IiwiZWU3NjYwYTc0ZmE4MTk0ZGVlMTQ3NTlmNWM2NDExNTMxMWVhMWNmNSI6Img0bFNhTjdSU1VjdW9obHl4MW9XWlg2Z1ozVDdJcGQ5OGF4RWxSdkZjNlwvSk4yZ2VLRytMR2JvUmI1MGt2N0NNK25DNDg1eTBqbHpsUEVGdWwwaE84ekhWdHp1ZGVcL1BnNytKZCtVS0w3QVNTdGo3VW5iNVwvXC9iQXdOc3djeUtBZVYwYlZvUFZQYnE4Y1wvbVdiWTZHbE9ET3phZGsrSncwN1oya0xTUkhOTlo1SkpNczVhR1BUeFdTXC9HZnZMRE50WEFFZjJnRVBobVpXZ0pIWCsyeUNOTHhVZlYwNFRseVZ5VW1LYkxGZURHU0ZOXC9jbWcxSFlaZkVJY3RwWlZMQUdUMWdCZ0Y4aDVZNmxacHNhSlVEXC9XRjdJaExaNWJLaGREWUdOYThhYlY0SXUxN0RENjRseFZIV3F4YUlESms0eEdGXC9UdnNJaVVwcFAzanlcL1AzeGd6SUxIS213Z2tvRWdwaXJGUk4xRUNwYVEzVDZITWJ6ckZselJjK3ZMRTN6QkhHaDkxVjZNb0JjQXhGeFUzd2w4akZrRHZlRk5Oa1A3bWh0K2JNdFwvYUZIdVhnbW41a1FhRkRoTW1INzNUbmJ5RVNSWEprVnV5T3dTUzBSK3dpQlQ0Rnk3NjA2WUc0R0xXTTEwMFUyZWc4aE9JQkNJdVRBSlUxSVZrWUVrUWpBa2R1S1UyV0pKUGJlREtneWtBRWJUaHkyTTRcL0xLNVJ6YlIxSWR1TDdhWmtISnRJMlpSbzduMHNXeVJxREJpMEdTQWdYXC9BOG9UNVVBUVAxa3dFTXR0YUJubFRcL3lpdER6ZW1RU1wvSlNoSVlYbGxoZmdJa3BZaFwvY0xFbkowQ0VnU1MzV1AwcVdiXC90YnZ5R1p5aFFMOEw4dTB0YnJxbHg3YUJPOU95d2NIcjhxYk09In0=:vD99G9njlhM=',0),(4,0,0,'fe_users',1,'address','rc4::eyJlNTAyN2E5NGUzZjI2MDg3NTg1Mzc4MzliNzc5ZTYzMWQ5ZTlhN2IwIjoiRTFYTEZzYU9qRG54UFlSZmJIZDFCSDJKTjk4MEUyckZkaGVvXC9JQmI3TEhQUGU4bTRNZXpMa0hRbitwc1dLME5YUmtJdnJcL1NKZ21kXC9QQ2Z2ZUFLQnIyQmhkWmg2UGROcGFmdTBcL1c4bnRoNzJ5OFV5MU5xdDZlNGc2ZjFCTlNrTWdScEpZbFNGSm4wenY1Z0FOaE40QmpKWXk5bENYbFJKZ2xhMElVRGdtNGM2MHIrYkcwYWFWZnBJNEdEVlpUYndZaVFQWmVcL1UrT2w4b2M4aFwvNnpcL29jREI5bEFxR3oySHk4bjZyTmRpUGNmMUFhTlwvc2h2RTB0T3BnMW0yVGlITDAwNVFzbVprNjZacU1cL29ESXhJeXRsMFQ4d29vaVMreUJ4amVDRmdaaFlMUldVdFRaV0tNRTN1UG93ZG5sT0lONzIrUFlXSWlMaVZQeU40VVl2T3hBd295RmFaamVhekJReEdpcVpcL0ZyWjBvUHdLUXVIZmd5VWpEb2lWb21TTTh2U2Q2YURHd0ViMk5idW83QTE4YzgrT3RKbGZtRWxmTzZFQlIwODZtckVDOEhHNW5TUmtBUG14Y0txN0Y4TllTdlZtWThybTJXbDhjUmtGKzd4bFpwSHlKaUlrbDFwSk9EOGt3b2NQZ2YxWEU3U1pKdnJnM1VKNFFwaUkzOEhHQ0NhU1BLUFZ6MkRIbCtqVDF4YlV4OGVCN3F5UUdqemUwMHE2cDR4eCttSWh0OERJZUU3VUwxQVI2K3FrZk5lYVA1T0I1Q2RGd2lpXC91YndkYVhqMkJieWRyd0FLVVhVbm9LaVQzMHRmbkJsWDdES1NUVVJoVzU0YkgxVDhra256aDY5RTRDTlJONzRDUDJUU0lXWENCOE1WNlFtelwvRmZqV0pFUEZPQTdUZWs9IiwiZWU3NjYwYTc0ZmE4MTk0ZGVlMTQ3NTlmNWM2NDExNTMxMWVhMWNmNSI6ImdJVk94S2NNRGdOWjFnaDJoWG9kZUhDODZ1THFaTkpIZE9xRUQ2bDY1QzJXdWs2VENGbG1HWWdsWmdaN1NkRTJBb1hZd1IwV0JKaUxBMFkyc0ZOT3U0TG5jdERnaUdFeDFxTkZZZkdYNFdrc0dTNVA5NjdaMzAzN0R2UHdMSzJPcnRvdGlrMTh1XC9Ndmlrc1l5Y1hMdTRCQk5jMm14VENweEZhXC95ZDRkcWJcL3FIdGI0SE5zc0N6bXFjTWpSMUYxSHFXano1anA5RngrdW9cL0FXZkNHUk1EWTJJQlwvTUp4TkZ1bzUrMU9EeGwxQmd5Z0g1eWkwbHllM1RQd1BCRzRqXC9Ialk0UFwvN0R4TDYyaDk2TkVRbitmSitEbFphOVI3R1hHblpEQUszeksrZ2REMjVPSXR3eGJOWUluNzd6SGorNTZneG1wNjhpNTdyeUd3VW9JT25FYVZ5Y2ViaHpXcmZsTXNrR2lZcGpHbmxMTkx2THc4RkR6MXNSWFF0a0J6UHdcL0I5SXNQYWdOYjlLckNBMk9pUmtQam5malBxdmxTRElEUVFnRGRFWlJiOTUwcE9nWFlHU3JZYkdOb1R0SFwvUEhwcUV0eldTbWNObCs0aWxLVmN2ZU8yZzc4a2VYNkttamhYdG13ZmdxNk1zallqdzZJeEx2QlVOS3U5TzJNM2hQaElyeVJyMXJMMllmNkJiTWtOMkhDdHV6U3FUZ0dFVU1VYlVnQVwvcTdURWpaK3lKRXFnTXc5Q1hJT0F4Mlg2eE5rWkVrV2VLcFlUYkNJcEgxYU1cLzF5VUJtS3V2OW5nM093Mkdia2tXblpXN0NVaVMxQmJod2xmWnA2TUQ5WXdENmdIUmI1QzZGOXd3SWlydUZaN3JENlFaU2JcL2g0UGowRk9teTJkOFR2NXZZPSJ9:ICdljjrGjm0=',0),(13,0,0,'tx_workshopblog_domain_model_blog',1,'teaser','RC4::eyJlZTc2NjBhNzRmYTgxOTRkZWUxNDc1OWY1YzY0MTE1MzExZWExY2Y1IjoiSElqYkhFb21aTXQ1aDg3WnVUZWlJeGtzSGM3UjdVN3dvdFl4RGdNdytJc2tiZGIzTk5jZkhlWFFQZHBlWlwvOGJKcmZjMEhISHUwN3FVUno1QU5JOVZveFhnNE04UHZhcmRiTWg0WWM5MTZyUXhuS2Voc2JjWlhRS1EraWczVUVpVCt1ZnpGa0xDRjdGQnE5RklZUFpNRlNITVZKaEFlenJGQlFrQkJMVWF0NHpVMUJJWFRFTWVzYnNLb3JcL3U0RFI3VlJJaVBQZE9sc0dHRm41Qlk3Q2J3XC9EcDNrS05HbFExUU1Zb3QzMGx2TVwvcTZcL0pLaUlmVGhublwvVWFzcnExb3U0RFBrU2xzcHU3WWEzMXZCSGt6eFc3QWx5N2NCeldxU0VRV1gzaFJsUHhHMGk4NUI3a0RueUo1RzNVS3BTdERYOVFYbWFKd2g0bm8xN1VqeUxIbXFEbXExcjMrM2YrNVNkTnIyN3dzVng1UEJyY0k0S01yWVlNSmtMVnBlMXhQRVZqMzhLaWh2TjkxZThaZHE1cWREOXBxc3J4XC9LK1hNaVJ5S2VHYmo0Zk5oZHFQekhGSWtZUERjQXdoNG1HK3gzOTNlcnBvNCtSNmY4Rjg1Z1JaaG5JXC9HcFJiTWQrWWplMHVPUVIzc0owTkgzSVdsbWp4UjBKQVwvWVdPSWtqSUlMcVBmRDVPeDlKWTA2eGE4cDlhM3E2d3lCVVViSW1kUkFWWmhHWHkzUDI1aHROSVdvWjNYQ3VTSjhFSXl5c2JDaWVsWlwvbUsrNHFCRW13a0RIT0xWRnFuNEZJa1RzVndzcm1TZ0Q1ejVqZmE1VEV6KzgrclJCYkllTXhsWEc1TDNFbVl5R2lQK1wvOXBxU0RwRnlTYlVFMGNxVGpKWmNVMmtrRE0yUnVPdlVnMD0ifQ==:xkTV0qKe+OT7aOgvocSKSXei',0);
/*!40000 ALTER TABLE `tx_guard7_domain_model_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_guard7_signatures`
--

DROP TABLE IF EXISTS `tx_guard7_signatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_guard7_signatures` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `signature` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `idxparent` (`parent`),
  KEY `idxsignature` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_guard7_signatures`
--

LOCK TABLES `tx_guard7_signatures` WRITE;
/*!40000 ALTER TABLE `tx_guard7_signatures` DISABLE KEYS */;
INSERT INTO `tx_guard7_signatures` VALUES (1,0,1,'e5027a94e3f2608758537839b779e631'),(2,0,1,'ee7660a74fa8194dee14759f5c641153'),(3,0,2,'e5027a94e3f2608758537839b779e631'),(4,0,2,'ee7660a74fa8194dee14759f5c641153'),(5,0,3,'e5027a94e3f2608758537839b779e631'),(6,0,3,'ee7660a74fa8194dee14759f5c641153'),(7,0,4,'e5027a94e3f2608758537839b779e631'),(8,0,4,'ee7660a74fa8194dee14759f5c641153'),(9,0,5,'ee7660a74fa8194dee14759f5c641153'),(10,0,6,'ee7660a74fa8194dee14759f5c641153'),(11,0,7,'ee7660a74fa8194dee14759f5c641153'),(12,0,8,'ee7660a74fa8194dee14759f5c641153'),(13,0,9,'ee7660a74fa8194dee14759f5c641153'),(14,0,10,'ee7660a74fa8194dee14759f5c641153'),(15,0,11,'ee7660a74fa8194dee14759f5c641153'),(16,0,12,'ee7660a74fa8194dee14759f5c641153'),(17,0,13,'ee7660a74fa8194dee14759f5c641153'),(18,0,14,'ee7660a74fa8194dee14759f5c641153'),(19,0,15,'ee7660a74fa8194dee14759f5c641153'),(20,0,16,'ee7660a74fa8194dee14759f5c641153'),(21,0,17,'ee7660a74fa8194dee14759f5c641153'),(22,0,18,'ee7660a74fa8194dee14759f5c641153'),(23,0,19,'ee7660a74fa8194dee14759f5c641153'),(24,0,20,'ee7660a74fa8194dee14759f5c641153'),(25,0,21,'ee7660a74fa8194dee14759f5c641153'),(26,0,22,'ee7660a74fa8194dee14759f5c641153'),(27,0,23,'ee7660a74fa8194dee14759f5c641153'),(28,0,24,'ee7660a74fa8194dee14759f5c641153'),(29,0,25,'ee7660a74fa8194dee14759f5c641153'),(30,0,26,'ee7660a74fa8194dee14759f5c641153'),(31,0,27,'ee7660a74fa8194dee14759f5c641153'),(32,0,28,'ee7660a74fa8194dee14759f5c641153'),(33,0,29,'ee7660a74fa8194dee14759f5c641153'),(34,0,30,'ee7660a74fa8194dee14759f5c641153'),(35,0,31,'ee7660a74fa8194dee14759f5c641153'),(36,0,32,'ee7660a74fa8194dee14759f5c641153'),(37,0,33,'ee7660a74fa8194dee14759f5c641153'),(38,0,34,'ee7660a74fa8194dee14759f5c641153'),(39,0,35,'ee7660a74fa8194dee14759f5c641153'),(40,0,36,'ee7660a74fa8194dee14759f5c641153'),(41,0,37,'ee7660a74fa8194dee14759f5c641153'),(42,0,38,'ee7660a74fa8194dee14759f5c641153'),(43,0,39,'ee7660a74fa8194dee14759f5c641153'),(44,0,40,'ee7660a74fa8194dee14759f5c641153'),(45,0,41,'ee7660a74fa8194dee14759f5c641153'),(46,0,42,'ee7660a74fa8194dee14759f5c641153'),(47,0,43,'ee7660a74fa8194dee14759f5c641153'),(48,0,44,'ee7660a74fa8194dee14759f5c641153'),(49,0,45,'ee7660a74fa8194dee14759f5c641153'),(50,0,46,'ee7660a74fa8194dee14759f5c641153'),(51,0,47,'ee7660a74fa8194dee14759f5c641153'),(52,0,48,'ee7660a74fa8194dee14759f5c641153'),(53,0,49,'ee7660a74fa8194dee14759f5c641153'),(54,0,50,'ee7660a74fa8194dee14759f5c641153');
/*!40000 ALTER TABLE `tx_guard7_signatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_scheduler_task`
--

DROP TABLE IF EXISTS `tx_scheduler_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_scheduler_task` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `disable` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `nextexecution` int(10) unsigned NOT NULL DEFAULT '0',
  `lastexecution_time` int(10) unsigned NOT NULL DEFAULT '0',
  `lastexecution_failure` text COLLATE utf8_unicode_ci,
  `lastexecution_context` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `serialized_task_object` mediumblob,
  `serialized_executions` mediumblob,
  `task_group` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `index_nextexecution` (`nextexecution`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_scheduler_task`
--

LOCK TABLES `tx_scheduler_task` WRITE;
/*!40000 ALTER TABLE `tx_scheduler_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_scheduler_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_scheduler_task_group`
--

DROP TABLE IF EXISTS `tx_scheduler_task_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_scheduler_task_group` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sorting` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groupName` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_scheduler_task_group`
--

LOCK TABLES `tx_scheduler_task_group` WRITE;
/*!40000 ALTER TABLE `tx_scheduler_task_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_scheduler_task_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_workshopblog_domain_model_blog`
--

DROP TABLE IF EXISTS `tx_workshopblog_domain_model_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_workshopblog_domain_model_blog` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0',
  `teaser` text COLLATE utf8_unicode_ci,
  `bodytext` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_workshopblog_domain_model_blog`
--

LOCK TABLES `tx_workshopblog_domain_model_blog` WRITE;
/*!40000 ALTER TABLE `tx_workshopblog_domain_model_blog` DISABLE KEYS */;
INSERT INTO `tx_workshopblog_domain_model_blog` VALUES (1,2,1576238770,1576167542,1,0,0,'test',1576168560,'&#128274;','&#128274;');
/*!40000 ALTER TABLE `tx_workshopblog_domain_model_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_workshopblog_domain_model_comment`
--

DROP TABLE IF EXISTS `tx_workshopblog_domain_model_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_workshopblog_domain_model_comment` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deleted` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hidden` smallint(5) unsigned NOT NULL DEFAULT '0',
  `commentor` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci,
  `date` int(11) NOT NULL DEFAULT '0',
  `blog` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-18 14:44:16
