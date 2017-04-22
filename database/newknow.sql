-- MySQL dump 10.13  Distrib 5.6.36, for Linux (x86_64)
--
-- Host: localhost    Database: newknow
-- ------------------------------------------------------
-- Server version	5.6.36

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
-- Table structure for table `tblExp`
--

DROP TABLE IF EXISTS `tblExp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblExp` (
  `eid` int(10) unsigned NOT NULL,
  `title` varbinary(1000) NOT NULL,
  `summary` varbinary(3000) NOT NULL DEFAULT '' COMMENT '摘要',
  `content` mediumtext NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `creator_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `creator_uname` varbinary(128) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` smallint(3) unsigned NOT NULL DEFAULT '0',
  `reply_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `approve_num` int(10) unsigned NOT NULL DEFAULT '0',
  `follower_num` int(10) unsigned NOT NULL DEFAULT '0',
  `browser_num` int(10) unsigned NOT NULL DEFAULT '0',
  `title_key` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  PRIMARY KEY (`eid`),
  KEY `user_q` (`creator_uid`,`create_time`),
  KEY `title_key` (`title_key`),
  KEY `reply_num` (`reply_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='经验表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblExp`
--

LOCK TABLES `tblExp` WRITE;
/*!40000 ALTER TABLE `tblExp` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblExp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblFeed`
--

DROP TABLE IF EXISTS `tblFeed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblFeed` (
  `qid` bigint(10) unsigned NOT NULL,
  `uid` bigint(10) unsigned NOT NULL,
  `data` varbinary(8000) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL,
  `fid` bigint(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `qid` (`fid`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblFeed`
--

LOCK TABLES `tblFeed` WRITE;
/*!40000 ALTER TABLE `tblFeed` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblFeed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblNotification`
--

DROP TABLE IF EXISTS `tblNotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblNotification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0-未读，1-已读，2-删除',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户通知类型',
  `obj_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对象id',
  `from_uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '来源uid',
  `notify_num` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '消息数目',
  `read_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '值为0时为已阅读后未更新，大于0时为更新消息数目时的时间戳',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建的时间',
  `notify_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uid_type_qid` (`uid`,`type`,`obj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户消息通知数据表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblNotification`
--

LOCK TABLES `tblNotification` WRITE;
/*!40000 ALTER TABLE `tblNotification` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblNotification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblQuestions`
--

DROP TABLE IF EXISTS `tblQuestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblQuestions` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varbinary(1000) NOT NULL,
  `content` varbinary(20000) NOT NULL,
  `creator_uid` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT '状态：1-正常 | 2-删除',
  `reply_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `follower_num` int(10) unsigned NOT NULL DEFAULT '0',
  `title_key` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `browser_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `title_key` (`title_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='问题表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblQuestions`
--

LOCK TABLES `tblQuestions` WRITE;
/*!40000 ALTER TABLE `tblQuestions` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblQuestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblReply`
--

DROP TABLE IF EXISTS `tblReply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblReply` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '种类',
  `content` varbinary(20000) NOT NULL DEFAULT '',
  `uid` int(10) unsigned NOT NULL,
  `uname` varbinary(128) NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `status` smallint(3) unsigned NOT NULL DEFAULT '0',
  `vote_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblReply`
--

LOCK TABLES `tblReply` WRITE;
/*!40000 ALTER TABLE `tblReply` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblReply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblUser`
--

DROP TABLE IF EXISTS `tblUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblUser` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `uname` varbinary(128) NOT NULL COMMENT '用户名',
  `tel` varchar(11) DEFAULT NULL COMMENT '电话',
  `email` varbinary(50) DEFAULT NULL COMMENT '邮箱',
  `intro` varbinary(128) DEFAULT NULL COMMENT '简介',
  `feature` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户等级：1-普通用户 | 10-管理员',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `islogin` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否登录：0-未登录 | 1-已登录',
  `headpic` varbinary(128) DEFAULT NULL COMMENT '头像地址',
  `passwd` varchar(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB AUTO_INCREMENT=1492052888 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblUser`
--

LOCK TABLES `tblUser` WRITE;
/*!40000 ALTER TABLE `tblUser` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblVote`
--

DROP TABLE IF EXISTS `tblVote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblVote` (
  `rid` int(10) unsigned NOT NULL,
  `qid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL COMMENT '点赞者',
  `uid2` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被点赞者',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` smallint(2) unsigned NOT NULL,
  PRIMARY KEY (`rid`,`uid`,`type`),
  KEY `qid` (`qid`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='点赞表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblVote`
--

LOCK TABLES `tblVote` WRITE;
/*!40000 ALTER TABLE `tblVote` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblVote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluserfollowing`
--

DROP TABLE IF EXISTS `tbluserfollowing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbluserfollowing` (
  `uid` int(10) unsigned NOT NULL,
  `obj_type` int(10) unsigned NOT NULL,
  `obj_id` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`obj_type`,`obj_id`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluserfollowing`
--

LOCK TABLES `tbluserfollowing` WRITE;
/*!40000 ALTER TABLE `tbluserfollowing` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbluserfollowing` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-22 12:32:17
