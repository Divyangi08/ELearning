SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone="+00:00";

SET NAMES utf8;

-- -----------------------------
-- Table: admin
-- -----------------------------
CREATE TABLE `admin` (
`admin_id` int(11) NOT NULL,
`admin_name` varchar(255) NOT NULL,
`admin_email` varchar(255) NOT NULL,
`admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` VALUES
(1,'Admin Kumar','admin@gmail.com','admin');

-- -----------------------------
CREATE TABLE `course` (
`course_id` int(11) NOT NULL,
`course_name` text NOT NULL,
`course_desc` text NOT NULL,
`course_author` varchar(255) NOT NULL,
`course_img` text NOT NULL,
`course_duration` text NOT NULL,
`course_price` int(11) NOT NULL,
`course_original_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `course` VALUES
(8,'Learn Guitar The Easy Wayy','This course is your Free Pass to playing guitar.','Adil','../image/courseimg/Guitar.jpg','3 Hours',1655,1800),
(9,'Complete PHP Bootcamp','This course will help you get all the Object Oriented PHP, MYSQLi.','Rajesh Kumar','../image/courseimg/php.jpg','3 Months',700,1700),
(10,'Learn Python A-Z','Python programming course.','Rahul Kumar','../image/courseimg/Python.jpg','4 Months',800,1800);

-- -----------------------------
CREATE TABLE `courseorder` (
`co_id` int(11) NOT NULL,
`order_id` varchar(255) NOT NULL,
`stu_email` varchar(255) NOT NULL,
`course_id` int(11) NOT NULL,
`status` varchar(255) NOT NULL,
`respmsg` text NOT NULL,
`amount` int(11) NOT NULL,
`order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `courseorder` VALUES
(3,'ORDS98956453','ant@example.com',10,'TXN_SUCCESS','Txn Success',800,'2019-09-12');

-- -----------------------------
CREATE TABLE `feedback` (
`f_id` int(11) NOT NULL,
`f_content` text NOT NULL,
`stu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `feedback` VALUES
(3,'My life at iSchool made me stronger.',171);

-- -----------------------------
CREATE TABLE `lesson` (
`lesson_id` int(11) NOT NULL,
`lesson_name` text NOT NULL,
`lesson_desc` text NOT NULL,
`lesson_link` text NOT NULL,
`course_id` int(11) NOT NULL,
`course_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `lesson` VALUES
(32,'Introduction to Python','Intro Desc','../lessonvid/video2.mp4',10,'Learn Python A-Z');

-- -----------------------------
CREATE TABLE `student` (
`stu_id` int(11) NOT NULL,
`stu_name` varchar(255) NOT NULL,
`stu_email` varchar(255) NOT NULL,
`stu_pass` varchar(255) NOT NULL,
`stu_occ` varchar(255) NOT NULL,
`stu_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `student` VALUES
(171,'Captain Marvel','cap@example.com','123456','Web Designer','../image/stu/student2.jpg');

-- -----------------------------
ALTER TABLE `admin` ADD PRIMARY KEY (`admin_id`);
ALTER TABLE `course` ADD PRIMARY KEY (`course_id`);
ALTER TABLE `courseorder` ADD PRIMARY KEY (`co_id`);
ALTER TABLE `feedback` ADD PRIMARY KEY (`f_id`);
ALTER TABLE `lesson` ADD PRIMARY KEY (`lesson_id`);
ALTER TABLE `student` ADD PRIMARY KEY (`stu_id`);

ALTER TABLE `admin` MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `course` MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `courseorder` MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `feedback` MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `lesson` MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `student` MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;