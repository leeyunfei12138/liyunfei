
--
-- 数据库： `anxilvyou`
--
CREATE DATABASE IF NOT EXISTS `anxilvyou` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `anxilvyou`;

-- --------------------------------------------------------

--
-- 表的结构 `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `id` int(11) NOT NULL COMMENT 'id自增',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `pics` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '配图',
  `sinfo` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '简介',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容体',
  `createTime` datetime NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='信息表';

--
-- 转存表中的数据 `picture`
--

INSERT INTO `picture` (`id`, `name`, `pics`, `sinfo`, `content`, `createTime`) VALUES
(1, '中国茶都福源壶', './images/1703582528.jpeg', '坐落于中国茶都广场南侧、 城区二环路旁。2005年４月，由安溪县人民政府投资，惠安县海奇石雕厂雕刻并承建。', '大茶壶高8.18米，宽14.12米；茶杯高1.3米，宽2.1米。整体建筑由409块花岗岩垒成，其中茶壶310块、茶盘94块、茶杯5块（用整块的花岗岩直接雕成）。壶身上镌刻着安溪至宝，千年屹立的大字，五个大茶杯的杯壁上分别刻有茶诗。 ', '2023-12-26 17:19:49'),
(2, '清水岩', './images/1703582461.jpeg', '清水岩地处泉州市安溪县蓬莱镇蓬莱山，始建于北宋，总面积11.1平方公里，主峰海拔763米', '清水岩，位于泉州安溪县城西北部16公里处的蓬莱镇境内，毗邻城关，景区现为国家AAAA级旅游区、全国重点文物保护单位、全国涉台文物保护工程、中国书法家创作培训基地、福建省级风景名胜区，清水祖师信俗是国家级非物质文化遗产。', '2023-12-26 18:19:49'),
(3, '安溪文庙', './images/1703582632.jpeg', '安溪文庙始建于北宋咸平四年（1001年），省级文物保护单位。现存格局为清康熙年间重建。', '主体建筑贯穿在一条南北走向的中轴线上，左右对称，自外至内有泮宫、腾蛟起凤石坊及泮池、照墙、棂星门、戟门、庑廊、大成殿、崇圣殿、教谕衙等，南北164米，东西宽36.5米，加上明伦堂，建筑面积达5986平方米。整个建筑布局合理，层次分明，规模宏大，艺术精湛，素有秀甲江南、名冠八闽之美誉，其建筑法式曾传播日本，是中日文化科技交流的重要例证。 ', '2023-12-26 16:57:06'),
(4, '李光地故居', './images/1703582592.jpeg', '位于湖头镇中山街，明初李氏先祖李森建。经清初扩建重修，前后三进，占地面积2000平方米，被称为大宗祠堂。', '乃湖头李氏祀先祖、明宗规、行族事的所在地，春秋两祭，祭祀规模盛大。庙内尚保留有明英宗皇帝敕文。第二进大厅厅前悬挂夹辅高风匾额，为康熙皇帝表彰李光地所赐；厅中高悬急公尚义匾额。第三进厅堂前横挂鸣臬闻天匾额，为正统年间宰相叶向高题赠；厅堂后侧悬挂保世滋大匾额，疑为李光地所题。庙并有许多金碧辉煌的柱联，有较高的文物价值。1988年，李氏家庙经海外族亲李氏昆仲献资修复，现焕然一新。 ', '2023-12-26 17:12:14');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键id自增',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `pass` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户类型',
  `createTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `type`, `createTime`) VALUES
(1, 'admin', 'admin888', 'admin', '2023-12-26 11:59:04'),
(2, 'test', 'test', 'user', '2023-12-26 05:24:43'),
(3, 'test1', 'test1', 'user', '2023-12-25 18:12:52');

--
-- 转储表的索引
--

--
-- 表的索引 `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id自增', AUTO_INCREMENT=4;
COMMIT;

