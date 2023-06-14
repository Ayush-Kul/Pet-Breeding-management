TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `Male_pets` AFTER INSERT ON `pets` FOR EACH ROW if(NEW.Gender ="Male") then\nINSERT INTO m_pet SET pet_id = NEW.pet_id;\nend if' 'CREATE DEFINER=`root`@`localhost` TRIGGER `Female_pets` AFTER INSERT ON `pets` FOR EACH ROW if(NEW.Gender ="Female") then \nINSERT INTO f_pet SET pet_id = NEW.pet_id; \nend if'
sql_modes=1098907648 1098907648
definers='root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
created=1684166830703136 1684167706036123
