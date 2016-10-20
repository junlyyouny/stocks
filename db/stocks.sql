create table stockts
(
	id int unsigned not null auto_increment,
	goods_num varchar(50) not null COMMENT '商品编码',
	bar_code varchar(100) not null COMMENT '条形码',
	amount int(4) unsigned not null COMMENT '库存量',
	add_time int(11) unsigned not null COMMENT '添加时间',
	PRIMARY KEY (`id`),
	KEY `bar_code` (`bar_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存表';：：