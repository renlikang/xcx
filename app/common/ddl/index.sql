use old_base;
CREATE TABLE attachment(
 `attachment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
 `uid` int(11) NOT NULL COMMENT '员工编号',
 `attachment_url` VARCHAR(1000) NOT NULL COMMENT 'url',
 PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '版本控制表';