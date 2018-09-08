CREATE DATABASE trezoteam;
USE  trezoteam;
CREATE TABLE `users` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`AutoId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



CREATE TABLE `access` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`AutoId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `quiz` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`AutoId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `type` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`AutoId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `user_quiz` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `access_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`AutoId`),
  KEY `FK_quiz_idx` (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `question` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`AutoId`),
  KEY `FK_quiz_idx` (`quiz_id`),
  KEY `FK_type_idx` (`type`),
  CONSTRAINT `FK_type` FOREIGN KEY (`type`) REFERENCES `type` (`AutoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`AutoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `answers` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `right_answer` int(11) DEFAULT '0',
  `status` char(1) DEFAULT 'A',
  PRIMARY KEY (`AutoId`),
  KEY `FK_question_idx` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `answers_user` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answers` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `access_id` int(11) DEFAULT NULL,
  `user_quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`AutoId`),
  KEY `FK_question_idx` (`question_id`),
  KEY `FK_user_quiz_idx` (`user_quiz_id`),
  KEY `FK_access_idx` (`access_id`),
  CONSTRAINT `FK_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`AutoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_quiz` FOREIGN KEY (`user_quiz_id`) REFERENCES `user_quiz` (`AutoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


INSERT INTO `users` (`login`, `password`, `created_at`) VALUES ('admin', md5('123'), sysdate());
INSERT INTO `type` (`name`) VALUES ('Multipla escolha');
INSERT INTO `type` (`name`) VALUES ('CheckBox');
