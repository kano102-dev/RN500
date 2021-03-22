INSERT INTO `company_master` (`company_name`, `company_email`, `company_mobile`, `priority`, `address_id`, `is_master`, `created_at`, `updated_at`)
VALUES ('RN500', '', '', '', '', '', '', '');

INSERT INTO `company_branch` (`id`, `company_id`, `branch_name`, `address_id`, `is_default`, `created_at`, `updated_at`)
VALUES ('', '1', 'HO', '', '1', '', '');

INSERT INTO `user` (`email`, `password`, `original_password`, `status`, `role_id`, `branch_id`, `type`, `is_master_admin`, `auth_key`, `password_reset_token`)
VALUES ('rn500@gmail.com', '$2y$13$l3gZ76OvvqR3OmPDAFgT9eUJQDYJsIGPGIecUtKf6GUaIqRlwphWS', 'admin123', '1', NULL, '1', '', '1', '', '');

