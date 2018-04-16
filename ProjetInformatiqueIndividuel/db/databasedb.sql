create database if not exists experienceetranger character set utf8 collate utf8_unicode_ci;
use experienceetranger;

grant all privileges on experienceetranger.* to 'experience_user'@'localhost' identified by 'secret';