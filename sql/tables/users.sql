/* user */

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	uid INT(11) not null AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci not null,
	role VARCHAR(16) not null,
  email VARCHAR(56) not null,
  created DATETIME not null,
	password VARCHAR(512) not null,
	countryID VARCHAR(2) not null
)

DROP TABLE IF EXISTS posts;
CREATE TABLE `posts` (
  `uid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(100) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `path` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_path` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_uid` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(2) NOT NULL,
  `nsfwl` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `upvotes` int(11) NOT NULL,
  `downvotes` int(11) NOT NULL,
  `ispic` bit(1) NOT NULL
)

CREATE TABLE tbl_comment (
  comment_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    parent_comment_id INT(11) NOT NULL,
    comment VARCHAR(200) NOT NULL,
    comment_sender_name VARCHAR(40) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)