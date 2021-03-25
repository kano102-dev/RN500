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