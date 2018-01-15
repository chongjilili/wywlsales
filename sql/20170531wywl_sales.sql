-- ---------------------------------------------------------
-- Database Name: wywlsales
CREATE DATABASE IF NOT EXISTS `wywlsales` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `wywlsales`;
-- ---------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES 'utf8' */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='SYSTEM' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table wywl_access
--

DROP TABLE IF EXISTS `wywl_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_access
--

/*!40000 ALTER TABLE `wywl_access` DISABLE KEYS */;
INSERT INTO `wywl_access` VALUES ( 1, 38, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 37, 2, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 36, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 35, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 34, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 33, 2, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 32, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 31, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 30, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 29, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 28, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 27, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 26, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 25, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 24, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 23, 2, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 19, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 18, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 17, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 16, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 15, 2, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 14, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 13, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 12, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 11, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 10, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 9, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 8, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 7, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 6, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 5, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 4, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 3, 3, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 2, 2, NULL );
INSERT INTO `wywl_access` VALUES ( 1, 1, 1, NULL );
/*!40000 ALTER TABLE wywl_access ENABLE KEYS */;

--
-- Table structure for table wywl_admin
--

DROP TABLE IF EXISTS `wywl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'admin id',
  `seid` int(10) NOT NULL COMMENT 'sequence id 顺序id，按照个体的顺序排序的id，保证树状结构',
  `pid` int(10) NOT NULL COMMENT 'parent id 指明是那个adminid的直推',
  `dirsalenum` int(10) DEFAULT '0' COMMENT '直推的产品数量，判断用户等级，10件为银牌，100件为金牌',
  `username` varchar(250) NOT NULL COMMENT '用户名',
  `toexaminepass` varchar(250) DEFAULT NULL COMMENT '审核密码 在一些特别的操作要的审核审核身份',
  `password` varchar(250) NOT NULL COMMENT '密码',
  `encrypt` varchar(250) NOT NULL COMMENT '加密的字符串',
  `usertype` int(10) DEFAULT '1' COMMENT '管理员类型',
  `yintime` varchar(250) DEFAULT NULL COMMENT '升级为银牌代理的时间',
  `jintime` varchar(250) DEFAULT NULL COMMENT '升级为金牌代理的时间',
  `registertime` varchar(250) DEFAULT NULL COMMENT '注册时间戳',
  `logintime` varchar(250) DEFAULT NULL,
  `realname` varchar(100) DEFAULT '真是姓名',
  `email` varchar(250) DEFAULT NULL COMMENT '邮箱',
  `loginip` varchar(250) DEFAULT '0' COMMENT '登录ip',
  `islock` int(10) NOT NULL DEFAULT '0' COMMENT '是否被锁住',
  `loginaddress` varchar(250) DEFAULT '无法获取' COMMENT '登录地址',
  `phone` varchar(250) DEFAULT NULL COMMENT '电话',
  `sex` int(10) DEFAULT NULL COMMENT '性别，1为男，2为女',
  `address` varchar(250) DEFAULT NULL COMMENT '地址',
  `idcard` varchar(250) DEFAULT NULL COMMENT '身份证号码',
  `creditcard` varchar(250) DEFAULT NULL COMMENT '银行卡号',
  `addressofcreditcard` varchar(250) DEFAULT NULL COMMENT '开卡户地',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_admin
--

/*!40000 ALTER TABLE `wywl_admin` DISABLE KEYS */;
INSERT INTO `wywl_admin` VALUES ( 1, 0, 1, 0, 'admin', '9f87223cf1a9452b80f6f50f78895292', '9f87223cf1a9452b80f6f50f78895292', 'sa8jYM', 9, NULL, NULL, 1489197372, 1495729981, '公司管理员', NULL, '0.0.0.0', 0, 0, 13666666666, NULL, NULL, 1111111111111, NULL, NULL );
INSERT INTO `wywl_admin` VALUES ( 2, 1, 1, 0, 1, NULL, 'aac03939f31432538c9e5dfcd95b5bc8', 'NIdxA8', 3, 1494255932, 1494255932, 1494255932, 1494938349, '李理', '1273640670@qq.com', '0.0.0.0', 1, 0, 18502074604, 1, '广州市番禺区祈福新村C区9街78号4F', 440181197904045154, 440181197904045154, '广州' );
INSERT INTO `wywl_admin` VALUES ( 3, 2, 1, 0, 2, NULL, '65cd94c385cc832cb74c019e893bda15', '7iPuuE', 3, 1494329198, 1494329198, 1494329198, 1494329198, '陈忆媚', '', '116.22.163.229', 1, '无法获取', 18621541345, 0, '', 2, NULL, '广州' );
INSERT INTO `wywl_admin` VALUES ( 4, 3, 1, 0, 3, NULL, '4bc376cc743a17163894ac8c7f0cd0a1', 'eJ9ajF', 3, 1494329200, 1494329200, 1494329200, 1494329200, '陈珍广', '', '116.22.163.229', 1, '无法获取', 13711567529, 0, '', '陈珍广', NULL, '广州' );
INSERT INTO `wywl_admin` VALUES ( 5, 4, 2, 0, 4, NULL, '9387dac626b0af4a58c501a35a8c706c', 'wJBlcb', 3, NULL, 1494147894, 1494147894, 1494147894, '周小爱', '', '116.22.163.229', 1, '无法获取', 13811811006, 0, '', '周小爱', NULL, '广州' );
INSERT INTO `wywl_admin` VALUES ( 6, 5, 2, 0, 5, NULL, '4857ff04ec106a4536c470637ca79fae', 'J5aQsn', 3, 1494235238, 1494235238, 1494235238, 1494235238, '陈印宗', '2142674@qq.com', '116.22.163.229', 1, '无法获取', 13825995577, 0, '', '陈印宗', NULL, '广州' );
INSERT INTO `wywl_admin` VALUES ( 7, 6, 3, 0, 6, NULL, '7c01f42df8a66f75351ac86d2e865c04', 'MWZT79', 3, NULL, 1494147830, 1494147902, 1494147902, '林文相', '', '116.22.163.229', 1, '无法获取', 13622957889, 1, '', '林文相', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 8, 7, 3, 0, 7, NULL, '02d11a934d301ceadb2a24c86ab66458', 'GNhGEi', 3, NULL, 1494147844, 1494147907, 1494147907, '穆茂', '', '116.22.163.229', 1, '无法获取', 13560351292, 1, '', '穆茂', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 9, 8, 2, 0, 8, NULL, '103a0e855e656c2bff7e614b9aa7dbae', 'pL6Mm2', 3, NULL, 1494140547, 1494147913, 1494147913, '陈本照', '', '116.22.163.229', 1, '无法获取', 13697429128, 1, '', '陈本照', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 10, 9, 2, 0, 9, NULL, '4c0dfc224f715a075036d73de77a1933', 'acwTCx', 1, NULL, NULL, 1494235657, 1494235657, '韩坤', '', '116.22.163.229', 1, '无法获取', 18126722979, 1, '', '韩坤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 11, 10, 5, 0, 10, NULL, '0126a9b7fe2aa5c8a0d15eb00931628c', '8BQZ2x', 1, NULL, NULL, 1494235703, 1494235703, '江春梅', '', '116.22.163.229', 1, '无法获取', 18502074604, 2, '', '江春梅', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 12, 11, 7, 0, 11, NULL, '9f674d6957d4a9a8066eac1262330234', 'nJBwjF', 1, NULL, NULL, 1494241155, 1494241155, '高瑞', '', '116.22.163.229', 1, '无法获取', 13711755553, 2, '', '高瑞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 13, 12, 6, 0, 12, NULL, '284575abfcba1e0f9111a9cc70a35784', 'rYN1rL', 1, NULL, NULL, 1494241201, 1494241201, '李纪红', '', '116.22.163.229', 1, '无法获取', 13354199629, 2, '', '李纪红', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 14, 13, 2, 0, 13, NULL, '2d2b7e80bc072d508107a5c7724cfda0', 'G9bxQt', 1, NULL, NULL, 1494243391, 1494243391, '温秋彤', '', '116.22.163.229', 1, '无法获取', 18502074604, 2, '', '温秋彤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 15, 14, 14, 0, 14, NULL, '321090f3b8954fab362dc72f0ec3ed11', 'ZYYVGM', 2, 1494247998, NULL, 1494247998, 1494247998, '李波', '', '116.22.163.229', 1, '无法获取', 13249778991, 0, '', '李波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 16, 15, 15, 0, 15, NULL, 'd9a5c4792397e0a31eb5602c5a6869a8', 'qy4tK4', 1, NULL, NULL, 1494250693, 1494250693, '周洪亮', '', '116.22.163.229', 1, '无法获取', 13138776445, 1, '', '周洪亮', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 17, 16, 2, 0, 16, NULL, '2a90ce3f7843e3c34ccbc441279c85cc', 'fGRnAw', 1, NULL, NULL, 1494490690, 1494490690, '梁兰凤', '', '116.22.163.229', 1, '无法获取', 13660051828, 2, '', '梁兰凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 18, 17, 2, 0, 17, NULL, 'e195cbd097888622be985e14e4276d24', 'unPvLN', 1, NULL, NULL, 1494490707, 1494490707, '吴珂尘', '', '116.22.163.229', 1, '无法获取', 15899567023, 1, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 19, 18, 3, 0, 18, NULL, '60e285ee1509a6e10a5267b9d6b5e762', '8dkV38', 1, NULL, NULL, 1494696229, 1494696229, '刘赢政', '', '116.22.163.229', 1, '无法获取', 17620134030, 1, '', '刘赢政', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 20, 19, 19, 0, 19, NULL, 'f77db5afa246883280649520cded2e87', 'AR41ng', 1, NULL, NULL, 1493984071, 1493984071, '刘全全', '', '116.22.163.229', 0, '无法获取', 13751880662, 1, '', '刘全全', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 21, 20, 19, 0, 20, NULL, 'c442843fa9dc402cc2bf8c17e541ccab', 'lS5dN2', 1, NULL, NULL, 1493984068, 1493984068, '刘彬彬', '', '116.22.163.229', 0, '无法获取', 18502086315, 0, '', '刘彬彬', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 22, 21, 19, 0, 21, NULL, '9e5b60675693dabb1fec1d4fe01d24d5', 'tqsIH1', 1, NULL, NULL, 1493984066, 1493984066, '冯艳辉', '', '116.22.163.229', 0, '无法获取', 13560217898, 1, '', '冯艳辉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 23, 22, 22, 0, 22, NULL, '887d92e1b8227a2bcfae9caf9bd5218c', 'ttYIsZ', 1, NULL, NULL, 1493984064, 1493984064, '冯艳明', '', '116.22.163.229', 0, '无法获取', 18502086282, 1, '', '冯艳明', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 24, 23, 3, 0, 23, NULL, '0039c1d3a99a93989b7d8fa7e556c6dc', 'P62pVN', 1, NULL, NULL, 1493984061, 1493984061, '范文峰', '', '116.22.163.229', 0, '无法获取', 13602260811, 1, '', '范文峰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 25, 24, 24, 0, 24, NULL, '01722164f4b809171d3b2388ccfe2dd4', 'dsdY9I', 1, NULL, NULL, 1493984055, 1493984055, '吴海鹰', '', '116.22.163.229', 0, '无法获取', 13926071828, 0, '', '吴海鹰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 26, 25, 24, 0, 25, NULL, '00e126db4bccb30cb6f4541a09b4f506', 'HzgWAh', 1, NULL, NULL, 1493984053, 1493984053, '周开迟', '', '116.22.163.229', 0, '无法获取', 13602792196, 1, '', '周开迟', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 27, 26, 24, 0, 26, NULL, 'f8203405a43ef60bf46c2570a9e181b3', 'pypGzg', 1, NULL, NULL, 1493984052, 1493984052, '江晓燕', '', '116.22.163.229', 0, '无法获取', 13535138227, 2, '', '江晓燕', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 28, 27, 24, 0, 27, NULL, '97aa5aac5968a8b2d86a36629a5bb45a', 'FPWJIz', 1, NULL, NULL, 1493984050, 1493984050, '江富方', '', '116.22.163.229', 0, '无法获取', 13824558162, 1, '', '江富方', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 29, 28, 2, 0, 28, NULL, '83b8ce055df2852ff5097f22c8fa2600', 'trKHeI', 1, NULL, NULL, 1493984045, 1493984045, '刘降珠', '', '116.22.163.229', 0, '无法获取', 13973823635, 2, '', '刘降珠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 30, 29, 29, 0, 29, NULL, '6dfcf95feba5a2abe5429215dc0c7e16', 'qqU9N3', 1, NULL, NULL, 1493984041, 1493984041, '', '', '116.22.163.229', 0, '无法获取', 13973823635, 2, '', '刘降珠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 31, 30, 29, 0, 30, NULL, 'e0ec1899867673372b57ef12c7aca1fc', 'KIwwFn', 1, NULL, NULL, 1493984039, 1493984039, '文魁', '', '116.22.163.229', 0, '无法获取', 15973825322, 1, '', '文魁', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 32, 31, 29, 0, 31, NULL, 'dcb85fdcaa0fc433f453817eeb98b152', 'vUatie', 1, NULL, NULL, 1493984037, 1493984037, '吴伟波', '', '116.22.163.229', 0, '无法获取', 13723805559, 1, '', '吴伟波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 33, 32, 29, 0, 32, NULL, '4ce98419dd5a23305c39f90d0fcc0a1d', 'TW2bRQ', 1, NULL, NULL, 1493273371, 1493273371, '石伟云', '', '116.22.163.229', 0, '无法获取', 13926110195, 2, '', '石伟云', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 34, 33, 8, 0, 33, NULL, '9993b35de993a6eaff0840b8598c7440', 'wUrCXG', 1, NULL, NULL, 1493273420, 1493273420, '穆茂', '', '116.22.163.229', 0, '无法获取', 13560351292, 1, '', '穆茂', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 35, 34, 29, 0, 34, NULL, 'c1f050aa2b047aecd34a63e85a6fda89', 'Eesv4n', 1, NULL, NULL, 1493273481, 1493273481, '李辉', '', '116.22.163.229', 0, '无法获取', 15920927456, 1, '', '李辉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 36, 35, 24, 0, 35, NULL, 'a1bc6b2ffbcc567dd1014b7034c81de0', 'ZPtt86', 3, NULL, 1493289110, 1493273537, 1493289110, '左峰', '', '116.22.163.229', 0, '无法获取', 18922746087, 1, '', '左峰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 37, 36, 24, 0, 36, NULL, '71a6929a4eabec8332def44019172495', 'WWBgDE', 1, NULL, NULL, 1493273664, 1493273664, '林建全', '', '116.22.163.229', 0, '无法获取', 18922745960, 1, '', '林建全', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 38, 37, 24, 0, 37, NULL, '6e01398406ada16f65cf0f6e0bda3a54', 'u2YmJ1', 1, NULL, NULL, 1493273731, 1493273731, '伍玉琼', '', '116.22.163.229', 0, '无法获取', 13824492092, 2, '', '伍玉琼', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 39, 38, 24, 0, 38, NULL, '7b67ef955223420952f9685db000b8a5', 'p37vBC', 1, NULL, NULL, 1493273894, 1493273894, '刘敏', '', '116.22.163.229', 0, '无法获取', 18565353779, 2, '', '刘敏', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 40, 39, 14, 0, 39, NULL, '8b77a88d428beaee1141bcfa2f8037b4', 'qfCD6p', 1, NULL, NULL, 1493274077, 1493274077, '张冬梅', '', '116.22.163.229', 0, '无法获取', 13850078566, 2, '', '张冬梅', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 41, 40, 24, 0, 40, NULL, '19449de2a0ec6623f43b9cede78c65fe', '4QLn3d', 1, NULL, NULL, 1493274251, 1493274251, '黄锋', '', '116.22.163.229', 0, '无法获取', 13572226566, 1, '', '黄锋', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 42, 41, 24, 0, 41, NULL, '046d6531ab1826d13ecb75d5910cb2f5', 'UY5W5T', 1, NULL, NULL, 1493274717, 1493274717, '叶一凡', '', '116.22.163.229', 0, '无法获取', 13682263228, 1, '', '叶一凡', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 43, 42, 24, 0, 42, NULL, 'a0f07ca56631a7362c47b8c4541ffbb6', 'dbCK8j', 1, NULL, NULL, 1493274982, 1493275881, '陈爱云', '', '116.22.163.229', 0, '无法获取', 13048003960, 2, '', '陈爱云', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 44, 43, 43, 0, 43, NULL, 'a09fefdedf6dcd0658b5c4b348afd3be', 'tHrSaU', 1, NULL, NULL, 1493275082, 1493275082, '陈忆媚', '', '116.22.163.229', 0, '无法获取', 13539497603, 2, '', '陈忆媚', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 45, 44, 19, 0, 44, NULL, '53bcd6026fdf53887f0d4b05651c58a4', 'PFhCZK', 1, NULL, NULL, 1493275134, 1493275134, '刘如', '', '116.22.163.229', 0, '无法获取', 15099999065, 2, '', '刘如', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 46, 45, 19, 0, 45, NULL, 'f4d7d11bdac4e37c95524f416f670804', 'T8BRU1', 1, NULL, NULL, 1493275189, 1493275189, '廖傽玲', '', '116.22.163.229', 0, '无法获取', 13902962810, 2, '', '廖傽玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 47, 46, 19, 0, 46, NULL, '7131dd9c25bc438ca17698172636204b', 'fhNEeP', 1, NULL, NULL, 1493275243, 1493275243, '王士兰', '', '116.22.163.229', 0, '无法获取', 18819250662, 0, '', '王士兰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 48, 47, 19, 0, 47, NULL, 'a55261297c8a2a61e484f1ba0b252e7a', 'P6q9WA', 1, NULL, NULL, 1493275301, 1493275375, '陈爱平', '', '116.22.163.229', 0, '无法获取', 13424077889, 2, '', '陈爱平', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 49, 48, 43, 0, 48, NULL, 'f59f0c5e6b278592262676c389463dd5', 'AGpq8i', 1, NULL, NULL, 1493275428, 1493275428, '江紫晴', '', '116.22.163.229', 0, '无法获取', 13924229339, 2, '', '江紫晴', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 50, 49, 43, 0, 49, NULL, 'fad5f0806d2f9d74865baa5833e07110', 'zqA6eB', 1, NULL, NULL, 1493275499, 1493275499, '江泽廷', '', '116.22.163.229', 0, '无法获取', 13048008181, 1, '', '江泽廷', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 51, 50, 43, 0, 50, NULL, '28673c556b63a9afd89243268ee51efb', 'u1s92p', 1, NULL, NULL, 1493275552, 1493275552, '朱海美', '', '116.22.163.229', 0, '无法获取', 15019811941, 2, '', '朱海美', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 52, 51, 51, 0, 51, NULL, 'b1c6668cb4b04800d70dc45f2abf5c48', '46vMeU', 1, NULL, NULL, 1493275607, 1493275607, '朱婉茹', '', '116.22.163.229', 0, '无法获取', 15625006442, 2, '', '朱婉茹', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 53, 52, 29, 0, 52, NULL, 'ff0dfc9f8158580e28bb87e49a1d3bcd', 'Ejwhtq', 1, NULL, NULL, 1493275668, 1493275668, '马冠芳', '', '116.22.163.229', 0, '无法获取', 18007380200, 2, '', '马冠芳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 54, 53, 19, 0, 53, NULL, '515322e89eff99a5bc856bef7b758ac0', 'cEHWUf', 1, NULL, NULL, 1493275728, 1493275728, '鲁小艳', '', '116.22.163.229', 0, '无法获取', 13726706222, 2, '', '鲁小艳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 55, 54, 43, 0, 54, NULL, '73337afd149dc2f0d26c0a46b5e9dc92', '7WfSst', 2, NULL, NULL, NULL, NULL, '江洪山', '', '116.22.163.229', 0, '无法获取', 13922497388, 1, '', '江洪山', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 56, 55, 43, 0, 55, NULL, '561752a9df698fa2d598f678d8bc54ef', 'TBFUVL', 2, '', NULL, 1493275854, 1493289144, '江炳桦', '', '116.22.163.229', 0, '无法获取', 13532229983, 1, '', '江炳桦', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 57, 56, 15, 0, 56, NULL, 'f332c10c35a4c410564042bd27ad94df', 'vp8PvM', 1, NULL, NULL, 1493275968, 1493275968, '欧在武', '', '116.22.163.229', 0, '无法获取', 13602214546, 1, '', '欧在武', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 58, 57, 18, 0, 57, NULL, '6eb9668317cb16f194813f180066b92b', 'GIfLym', 2, '', NULL, 1493276036, 1493276036, '严仪君', '', '116.22.163.229', 0, '无法获取', 13244838050, 2, '', '严仪君', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 59, 58, 29, 0, 58, NULL, '908b51eb23a867832872d6dee728db9a', 'eudCPt', 1, NULL, NULL, 1493276114, 1493276114, '李培', '', '116.22.163.229', 0, '无法获取', 15581268831, 0, '', '李培', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 60, 59, 2, 0, 59, NULL, 'c5312d61b6b718325b17bfa8932bdd32', 'jliUd3', 1, NULL, NULL, 1493276161, 1493276161, '沈雅丽', '', '116.22.163.229', 0, '无法获取', 18621541345, 0, '', '沈雅丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 61, 60, 60, 0, 60, NULL, 'ea51703d38a5dd8cfd827a9bbba3496d', '5mKV7B', 1, NULL, NULL, 1493276208, 1493276208, '沈雅丽', '', '116.22.163.229', 0, '无法获取', 18621541345, 0, '', '沈雅丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 62, 61, 60, 0, 61, NULL, 'f89003ab522b3442b2b2ec95083fbfaf', 'NTw8W6', 1, NULL, NULL, 1493276253, 1493276253, '沈雅丽', '', '116.22.163.229', 0, '无法获取', 18621541345, 0, '', '沈雅丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 63, 62, 60, 0, 62, NULL, '233fd7a4e6125988ca903c7a7a992cdc', 'uf8hK5', 1, NULL, NULL, 1493276302, 1493276302, '沈雅丽', '', '116.22.163.229', 0, '无法获取', 18621541345, 2, '', '沈雅丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 64, 63, 14, 0, 63, NULL, '98c02c2e13537d1e12c6b1505b20bea2', 'jcA8Kv', 1, NULL, NULL, 1493276337, 1493276337, '温建安', '', '116.22.163.229', 0, '无法获取', 18502074604, 0, '', '温建安', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 65, 64, 57, 0, 64, NULL, 'dea747d6f4ac44d063f0c7dfb65af626', 'iXd67S', 1, NULL, NULL, 1493276381, 1493276381, '欧阳伟辉', '', '116.22.163.229', 0, '无法获取', 18898888517, 0, '', '欧阳伟辉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 66, 65, 10, 0, 65, NULL, '35b2654df499f58ea75e623d8d8b5d6a', 'jCJxUk', 1, NULL, NULL, 1493276428, 1493276428, '韩坤', '', '116.22.163.229', 0, '无法获取', 18126722979, 0, '', '韩坤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 67, 66, 57, 0, 66, NULL, '03b8eb6232e8bb318eb068029ea1223d', 'Btivdw', 1, NULL, NULL, 1493276466, 1493276466, '梁亚聪', '', '116.22.163.229', 0, '无法获取', 18826459003, 0, '', '梁亚聪', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 68, 67, 57, 0, 67, NULL, 'c85caf7af4167b3faa3f4c871041e1cc', 'rSLYwD', 1, NULL, NULL, 1493276509, 1493276509, '李海标', '', '116.22.163.229', 0, '无法获取', 18023305382, 0, '', '李海标', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 69, 68, 43, 0, 68, NULL, 'e1eb0e7730deb28ed317bf9435c31467', 'L9KrTm', 1, NULL, NULL, 1493276556, 1493276556, '陈宇凤', '', '116.22.163.229', 0, '无法获取', 13660092955, 0, '', '陈宇凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 70, 69, 43, 0, 69, NULL, '432c2a041143641ec9b9c74609b55749', 'Qz6HCU', 1, NULL, NULL, 1493276594, 1493276594, '陈宇凤', '', '116.22.163.229', 0, '无法获取', 13660092955, 0, '', '陈宇凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 71, 70, 29, 0, 70, NULL, '21b5a266f23a6c856b7a16038274fda2', 'NzaWgl', 1, NULL, NULL, 1493276633, 1493276633, '张新', '', '116.22.163.229', 0, '无法获取', 13973848092, 0, '', '张新', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 72, 71, 19, 0, 71, NULL, '19c31f4f4b86c058c9ca2b82f0b04da5', 'D9WUsK', 1, NULL, NULL, 1493276704, 1493276704, '张子函', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张子函', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 73, 72, 14, 0, 72, NULL, '7851ba0e8a624175b14e3f1e0a61cc92', 'StGqV9', 1, NULL, NULL, 1493276747, 1493276747, '张志明', '', '116.22.163.229', 0, '无法获取', 15817076882, 0, '', '张志明', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 74, 73, 43, 0, 73, NULL, 'cbfd53e5e0994b7b2743406933b3d636', '1SbqZj', 1, NULL, NULL, 1493276787, 1493276787, '吴春红', '', '116.22.163.229', 0, '无法获取', 18955787035, 0, '', '吴春红', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 75, 74, 74, 0, 74, NULL, 'f97a917dee7345374a715084e184f1b5', 'swZLZt', 1, NULL, NULL, 1493276827, 1493276827, '刘艳红', '', '116.22.163.229', 0, '无法获取', 13505577177, 0, '', '刘艳红', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 76, 75, 74, 0, 75, NULL, '64e6c39e4ba020d7a40efdea0282dc5b', 'qpd2GS', 1, NULL, NULL, 1493276918, 1493276918, '陶翠俠', '', '116.22.163.229', 0, '无法获取', 15955755050, 0, '', '陶翠俠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 77, 76, 29, 0, 76, NULL, '98c0a281849fb83d4ad7ba3f7dca9200', 'CYi3e3', 1, NULL, NULL, 1493276974, 1493276974, '刘东姣', '', '116.22.163.229', 0, '无法获取', 18573803162, 0, '', '刘东姣', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 78, 77, 4, 0, 77, NULL, '3df7008e5c99063aa9f1da26ce16e23e', 'SJMBC7', 1, NULL, NULL, 1493277013, 1493277013, '谭丽芳', '', '116.22.163.229', 0, '无法获取', 13427586956, 0, '', '谭丽芳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 79, 78, 78, 0, 78, NULL, 'd18f28a7e386fd2c236f93c357d3b4b0', 'Ih1GZI', 1, NULL, NULL, 1493277055, 1493277055, '陈小珍', '', '116.22.163.229', 0, '无法获取', 18665656092, 0, '', '陈小珍', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 80, 79, 78, 0, 79, NULL, '3941d3ce7615f7c46f1bb023afd2dcc3', 'IrAnzL', 1, NULL, NULL, 1493277099, 1493277099, '陈珍本', '', '116.22.163.229', 0, '无法获取', 13725368003, 0, '', '陈珍本', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 81, 80, 78, 0, 80, NULL, '16446b036768212ee05bfa00b655520e', 'cRKW3Z', 1, NULL, NULL, 1493277136, 1493277136, '张利玲', '', '116.22.163.229', 0, '无法获取', 13922146891, 0, '', '张利玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 82, 81, 78, 0, 81, NULL, '9e9c0eedaa5d19d06c560d040f3eab3f', 'ptFNKw', 1, NULL, NULL, 1493277189, 1493277189, '邹松桦', '', '116.22.163.229', 0, '无法获取', 13802934898, 0, '', '邹松桦', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 83, 82, 78, 0, 82, NULL, '0b4f0d38317127f547488eaab8439396', 'It5e5s', 1, NULL, NULL, 1493277224, 1493277224, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 84, 83, 78, 0, 83, NULL, 'bcacc1291459bc97c8e6fe7f3f3e6513', '8hgnYt', 1, NULL, NULL, 1493277267, 1493277267, '陈耀迳', '', '116.22.163.229', 0, '无法获取', 13611414009, 0, '', '陈耀迳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 85, 84, 78, 0, 84, NULL, '95deb129b32382a6b53931bb2a315dad', 'zaa1l6', 1, NULL, NULL, 1493277344, 1493277344, '杨秀雯', '', '116.22.163.229', 0, '无法获取', 13538701827, 0, '', '杨秀雯', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 86, 85, 78, 0, 85, NULL, '6ef4ddbbb441c76a6390bd4f6c3903e1', 'nfAeF3', 1, NULL, NULL, 1493277388, 1493277388, '何浣萍', '', '116.22.163.229', 0, '无法获取', 15920360574, 0, '', '何浣萍', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 87, 86, 78, 0, 86, NULL, '5481a2ca10cf6d23385ec4eef51fa6e7', 'xDNACE', 1, NULL, NULL, 1493277427, 1493277427, '陈珍培', '', '116.22.163.229', 0, '无法获取', 13712860038, 0, '', '陈珍培', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 88, 87, 78, 0, 87, NULL, 'de3fc4ba60f12de15a8dd843fa6071a6', 'jSmBe1', 1, NULL, NULL, 1493277502, 1493277502, '叶卓麒', '', '116.22.163.229', 0, '无法获取', 13802543533, 0, '', '叶卓麒', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 89, 88, 43, 0, 88, NULL, '2fa6d73a6192bb4a1ca7eb314e107d44', 'tUeBQT', 1, NULL, NULL, 1493277540, 1493277540, '李俊洪', '', '116.22.163.229', 0, '无法获取', 13679561240, 0, '', '李俊洪', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 90, 89, 29, 0, 89, NULL, '1fc7bcce2d1f3cfdfdb9a44ff9d76dd0', 'CMWu8Z', 1, NULL, NULL, 1493277580, 1493277580, '刘降珠', '', '116.22.163.229', 0, '无法获取', 13973823635, 0, '', '刘降珠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 91, 90, 29, 0, 90, NULL, '0a9f0912507608cc3c4c897fa530c106', 'HfyGEp', 1, NULL, NULL, 1493277617, 1493277617, '吴德宇', '', '116.22.163.229', 0, '无法获取', 18673834766, 0, '', '吴德宇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 92, 91, 2, 0, 91, NULL, '061b53822d0804f8138ac7a60e39fc4c', 'Qg7jbc', 1, NULL, NULL, 1493277662, 1493277662, '吴普升', '', '116.22.163.229', 0, '无法获取', 18992871078, 0, '', '吴普升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 93, 92, 2, 0, 92, NULL, 'aabe2df925ab58f7b227c54d61839676', 'IzakbX', 1, NULL, NULL, 1493277705, 1493277705, '刘降珠', '', '116.22.163.229', 0, '无法获取', 18502074604, 0, '', '刘降珠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 94, 93, 2, 0, 93, NULL, 'cd8c22774c27425ba088145f97577493', '5evtk5', 1, NULL, NULL, 1493277745, 1493277745, '温建安', '', '116.22.163.229', 0, '无法获取', 18502074604, 0, '', '温建安', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 95, 94, 43, 0, 94, NULL, '2324ef5d3af6c953eeb14b8f73c52522', 'cYUJnR', 1, NULL, NULL, 1493277791, 1493277791, '陈忠升', '', '116.22.163.229', 0, '无法获取', 13823458121, 0, '', '陈忠升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 96, 95, 7, 0, 95, NULL, 'd14a25cf959a5aa51216f2d7b3f53608', 'cLSLkp', 1, NULL, NULL, 1493277825, 1493277825, '钟利玲', '', '116.22.163.229', 0, '无法获取', 13539161233, 0, '', '钟利玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 97, 96, 7, 0, 96, NULL, 'a89dcd328b079ca7170267f775cc48ca', 'Z2THjT', 1, NULL, NULL, 1493277864, 1493277864, '林宇展', '', '116.22.163.229', 0, '无法获取', 15119362703, 0, '', '林宇展', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 98, 97, 7, 0, 97, NULL, 'd457dc43f83137591986f649da0615f4', 'YEG7Vi', 1, NULL, NULL, 1493277901, 1493277901, '徐凯萍', '', '116.22.163.229', 0, '无法获取', 13750570671, 0, '', '徐凯萍', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 99, 98, 7, 0, 98, NULL, '3478f2392718b14ca54ebaa76e815ae3', 'BTX1D8', 1, NULL, NULL, 1493277946, 1493277946, '林宇瑾', '', '116.22.163.229', 0, '无法获取', 15218056796, 0, '', '林宇瑾', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 100, 99, 7, 0, 99, NULL, '1cb0b5a5863577f4695d2a739071f4bb', 'JjSAyk', 1, NULL, NULL, 1493277981, 1493277981, '刘利兰', '', '116.22.163.229', 0, '无法获取', 13750502512, 0, '', '刘利兰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 101, 100, 7, 0, 100, NULL, '086613fffb83821343c30ebce4fccff2', 'HEwfPm', 1, NULL, NULL, 1493278012, 1493278012, '王华荣', '', '116.22.163.229', 0, '无法获取', 13825990186, 0, '', '王华荣', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 102, 101, 10, 0, 101, NULL, '94a342123b5722c342cb914d2f9d50b0', '9a2DWN', 1, NULL, NULL, 1493278049, 1493278049, '李小霞', '', '116.22.163.229', 0, '无法获取', 18138706100, 0, '', '李小霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 103, 102, 10, 0, 102, NULL, '52fc0b7caab1f302c8dede33b2c85e57', '77Ag4s', 1, NULL, NULL, 1493278082, 1493278082, '韩正良', '', '116.22.163.229', 0, '无法获取', 18126720272, 0, '', '韩正良', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 104, 103, 10, 0, 103, NULL, 'ef0eaa7a96be97f2a16076fd6c65f630', 'KLbgxF', 1, NULL, NULL, 1493278123, 1493278123, '王湘华', '', '116.22.163.229', 0, '无法获取', 15364071002, 0, '', '王湘华', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 105, 104, 4, 0, 104, NULL, '40cb0b6098c28955f8bb25a42c893c69', 'QH62J6', 1, NULL, NULL, 1493278157, 1493278157, '谭志东', '', '116.22.163.229', 0, '无法获取', 13512743707, 0, '', '谭志东', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 106, 105, 105, 0, 105, NULL, '6fc550e118de951eadbae2f65dfdaf58', 'AhsCEl', 1, NULL, NULL, 1493278198, 1493278198, '解九洲', '', '116.22.163.229', 0, '无法获取', 18816833674, 0, '', '解九洲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 107, 106, 105, 0, 106, NULL, '443f88155819b01f43bda73688b0f3a0', 'M5wZ4m', 1, NULL, NULL, 1493278231, 1493278231, '田群', '', '116.22.163.229', 0, '无法获取', 13630167191, 0, '', '田群', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 108, 107, 2, 0, 107, NULL, '462fa25c42a038e48447bd8364c17d7a', 'U7BUEa', 2, 1493288340, NULL, 1493278280, 1493288340, '王艳', '', '116.22.163.229', 0, '无法获取', 13941765995, 0, '', '王艳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 109, 108, 108, 0, 108, NULL, '260d47797893589b8a5112b93bb9079e', 'zqF5BL', 2, 1493289202, NULL, 1493278320, 1493289202, '王经伟', '', '116.22.163.229', 0, '无法获取', 13840743407, 0, '', '王经伟', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 110, 109, 109, 0, 109, NULL, '24de85b0abeeb9753f21927ec3db909f', 'vRQmdp', 2, 1493289177, NULL, 1493278360, 1493289177, '曲畅', '', '116.22.163.229', 0, '无法获取', 15941775159, 0, '', '曲畅', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 111, 110, 20, 0, 110, NULL, '983a2b7ef5c47f9761fa651552c606df', 'XiEJl4', 1, NULL, NULL, 1493278406, 1493278406, '张建波', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张建波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 112, 111, 20, 0, 111, NULL, 'b02d3e9206a270e802e58ba1aa79399c', 'VA7Cef', 1, NULL, NULL, 1493278465, 1493278465, '张楚涵', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张楚涵', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 113, 112, 20, 0, 112, NULL, '625c086f82e9ae46a3edcbe3092578fe', '8zIfeX', 1, NULL, NULL, 1493278507, 1493278507, '岳洪岩', '', '116.22.163.229', 0, '无法获取', 15998056969, 0, '', '岳洪岩', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 114, 119, 20, 0, 119, NULL, 'c657159350bda54f73bbf9ebebb595c4', 'QU3b21', 1, NULL, NULL, 1493278552, 1493278987, '张宁', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张宁', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 115, 114, 20, 0, 114, NULL, 'fe55290da587bcef72f6307ee955b22b', 'cKJEkw', 1, NULL, NULL, 1493278634, 1493278634, '王慧良', '', '116.22.163.229', 0, '无法获取', 15942242499, 0, '', '王慧良', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 116, 115, 20, 0, 115, NULL, 'a408b76a370a3691ded930cd1392816f', 'khEVlj', 1, NULL, NULL, 1493278674, 1493278674, '吴寿鹏', '', '116.22.163.229', 0, '无法获取', 13711748758, 0, '', '吴寿鹏', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 117, 113, 20, 0, 113, NULL, '451e6e91ecce77f8b2bd148fa20f621b', 'UCL9wj', 1, NULL, NULL, 1493278765, 1493278765, '岳春波', '', '116.22.163.229', 0, '无法获取', 13019633397, 0, '', '岳春波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 118, 116, 20, 0, 116, NULL, 'e7df82b2f3af2627281e027f02b0ba38', 'thIBMD', 1, NULL, NULL, 1493278846, 1493278846, '张绍良', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张绍良', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 119, 117, 20, 0, 117, NULL, '8cbf476669b63c2b62e337e9a576b030', 'BXaF5d', 1, NULL, NULL, 1493278898, 1493278898, '陈馨', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '陈馨', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 120, 118, 20, 0, 118, NULL, 'ee88c56a28e16dbd96acaec90e1ca0cd', 'sHg1cU', 1, NULL, NULL, 1493278941, 1493278941, '张伟源', '', '116.22.163.229', 0, '无法获取', 13751880662, 0, '', '张伟源', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 121, 120, 16, 0, 120, NULL, '7fc99a2f9fbe8a20bcdb546a7ff289e2', 'gMitED', 1, NULL, NULL, 1493279025, 1493279025, '周洪波', '', '116.22.163.229', 0, '无法获取', 13229316295, 0, '', '周洪波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 122, 121, 110, 0, 121, NULL, '11fdf332af6057686fa07b8418ffdc9a', 'TYBiRV', 2, 1493289324, NULL, 1493279068, 1493289324, '林树权', '', '116.22.163.229', 0, '无法获取', 15542649808, 0, '', '林树权', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 123, 122, 13, 0, 122, NULL, '101029c8c06a81840ea3c6762eddad87', 'ntvNDy', 2, 1493289308, NULL, 1493279112, 1493289308, '金秋波', '', '116.22.163.229', 0, '无法获取', 13104190022, 0, '', '金秋波', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 124, 123, 18, 0, 123, NULL, '3fee59e72130c3376423932718f1ab62', 'NdwzAu', 1, NULL, NULL, 1493279164, 1493279164, '吴珂尘', '', '116.22.163.229', 0, '无法获取', 15899567023, 0, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 125, 124, 18, 0, 124, NULL, '7a5e1e49ddcb90e77eb7bfb711faed08', 'GZDE5f', 1, NULL, NULL, 1493279201, 1493279201, '吴珂尘', '', '116.22.163.229', 0, '无法获取', 15899567023, 0, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 126, 125, 18, 0, 125, NULL, '44fc39f554904364d20f78e2c75ca4e0', 'EKcNad', 1, NULL, NULL, 1493279235, 1493279235, '吴珂尘', '', '116.22.163.229', 0, '无法获取', 15899567023, 0, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 127, 126, 18, 0, 126, NULL, '5515f4c332d40b2fb476dbfd57ba1180', 'TcJCbG', 1, NULL, NULL, 1493279269, 1493279269, '吴珂尘', '', '116.22.163.229', 0, '无法获取', 15899567023, 0, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 128, 127, 18, 0, 127, NULL, '657df81c47508cd9d454a5b453f29f4f', 'U5CNHB', 1, NULL, NULL, 1493279309, 1493279309, '吴珂尘', '', '116.22.163.229', 0, '无法获取', 15899567023, 0, '', '吴珂尘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 129, 128, 18, 0, 128, NULL, '10bc9d12f3c4bf87b903d876fda301f9', 'MQjE8q', 1, NULL, NULL, 1493279353, 1493279353, '吴普升', '', '116.22.163.229', 0, '无法获取', 18992871078, 0, '', '吴普升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 130, 129, 18, 0, 129, NULL, '1811603b13262c0eae551346bf18f884', 'D7v4tF', 1, NULL, NULL, 1493279401, 1493279401, '吴普升', '', '116.22.163.229', 0, '无法获取', 18992871078, 0, '', '吴普升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 131, 130, 18, 0, 130, NULL, '54e259bf3740b4c8fb611dd2f2217b84', 'XLBvBy', 1, NULL, NULL, 1493279444, 1493279444, '吴普升', '', '116.22.163.229', 0, '无法获取', 18992871078, 0, '', '吴普升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 132, 131, 18, 0, 131, NULL, '0d78c49b2b2621f071651588322ed083', 'CWDqvl', 1, NULL, NULL, 1493279494, 1493279494, '吴普升', '', '116.22.163.229', 0, '无法获取', 18992871078, 0, '', '吴普升', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 133, 132, 18, 0, 132, NULL, 'c95149e871c6b1ab41f9c289d3d8e6dc', 'IUdt6z', 1, NULL, NULL, 1493279549, 1493279549, '胡明贺', '', '116.22.163.229', 0, '无法获取', 18318683880, 0, '', '胡明贺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 134, 133, 10, 0, 133, NULL, 'c52d95ae4b691b93b8ca271ad861cca0', 'DGZ3qL', 1, NULL, NULL, 1493279601, 1493279601, '李攀美', '', '116.22.163.229', 0, '无法获取', 18670098076, 0, '', '李攀美', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 135, 134, 10, 0, 134, NULL, '5a24aa54d6eb58c90f3f7fbab9ec12b0', 'SEdUF4', 1, NULL, NULL, 1493279637, 1493279637, '罗海强', '', '116.22.163.229', 0, '无法获取', 13537443004, 0, '', '罗海强', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 136, 135, 66, 0, 135, NULL, 'a9ce3ef0eacff86b78ac0093901a2e61', 'lJJNvt', 1, NULL, NULL, 1493279701, 1493279701, '申海飞', '', '116.22.163.229', 0, '无法获取', 18688446414, 0, '', '申海飞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 137, 136, 8, 0, 136, NULL, 'a307a38355fca34ec292b0b8b870a6ac', 'RduLTN', 1, NULL, NULL, 1493279737, 1493279737, '林影霞', '', '116.22.163.229', 0, '无法获取', 13662548023, 0, '', '林影霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 138, 137, 8, 0, 137, NULL, '6be7257bce70f2b191ef27a27aa9b560', 'LuhAKC', 1, NULL, NULL, 1493279773, 1493279773, '姚美英', '', '116.22.163.229', 0, '无法获取', 13935090767, 0, '', '姚美英', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 139, 138, 8, 0, 138, NULL, 'cf75d9267a5c5e2fb60404a5bd59a9e0', 'ESmed2', 1, NULL, NULL, 1493279815, 1493279815, '姚喜春', '', '116.22.163.229', 0, '无法获取', 13934857865, 0, '', '姚喜春', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 140, 139, 8, 0, 139, NULL, 'ba05e0d9e200e337b9da97b809c48903', 'BItR9W', 1, NULL, NULL, 1493279851, 1493279851, '安文芝', '', '116.22.163.229', 0, '无法获取', 18553840507, 0, '', '安文芝', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 141, 140, 8, 0, 140, NULL, '33c34181f787bf8dd7917771f10d6fa3', 'ffz7mi', 1, NULL, NULL, 1493279891, 1493279891, '张俊武', '', '116.22.163.229', 0, '无法获取', 15820232993, 0, '', '张俊武', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 142, 141, 9, 0, 141, NULL, 'a02eb01a14d98b9684bc45a88e5b6e2e', 'r4QuuK', 2, 1493289288, NULL, 1493279965, 1493289288, '史海妹', '', '116.22.163.229', 0, '无法获取', 13725397878, 0, '', '史海妹', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 143, 142, 12, 0, 142, NULL, '27d32e7e6750b2e0f5118b75b4b031e9', 'yMSu6d', 2, 1493289267, NULL, 1493280012, 1493289267, '米丽先', '', '116.22.163.229', 0, '无法获取', 15102092036, 0, '', '米丽先', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 144, 143, 12, 0, 143, NULL, '17b1a9d569145e0e0f26c55ccbbc0c24', 'NhEcV8', 1, NULL, NULL, 1493280054, 1493280054, '高瑗', '', '116.22.163.229', 0, '无法获取', 13763372113, 0, '', '高瑗', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 145, 144, 12, 0, 144, NULL, '07c71cbd22dff76eb204dcf92c52e5c3', 'ctBHet', 1, NULL, NULL, 1493280091, 1493280091, '马辉', '', '116.22.163.229', 0, '无法获取', 18588871123, 0, '', '马辉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 146, 145, 12, 0, 145, NULL, '044b1f1241d012384fc9a2900b7cc3b1', '1WGHae', 1, NULL, NULL, 1493280174, 1493280174, '薛倩婷', '', '116.22.163.229', 0, '无法获取', 13910387369, 0, '', '薛倩婷', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 147, 146, 12, 0, 146, NULL, 'bd06044f2142b4b3643da3b8e318857c', 'wjcSBy', 1, NULL, NULL, 1493280206, 1493280206, '高凤兰', '', '116.22.163.229', 0, '无法获取', 13945478977, 0, '', '高凤兰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 148, 147, 12, 0, 147, NULL, '81556256e9acc27765ccf38191bcd2e9', 'VlBGKY', 1, NULL, NULL, 1493280240, 1493280240, '邵双双', '', '116.22.163.229', 0, '无法获取', 13538833116, 0, '', '邵双双', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 149, 148, 12, 0, 148, NULL, '2a68800a57ac64f54c18e4fe701a63be', 'kEB5Gp', 1, NULL, NULL, 1493280281, 1493280281, '邵盼盼', '', '116.22.163.229', 0, '无法获取', 18738569109, 0, '', '邵盼盼', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 150, 149, 12, 0, 149, NULL, '7bffee203bdf1093d9e0820ea92d7a49', 'L7pdAG', 1, NULL, NULL, 1493280315, 1493280315, '邵蒙蒙', '', '116.22.163.229', 0, '无法获取', 13025183393, 0, '', '邵蒙蒙', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 151, 150, 12, 0, 150, NULL, '55023eaee240d5cb81f32940622f1e79', 'xbXfGX', 1, NULL, NULL, 1493280355, 1493280355, '邵丁丁', '', '116.22.163.229', 0, '无法获取', 13631412467, 0, '', '邵丁丁', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 152, 151, 12, 0, 151, NULL, '47ff9cf51f1241640a1a945ccf408b96', 'W6WQzf', 1, NULL, NULL, 1493280416, 1493280416, '邵鸿睿', '', '116.22.163.229', 0, '无法获取', 18688894788, 0, '', '邵鸿睿', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 153, 152, 12, 0, 152, NULL, '8788efb382b6eae79c5d482d79c3cc03', 'Pw67jk', 2, 1493289390, NULL, 1493280465, 1493289390, '何春莲', '', '116.22.163.229', 0, '无法获取', 13828415134, 0, '', '何春莲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 154, 153, 12, 0, 153, NULL, '1a2ccbd52a511edf70fef0e4541c76e5', 'fZujxX', 1, NULL, NULL, 1493280514, 1493280514, '尹香华', '', '116.22.163.229', 0, '无法获取', 13902283586, 0, '', '尹香华', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 155, 154, 12, 0, 154, NULL, '0f0bcdddf0853ce9b4caf4aa70be0b57', 'ySlt6F', 2, 1493289376, NULL, 1493280551, 1493289376, '欧阳兵', '', '116.22.163.229', 0, '无法获取', 13509024667, 0, '', '欧阳兵', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 156, 155, 12, 0, 155, NULL, 'be657c1de258f09edd2695e6924a875b', 's3kcuf', 1, NULL, NULL, 1493280591, 1493280591, '肖勇', '', '116.22.163.229', 0, '无法获取', 18627833789, 0, '', '肖勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 157, 156, 12, 0, 156, NULL, 'a196652f7949bf1c115f37374756acd0', '1xUauW', 1, NULL, NULL, 1493280626, 1493280626, '范水平', '', '116.22.163.229', 0, '无法获取', 15902096096, 0, '', '范水平', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 158, 157, 12, 0, 157, NULL, '6865391e5722b460939450468de484cd', 'fmV2ag', 1, NULL, NULL, 1493280660, 1493280660, '邵会峰', '', '116.22.163.229', 0, '无法获取', 13016069718, 0, '', '邵会峰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 159, 158, 12, 0, 158, NULL, 'bc45b7a164df8a13760bc80e38d95cb1', 'zfjB68', 2, 1493280712, NULL, 1493280712, 1493280712, '徐泽荣', '', '116.22.163.229', 0, '无法获取', 17760782628, 0, '', '徐泽荣', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 160, 159, 159, 0, 159, NULL, 'c55e00e68067aad9bcdf759c278d6d80', '5KZWHJ', 2, 1493280892, NULL, 1493280768, 1493280892, '尚世国', '', '116.22.163.229', 0, '无法获取', 13503864599, 0, '', '尚世国', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 161, 160, 79, 0, 160, NULL, '7ae8909366c2bb6a82e095cae44f5ca7', 'D3rFna', 1, NULL, NULL, 1493280810, 1493280810, '黄松坚', '', '116.22.163.229', 0, '无法获取', 13542404673, 0, '', '黄松坚', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 162, 161, 66, 0, 161, NULL, '2fb9b2e0775e3e5301238280852dd36c', 'ufLBcn', 1, NULL, NULL, 1493280880, 1493280880, '许文彬', '', '116.22.163.229', 0, '无法获取', 13826198715, 0, '', '许文彬', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 163, 162, 66, 0, 162, NULL, '34b43c27cf33350148d2792ea779971c', 'uTgECQ', 1, NULL, NULL, 1493280944, 1493280944, '黄秋香', '', '116.22.163.229', 0, '无法获取', 13875284182, 0, '', '黄秋香', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 164, 163, 66, 0, 163, NULL, '6b55c55451eb2404c75479b52308a9a6', 'TIDTf6', 1, NULL, NULL, 1493280985, 1493280985, '黄爱湘', '', '116.22.163.229', 0, '无法获取', 13875214894, 0, '', '黄爱湘', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 165, 164, 83, 0, 164, NULL, '606e6607cb7ae26bf74af764af2d737c', 'Smf31f', 1, NULL, NULL, 1493281030, 1493281030, '覃福静', '', '116.22.163.229', 0, '无法获取', 15019671783, 0, '', '覃福静', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 166, 165, 34, 0, 165, NULL, 'ffb0a6e2335dfb5b845eb519df7e183d', 'ZBTRkQ', 1, NULL, NULL, 1493281069, 1493281069, '黄林勇', '', '116.22.163.229', 0, '无法获取', 13542489681, 0, '', '黄林勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 167, 166, 166, 0, 166, NULL, '0b06c4c139d2893c719256f60af58913', 'KtdvBD', 1, NULL, NULL, 1493281105, 1493281105, '黄林银', '', '116.22.163.229', 0, '无法获取', 15768028629, 0, '', '黄林银', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 168, 167, 9, 0, 167, NULL, 'ef28c14e0094de628d6637943c65665c', 'w3WbTp', 1, NULL, NULL, 1493281141, 1493281141, '范汉菊', '', '116.22.163.229', 0, '无法获取', 13903062769, 0, '', '范汉菊', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 169, 168, 9, 0, 168, NULL, '487ab631818a0aa63cfee3bdb4481139', 'MyPAXN', 1, NULL, NULL, 1493281183, 1493281183, '陈本照', '', '116.22.163.229', 0, '无法获取', 13697429128, 0, '', '陈本照', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 170, 169, 9, 0, 169, NULL, '40a4b68f3b3da319fa302145cb856768', 'pT9rKu', 1, NULL, NULL, 1493281220, 1493281220, '陈本照', '', '116.22.163.229', 0, '无法获取', 13697429128, 0, '', '陈本照', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 171, 170, 9, 0, 170, NULL, '9a178519b16bf1a32231c7beed955e7a', '8JfVV2', 1, NULL, NULL, 1493281255, 1493281255, '陈本照', '', '116.22.163.229', 0, '无法获取', 13697429128, 0, '', '陈本照', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 172, 171, 19, 0, 171, NULL, 'bc9fbfcf8694e5062b99158c1a31543a', 'mYf2MN', 1, NULL, NULL, 1493281297, 1493281297, '廖伟灿', '', '116.22.163.229', 0, '无法获取', 15937659996, 0, '', '廖伟灿', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 173, 172, 23, 0, 172, NULL, '2421089271822a499699ad8102a577f2', 'mPNrlu', 1, NULL, NULL, 1493281341, 1493281341, '冯紫龙', '', '116.22.163.229', 0, '无法获取', 18502086282, 0, '', '冯紫龙', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 174, 173, 9, 0, 173, NULL, '0010898d4584b0a49f80b13c7e517d36', 'd5QgFC', 1, NULL, NULL, 1493281375, 1493281375, '吴春发', '', '116.22.163.229', 0, '无法获取', 18802086428, 0, '', '吴春发', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 175, 174, 43, 0, 174, NULL, '95c34d393b6d317d0906cce308ad0833', 'a182R2', 1, NULL, NULL, 1493281409, 1493281409, '吴江兴', '', '116.22.163.229', 0, '无法获取', 18925002813, 0, '', '吴江兴', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 176, 175, 34, 0, 175, NULL, '22b9320910dd9ac3936892eab874d312', 'r5e48s', 2, 1493281450, NULL, 1493281450, 1493281450, '陈汉荣', '', '116.22.163.229', 0, '无法获取', 15800031378, 0, '', '陈汉荣', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 177, 176, 124, 0, 176, NULL, '67145f57c5195b5b0fcc92e958ec7c54', 'Ks8ZJr', 1, NULL, NULL, 1493281495, 1493281495, '黄兆凡', '', '116.22.163.229', 0, '无法获取', 13929066112, 0, '', '黄兆凡', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 178, 177, 83, 0, 177, NULL, 'dea08c62214f0e5f8a955725496883c1', 'uZVrBU', 1, NULL, NULL, 1493281532, 1493281532, '覃妹红', '', '116.22.163.229', 0, '无法获取', 13728147248, 0, '', '覃妹红', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 179, 178, 159, 0, 178, NULL, '5225ad2ef76edcce9142771151e447fb', 'a9ddXh', 3, NULL, 1493281600, 1493281600, 1493281600, '尚徐曼', '', '116.22.163.229', 0, '无法获取', 13526642919, 0, '', '尚徐曼', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 180, 179, 159, 0, 179, NULL, '5e77358bbb59a88df804e959a6e3d47c', 'Ncyd89', 1, NULL, NULL, 1493281650, 1493281650, '尚瑞曼', '', '116.22.163.229', 0, '无法获取', 18638536855, 0, '', '尚瑞曼', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 181, 180, 66, 0, 180, NULL, '5ab71b283657de5d02cda2ffcafc3118', 'YNqa7T', 1, NULL, NULL, 1493281693, 1493281693, '郑庆环', '', '116.22.163.229', 0, '无法获取', 13828447033, 0, '', '郑庆环', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 182, 181, 66, 0, 181, NULL, 'f0fd80a7de54eba3b3c152250ae4eb5e', 'PNrjI8', 2, 1493288283, NULL, 1493281731, 1493288283, '刘永清', '', '116.22.163.229', 0, '无法获取', 18124289507, 0, '', '刘永清', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 183, 182, 66, 0, 182, NULL, 'dcf9f516b1f9e228f03ce7c886a566ce', 'BHTuif', 1, NULL, NULL, 1493281776, 1493281776, '王神德', '', '116.22.163.229', 0, '无法获取', 13828524984, 0, '', '王神德', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 184, 183, 51, 0, 183, NULL, '34d195cebb88352d5e04b6a43fb726fd', '9niLR6', 1, NULL, NULL, 1493281817, 1493281817, '朱银坡', '', '116.22.163.229', 0, '无法获取', 15768240597, 0, '', '朱银坡', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 185, 184, 22, 0, 184, NULL, 'fd986a49df0be96590c20a0d5dbba64b', 'x1CRsb', 1, NULL, NULL, 1493281861, 1493281861, '陈除妹', '', '116.22.163.229', 0, '无法获取', 18476379429, 0, '', '陈除妹', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 186, 185, 16, 0, 185, NULL, 'c52fbd19b3f44cb041e92dc640c99a4c', 'wfIBar', 1, NULL, NULL, 1493281897, 1493281897, '杨鸿美', '', '116.22.163.229', 0, '无法获取', 18218227661, 0, '', '杨鸿美', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 187, 186, 107, 0, 186, NULL, 'd68da9aa3b4cf040ff26ba36deca91e9', 'GM29r9', 1, NULL, NULL, 1493281931, 1493281931, '邓小芳', '', '116.22.163.229', 0, '无法获取', 13825536536, 0, '', '邓小芳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 188, 187, 12, 0, 187, NULL, '8c1c4446c1cace4ac73149f0d063154f', 'bNvsDU', 1, NULL, NULL, 1493281974, 1493281974, '杨贤香', '', '116.22.163.229', 0, '无法获取', 13085471310, 0, '', '杨贤香', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 189, 188, 51, 0, 188, NULL, 'fdde195522f4a11e90507c778cd18a55', 'sjcJjz', 1, NULL, NULL, 1493282518, 1493282518, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 190, 189, 189, 0, 189, NULL, '16a6175440c94fa65f7f488514449bf6', '8UClTl', 1, NULL, NULL, 1493282591, 1493282591, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 191, 190, 189, 0, 190, NULL, '220e5c05900dde1c6bef04a9aef1c1dd', 'Pt5XRz', 1, NULL, NULL, 1493282641, 1493282641, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 192, 191, 189, 0, 191, NULL, 'c83661f25445e0708957d39cfbf027cc', '27GtWV', 1, NULL, NULL, 1493282683, 1493282683, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 193, 192, 189, 0, 192, NULL, '017c04b24757f64582bb1ac999a3e0b3', 'uh9tsD', 1, NULL, NULL, 1493282737, 1493282737, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 194, 193, 189, 0, 193, NULL, '097617e15dda2cb2fbe0ecb2653ec24a', '9SYBjf', 1, NULL, NULL, 1493282778, 1493282778, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 195, 194, 189, 0, 194, NULL, '11add8822101d3ca9ceb70bdaf2780af', 'va2XT6', 1, NULL, NULL, 1493283088, 1493283088, '张勇', '', '116.22.163.229', 0, '无法获取', 18628312068, 0, '', '张勇1', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 196, 195, 83, 0, 195, NULL, 'a68d7d4b192d40ccd25f3f23b29299ed', '6l5ujv', 1, NULL, NULL, 1493283176, 1493283176, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 197, 196, 83, 0, 196, NULL, 'e74952f949685a2c3fa5afeaa91fd066', 'qAg8yL', 1, NULL, NULL, 1493283228, 1493283228, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 198, 197, 83, 0, 197, NULL, '07034d3a5c31015f103957986d7c67df', 'mVcdr4', 1, NULL, NULL, 1493283268, 1493283268, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 199, 198, 83, 0, 198, NULL, 'ea71677b88de9c13ea0a031e828a0620', 'iAMtEl', 1, NULL, NULL, 1493283305, 1493283305, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 200, 199, 83, 0, 199, NULL, '07752c09347123a30ba9b7e1f5ef69ef', 'VIn79K', 1, NULL, NULL, 1493283379, 1493283379, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 201, 200, 83, 0, 200, NULL, 'a02f8adc908dffc516e69c04fdc7d1cc', 'FhFT7G', 1, NULL, NULL, 1493283471, 1493283471, '覃福旺', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '覃福旺1', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 202, 201, 83, 0, 201, NULL, '26b1e3197fd52431b96e2f5b87157357', 'lDWUjc', 1, NULL, NULL, 1493283518, 1493283518, '韦玉', '', '116.22.163.229', 0, '无法获取', 13710156935, 0, '', '韦玉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 203, 202, 83, 0, 202, NULL, 'c1edad51564de78143994b289826ca7b', 'wSA68c', 1, NULL, NULL, 1493283563, 1493283563, '韦玉', '', '116.22.163.229', 0, '无法获取', 13250271520, 0, '', '韦玉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 204, 203, 22, 0, 203, NULL, 'e21719f1ecb121d25635ad0aeffb73df', 'sb4sXB', 1, NULL, NULL, 1493283606, 1493283606, '黄玉群', '', '116.22.163.229', 0, '无法获取', 13538980580, 0, '', '黄玉群', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 205, 204, 153, 0, 204, NULL, 'df1b994a04626466e9e7294293f6a231', 'LftYdn', 1, NULL, NULL, 1493283652, 1493283652, '杨国耀', '', '116.22.163.229', 0, '无法获取', 13286812282, 0, '', '杨国耀', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 206, 205, 4, 0, 205, NULL, '876ac976ada52f10dc8c4728627eb8cc', '4jM3D1', 1, NULL, NULL, 1493283690, 1493283690, '陈继才', '', '116.22.163.229', 0, '无法获取', 13710473484, 0, '', '陈继才', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 207, 206, 4, 0, 206, NULL, '6037908223fb775fc97ad4486bc1480b', 'VKYuik', 1, NULL, NULL, 1493283729, 1493283729, '张爱明', '', '116.22.163.229', 0, '无法获取', 13928808411, 0, '', '张爱明', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 208, 207, 4, 0, 207, NULL, 'cc470a858c97764a1e02b195d65a1abc', 'EDaqAY', 1, NULL, NULL, 1493283774, 1493283774, '陈珍广', '', '116.22.163.229', 0, '无法获取', 13711567529, 0, '', '陈珍广', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 209, 208, 185, 0, 208, NULL, '7d0d04515a6a3bf5ca7b94904c159bee', 'ALpUlS', 1, NULL, NULL, 1493283815, 1493283815, '陈除妹', '', '116.22.163.229', 0, '无法获取', 18476379429, 0, '', '陈除妹', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 210, 209, 155, 0, 209, NULL, '18b6a6ccf4eae9333b79d4b3508b4e75', 'UJNaw5', 1, NULL, NULL, 1493283855, 1493283855, '卢飞', '', '116.22.163.229', 0, '无法获取', 13926215586, 0, '', '卢飞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 211, 210, 9, 0, 210, NULL, 'bac7e88f732f4c3b648a3024c221d12d', 'lDANIL', 1, NULL, NULL, 1493283903, 1493283903, '何伟丽', '', '116.22.163.229', 0, '无法获取', 13570502179, 0, '', '何伟丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 212, 211, 48, 0, 211, NULL, 'fe6a4d176d3e8c8145e31b3039e0e9d0', 'PvAm8b', 1, NULL, NULL, 1493283948, 1493283948, '袁瑞良', '', '116.22.163.229', 0, '无法获取', 13763318736, 0, '', '袁瑞良', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 213, 212, 159, 0, 212, NULL, 'd2b39947f29751bea0fb5c47375c3eb6', 'KBWuSI', 1, NULL, NULL, 1493284011, 1493284011, '霍清俊', '', '116.22.163.229', 0, '无法获取', 15037891557, 0, '', '霍清俊', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 214, 213, 159, 0, 213, NULL, 'e02639cd0b54ab02d00e5cdcd4a3bc03', 'W5qfKZ', 1, NULL, NULL, 1493284052, 1493284052, '范念莲', '', '116.22.163.229', 0, '无法获取', 13937852668, 0, '', '范念莲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 215, 214, 159, 0, 214, NULL, '08127a9cccabac95625597e4d20465f9', 'Fmt8UK', 1, NULL, NULL, 1493284090, 1493284090, '周书连', '', '116.22.163.229', 0, '无法获取', 13723277620, 0, '', '周书连', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 216, 215, 159, 0, 215, NULL, 'de3b83d45a860e5854abb5e3427b067a', 'Bsb1EC', 1, NULL, NULL, 1493284137, 1493284137, '袁连香', '', '116.22.163.229', 0, '无法获取', 15938565131, 0, '', '袁连香', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 217, 216, 12, 0, 216, NULL, '6f784c53dfbe441b08f4ff71e298c86a', 'JTEnxT', 1, NULL, NULL, 1493284182, 1493284182, '陈嘉敏', '', '116.22.163.229', 0, '无法获取', 13822113809, 0, '', '陈嘉敏', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 218, 217, 2, 0, 217, NULL, '0c046d9d11e31cc6f90d85db9e1302dd', 'D5TBGW', 1, NULL, NULL, 1493284222, 1493284222, '解达伟', '', '116.22.163.229', 0, '无法获取', 13331110888, 0, '', '解达伟', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 219, 218, 218, 0, 218, NULL, '393d6f2ae683f051687a761fdb6b2976', 'raUexS', 1, NULL, NULL, 1493284266, 1493284266, '李国斌', '', '116.22.163.229', 0, '无法获取', 13522234888, 0, '', '李国斌', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 220, 219, 144, 0, 219, NULL, 'cac6c5e0ed8a160abaff3c334f57263d', 'c1zPKJ', 1, NULL, NULL, 1493284312, 1493284312, '王汝卉', '', '116.22.163.229', 0, '无法获取', 18902220619, 0, '', '王汝卉', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 221, 220, 144, 0, 220, NULL, '20f9be36164b4e52051ba32f2af0fc3f', 'd7Z52V', 1, NULL, NULL, 1493284353, 1493284353, '汪家', '', '116.22.163.229', 0, '无法获取', 13535504504, 0, '', '汪家', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 222, 221, 219, 0, 221, NULL, '07e86438624b1239ad973e4d5f962ce3', 'kj2Uib', 1, NULL, NULL, 1493284393, 1493284393, '路鑫', '', '116.22.163.229', 0, '无法获取', 13911255412, 0, '', '路鑫', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 223, 222, 218, 0, 222, NULL, 'c940c1cf426afc993595c7aaf3572d85', 'E1uLSB', 1, NULL, NULL, 1493284449, 1493284449, '魏婷婷', '', '116.22.163.229', 0, '无法获取', 15034366672, 0, '', '魏婷婷', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 224, 223, 17, 0, 223, NULL, '6b1af7f18c0ce46199db6918e058e0b3', '6U8KY7', 1, NULL, NULL, 1493284496, 1493284496, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 225, 224, 17, 0, 224, NULL, '248070cac06e54d876b2d49a769af8a1', '9hBthH', 1, NULL, NULL, 1493284531, 1493284531, '郭金凤', '', '116.22.163.229', 0, '无法获取', 13556577278, 0, '', '郭金凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 226, 225, 17, 0, 225, NULL, '2ef4db7557e70f81afa01df70876cde9', 'iCmfQB', 1, NULL, NULL, 1493284589, 1493284589, '梁桂凤', '', '116.22.163.229', 0, '无法获取', 13428928134, 0, '', '梁桂凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 227, 226, 12, 0, 226, NULL, '85ffbac1c05c5c38aed69c742a1f5792', 'vbMius', 1, NULL, NULL, 1493284628, 1493284628, '刘美', '', '116.22.163.229', 0, '无法获取', 13983904338, 0, '', '刘美', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 228, 227, 218, 0, 227, NULL, '7af909f47e72eed7df92bceb72e99109', 'I2diH3', 1, NULL, NULL, 1493284671, 1493284671, '曾庆杰', '', '116.22.163.229', 0, '无法获取', 18931888598, 0, '', '曾庆杰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 229, 228, 218, 0, 228, NULL, '60f0cee738d2a10d9edb1655caa0b12f', 'DfHxBd', 1, NULL, NULL, 1493284726, 1493284726, '葛楠楠', '', '116.22.163.229', 0, '无法获取', 18911088237, 0, '', '葛楠楠', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 230, 229, 108, 0, 229, NULL, '1790b359d1005f5a3397da81ae8169bd', '2TGa8g', 1, NULL, NULL, 1493284764, 1493288441, '韩圣利', '', '116.22.163.229', 0, '无法获取', 13840760556, 0, '', '韩圣利', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 231, 230, 3, 0, 230, NULL, '659e8501dd2ef9d1f86aff2be1114777', 'iLpnm2', 1, NULL, NULL, 1493284803, 1493284803, '梁影珊', '', '116.22.163.229', 0, '无法获取', 18028648793, 0, '', '梁影珊', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 232, 231, 231, 0, 231, NULL, 'be928fc106c94c94c0c3b8fee96e2e26', 'mLxdPQ', 1, NULL, NULL, 1493284852, 1493284852, '韦俊挺', '', '116.22.163.229', 0, '无法获取', 13710513262, 0, '', '韦俊挺', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 233, 232, 144, 0, 232, NULL, 'de9e38ceb23a7ae9a92c915a745853f3', 'QcyFVt', 1, NULL, NULL, 1493284901, 1493284901, '赵晶彦', '', '116.22.163.229', 0, '无法获取', 13512645399, 0, '', '赵晶彦', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 234, 233, 160, 0, 233, NULL, 'f96e7f051c7df9041008de0b9f4f2a64', 'AcKBvw', 1, NULL, NULL, 1493284941, 1493284941, '蔡吉凤', '', '116.22.163.229', 0, '无法获取', 13837888011, 0, '', '蔡吉凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 235, 234, 160, 0, 234, NULL, '88248ff096489c5f8b94c36788372949', 'CMcbUm', 1, NULL, NULL, 1493284982, 1493284982, '邵元治', '', '116.22.163.229', 0, '无法获取', 13837862059, 0, '', '邵元治', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 236, 235, 187, 0, 235, NULL, '8937546391a0483302ad0435f4c5a381', 'bZ5Abw', 1, NULL, NULL, 1493285058, 1493285058, '余勇', '', '116.22.163.229', 0, '无法获取', 18638296068, 0, '', '余勇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 237, 236, 17, 0, 236, NULL, '2b9dcb9d08cf29cbca6de75180a0166c', 'X6RNFW', 1, NULL, NULL, 1493285099, 1493285099, '何锐英', '', '116.22.163.229', 0, '无法获取', 13556529335, 0, '', '何锐英', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 238, 237, 159, 0, 237, NULL, '357027902ca62cb438dac7e05456bc78', '1qHceB', 1, NULL, NULL, 1493285151, 1493285151, '孔令霞', '', '116.22.163.229', 0, '无法获取', 15516156696, 0, '', '孔令霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 239, 238, 159, 0, 238, NULL, 'fa2548dd5f06fe4d55b04819cc2d4d0a', '4Gj6S1', 2, 1493285202, NULL, 1493285191, 1493285202, '赵军', '', '116.22.163.229', 0, '无法获取', 15037878166, 0, '', '赵军', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 240, 239, 179, 0, 239, NULL, 'd6276f18253737a79641551f3194a0aa', 'VLnTAZ', 1, NULL, NULL, 1493285250, 1493285250, '候艳平', '', '116.22.163.229', 0, '无法获取', 18638530677, 0, '', '候艳平', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 241, 240, 153, 0, 240, NULL, 'f7af96bc80a26793cbc43489e60ef3f5', 'Ylep9m', 1, NULL, NULL, 1493285294, 1493285294, '周紫薇', '', '116.22.163.229', 0, '无法获取', 13922486134, 0, '', '周紫薇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 242, 241, 159, 0, 241, NULL, 'd97567bdd46b75a2678b6e56f64a59c2', '79llhJ', 1, NULL, NULL, 1493285339, 1493285339, '吴松花', '', '116.22.163.229', 0, '无法获取', 13303838979, 0, '', '吴松花', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 243, 242, 159, 0, 242, NULL, '9b2986c22aeac7dab7f664adc131e87d', 'g1hv6G', 1, NULL, NULL, 1493285381, 1493285381, '袁扶', '', '116.22.163.229', 0, '无法获取', 13937871780, 0, '', '袁扶', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 244, 243, 159, 0, 243, NULL, '812441e7d63f1bb2e4144965a0e80291', 'JqPC3e', 1, NULL, NULL, 1493285424, 1493285424, '张凤玲', '', '116.22.163.229', 0, '无法获取', 13937871780, 0, '', '张凤玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 245, 244, 16, 0, 244, NULL, '5055321370de216a73f7b8ac0cae97cf', '5diiqI', 1, NULL, NULL, 1493285467, 1493285467, '徐笑雪', '', '116.22.163.229', 0, '无法获取', 17820132891, 0, '', '徐笑雪', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 246, 245, 159, 0, 245, NULL, 'fdf29111cd63e8f33bd2bf9dd8948f12', '4KnhtG', 1, NULL, NULL, 1493285507, 1493285507, '徐淑霞', '', '116.22.163.229', 0, '无法获取', 15649511656, 0, '', '徐淑霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 247, 246, 159, 0, 246, NULL, 'e30f3f708d901402147b7dad6205c875', 'wYkChs', 1, NULL, NULL, 1493285559, 1493285559, '徐凤真', '', '116.22.163.229', 0, '无法获取', 15839259711, 0, '', '徐凤真', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 248, 247, 159, 0, 247, NULL, '202fb887995972a7c15d55bac96f389d', 'SPb2ih', 1, NULL, NULL, 1493285593, 1493285593, '杨德华', '', '116.22.163.229', 0, '无法获取', 13523786478, 0, '', '杨德华', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 249, 248, 179, 0, 248, NULL, '1cfede74b24659a6d1f9e28347369660', 'cnZV8c', 1, NULL, NULL, 1493285637, 1493285637, '张世凡', '', '116.22.163.229', 0, '无法获取', 18903856910, 0, '', '张世凡', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 250, 249, 29, 0, 249, NULL, '1268d07ba01e2ffcab481476f1a9983a', 'nC3fsJ', 1, NULL, NULL, 1493285675, 1493285675, '李伟', '', '116.22.163.229', 0, '无法获取', 15773847009, 0, '', '李伟', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 251, 250, 29, 0, 250, NULL, '478e80460fac098838655dc30d67e0d8', 'YeCDaa', 1, NULL, NULL, 1493285713, 1493285713, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 252, 251, 29, 0, 251, NULL, '248818ce1ece720d80f85fe939759ab2', '18JA2D', 1, NULL, NULL, 1493285754, 1493285754, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 253, 252, 29, 0, 252, NULL, '4b3566fad6028de6c341f221d182c833', 'ZFLb6N', 1, NULL, NULL, 1493285792, 1493285792, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 254, 253, 29, 0, 253, NULL, '7e12f3b6abc6a4c6e5f53a7e19230d99', '2IhNAr', 1, NULL, NULL, 1493285822, 1493285822, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 255, 254, 29, 0, 254, NULL, '2713a5755e6e8cc53d6224bc98f16ae2', 'f14bl9', 1, NULL, NULL, 1493285854, 1493285854, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 256, 255, 29, 0, 255, NULL, 'e58e397a1efd498503778c65b4de71be', 'C4irrn', 1, NULL, NULL, 1493285893, 1493285893, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 257, 256, 153, 0, 256, NULL, '1839f60ebe8fb28971e7b2a80510a7a7', 'l8X1iz', 1, NULL, NULL, 1493285932, 1493285932, '沈广平', '', '116.22.163.229', 0, '无法获取', 13826143199, 0, '', '沈广平', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 258, 257, 109, 0, 257, NULL, 'f1b256f71de9f6d4babd748a27d8f1bd', 'EJxcNv', 1, NULL, NULL, 1493285976, 1493288495, '高铭', '', '116.22.163.229', 0, '无法获取', 18618307133, 0, '', '高铭', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 259, 258, 204, 0, 258, NULL, '9e76237085725a8bdd6721f56308c0ad', 'BuEc74', 1, NULL, NULL, 1493286015, 1493286015, '黄玉群', '', '116.22.163.229', 0, '无法获取', 13538980580, 0, '', '黄玉群', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 260, 259, 247, 0, 259, NULL, '7901f5651ba41839059d9add6d3d8392', 'CfLRgU', 1, NULL, NULL, 1493286057, 1493286057, '韩瀟琦', '', '116.22.163.229', 0, '无法获取', 15039228751, 0, '', '韩瀟琦', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 261, 260, 43, 0, 260, NULL, 'd3ae27389accda7af5f66219658c9df8', 'GwFBci', 1, NULL, NULL, 1493286101, 1493286101, '谭凤银', '', '116.22.163.229', 0, '无法获取', 13682263228, 0, '', '谭凤银', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 262, 261, 261, 0, 261, NULL, '8680ee2f2ac62eb38f4b6e900fa242bb', '8dTt27', 1, NULL, NULL, 1493286145, 1493286145, '谭凤银', '', '116.22.163.229', 0, '无法获取', 13682263228, 0, '', '谭凤银', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 263, 262, 179, 0, 262, NULL, 'c8e6eea74bca2c073ad248a8b83973b1', 'CtMzP7', 1, NULL, NULL, 1493286182, 1493286182, '王丽丽', '', '116.22.163.229', 0, '无法获取', 13276906674, 0, '', '王丽丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 264, 263, 19, 0, 263, NULL, 'e409197791311b8d8dff6b073d6d8fc7', 'GLPe4j', 1, NULL, NULL, 1493286225, 1493286225, '张翠霞', '', '116.22.163.229', 0, '无法获取', 1509999065, 0, '', '张翠霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 265, 264, 29, 0, 264, NULL, '1397c61417a1cbc68ea250d2e908c2a8', 'TijAJZ', 1, NULL, NULL, 1493286301, 1493286301, '刘彩霞', '', '116.22.163.229', 0, '无法获取', 13928830967, 0, '', '刘彩霞1', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 266, 265, 144, 0, 265, NULL, 'ef654f988fef25ef23f8287bfc61c88f', 'fuSTgC', 1, NULL, NULL, 1493286336, 1493286336, '张晓龙', '', '116.22.163.229', 0, '无法获取', 18218709656, 0, '', '张晓龙', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 267, 266, 17, 0, 266, NULL, '4aa361a33d858da9c04ee9c4dc277782', '6yVhZX', 1, NULL, NULL, 1493286410, 1493286410, '梁兰凤', '', '116.22.163.229', 0, '无法获取', 13660051828, 0, '', '梁兰凤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 268, 267, 17, 0, 267, NULL, '29d28fdf103b4b8e93f4d76553b245a0', '9pn4Kx', 1, NULL, NULL, 1493286450, 1493286450, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 269, 268, 17, 0, 268, NULL, 'a4b4a0637baae402ea72f8ef58e9ccc5', 'jhXQ1K', 1, NULL, NULL, 1493286483, 1493286483, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 270, 269, 17, 0, 269, NULL, '37dc8536d8b3425d798245ded9789f50', 'wYwkwQ', 1, NULL, NULL, 1493286526, 1493286526, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 271, 270, 17, 0, 270, NULL, '62f2fde12a8174ed3950903430197d5d', 'a9dQN3', 1, NULL, NULL, 1493286567, 1493286567, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 272, 271, 17, 0, 271, NULL, '0f888fc7bd5d4f153663d884f976be45', 'Mv9RMp', 1, NULL, NULL, 1493286614, 1493286614, '郭永光', '', '116.22.163.229', 0, '无法获取', 15818840073, 0, '', '郭永光', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 273, 272, 144, 0, 272, NULL, 'edec3fd888698c382b034c7ffaa73741', '7k8b76', 1, NULL, NULL, 1493286655, 1493286655, '何翠玲', '', '116.22.163.229', 0, '无法获取', 13686799168, 0, '', '何翠玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 274, 273, 144, 0, 273, NULL, '0eb3b9c49223dd0d2a47c3a61e782387', 'GefvJU', 1, NULL, NULL, 1493286697, 1493286697, '凌秀芬', '', '116.22.163.229', 0, '无法获取', 13986426627, 0, '', '凌秀芬', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 275, 274, 4, 0, 274, NULL, '73120adf50702b20da8566a2a0735e49', '94qmqt', 1, NULL, NULL, 1493286738, 1493286738, '冯世志', '', '116.22.163.229', 0, '无法获取', 13822262895, 0, '', '冯世志', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 276, 275, 204, 0, 275, NULL, '1fa84ca9416cb312fb3ea29696c5c830', 'BFDK6Q', 1, NULL, NULL, 1493286777, 1493288889, '谢冬秀', '', '116.22.163.229', 0, '无法获取', 13660762960, 0, '', '谢冬秀', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 277, 276, 179, 0, 276, NULL, '82052ff49e74962d3ca879d48769be95', '2KnMlk', 1, NULL, NULL, 1493286837, 1493286837, '张万兰', '', '116.22.163.229', 0, '无法获取', 13346689518, 0, '', '张万兰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 278, 277, 22, 0, 277, NULL, '4fde76dda9d8ba39c4b14a8388607ba0', 'VyudFh', 1, NULL, NULL, 1493286884, 1493286884, '龙丽群', '', '116.22.163.229', 0, '无法获取', 13672463982, 0, '', '龙丽群', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 279, 278, 58, 0, 278, NULL, '35bed50a32e4a224bad66aa1192206e1', 'LIUDJx', 1, NULL, NULL, 1493286918, 1493286918, '严仪君', '', '116.22.163.229', 0, '无法获取', 13244838050, 0, '', '严仪君', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 280, 279, 31, 0, 279, NULL, 'bb7e36580b6a8bf186b5b83cad0e8e6b', 'pE8D9f', 1, NULL, NULL, 1493286961, 1493286961, '吴东', '', '116.22.163.229', 0, '无法获取', 17763789715, 0, '', '吴东', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 281, 280, 160, 0, 280, NULL, '15e86b1a2dcc6c2c344b4189b38b6540', 'eVfFPZ', 1, NULL, NULL, 1493287003, 1493287003, '谢二英', '', '116.22.163.229', 0, '无法获取', 15896525481, 0, '', '谢二英', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 282, 281, 159, 0, 281, NULL, '1743f54cefd9c3ddb6dfc3b9299ea03c', 'VuJWLp', 2, 1493287073, NULL, 1493287073, 1493287073, '于果良', '', '116.22.163.229', 0, '无法获取', 15896692866, 0, '', '于果良', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 283, 282, 160, 0, 282, NULL, '8d2264ac7899843d58ae394f95fcb4b5', 'yw6VFt', 1, NULL, NULL, 1493287116, 1493287116, '柳安晴', '', '116.22.163.229', 0, '无法获取', 15136317071, 0, '', '柳安晴', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 284, 283, 159, 0, 283, NULL, '62cbffb441cc3f58546b7c1d97642534', 'BLTiwf', 2, 1493288215, NULL, 1493287159, 1493288215, '王玲', '', '116.22.163.229', 0, '无法获取', 15136317071, 0, '', '王玲', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 285, 284, 48, 0, 284, NULL, '08c7a7e1751d5f518ac6f11b41e96135', 'SzDUKa', 1, NULL, NULL, 1493287228, 1493287228, '骆欣妤', '', '116.22.163.229', 0, '无法获取', 15099999065, 0, '', '骆欣妤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 286, 285, 48, 0, 285, NULL, '6e514a89afb6775e2452d165cbd582c5', 'mPp6dS', 1, NULL, NULL, 1493287265, 1493287265, '陈爱敏', '', '116.22.163.229', 0, '无法获取', 15099999065, 0, '', '陈爱敏', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 287, 286, 48, 0, 286, NULL, 'c265ff5875b427ff24f4e39c5b619752', 'GbXh8x', 1, NULL, NULL, 1493287301, 1493287301, '陈有华', '', '116.22.163.229', 0, '无法获取', 15099999065, 0, '', '陈有华', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 288, 287, 48, 0, 287, NULL, 'aeea9dcf49cbe40c44447be82e257c4d', 'efrkav', 1, NULL, NULL, 1493287350, 1493287350, '梁燕明', '', '116.22.163.229', 0, '无法获取', 15099999065, 0, '', '梁燕明', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 289, 288, 184, 0, 288, NULL, 'dc787769e712bbd4cfff8d6eb06419eb', 'JZKANM', 1, NULL, NULL, 1493287387, 1493287387, '吴文龙', '', '116.22.163.229', 0, '无法获取', 13928390350, 0, '', '吴文龙', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 290, 289, 159, 0, 289, NULL, 'd79d796ba66fdf1139d8acbc05ce65ab', 'fcH2wW', 3, NULL, 1493287444, 1493287425, 1493287444, '翟连刚', '', '116.22.163.229', 0, '无法获取', 13383790629, 0, '', '翟连刚', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 291, 290, 159, 0, 290, NULL, '695c76e467e0139790b5bcd9511f1835', 'Eumb19', 3, NULL, 1493287496, 1493287496, 1493287496, '汤庆宇', '', '116.22.163.229', 0, '无法获取', 18203928999, 0, '', '汤庆宇', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 292, 291, 291, 0, 291, NULL, '358c2f9f0f2cd4db9360bf0b768c60f6', 'XNF5EE', 1, NULL, NULL, 1493287602, 1493287602, '林利娟', '', '116.22.163.229', 0, '无法获取', 18898116822, 0, '', '林利娟', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 293, 292, 291, 0, 292, NULL, '7951f7e2942ea14cb7bf3b703fc184fe', 'aX8znx', 1, NULL, NULL, 1493287656, 1493287656, '彭彦霞', '', '116.22.163.229', 0, '无法获取', 13598828659, 0, '', '彭彦霞', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 294, 293, 291, 0, 293, NULL, 'fe0d97be0f0ac2dcd674a1ac3cfef2fa', '5cHe6L', 1, NULL, NULL, 1493287735, 1493287735, '郭海涛', '', '116.22.163.229', 0, '无法获取', 18037875558, 0, '', '郭海涛', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 295, 294, 204, 0, 294, NULL, '51eeba7c3d0168b651c6f5d4499c74e0', 'pKTrSn', 1, NULL, NULL, 1493287780, 1493287780, '黄海', '', '116.22.163.229', 0, '无法获取', 13539896756, 0, '', '黄海', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 296, 295, 7, 0, 295, NULL, 'eab56ca8ba679155f16ba6278b69dade', 'wKmkVk', 1, NULL, NULL, 1493287830, 1493287830, '彭海文', '', '116.22.163.229', 0, '无法获取', 13750507028, 0, '', '彭海文', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 297, 296, 235, 0, 296, NULL, '0060f1c255c77746ca46f69b7b274780', 'Hig9aI', 1, NULL, NULL, 1493287884, 1493287884, '潘书品', '', '116.22.163.229', 0, '无法获取', 13598788464, 0, '', '潘书品', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 298, 297, 235, 0, 297, NULL, '29a7b4c6d4100233fdaff17b8d8e61b6', 'pld4iC', 1, NULL, NULL, 1493287928, 1493287928, '孟琳', '', '116.22.163.229', 0, '无法获取', 15837889711, 0, '', '孟琳', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 299, 298, 235, 0, 298, NULL, '63ed3c2a6b99f0cc72775ab20acd0973', 'mxcrwh', 1, NULL, NULL, 1493287972, 1493287972, '李昌峰', '', '116.22.163.229', 0, '无法获取', 15626012566, 0, '', '李昌峰', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 300, 299, 204, 0, 299, NULL, '5206eaa1316b2d6f341621f9dc8d6d59', 'qMf3xp', 1, NULL, NULL, 1493288006, 1493288006, '黄德', '', '116.22.163.229', 0, '无法获取', 13421761354, 0, '', '黄德', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 301, 300, 159, 0, 300, NULL, '0e5830b6cb3acf23ac0bc92946a95a53', 'wT18tB', 1, NULL, NULL, 1493288060, 1493288060, '余勤', '', '116.22.163.229', 0, '无法获取', 13607611015, 0, '', '余勤', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 302, 301, 159, 0, 301, NULL, 'e31abf4bc6142dcb7a4ee61d136dc1c4', 'ZPi6wA', 1, NULL, NULL, 1493288104, 1493288104, '孟俊丽', '', '116.22.163.229', 0, '无法获取', 13603822623, 0, '', '孟俊丽', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 303, 302, 48, 0, 302, NULL, 'a54f70d22a913c8dc30df88f811a082c', '9SVsAT', 1, NULL, NULL, 1493288146, 1493288146, '陈爱平', '', '116.22.163.229', 0, '无法获取', 13424077889, 0, '', '陈爱平', NULL, '' );
INSERT INTO `wywl_admin` VALUES ( 304, 303, 276, 0, 303, NULL, '2755249cb9b581142e6a7e0b0b91a833', 'TkfrJE', 1, NULL, NULL, 1493988821, 1493988821, '谢冬秀', '', '116.22.163.229', 0, '无法获取', 13660762960, 0, '', '谢冬秀', NULL, 555 );
/*!40000 ALTER TABLE wywl_admin ENABLE KEYS */;

--
-- Table structure for table wywl_companyachi
--

DROP TABLE IF EXISTS `wywl_companyachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_companyachi` (
  `monthid` int(10) DEFAULT NULL COMMENT '月份id，对应月份表',
  `monthstr` varchar(250) DEFAULT NULL COMMENT '月份字符串',
  `monthtime` varchar(250) DEFAULT NULL COMMENT '月份，时间戳，idwywl_companyachi 每月公司业绩表',
  `allprice` decimal(10,2) DEFAULT NULL COMMENT '每月总业绩',
  `allpv` decimal(10,2) DEFAULT NULL COMMENT '每月总pv值',
  `bonusofallpeople` decimal(10,2) DEFAULT NULL COMMENT '每月总分红支出',
  `netprofit` decimal(10,2) DEFAULT NULL COMMENT '每月总净利润',
  `grouper` int(10) DEFAULT '1' COMMENT '值为1，默认，用于分组求和'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_companyachi
--

/*!40000 ALTER TABLE `wywl_companyachi` DISABLE KEYS */;
INSERT INTO `wywl_companyachi` VALUES ( 5, '2017-05', 1493568000, 123000.00, 92250.00, 19503.77, 72746.23, 1 );
INSERT INTO `wywl_companyachi` VALUES ( 4, '2017-04', 1490976000, 0.00, 0.00, 0.00, 0.00, 1 );
INSERT INTO `wywl_companyachi` VALUES ( 3, '2017-03', 1488297600, 0.00, 0.00, 0.00, 0.00, 1 );
INSERT INTO `wywl_companyachi` VALUES ( 2, '2017-02', 1485878400, 0.00, 0.00, 0.00, 0.00, 1 );
INSERT INTO `wywl_companyachi` VALUES ( 1, '2017-01', 1483200000, 0.00, 0.00, 0.00, 0.00, 1 );
/*!40000 ALTER TABLE wywl_companyachi ENABLE KEYS */;

--
-- Table structure for table wywl_email
--

DROP TABLE IF EXISTS `wywl_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_email` (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `host` varchar(250) DEFAULT NULL COMMENT 'SMTP 服务器',
  `port` varchar(250) DEFAULT NULL COMMENT 'SMTP服务器的端口号',
  `username` varchar(250) DEFAULT NULL COMMENT 'SMTP服务器用户名',
  `password` varchar(250) DEFAULT NULL COMMENT 'SMTP服务器密码',
  `fromemail` varchar(250) DEFAULT NULL COMMENT '发件人EMAIL',
  `fromname` varchar(250) DEFAULT NULL COMMENT '发件人名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_email
--

/*!40000 ALTER TABLE `wywl_email` DISABLE KEYS */;
INSERT INTO `wywl_email` VALUES ( 1, 'smtp.qq.com', 465, 2738805199, 'yrtrcswhzdcrdebb', '2738805199@qq.com', '公司管理员在线' );
/*!40000 ALTER TABLE wywl_email ENABLE KEYS */;

--
-- Table structure for table wywl_month
--

DROP TABLE IF EXISTS `wywl_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_month` (
  `monthid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'wywl_month 月份表	主键 递增',
  `month` varchar(250) DEFAULT NULL COMMENT '月份 时间戳',
  `monthstr` varchar(250) DEFAULT NULL COMMENT '格式化月份字符串',
  PRIMARY KEY (`monthid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_month
--

/*!40000 ALTER TABLE `wywl_month` DISABLE KEYS */;
INSERT INTO `wywl_month` VALUES ( 1, 1483200000, '2017-01' );
INSERT INTO `wywl_month` VALUES ( 2, 1485878400, '2017-02' );
INSERT INTO `wywl_month` VALUES ( 3, 1488297600, '2017-03' );
INSERT INTO `wywl_month` VALUES ( 4, 1490976000, '2017-04' );
INSERT INTO `wywl_month` VALUES ( 5, 1493568000, '2017-05' );
INSERT INTO `wywl_month` VALUES ( 6, 1496246400, '2017-06' );
INSERT INTO `wywl_month` VALUES ( 7, 1498838400, '2017-07' );
INSERT INTO `wywl_month` VALUES ( 8, 1501516800, '2017-08' );
INSERT INTO `wywl_month` VALUES ( 9, 1504195200, '2017-09' );
INSERT INTO `wywl_month` VALUES ( 10, 1506787200, '2017-10' );
INSERT INTO `wywl_month` VALUES ( 11, 1509465600, '2017-11' );
INSERT INTO `wywl_month` VALUES ( 12, 1512057600, '2017-12' );
INSERT INTO `wywl_month` VALUES ( 13, 1514736000, '2018-01' );
INSERT INTO `wywl_month` VALUES ( 14, 1517414400, '2018-02' );
INSERT INTO `wywl_month` VALUES ( 15, 1519833600, '2018-03' );
INSERT INTO `wywl_month` VALUES ( 16, 1522512000, '2018-04' );
INSERT INTO `wywl_month` VALUES ( 17, 1525104000, '2018-05' );
INSERT INTO `wywl_month` VALUES ( 18, 1527782400, '2018-06' );
INSERT INTO `wywl_month` VALUES ( 19, 1530374400, '2018-07' );
INSERT INTO `wywl_month` VALUES ( 20, 1533052800, '2018-08' );
INSERT INTO `wywl_month` VALUES ( 21, 1535731200, '2018-09' );
INSERT INTO `wywl_month` VALUES ( 22, 1538323200, '2018-10' );
INSERT INTO `wywl_month` VALUES ( 23, 1541001600, '2018-11' );
INSERT INTO `wywl_month` VALUES ( 24, 1543593600, '2018-12' );
INSERT INTO `wywl_month` VALUES ( 25, 1546272000, '2019-01' );
INSERT INTO `wywl_month` VALUES ( 26, 1548950400, '2019-02' );
INSERT INTO `wywl_month` VALUES ( 27, 1551369600, '2019-03' );
INSERT INTO `wywl_month` VALUES ( 28, 1554048000, '2019-04' );
INSERT INTO `wywl_month` VALUES ( 29, 1556640000, '2019-05' );
INSERT INTO `wywl_month` VALUES ( 30, 1559318400, '2019-06' );
INSERT INTO `wywl_month` VALUES ( 31, 1561910400, '2019-07' );
INSERT INTO `wywl_month` VALUES ( 32, 1564588800, '2019-08' );
INSERT INTO `wywl_month` VALUES ( 33, 1567267200, '2019-09' );
INSERT INTO `wywl_month` VALUES ( 34, 1569859200, '2019-10' );
INSERT INTO `wywl_month` VALUES ( 35, 1572537600, '2019-11' );
INSERT INTO `wywl_month` VALUES ( 36, 1575129600, '2019-12' );
INSERT INTO `wywl_month` VALUES ( 37, 1577808000, '2020-01' );
INSERT INTO `wywl_month` VALUES ( 38, 1580486400, '2020-02' );
INSERT INTO `wywl_month` VALUES ( 39, 1582992000, '2020-03' );
INSERT INTO `wywl_month` VALUES ( 40, 1585670400, '2020-04' );
INSERT INTO `wywl_month` VALUES ( 41, 1588262400, '2020-05' );
INSERT INTO `wywl_month` VALUES ( 42, 1590940800, '2020-06' );
INSERT INTO `wywl_month` VALUES ( 43, 1593532800, '2020-07' );
INSERT INTO `wywl_month` VALUES ( 44, 1596211200, '2020-08' );
INSERT INTO `wywl_month` VALUES ( 45, 1598889600, '2020-09' );
INSERT INTO `wywl_month` VALUES ( 46, 1601481600, '2020-10' );
INSERT INTO `wywl_month` VALUES ( 47, 1604160000, '2020-11' );
INSERT INTO `wywl_month` VALUES ( 48, 1606752000, '2020-12' );
INSERT INTO `wywl_month` VALUES ( 49, 1609430400, '2021-01' );
INSERT INTO `wywl_month` VALUES ( 50, 1612108800, '2021-02' );
INSERT INTO `wywl_month` VALUES ( 51, 1614528000, '2021-03' );
INSERT INTO `wywl_month` VALUES ( 52, 1617206400, '2021-04' );
INSERT INTO `wywl_month` VALUES ( 53, 1619798400, '2021-05' );
INSERT INTO `wywl_month` VALUES ( 54, 1622476800, '2021-06' );
INSERT INTO `wywl_month` VALUES ( 55, 1625068800, '2021-07' );
INSERT INTO `wywl_month` VALUES ( 56, 1627747200, '2021-08' );
INSERT INTO `wywl_month` VALUES ( 57, 1630425600, '2021-09' );
INSERT INTO `wywl_month` VALUES ( 58, 1633017600, '2021-10' );
INSERT INTO `wywl_month` VALUES ( 59, 1635696000, '2021-11' );
INSERT INTO `wywl_month` VALUES ( 60, 1638288000, '2021-12' );
INSERT INTO `wywl_month` VALUES ( 61, 1640966400, '2022-01' );
INSERT INTO `wywl_month` VALUES ( 62, 1643644800, '2022-02' );
INSERT INTO `wywl_month` VALUES ( 63, 1646064000, '2022-03' );
INSERT INTO `wywl_month` VALUES ( 64, 1648742400, '2022-04' );
INSERT INTO `wywl_month` VALUES ( 65, 1651334400, '2022-05' );
INSERT INTO `wywl_month` VALUES ( 66, 1654012800, '2022-06' );
INSERT INTO `wywl_month` VALUES ( 67, 1656604800, '2022-07' );
INSERT INTO `wywl_month` VALUES ( 68, 1659283200, '2022-08' );
INSERT INTO `wywl_month` VALUES ( 69, 1661961600, '2022-09' );
INSERT INTO `wywl_month` VALUES ( 70, 1664553600, '2022-10' );
INSERT INTO `wywl_month` VALUES ( 71, 1667232000, '2022-11' );
INSERT INTO `wywl_month` VALUES ( 72, 1669824000, '2022-12' );
INSERT INTO `wywl_month` VALUES ( 73, 1672502400, '2023-01' );
INSERT INTO `wywl_month` VALUES ( 74, 1675180800, '2023-02' );
INSERT INTO `wywl_month` VALUES ( 75, 1677600000, '2023-03' );
INSERT INTO `wywl_month` VALUES ( 76, 1680278400, '2023-04' );
INSERT INTO `wywl_month` VALUES ( 77, 1682870400, '2023-05' );
INSERT INTO `wywl_month` VALUES ( 78, 1685548800, '2023-06' );
INSERT INTO `wywl_month` VALUES ( 79, 1688140800, '2023-07' );
INSERT INTO `wywl_month` VALUES ( 80, 1690819200, '2023-08' );
INSERT INTO `wywl_month` VALUES ( 81, 1693497600, '2023-09' );
INSERT INTO `wywl_month` VALUES ( 82, 1696089600, '2023-10' );
INSERT INTO `wywl_month` VALUES ( 83, 1698768000, '2023-11' );
INSERT INTO `wywl_month` VALUES ( 84, 1701360000, '2023-12' );
INSERT INTO `wywl_month` VALUES ( 85, 1704038400, '2024-01' );
INSERT INTO `wywl_month` VALUES ( 86, 1706716800, '2024-02' );
INSERT INTO `wywl_month` VALUES ( 87, 1709222400, '2024-03' );
INSERT INTO `wywl_month` VALUES ( 88, 1711900800, '2024-04' );
INSERT INTO `wywl_month` VALUES ( 89, 1714492800, '2024-05' );
INSERT INTO `wywl_month` VALUES ( 90, 1717171200, '2024-06' );
INSERT INTO `wywl_month` VALUES ( 91, 1719763200, '2024-07' );
INSERT INTO `wywl_month` VALUES ( 92, 1722441600, '2024-08' );
INSERT INTO `wywl_month` VALUES ( 93, 1725120000, '2024-09' );
INSERT INTO `wywl_month` VALUES ( 94, 1727712000, '2024-10' );
INSERT INTO `wywl_month` VALUES ( 95, 1730390400, '2024-11' );
INSERT INTO `wywl_month` VALUES ( 96, 1732982400, '2024-12' );
INSERT INTO `wywl_month` VALUES ( 97, 1735660800, '2025-01' );
INSERT INTO `wywl_month` VALUES ( 98, 1738339200, '2025-02' );
INSERT INTO `wywl_month` VALUES ( 99, 1740758400, '2025-03' );
INSERT INTO `wywl_month` VALUES ( 100, 1743436800, '2025-04' );
/*!40000 ALTER TABLE wywl_month ENABLE KEYS */;

--
-- Table structure for table wywl_monthcomachi
--

DROP TABLE IF EXISTS `wywl_monthcomachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_monthcomachi` (
  `monthid` int(10) DEFAULT NULL COMMENT '月份表对应id',
  `adminid` int(10) DEFAULT NULL COMMENT '用户对应id 这个要是1，公司id',
  `comachiid` int(10) DEFAULT NULL COMMENT '每月公司业绩表id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_monthcomachi
--

/*!40000 ALTER TABLE `wywl_monthcomachi` DISABLE KEYS */;
/*!40000 ALTER TABLE wywl_monthcomachi ENABLE KEYS */;

--
-- Table structure for table wywl_monthsingleachi
--

DROP TABLE IF EXISTS `wywl_monthsingleachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_monthsingleachi` (
  `monthid` int(10) DEFAULT NULL COMMENT '月份表对应id    wywl_monthmsg 月份奖金中间表',
  `adminid` int(10) DEFAULT NULL,
  `sachiid` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_monthsingleachi
--

/*!40000 ALTER TABLE `wywl_monthsingleachi` DISABLE KEYS */;
/*!40000 ALTER TABLE wywl_monthsingleachi ENABLE KEYS */;

--
-- Table structure for table wywl_node
--

DROP TABLE IF EXISTS `wywl_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_node
--

/*!40000 ALTER TABLE `wywl_node` DISABLE KEYS */;
INSERT INTO `wywl_node` VALUES ( 1, 'Wanyu', '后台应用', 1, '', 1, 0, 1 );
INSERT INTO `wywl_node` VALUES ( 2, 'Promag', '产品管理', 1, NULL, 1, 1, 2 );
INSERT INTO `wywl_node` VALUES ( 3, 'index', '商品管理起初页', 1, NULL, 1, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 4, 'searchpro', '商品的搜索操作', 1, NULL, 2, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 5, 'addpro', '添加商品的处理', 1, NULL, 3, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 6, 'editpro', '修改商品页', 1, NULL, 4, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 7, 'prochg', '修改商品处理', 1, NULL, 5, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 8, 'delpro', '删除商品', 1, NULL, 6, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 9, 'addmenu', '商品套餐页', 1, NULL, 7, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 10, 'doaddmenu', '添加商品套餐处理', 1, NULL, 8, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 11, 'menulist', '商品套餐列表页', 1, NULL, 9, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 12, 'menuchg', '商品套餐修改页', 1, NULL, 10, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 13, 'dochgmenu', '修改套餐属性操作', 1, NULL, 11, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 14, 'menudel', '删除套餐', 1, NULL, 12, 2, 3 );
INSERT INTO `wywl_node` VALUES ( 15, 'Admin', '管理员控制器', 1, NULL, 2, 1, 2 );
INSERT INTO `wywl_node` VALUES ( 16, 'index', '管理员列表页index', 1, NULL, 1, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 17, 'manage', '管理员列表页', 1, NULL, 2, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 18, 'addadmin', '添加/编辑用户页面', 1, NULL, 3, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 19, 'editadmin', '修改用户处理', 1, NULL, 4, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 20, 'deladmin', '删除管理员', 1, NULL, 5, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 21, 'deladminAll', '指量删除用户处理', 1, NULL, 6, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 22, 'addadminPost', '添加用户处理', 1, NULL, 7, 15, 3 );
INSERT INTO `wywl_node` VALUES ( 23, 'Order', '订单控制器', 1, NULL, 3, 1, 2 );
INSERT INTO `wywl_node` VALUES ( 24, 'index', '默认进入列表页面', 1, NULL, 1, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 25, 'orderlist', '订单列表页', 1, NULL, 2, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 26, 'orderadd', '订单添加页', 1, NULL, 3, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 27, 'orderdoadd', '订单添加操作', 1, NULL, 4, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 28, 'ordersearch', '订单搜索页', 1, NULL, 5, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 29, 'orderedit', 'order编辑页', 1, NULL, 6, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 30, 'orderchg', '修改补充订单操作', 1, NULL, 7, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 31, 'orderdel', '删除一个数据', 1, NULL, 8, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 32, 'ordermanydel', '批量删除', 1, NULL, 9, 23, 3 );
INSERT INTO `wywl_node` VALUES ( 33, 'Public', '公共系统信息处理器', 1, NULL, 4, 1, 2 );
INSERT INTO `wywl_node` VALUES ( 34, 'header', '网站头部访问', 1, NULL, 1, 33, 3 );
INSERT INTO `wywl_node` VALUES ( 35, 'left', '网站左侧访问', 1, NULL, 2, 33, 3 );
INSERT INTO `wywl_node` VALUES ( 36, 'sysmain', '系统信息访问', 1, NULL, 3, 33, 3 );
INSERT INTO `wywl_node` VALUES ( 37, 'Index', '系统主页', 1, NULL, 5, 1, 2 );
INSERT INTO `wywl_node` VALUES ( 38, 'index', '系统主页index方法', 1, NULL, 1, 37, 3 );
/*!40000 ALTER TABLE wywl_node ENABLE KEYS */;

--
-- Table structure for table wywl_order
--

DROP TABLE IF EXISTS `wywl_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_order` (
  `orderid` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键，id订单页面',
  `pid` int(10) NOT NULL COMMENT '连接产品表主键',
  `adminid` int(10) NOT NULL COMMENT '连接用户表主键 用户id',
  `otime` varchar(250) DEFAULT NULL COMMENT '下单时间',
  `ispass` int(10) DEFAULT '0' COMMENT '0为不通过，1为通过',
  `additionalprice` decimal(10,0) DEFAULT NULL COMMENT '附加的价格',
  `additionalpprice` decimal(10,2) DEFAULT '0.00' COMMENT '附加的pv价格',
  `pprice` decimal(10,2) DEFAULT NULL COMMENT '产品pv价格，=价格*pv值',
  `price` decimal(10,2) DEFAULT NULL COMMENT '产品价格',
  `pv` decimal(10,2) DEFAULT NULL COMMENT 'pv值，pv价与价格的比例，=pv价/价格',
  `finalpprice` decimal(10,2) DEFAULT NULL COMMENT '最终的pv值',
  `finalprice` decimal(10,2) DEFAULT NULL COMMENT '最终的价格',
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_order
--

/*!40000 ALTER TABLE `wywl_order` DISABLE KEYS */;
INSERT INTO `wywl_order` VALUES ( 1, 16, 2, 1494255932, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 2, 16, 3, 1494329198, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 3, 16, 4, 1494329200, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 4, 16, 5, 1494147894, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 5, 16, 6, 1494235238, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 6, 16, 7, 1494147902, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 7, 16, 8, 1494147907, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 8, 16, 9, 1494147913, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 9, 16, 10, 1494235657, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 10, 16, 11, 1494235703, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 11, 16, 12, 1494241155, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 12, 16, 13, 1494241201, 1, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 13, 1, 14, 1494243391, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 14, 1, 15, 1494247998, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 15, 1, 16, 1494250693, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 16, 1, 17, 1494490690, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 17, 1, 18, 1494490707, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 18, 1, 19, 1494696229, 1, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 19, 1, 20, 1493962981, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 20, 1, 21, 1493962984, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 21, 1, 22, 1493962987, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 22, 1, 23, 1493962989, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 23, 1, 24, 1493962992, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 24, 1, 25, 1493962997, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 25, 1, 26, 1493963001, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 26, 1, 27, 1493963005, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 27, 1, 28, 1493963008, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 28, 1, 29, 1493963010, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 29, 1, 30, 1493963014, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 30, 1, 31, 1493963016, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 31, 1, 32, 1493963020, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 32, 1, 33, 1493273371, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 33, 1, 34, 1493273420, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 34, 1, 35, 1493273481, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 35, 16, 36, 1493273537, 0, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 36, 1, 37, 1493273664, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 37, 1, 38, 1493273731, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 38, 1, 39, 1493273894, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 39, 1, 40, 1493274077, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 40, 1, 41, 1493274251, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 41, 1, 42, 1493274717, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 42, 1, 43, 1493274982, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 43, 1, 44, 1493275082, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 44, 1, 45, 1493275134, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 45, 1, 46, 1493275189, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 46, 1, 47, 1493275243, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 47, 1, 48, 1493275301, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 48, 1, 49, 1493275428, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 49, 1, 50, 1493275499, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 50, 1, 51, 1493275552, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 51, 1, 52, 1493275607, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 52, 1, 53, 1493275668, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 53, 1, 54, 1493275728, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 54, 2, 55, 1494232048, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 55, 2, 56, 1493275854, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 56, 1, 57, 1493275968, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 57, 2, 58, 1493276036, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 58, 1, 59, 1493276114, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 59, 1, 60, 1493276161, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 60, 1, 61, 1493276208, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 61, 1, 62, 1493276253, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 62, 1, 63, 1493276302, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 63, 1, 64, 1493276337, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 64, 1, 65, 1493276381, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 65, 1, 66, 1493276428, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 66, 1, 67, 1493276466, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 67, 1, 68, 1493276509, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 68, 1, 69, 1493276556, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 69, 1, 70, 1493276594, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 70, 1, 71, 1493276633, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 71, 1, 72, 1493276704, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 72, 1, 73, 1493276747, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 73, 1, 74, 1493276787, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 74, 1, 75, 1493276827, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 75, 1, 76, 1493276918, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 76, 1, 77, 1493276974, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 77, 1, 78, 1493277013, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 78, 1, 79, 1493277055, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 79, 1, 80, 1493277099, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 80, 1, 81, 1493277136, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 81, 1, 82, 1493277189, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 82, 1, 83, 1493277224, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 83, 1, 84, 1493277267, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 84, 1, 85, 1493277344, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 85, 1, 86, 1493277388, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 86, 1, 87, 1493277427, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 87, 1, 88, 1493277502, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 88, 1, 89, 1493277540, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 89, 1, 90, 1493277580, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 90, 1, 91, 1493277617, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 91, 1, 92, 1493277662, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 92, 1, 93, 1493277705, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 93, 1, 94, 1493277745, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 94, 1, 95, 1493277791, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 95, 1, 96, 1493277825, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 96, 1, 97, 1493277864, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 97, 1, 98, 1493277901, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 98, 1, 99, 1493277946, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 99, 1, 100, 1493277981, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 100, 1, 101, 1493278012, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 101, 1, 102, 1493278049, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 102, 1, 103, 1493278082, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 103, 1, 104, 1493278123, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 104, 1, 105, 1493278157, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 105, 1, 106, 1493278198, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 106, 1, 107, 1493278231, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 107, 2, 108, 1493278280, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 108, 2, 109, 1493278320, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 109, 2, 110, 1493278360, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 110, 1, 111, 1493278406, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 111, 1, 112, 1493278465, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 112, 1, 113, 1493278507, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 113, 1, 114, 1493278552, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 114, 1, 115, 1493278634, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 115, 1, 116, 1493278674, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 116, 1, 117, 1493278765, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 117, 1, 118, 1493278846, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 118, 1, 119, 1493278898, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 119, 1, 120, 1493278941, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 120, 1, 121, 1493279025, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 121, 2, 122, 1493279068, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 122, 2, 123, 1493279112, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 123, 1, 124, 1493279164, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 124, 1, 125, 1493279201, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 125, 1, 126, 1493279235, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 126, 1, 127, 1493279269, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 127, 1, 128, 1493279309, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 128, 1, 129, 1493279353, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 129, 1, 130, 1493279401, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 130, 1, 131, 1493279444, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 131, 1, 132, 1493279494, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 132, 1, 133, 1493279549, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 133, 1, 134, 1493279601, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 134, 1, 135, 1493279637, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 135, 1, 136, 1493279701, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 136, 1, 137, 1493279737, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 137, 1, 138, 1493279773, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 138, 1, 139, 1493279815, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 139, 1, 140, 1493279851, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 140, 1, 141, 1493279891, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 141, 2, 142, 1493279965, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 142, 2, 143, 1493280012, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 143, 1, 144, 1493280054, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 144, 1, 145, 1493280091, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 145, 1, 146, 1493280174, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 146, 1, 147, 1493280206, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 147, 1, 148, 1493280240, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 148, 1, 149, 1493280281, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 149, 1, 150, 1493280315, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 150, 1, 151, 1493280355, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 151, 1, 152, 1493280416, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 152, 1, 153, 1493280465, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 153, 1, 154, 1493280514, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 154, 1, 155, 1493280551, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 155, 1, 156, 1493280591, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 156, 1, 157, 1493280626, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 157, 1, 158, 1493280660, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 158, 2, 159, 1493280712, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 159, 16, 160, 1493280768, 0, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 160, 1, 161, 1493280810, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 161, 1, 162, 1493280880, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 162, 1, 163, 1493280944, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 163, 1, 164, 1493280985, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 164, 1, 165, 1493281030, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 165, 1, 166, 1493281069, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 166, 1, 167, 1493281105, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 167, 1, 168, 1493281141, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 168, 1, 169, 1493281183, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 169, 1, 170, 1493281220, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 170, 1, 171, 1493281255, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 171, 1, 172, 1493281298, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 172, 1, 173, 1493281341, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 173, 1, 174, 1493281375, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 174, 1, 175, 1493281409, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 175, 1, 176, 1493281450, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 176, 1, 177, 1493281495, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 177, 1, 178, 1493281533, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 178, 16, 179, 1493281600, 0, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 179, 1, 180, 1493281650, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 180, 1, 181, 1493281693, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 181, 1, 182, 1493281731, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 182, 1, 183, 1493281776, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 183, 1, 184, 1493281817, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 184, 1, 185, 1493281861, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 185, 1, 186, 1493281897, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 186, 1, 187, 1493281931, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 187, 1, 188, 1493281974, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 188, 1, 189, 1493282518, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 189, 1, 190, 1493282591, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 190, 1, 191, 1493282641, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 191, 1, 192, 1493282683, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 192, 1, 193, 1493282737, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 193, 1, 194, 1493282778, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 194, 1, 195, 1493283088, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 195, 1, 196, 1493283176, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 196, 1, 197, 1493283228, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 197, 1, 198, 1493283268, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 198, 1, 199, 1493283305, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 199, 1, 200, 1493283379, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 200, 1, 201, 1493283471, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 201, 1, 202, 1493283519, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 202, 1, 203, 1493283563, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 203, 1, 204, 1493283606, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 204, 1, 205, 1493283652, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 205, 1, 206, 1493283690, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 206, 1, 207, 1493283729, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 207, 1, 208, 1493283774, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 208, 1, 209, 1493283815, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 209, 1, 210, 1493283855, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 210, 1, 211, 1493283903, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 211, 1, 212, 1493283948, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 212, 1, 213, 1493284011, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 213, 1, 214, 1493284052, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 214, 1, 215, 1493284090, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 215, 1, 216, 1493284137, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 216, 1, 217, 1493284182, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 217, 1, 218, 1493284222, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 218, 1, 219, 1493284266, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 219, 1, 220, 1493284312, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 220, 1, 221, 1493284353, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 221, 1, 222, 1493284393, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 222, 1, 223, 1493284449, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 223, 1, 224, 1493284496, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 224, 1, 225, 1493284531, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 225, 1, 226, 1493284589, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 226, 1, 227, 1493284628, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 227, 1, 228, 1493284671, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 228, 1, 229, 1493284726, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 229, 1, 230, 1493284764, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 230, 1, 231, 1493284803, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 231, 1, 232, 1493284852, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 232, 1, 233, 1493284901, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 233, 1, 234, 1493284941, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 234, 1, 235, 1493284982, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 235, 1, 236, 1493285058, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 236, 1, 237, 1493285099, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 237, 1, 238, 1493285151, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 238, 2, 239, 1493285191, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 239, 1, 240, 1493285250, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 240, 1, 241, 1493285294, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 241, 1, 242, 1493285339, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 242, 1, 243, 1493285381, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 243, 1, 244, 1493285424, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 244, 1, 245, 1493285467, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 245, 1, 246, 1493285507, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 246, 1, 247, 1493285559, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 247, 1, 248, 1493285593, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 248, 1, 249, 1493285637, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 249, 1, 250, 1493285675, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 250, 1, 251, 1493285713, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 251, 1, 252, 1493285754, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 252, 1, 253, 1493285792, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 253, 1, 254, 1493285822, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 254, 1, 255, 1493285854, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 255, 1, 256, 1493285893, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 256, 1, 257, 1493285932, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 257, 1, 258, 1493285976, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 258, 1, 259, 1493286015, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 259, 1, 260, 1493286057, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 260, 1, 261, 1493286101, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 261, 1, 262, 1493286145, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 262, 1, 263, 1493286182, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 263, 1, 264, 1493286225, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 264, 1, 265, 1493286301, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 265, 1, 266, 1493286336, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 266, 1, 267, 1493286410, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 267, 1, 268, 1493286450, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 268, 1, 269, 1493286483, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 269, 1, 270, 1493286526, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 270, 1, 271, 1493286567, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 271, 1, 272, 1493286614, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 272, 1, 273, 1493286655, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 273, 1, 274, 1493286697, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 274, 1, 275, 1493286738, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 275, 1, 276, 1493286777, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 276, 1, 277, 1493286837, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 277, 1, 278, 1493286884, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 278, 1, 279, 1493286918, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 279, 1, 280, 1493286961, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 280, 1, 281, 1493287003, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 281, 2, 282, 1493287073, 0, 0, 0.00, 3750.00, 5000.00, 0.75, 3750.00, 5000.00 );
INSERT INTO `wywl_order` VALUES ( 282, 1, 283, 1493287116, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 283, 1, 284, 1493287159, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 284, 1, 285, 1493287228, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 285, 1, 286, 1493287265, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 286, 1, 287, 1493287301, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 287, 1, 288, 1493287350, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 288, 1, 289, 1493287387, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 289, 1, 290, 1493287425, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 290, 16, 291, 1493287496, 0, 0, 0.00, 7500.00, 10000.00, 0.75, 7500.00, 10000.00 );
INSERT INTO `wywl_order` VALUES ( 291, 1, 292, 1493287602, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 292, 1, 293, 1493287656, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 293, 1, 294, 1493287735, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 294, 1, 295, 1493287780, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 295, 1, 296, 1493287830, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 296, 1, 297, 1493287884, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 297, 1, 298, 1493287928, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 298, 1, 299, 1493287972, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 299, 1, 300, 1493288006, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 300, 1, 301, 1493288060, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 301, 1, 302, 1493288105, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 302, 1, 303, 1493288146, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
INSERT INTO `wywl_order` VALUES ( 305, 1, 304, 1494423341, 0, 0, 0.00, 375.00, 500.00, 0.75, 375.00, 500.00 );
/*!40000 ALTER TABLE wywl_order ENABLE KEYS */;

--
-- Table structure for table wywl_product
--

DROP TABLE IF EXISTS `wywl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_product` (
  `pid` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品id',
  `pname` varchar(250) DEFAULT NULL COMMENT '产品名字',
  `pprice` decimal(10,2) DEFAULT NULL COMMENT '产品pv值计算出的pv价格',
  `pv` decimal(10,2) DEFAULT '0.75' COMMENT 'pv值，价格的比例',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_product
--

/*!40000 ALTER TABLE `wywl_product` DISABLE KEYS */;
INSERT INTO `wywl_product` VALUES ( 1, '产品', 375.00, 0.75, 500.00 );
INSERT INTO `wywl_product` VALUES ( 2, '产品2', 3750.00, 0.75, 5000.00 );
INSERT INTO `wywl_product` VALUES ( 16, '产品3', 7500.00, 0.75, 10000.00 );
INSERT INTO `wywl_product` VALUES ( 22, '产品5', 375.00, 0.75, 5900.00 );
INSERT INTO `wywl_product` VALUES ( 23, '产品5', 375.00, 0.74, 1500.00 );
/*!40000 ALTER TABLE wywl_product ENABLE KEYS */;

--
-- Table structure for table wywl_risingsetting
--

DROP TABLE IF EXISTS `wywl_risingsetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_risingsetting` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `startnum` int(10) DEFAULT NULL COMMENT '开始单量',
  `nownum` int(10) DEFAULT NULL COMMENT '目前单量',
  `risingtime` int(10) DEFAULT NULL COMMENT '多少秒就自动添加单量，单位为秒',
  `shares` int(10) DEFAULT NULL COMMENT '股值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_risingsetting
--

/*!40000 ALTER TABLE `wywl_risingsetting` DISABLE KEYS */;
INSERT INTO `wywl_risingsetting` VALUES ( 1, 590, 9873, 60, 1845 );
/*!40000 ALTER TABLE wywl_risingsetting ENABLE KEYS */;

--
-- Table structure for table wywl_role
--

DROP TABLE IF EXISTS `wywl_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_role
--

/*!40000 ALTER TABLE `wywl_role` DISABLE KEYS */;
INSERT INTO `wywl_role` VALUES ( 1, '管理员', 0, 1, '管理员' );
/*!40000 ALTER TABLE wywl_role ENABLE KEYS */;

--
-- Table structure for table wywl_role_admin
--

DROP TABLE IF EXISTS `wywl_role_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_role_admin` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `admin_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_role_admin
--

/*!40000 ALTER TABLE `wywl_role_admin` DISABLE KEYS */;
INSERT INTO `wywl_role_admin` VALUES ( 1, 11 );
INSERT INTO `wywl_role_admin` VALUES ( 1, 0 );
INSERT INTO `wywl_role_admin` VALUES ( 1, 14 );
INSERT INTO `wywl_role_admin` VALUES ( 1, 15 );
INSERT INTO `wywl_role_admin` VALUES ( 1, 16 );
/*!40000 ALTER TABLE wywl_role_admin ENABLE KEYS */;

--
-- Table structure for table wywl_settlementmsg
--

DROP TABLE IF EXISTS `wywl_settlementmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_settlementmsg` (
  `adminid` int(10) DEFAULT NULL COMMENT '代理id，对应代理表',
  `monthid` int(10) DEFAULT NULL COMMENT '月份id，对应月份表',
  `issettlement` int(10) DEFAULT '0' COMMENT '是否结算 0是没有结算，1是结算',
  `alreadysettlemoney` decimal(10,2) DEFAULT '0.00' COMMENT '已经结算的钱',
  `dirbonkus` decimal(10,2) DEFAULT '0.00' COMMENT '直接开拓pv分红',
  `encbonus` decimal(10,2) DEFAULT '0.00' COMMENT '每月前六分红',
  `indirbonkus` decimal(10,2) DEFAULT '0.00' COMMENT '间接开拓pv分红',
  `averagebonus` decimal(10,2) DEFAULT '0.00' COMMENT '金银牌加权分红',
  `pvtotal` decimal(10,2) DEFAULT '0.00' COMMENT '总pv分红',
  `truebonus` decimal(10,2) DEFAULT '0.00' COMMENT '实际奖金',
  `leftsettlemoney` decimal(10,2) DEFAULT '0.00' COMMENT '可提金额',
  `biyudou` decimal(10,2) DEFAULT '0.00' COMMENT '碧玉豆'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_settlementmsg
--

/*!40000 ALTER TABLE `wywl_settlementmsg` DISABLE KEYS */;
INSERT INTO `wywl_settlementmsg` VALUES ( 2, 5, 0, 600.00, 6225.00, 0.00, 603.75, 345.94, 7174.69, 5739.75, 5139.75, 1434.94 );
INSERT INTO `wywl_settlementmsg` VALUES ( 3, 5, 0, 0.00, 3075.00, 0.00, 1050.00, 345.94, 4470.94, 3576.75, 3576.75, 894.19 );
INSERT INTO `wywl_settlementmsg` VALUES ( 7, 5, 0, 0.00, 1500.00, 0.00, 0.00, 345.94, 1845.94, 1476.75, 1476.75, 369.19 );
INSERT INTO `wywl_settlementmsg` VALUES ( 8, 5, 0, 0.00, 0.00, 0.00, 0.00, 345.94, 345.94, 276.75, 276.75, 69.19 );
INSERT INTO `wywl_settlementmsg` VALUES ( 6, 5, 0, 0.00, 1500.00, 0.00, 78.75, 345.94, 1924.69, 1539.75, 1539.75, 384.94 );
INSERT INTO `wywl_settlementmsg` VALUES ( 5, 5, 0, 0.00, 1500.00, 0.00, 52.50, 345.94, 1898.44, 1518.75, 1518.75, 379.69 );
INSERT INTO `wywl_settlementmsg` VALUES ( 4, 5, 0, 0.00, 0.00, 0.00, 78.75, 345.94, 424.69, 339.75, 339.75, 84.94 );
INSERT INTO `wywl_settlementmsg` VALUES ( 9, 5, 0, 0.00, 0.00, 0.00, 0.00, 345.94, 345.94, 276.75, 276.75, 69.19 );
INSERT INTO `wywl_settlementmsg` VALUES ( 18, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 55, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 43, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 10, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 11, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 12, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 13, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 14, 5, 0, 0.00, 75.00, 0.00, 0.00, 0.00, 75.00, 60.00, 60.00, 15.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 15, 5, 0, 0.00, 75.00, 0.00, 0.00, 922.50, 997.50, 798.00, 798.00, 199.50 );
INSERT INTO `wywl_settlementmsg` VALUES ( 16, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 17, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
INSERT INTO `wywl_settlementmsg` VALUES ( 19, 5, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00 );
/*!40000 ALTER TABLE wywl_settlementmsg ENABLE KEYS */;

--
-- Table structure for table wywl_singleachi
--

DROP TABLE IF EXISTS `wywl_singleachi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_singleachi` (
  `sachiid` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键 achievementid 递增',
  `dirbonus` decimal(10,2) DEFAULT NULL COMMENT '每月直接开拓奖金',
  `indirbonus` decimal(10,0) DEFAULT NULL COMMENT '每月间接开拓奖金',
  `encbonus
encbonus` decimal(10,2) DEFAULT NULL COMMENT '每月激励奖金',
  `allbonus
allbonus` decimal(10,0) DEFAULT NULL COMMENT '每月总的奖金',
  PRIMARY KEY (`sachiid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_singleachi
--

/*!40000 ALTER TABLE `wywl_singleachi` DISABLE KEYS */;
/*!40000 ALTER TABLE wywl_singleachi ENABLE KEYS */;

--
-- Table structure for table wywl_sysmsg
--

DROP TABLE IF EXISTS `wywl_sysmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_sysmsg` (
  `sysname` varchar(250) DEFAULT NULL COMMENT '程序名称',
  `sysathu` varchar(250) DEFAULT NULL COMMENT '程序作者',
  `syslang` varchar(250) DEFAULT NULL COMMENT '程序开发语言',
  `conqq` varchar(250) DEFAULT NULL COMMENT '联系qq',
  `sysversion` varchar(250) DEFAULT NULL COMMENT '程序版本',
  `sysphone` varchar(250) DEFAULT NULL COMMENT 'l万域联系电话'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_sysmsg
--

/*!40000 ALTER TABLE `wywl_sysmsg` DISABLE KEYS */;
INSERT INTO `wywl_sysmsg` VALUES ( 'wywlorder', '万域网络开发团队', 'php', 379416960, 'wywlorder 2016', 18938396030 );
/*!40000 ALTER TABLE wywl_sysmsg ENABLE KEYS */;

--
-- Table structure for table wywl_withdrawalsmsg
--

DROP TABLE IF EXISTS `wywl_withdrawalsmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = 'utf8' */;
CREATE TABLE `wywl_withdrawalsmsg` (
  `wsid` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键，wywl_withdrawalsmsg 提现的申请表',
  `monthid` int(10) DEFAULT NULL COMMENT '月份表id，对应一个月份',
  `adminid` int(10) DEFAULT NULL COMMENT '用户id',
  `wstime` varchar(250) DEFAULT NULL COMMENT '申请的时间戳',
  `wsmoney` decimal(10,2) DEFAULT NULL COMMENT '申请的钱数，提现金额最高只可以是总额的80%，提现金额必须是100的倍数',
  `issettel` int(10) DEFAULT '0' COMMENT '是否审核了',
  `wssetteltime` varchar(250) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`wsid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table wywl_withdrawalsmsg
--

/*!40000 ALTER TABLE `wywl_withdrawalsmsg` DISABLE KEYS */;
INSERT INTO `wywl_withdrawalsmsg` VALUES ( 2, 5, 2, 1494683992, 500.00, 0, NULL );
INSERT INTO `wywl_withdrawalsmsg` VALUES ( 3, 5, 2, 1494684022, 200.00, 0, NULL );
/*!40000 ALTER TABLE wywl_withdrawalsmsg ENABLE KEYS */;



                DROP TRIGGER IF EXISTS `trigger_insert`;
                DELIMITER ;;
                CREATE TRIGGER `trigger_insert` BEFORE INSERT ON `wywl_settlementmsg` FOR EACH ROW begin
                set new.pvtotal = new.dirbonkus + new.encbonus + new.indirbonkus + new. averagebonus;
                set new.truebonus = new.pvtotal * 0.80;
                set new.biyudou =  new.pvtotal * 0.20;
                set new.leftsettlemoney = new.truebonus - new.alreadysettlemoney;
                end
                ;;
                DELIMITER ;
                DROP TRIGGER IF EXISTS `trigger_update`;
                DELIMITER ;;
                CREATE TRIGGER `trigger_update` BEFORE UPDATE ON `wywl_settlementmsg` FOR EACH ROW begin
                set new.pvtotal = new.dirbonkus + new.encbonus + new.indirbonkus + new. averagebonus;
                set new.truebonus = new.pvtotal * 0.80;
                set new.biyudou =  new.pvtotal * 0.20;
                set new.leftsettlemoney = new.truebonus - new.alreadysettlemoney;
                end
                ;;
                DELIMITER ;
                
                
                

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
