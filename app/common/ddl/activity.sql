set autocommit=0;
create database woof_content charset=utf8mb4;
use woof_content;

CREATE TABLE `woof_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户Id',
  `userNo` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '用户工号',
  `userName` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '用户名称',
  `ticketNo` VARCHAR(128) COMMENT '票务编号',
  `cTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `uTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleteFlag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标识:0正常，1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';