-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_no` varchar(250) NOT NULL,
  `street_address` varchar(250) NOT NULL,
  `suit/apt` varchar(250) NOT NULL,
  `city` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `company subscription`;
CREATE TABLE `company subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `company_branch`;
CREATE TABLE `company_branch` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_name` varchar(200) NOT NULL,
  `address_id` int(11) NOT NULL,
  `is_default` int(11) NOT NULL COMMENT '1:yes 0:no',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `company_master`;
CREATE TABLE `company_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(250) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_mobile` varchar(11) NOT NULL,
  `priority` int(11) NOT NULL COMMENT '1:high 2:modrate 3:semi modrate 4:low',
  `address_id` int(11) NOT NULL,
  `is_master` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `company_subscription_payment`;
CREATE TABLE `company_subscription_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `lead_master`;
CREATE TABLE `lead_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `jobseeker_payment` int(11) NOT NULL,
  `payment_type` tinyint(4) NOT NULL COMMENT '1:hourly,2:weekly,3:monthly',
  `job_type` tinyint(4) NOT NULL COMMENT '1:part_time,2:permanante,3:travel,4:on call',
  `shift` tinyint(4) NOT NULL COMMENT '1:all 2:morning 3:evening 4:night 5:flatulate',
  `start_date` int(11) NOT NULL,
  `end_date` int(11) DEFAULT NULL,
  `address_id` int(11) NOT NULL,
  `recruiter_commission` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0:pending 1:approve 2:reject',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `lead_master_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `otp_request`;
CREATE TABLE `otp_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otp` int(11) NOT NULL,
  `is_verified` tinyint(4) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `otp_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `package_master`;
CREATE TABLE `package_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `original_password` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:active 0:in active',
  `role_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1:recruiter,2:employeer 3:jobseeker',
  `is_master_admin` tinyint(4) NOT NULL,
  `auth_key` varchar(250) NOT NULL,
  `password_reset_token` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2021-03-21 06:43:23
