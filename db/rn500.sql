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

ALTER TABLE `user_details`
ADD `profile_pic` varchar(250) NOT NULL AFTER `address_id`;

ALTER TABLE `user_details`
CHANGE `profile_pic` `profile_pic` varchar(250) COLLATE 'latin1_swedish_ci' NULL AFTER `address_id`;

ALTER TABLE `user_details`
ADD `current_position` varchar(250) COLLATE 'latin1_swedish_ci' NULL AFTER `profile_pic`,
ADD `speciality` varchar(250) COLLATE 'latin1_swedish_ci' NULL AFTER `current_position`,
ADD `work experience` varchar(250) COLLATE 'latin1_swedish_ci' NULL AFTER `speciality`,
ADD `job_title` tinyint NULL COMMENT '(1) Actively Looking, (2) Looking from Date: MM/DD/YYYY.' AFTER `work experience`,
ADD `job_looking_from` date NULL COMMENT 'required when job_title 2' AFTER `job_title`,
ADD `travel_preference` tinyint NULL COMMENT '(1) 100%, (2) 50%, (3) 25% (3) 0% (4) Available anytime.' AFTER `job_looking_from`,
ADD `ssn` int NULL COMMENT 'Last 4 Digit of SSN' AFTER `travel_preference`,
ADD `work_authorization` tinyint NULL COMMENT '1:US Citizen ( ),2: Green Card Holder ( ),3: Other' AFTER `ssn`,
ADD `work_authorization_comment` text COLLATE 'latin1_swedish_ci' NULL COMMENT 'required when work_authorization 3' AFTER `work_authorization`,
ADD `license_suspended` text COLLATE 'latin1_swedish_ci' NULL AFTER `work_authorization_comment`,
ADD `professional_liability` text COLLATE 'latin1_swedish_ci' NULL AFTER `license_suspended`;

CREATE TABLE `job_location_preference` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `city` int NOT NULL,
  `priority` int NOT NULL,
   `user_id` int NOT NULL
);

CREATE TABLE `work_experience` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `organization_name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `education` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `degree_name` varchar(250) NOT NULL,
  `year_complete` varchar(50) NOT NULL,
  `institution` varchar(500) NOT NULL,
  `location` varchar(500) NOT NULL
);

ALTER TABLE `education`
ADD `user_id` int(11) NOT NULL AFTER `id`,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

CREATE TABLE `certifications` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `certificate_name` varchar(250) NOT NULL,
  `expiry_date` varchar(250) NOT NULL,
  `issue_by` varchar(500) NOT NULL,
  `verified` int NOT NULL,
  `user_id` int(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

ALTER TABLE `certifications`
ADD `issuing_state` int(11) NOT NULL AFTER `id`;

ALTER TABLE `licenses`
ADD `issuing_state` int(11) NOT NULL AFTER `id`;

CREATE TABLE `references` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `city` int NOT NULL,
  `state` int NOT NULL,
  `relation` varchar(250) NOT NULL
);

ALTER TABLE `references`
ADD `user_id` int(11) NOT NULL,
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `name` varchar(500) NOT NULL,
  `expiry_date` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `path` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `dicipline` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(250) NOT NULL
);

ALTER TABLE `dicipline`
CHANGE `name` `name` varchar(500) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `id`;

CREATE TABLE `benefits` (
  `id` int NOT NULL,
  `name` varchar(500) NOT NULL,
  `lead_id` int NOT NULL,
  `cre` int NOT NULL
);

ALTER TABLE `benefits`
CHANGE `cre` `created_at` int(11) NOT NULL AFTER `lead_id`,
ADD `updated_at` int(11) NOT NULL;

ALTER TABLE `dicipline`
ADD `created_at` int NOT NULL,
ADD `updated_at` int NOT NULL AFTER `created_at`,
RENAME TO `discipline`;

ALTER TABLE `benefits`
DROP `lead_id`;

CREATE TABLE `speciality` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(500) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
);

ALTER TABLE `benefits`
CHANGE `id` `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

CREATE TABLE `lead_discipline` (
  `lead_id` int NOT NULL,
  `discipline_id` int(11) NOT NULL,
  FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`id`)
);  

CREATE TABLE `lead_benefit` (
  `lead_id` int NOT NULL,
  `benefit_id` int(11) NOT NULL,
  FOREIGN KEY (`benefit_id`) REFERENCES `benefits` (`id`)
);

CREATE TABLE `lead_speciality` (
  `lead_id` int NOT NULL,
  `speciality_id` int(11) NOT NULL,
  FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`)
);

CREATE TABLE `jobseeker_lead` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `lead_id` int NOT NULL,
  `jobseeker_id` int NOT NULL,
  `recruiter_id` int NOT NULL
);

CREATE TABLE `auth_assignment` (
  `item_name` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

ALTER TABLE `auth_assignment`
ADD PRIMARY KEY `item_name_user_id` (`item_name`, `user_id`);

CREATE TABLE `auth_item` (
  `name` int NOT NULL,
  `type` int NOT NULL,
  `description` int NOT NULL,
  `rule_name` int NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
);

CREATE TABLE `auth_item_child` (
  `parent` varchar(500) NOT NULL,
  `child` varchar(500) NOT NULL
);

ALTER TABLE `auth_item_child`
ADD PRIMARY KEY `parent_child` (`parent`, `child`);

ALTER TABLE `auth_item`
CHANGE `name` `name` varchar(250) NOT NULL FIRST,
CHANGE `description` `description` varchar(250) NOT NULL AFTER `type`,
CHANGE `rule_name` `rule_name` varchar(250) NULL AFTER `description`;

ALTER TABLE `auth_item`
CHANGE `type` `type` tinyint NOT NULL AFTER `name`;

CREATE TABLE `role_master` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_name` varchar(250) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
);
-- 2021-03-21 06:43:23
