
create database if not exists `testing` COLLATE 'utf8_general_ci';
grant all privileges on testing.* to 'default'@'%' identified by 'secret' with grant option;
flush privileges;
