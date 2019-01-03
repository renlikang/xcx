set autocommit=0;
create database woof_content charset=utf8mb4;
use woof_content;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户Id',
  `nickName` text COMMENT '用户昵称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户类型 1:普通用户 2:媒体用户',
  `avatarUrl` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户头像图片的 URL',
  `gender` tinyint(4) DEFAULT NULL COMMENT '性别（0 未知 1 男性 2 女性）',
  `country` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户所在国家',
  `province` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户所在省份',
  `city` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户所在城市',
  `language` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '语言（en 英文 zh_CN 简体中文 zh_TW 繁体中文）',
  `birthday` datetime DEFAULT NULL COMMENT '生日',
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户签名',
  `session_key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `openid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `unionid` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态:1正常，2禁言',
  `cTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `uTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleteFlag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标识:0正常，1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

CREATE TABLE `article` (
  `articleId` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `authorId` int(11) NOT NULL COMMENT '作者ID',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '文章类型',
  `source` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文章来源',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `subTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '副标题',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '内容摘要',
  `headImg` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头图',
  `endImg` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '尾图',
  `content` json DEFAULT NULL COMMENT '内容',
  `orderId` int(11) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1:启用 0:禁用',
  `cTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `uTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleteFlag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标识:0正常，1删除',
  `isFeatured` tinyint(1) NOT NULL DEFAULT '0' COMMENT '编辑精选',
  PRIMARY KEY (`articleId`),
  KEY `authorId` (`authorId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章表';


create table `tag_map` (
  `md5TagName` char(32) COMMENT '标签名称',
  `mapId` int(11) not null comment '映射ID',
  PRIMARY KEY (`md5TagName`, `mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='标签映射表';

create table `tag` (
  `md5TagName` char(32) COLLATE 'utf8mb4_unicode_ci' NOT NULL COMMENT '标签名称（md5）',
  `tagName` varchar(255) COMMENT '标签名称',
  PRIMARY KEY (`md5TagName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='标签表';

