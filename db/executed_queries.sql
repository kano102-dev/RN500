INSERT INTO `company_master` (`company_name`, `company_email`, `company_mobile`, `priority`, `address_id`, `is_master`, `created_at`, `updated_at`)
VALUES ('RN500', '', '', '', '', '', '', '');

INSERT INTO `company_branch` (`id`, `company_id`, `branch_name`, `address_id`, `is_default`, `created_at`, `updated_at`)
VALUES ('', '1', 'HO', '', '1', '', '');

INSERT INTO `user` (`email`, `password`, `original_password`, `status`, `role_id`, `branch_id`, `type`, `is_master_admin`, `auth_key`, `password_reset_token`)
VALUES ('rn500@gmail.com', '$2y$13$l3gZ76OvvqR3OmPDAFgT9eUJQDYJsIGPGIecUtKf6GUaIqRlwphWS', 'admin123', '1', NULL, '1', '', '1', '', '');

ALTER TABLE `company_subscription_payment`
ADD `lead_id` int(11) NULL AFTER `payment_type`;

ALTER TABLE `company_branch`
CHANGE `id` `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST

ALTER TABLE `company_master`
CHANGE `address_id` `street_no` varchar(255) NOT NULL AFTER `priority`,
ADD `street_address` varchar(255) NOT NULL AFTER `street_no`,
ADD `suit/apt` varchar(255) NULL AFTER `street_address`,
ADD `city` int NULL AFTER `suit/apt`,
ADD `zip_code` varchar(20) NULL AFTER `city`;

ALTER TABLE `company_branch`
ADD `street_no` varchar(255) NOT NULL AFTER `branch_name`,
ADD `street_address` varchar(255) NOT NULL AFTER `street_no`,
ADD `suit/apt` varchar(255) NULL AFTER `street_address`,
ADD `city` int NULL AFTER `suit/apt`,
ADD `zip_code` varchar(20) NULL AFTER `city`

ALTER TABLE `company_branch`
DROP `address_id`;

ALTER TABLE `user_details`
DROP `address_id`;

ALTER TABLE `user_details`
ADD `street_no` varchar(255) NOT NULL AFTER `mobile_no`,
ADD `street_address` varchar(255) NOT NULL AFTER `street_no`,
ADD `suit/apt` varchar(255) NULL AFTER `street_address`,
ADD `city` int NULL AFTER `suit/apt`,
ADD `zip_code` varchar(20) NULL AFTER `city`

ALTER TABLE `company_master`
CHANGE `priority` `priority` int(11) NOT NULL DEFAULT '4' COMMENT '1:high 2:modrate 3:semi modrate 4:low' AFTER `company_mobile`,
CHANGE `is_master` `is_master` int(11) NOT NULL DEFAULT '0' AFTER `zip_code`;

ALTER TABLE `user`
CHANGE `status` `status` int(11) NOT NULL DEFAULT '0' COMMENT '1:active 0:in active' AFTER `original_password`;

ALTER TABLE `company_branch` CHANGE `suit/apt` `apt` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `company_master` CHANGE `suit/apt` `apt` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `user_details` CHANGE `suit/apt` `apt` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `lead_master`
ADD `street_no` varchar(255) NOT NULL AFTER `end_date`,
ADD `street_address` varchar(255) NOT NULL AFTER `street_no`,
ADD `apt` varchar(255) NULL AFTER `street_address`,
ADD `city` int NULL AFTER `apt`,
ADD `zip_code` varchar(20) NULL AFTER `city`;

ALTER TABLE `lead_master`
DROP FOREIGN KEY `lead_master_ibfk_1`;

ALTER TABLE `lead_master`
DROP `address_id`;

DROP TABLE `address`;

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
)

INSERT INTO `country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `state` varchar(22) NOT NULL,
  `state_code` char(2) NOT NULL,
  PRIMARY KEY (`state_code`)
)

INSERT INTO `states` VALUES ('Alaska', 'AK');
INSERT INTO `states` VALUES ('Alabama', 'AL');
INSERT INTO `states` VALUES ('Arkansas', 'AR');
INSERT INTO `states` VALUES ('Arizona', 'AZ');
INSERT INTO `states` VALUES ('California', 'CA');
INSERT INTO `states` VALUES ('Colorado', 'CO');
INSERT INTO `states` VALUES ('Connecticut', 'CT');
INSERT INTO `states` VALUES ('District of Columbia', 'DC');
INSERT INTO `states` VALUES ('Delaware', 'DE');
INSERT INTO `states` VALUES ('Florida', 'FL');
INSERT INTO `states` VALUES ('Georgia', 'GA');
INSERT INTO `states` VALUES ('Hawaii', 'HI');
INSERT INTO `states` VALUES ('Iowa', 'IA');
INSERT INTO `states` VALUES ('Idaho', 'ID');
INSERT INTO `states` VALUES ('Illinois', 'IL');
INSERT INTO `states` VALUES ('Indiana', 'IN');
INSERT INTO `states` VALUES ('Kansas', 'KS');
INSERT INTO `states` VALUES ('Kentucky', 'KY');
INSERT INTO `states` VALUES ('Louisiana', 'LA');
INSERT INTO `states` VALUES ('Massachusetts', 'MA');
INSERT INTO `states` VALUES ('Maryland', 'MD');
INSERT INTO `states` VALUES ('Maine', 'ME');
INSERT INTO `states` VALUES ('Michigan', 'MI');
INSERT INTO `states` VALUES ('Minnesota', 'MN');
INSERT INTO `states` VALUES ('Missouri', 'MO');
INSERT INTO `states` VALUES ('Mississippi', 'MS');
INSERT INTO `states` VALUES ('Montana', 'MT');
INSERT INTO `states` VALUES ('North Carolina', 'NC');
INSERT INTO `states` VALUES ('North Dakota', 'ND');
INSERT INTO `states` VALUES ('Nebraska', 'NE');
INSERT INTO `states` VALUES ('New Hampshire', 'NH');
INSERT INTO `states` VALUES ('New Jersey', 'NJ');
INSERT INTO `states` VALUES ('New Mexico', 'NM');
INSERT INTO `states` VALUES ('Nevada', 'NV');
INSERT INTO `states` VALUES ('New York', 'NY');
INSERT INTO `states` VALUES ('Ohio', 'OH');
INSERT INTO `states` VALUES ('Oklahoma', 'OK');
INSERT INTO `states` VALUES ('Oregon', 'OR');
INSERT INTO `states` VALUES ('Pennsylvania', 'PA');
INSERT INTO `states` VALUES ('Rhode Island', 'RI');
INSERT INTO `states` VALUES ('South Carolina', 'SC');
INSERT INTO `states` VALUES ('South Dakota', 'SD');
INSERT INTO `states` VALUES ('Tennessee', 'TN');
INSERT INTO `states` VALUES ('Texas', 'TX');
INSERT INTO `states` VALUES ('Utah', 'UT');
INSERT INTO `states` VALUES ('Virginia', 'VA');
INSERT INTO `states` VALUES ('Vermont', 'VT');
INSERT INTO `states` VALUES ('Washington', 'WA');
INSERT INTO `states` VALUES ('Wisconsin', 'WI');
INSERT INTO `states` VALUES ('West Virginia', 'WV');
INSERT INTO `states` VALUES ('Wyoming', 'WY');

ALTER TABLE `states`
ADD `country_id` int NOT NULL;

UPDATE `states` SET
`country_id` = '226';

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `city` varchar(50) NOT NULL,
  `state_code` char(2) NOT NULL,
  KEY `idx_state_code` (`state_code`)
);


#  ***********************27-MARCH-2021***********************

ALTER TABLE `user`
CHANGE `password` `password` varchar(250)  NULL ,
CHANGE `original_password` `original_password` varchar(250) NULL, 
CHANGE `auth_key` `auth_key` varchar(250)  NULL ,
CHANGE `password_reset_token` `password_reset_token` INT(11)  NULL ;


ALTER TABLE `cities` ADD `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE `states` DROP INDEX `PRIMARY`;

ALTER TABLE `states` ADD `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE `cities` ADD `state_id` int(11) NOT NULL;

UPDATE cities c,states s  SET  c.state_id= s.id WHERE c.state_code= s.state_code

# ***********************27-MARCH-2021********END***************
ALTER TABLE `package_master`
ADD `is_default` tinyint NOT NULL DEFAULT '0' COMMENT '1:yes 0:no' AFTER `title`;

INSERT INTO `package_master` (`title`, `is_default`, `status`)
VALUES ('Pay As You Go', '1', '1');

ALTER TABLE `company subscription`
RENAME TO `company_subscription`;

ALTER TABLE `company_subscription`
CHANGE `start_date` `start_date` date NULL AFTER `package_id`,
CHANGE `expiry_date` `expiry_date` date NULL AFTER `start_date`;

ALTER TABLE `company_subscription`
CHANGE `status` `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:active 2:in active' AFTER `expiry_date`;

ALTER TABLE `auth_assignment`
CHANGE `role_id` `role_id` varchar(250) NOT NULL AFTER `item_name`;

ALTER TABLE `user`
ADD `is_owner` tinyint NULL COMMENT '1:yes 0:no';

ALTER TABLE `user`
CHANGE `is_owner` `is_owner` tinyint(4) NULL DEFAULT '0' COMMENT '1:yes 0:no' AFTER `password_reset_token`;

ALTER TABLE `company_branch`
CHANGE `is_default` `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '1:yes 0:no' AFTER `zip_code`;

ALTER TABLE `user`
CHANGE `password_reset_token` `password_reset_token` varchar(250) NULL AFTER `auth_key`;

ALTER TABLE `company_master`
ADD `type` tinyint NOT NULL DEFAULT '0' COMMENT '1: recruiter 0:employer' AFTER `is_master`;

ALTER TABLE `user_details`
ADD `unique_id` varchar(20) NULL AFTER `user_id`;

ALTER TABLE `lead_master`
ADD `reference_no` varchar(50) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `title`,
CHANGE `description` `description` text COLLATE 'latin1_swedish_ci' NOT NULL AFTER `reference_no`,
ADD `recruiter_commision_type` tinyint NOT NULL COMMENT '1:percentage 0: amount' AFTER `recruiter_commission`,
ADD `recruiter_commision_mode` tinyint NOT NULL COMMENT '0:one time 1:monthly 2 Yearly' AFTER `recruiter_commision_type`;

ALTER TABLE `user`
ADD `is_suspend` tinyint(4) NULL DEFAULT '0' COMMENT '1:yes 0:no';

ALTER TABLE `lead_master`
CHANGE `description` `description` text COLLATE 'latin1_swedish_ci' NULL AFTER `reference_no`,
CHANGE `jobseeker_payment` `jobseeker_payment` int(11) NOT NULL COMMENT 'salary' AFTER `description`,
DROP `street_no`,
DROP `street_address`,
DROP `apt`,
DROP `city`,
DROP `zip_code`,
CHANGE `recruiter_commission` `recruiter_commission` int(11) NOT NULL COMMENT 'agancy commision' AFTER `end_date`,
CHANGE `recruiter_commision_mode` `recruiter_commision_mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:one time 1:monthly 2 Yearly' AFTER `recruiter_commision_type`,
CHANGE `price` `price` int(11) NULL COMMENT 'admin or master admin decide lead price' AFTER `recruiter_commision_mode`,
CHANGE `status` `status` int(11) NULL DEFAULT '0' COMMENT '0:pending 1:approve 2:reject' AFTER `price`,
ADD `created_by` int(11) NOT NULL,
ADD `updated_by` int(11) NOT NULL AFTER `created_by`;

ALTER TABLE `lead_master`
ADD UNIQUE `reference_no` (`reference_no`);

ALTER TABLE `company_master`
ADD `reference_no` varchar(50) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `company_name`;

ALTER TABLE `company_master`
ADD UNIQUE `reference_no` (`reference_no`);

ALTER TABLE `user`
CHANGE `status` `status` int(11) NOT NULL DEFAULT '0' COMMENT '1:approved 0:pending 2:rejected' AFTER `original_password`;

ALTER TABLE `user`
ADD `comment` varchar(500) NOT NULL AFTER `status`;ALTER TABLE `user`
CHANGE `comment` `comment` varchar(500) COLLATE 'latin1_swedish_ci' NOT NULL COMMENT 'approved and rejection comment' AFTER `status`;




# *********************************

ALTER TABLE `user` CHANGE `comment` `comment` VARCHAR(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'approved and rejection comment';

# ***********************11-April-2021***********************
ALTER TABLE `role_master`
ADD `company_id` int NOT NULL AFTER `role_name`;

# ***********************11-April-2021************END***********

# ***********************13-April-2021***********************

ALTER TABLE `benefits` ADD `created_by` INT(11) NULL AFTER `updated_at`;
ALTER TABLE `benefits` ADD `updated_by` INT(11) NULL AFTER `created_by`;
ALTER TABLE `discipline` ADD `created_by` INT(11) NULL AFTER `updated_at`;
ALTER TABLE `discipline` ADD `updated_by` INT(11) NULL AFTER `created_by`;
ALTER TABLE `speciality` ADD `created_by` INT(11) NULL AFTER `updated_at`;
ALTER TABLE `speciality` ADD `updated_by` INT(11) NULL AFTER `created_by`;

-- Adminer 4.8.0 MySQL 5.5.5-10.4.14-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `advertisement`;
CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_url` varchar(100) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `location_name` varchar(100) NOT NULL,
  `is_active` enum('0','1') NOT NULL COMMENT '0- Inactive, 1- Active	',
  `location_display` int(11) NOT NULL,
  `active_from` datetime DEFAULT NULL,
  `active_to` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `street_no` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `apt` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-04-13 05:24:47
ALTER TABLE `role_master`
ADD `company_id` int NOT NULL AFTER `role_name`;
UPDATE `role_master` SET `company_id` = '1';

UPDATE `auth_item` SET `description` = 'Staff' WHERE `name` = 'user' AND `name` = 'user' COLLATE utf8mb4_bin;


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('recruiter', '1', 'Recruiter', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('recruiter-create', '2', 'Create', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('recruiter-update', '', 'Update', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('recruiter-view', '2', 'View', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('branch', '1', 'Branch', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('branch-create', '2', 'Create', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('update', '2', 'Update', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('branch-view', '2', 'View', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('package', '1', 'Package', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('package-create', '2', 'Create', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('package-update', '2', 'Update', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('role', '1', 'Role', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('role-create', '2', 'Create', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('role-update', '2', 'Update', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('role-delete', '2', 'Delete', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('branch', 'branch-create');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('branch-update', '2', 'Update', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('branch', 'branch-update');


INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('branch', 'branch-view');


INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('package-view', '2', 'View', NULL, NULL, '1618133004', '1618133004');


INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('package', 'package-create');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('package', 'package-update');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('package', 'package-view');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('recruiter', 'recruiter-create');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('recruiter', 'recruiter-update');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('recruiter', 'recruiter-view');

DELETE FROM `auth_item`
WHERE ((`name` = 'update' AND `name` = 'update' COLLATE utf8mb4_bin));

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('role', 'role-create');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('role', 'role-update');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('role', 'role-view');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('role', 'role-delete');

UPDATE `auth_item` SET
`name` = 'approval',
`type` = '1',
`description` = 'Approval & Verification',
`rule_name` = NULL,
`data` = NULL,
`created_at` = '1617027889',
`updated_at` = '1617027889'
WHERE `name` = 'lead' AND `name` = 'lead' COLLATE utf8mb4_bin;

UPDATE `auth_item` SET
`name` = 'lead-verify',
`type` = '2',
`description` = 'Lead Verify',
`rule_name` = NULL,
`data` = NULL,
`created_at` = '1617027889',
`updated_at` = '1617027889'
WHERE `name` = 'verify' AND `name` = 'verify' COLLATE utf8mb4_bin;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('user-approval', '2', 'User Approval', NULL, NULL, '1618133004', '1618133004');

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('approval', 'user-approval');

UPDATE `auth_item` SET
`name` = 'user-approve',
`type` = '2',
`description` = 'Approve User',
`rule_name` = NULL,
`data` = NULL,
`created_at` = '1618133004',
`updated_at` = '1618133004'
WHERE `name` = 'user-approval' AND `name` = 'user-approval' COLLATE utf8mb4_bin;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES ('user-request-view', '2', 'View User Approval Request', NULL, NULL, NULL, NULL);

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES ('approval', 'user-request-view');


# ***********************13-April-2021************END***********

ALTER TABLE `company_master`
ADD `status` tinyint NOT NULL DEFAULT '0' COMMENT '1:approved 0:pending 2:rejected' AFTER `type`;

# **************PENDING OF 10-04-21***********
ALTER TABLE `lead_master`
ADD `branch_id` int(11) NOT NULL AFTER `id`;

ALTER TABLE `lead_master`
ADD `comment` varchar(500) NULL COMMENT 'for approval / rejection' AFTER `status`;

ALTER TABLE `lead_master`
CHANGE `jobseeker_payment` `jobseeker_payment` double NOT NULL COMMENT 'salary' AFTER `description`;

ALTER TABLE `lead_master`
CHANGE `start_date` `start_date` date NOT NULL AFTER `shift`,
CHANGE `end_date` `end_date` date NULL AFTER `start_date`;

ALTER TABLE `lead_master`
CHANGE `recruiter_commission` `recruiter_commission` int(11) NULL COMMENT 'agancy commision' AFTER `end_date`,
CHANGE `recruiter_commision_type` `recruiter_commision_type` tinyint(4) NULL COMMENT '1:percentage 0: amount' AFTER `recruiter_commission`;

ALTER TABLE `lead_master`
CHANGE `recruiter_commision_type` `recruiter_commission_type` tinyint(4) NULL COMMENT '1:percentage 0: amount' AFTER `recruiter_commission`,
CHANGE `recruiter_commision_mode` `recruiter_commission_mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:one time 1:monthly 2 Yearly' AFTER `recruiter_commission_type`;

# **************PENDING OF 10-04-21 END***********

ALTER TABLE `user_details`
CHANGE `mobile_no` `mobile_no` varchar(20) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `last_name`;

ALTER TABLE `company_master`
CHANGE `company_mobile` `company_mobile` varchar(20) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `company_email`;

ALTER TABLE `vendor`
CHANGE `phone` `phone` varchar(20) NOT NULL AFTER `email`;

ALTER TABLE `advertisement`
CHANGE `location_display` `location_display` tinyint NOT NULL COMMENT '1:Home Page' AFTER `is_active`;

ALTER TABLE `package_master`
ADD `price` float NOT NULL AFTER `title`;

ALTER TABLE `package_master`
ADD `created_at` int(11) NOT NULL,
ADD `updated_at` int(11) NOT NULL AFTER `created_at`,
ADD `created_by` int(11) NOT NULL AFTER `updated_at`,
ADD `updated_by` int(11) NOT NULL AFTER `created_by`;

ALTER TABLE `lead_master`
ADD `approved_at` int(11) NULL AFTER `updated_at`

CREATE TABLE `mobile_version_master` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `device_type` varchar(250) NOT NULL,
  `version` varchar(250) NOT NULL,
  `force_update` tinyint NOT NULL DEFAULT '0' COMMENT '1:yes 0:no',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
);

INSERT INTO `mobile_version_master` (`device_type`, `version`, `force_update`, `created_at`, `updated_at`)
VALUES ('android', '1.0.0', '0', now(), now());

INSERT INTO `mobile_version_master` (`device_type`, `version`, `force_update`, `created_at`, `updated_at`)
VALUES ('ios', '1.0.0', '0', now(), now());

ALTER TABLE `company_subscription_payment`
DROP `payment_type`,
ADD `payment_response` text NULL AFTER `lead_id`,
ADD `customer_transaction_id` text NULL AFTER `payment_response`;

ALTER TABLE `company_subscription_payment`
ADD `status` tinyint NULL COMMENT '1: success 2:fail' AFTER `customer_transaction_id`;

ALTER TABLE `company_subscription_payment`
CHANGE `status` `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: success 2:fail' AFTER `customer_transaction_id`;

ALTER TABLE `lead_master` ADD `visible_to` TINYINT NOT NULL DEFAULT '0' COMMENT '0:Both 1:recruiter 2:self' AFTER `recruiter_commission_mode`;

ALTER TABLE `lead_discipline` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

ALTER TABLE `lead_benefit` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

ALTER TABLE `lead_specialty` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

ALTER TABLE `lead_master`
ADD `street_no` varchar(255) NOT NULL,
ADD `street_address` varchar(255) NOT NULL AFTER `street_no`,
ADD `apt` varchar(255) NULL AFTER `street_address`,
ADD `city` int NULL AFTER `apt`,
ADD `zip_code` varchar(20) NULL AFTER `city`;