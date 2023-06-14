TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `App_log` AFTER UPDATE ON `appointment` FOR EACH ROW INSERT into app_log(App_id,Vet_id) values (OLD.App_id,NEW.Vet_id)'
sql_modes=1098907648
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_unicode_ci'
db_cl_names='utf8mb4_general_ci'
created=1683456065693441
