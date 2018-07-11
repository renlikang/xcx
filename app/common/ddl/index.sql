use old_base;
CREATE TABLE attachment(
 `attachment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
 `uid` int(11) NOT NULL COMMENT '员工编号',
 `attachment_url` VARCHAR(1000) NOT NULL COMMENT 'url',
 PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '版本控制表';


CREATE TABLE user(
 `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
 `appKey` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'appKey',
 `appType` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '类型 1：小程序 2：公众号',
 `nickName` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '昵称',
 `imgUrl` VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '用户头像图片',
 `openId` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '微信openId',
 `unionid` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '微信unionid',
 `cTime` TIMESTAMP not null  DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
 `uTime` TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
 `deleteFlag` tinyint(1) not null DEFAULT 0 COMMENT '删除标识:0正常，1删除',
 PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '版本控制表';