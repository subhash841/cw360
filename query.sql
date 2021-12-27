
ALTER TABLE predictions ADD current_price DECIMAL(65,2) NULL DEFAULT NULL AFTER price;


DELIMITER $$
CREATE TRIGGER `update_swipe_count` AFTER INSERT ON `executed_predictions` FOR EACH ROW BEGIN
   IF (new.swipe_status  = 'agreed') THEN
      UPDATE   `predictions` SET `agreed`= (agreed + 1)  where id = new.prediction_id;
   ELSEIF (new.swipe_status  = 'disagreed') THEN
      UPDATE   `predictions` SET `disagreed`= (disagreed + 1)  where id = new.prediction_id;
      END IF;
END
$$
DELIMITER ;


CREATE TABLE `points` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `game_id` bigint(20) NOT NULL,
  `points` decimal(65,2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `coins` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `coins` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `users` ADD  `coins` DECIMAL( 65, 2 ) NOT NULL AFTER  `device_type` ;
ALTER TABLE  `users` ADD  `login_ip` VARCHAR( 255 ) NULL AFTER  `coins` ; 
ALTER TABLE `predictions` ADD `agreed` BIGINT(20) NOT NULL AFTER `current_price`, ADD `disagreed` BIGINT(20) NOT NULL AFTER `agreed`;
ALTER TABLE  `executed_predictions` ADD  `topic_id` BIGINT( 20 ) NOT NULL AFTER  `seller_id` ;


ALTER TABLE `points` ADD `modified_date` TIMESTAMP NULL DEFAULT NULL AFTER `created_date`;
ALTER TABLE  `executed_predictions` ADD  `agreed` BIGINT( 20 ) NOT NULL AFTER  `topic_id` ,
ADD  `disagreed` BIGINT( 20 ) NOT NULL AFTER  `agreed` ;


CREATE TABLE `summary_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `game_id` bigint(20) NOT NULL,
  `prediction_id` bigint(20) NOT NULL,
  `swipe_status` VARCHAR( 10 ) NOT NULL,
  `sell_points` decimal(65,2) NOT NULL,
  `buy_points` decimal(65,2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `users` ADD `dob` VARCHAR(40) NOT NULL AFTER `created_date`;
ALTER TABLE  `users` ADD  `gender` VARCHAR( 1 ) NULL AFTER  `device_token` ;
ALTER TABLE  `users` ADD  `phone` BIGINT( 20 ) NULL AFTER  `gender` ;
ALTER TABLE  `users` ADD  `image` VARCHAR( 60 ) NULL AFTER  `gender` ;
ALTER TABLE `predictions` CHANGE `current_price` `current_price` DECIMAL(65,2) NOT NULL;

CREATE TABLE IF NOT EXISTS `rank` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `game_id` bigint(20) NOT NULL,
  `rank` bigint(20) NOT NULL,
  `total_points` decimal(65,2) NOT NULL COMMENT 'available  point  + bonus point + current point(purchase price + profit )',
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `executed_predictions` ADD `profit_point` DECIMAL(65,2) NULL DEFAULT '0' AFTER `prediction_id`, ADD `bonus_points` DECIMAL(65,2) NULL DEFAULT '0' AFTER `profit_point`;

ALTER TABLE `users` ADD `macid_unique` VARCHAR( 20 ) NULL AFTER `login_ip` ;

ALTER TABLE `games` ADD `max_players` BIGINT(20) NOT NULL AFTER `link`;


CREATE TABLE IF NOT EXISTS `wallet_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `game_id` bigint(20) DEFAULT NULL,
  `quiz_id` bigint(20) DEFAULT NULL,
  `prediction_id` bigint(20) DEFAULT NULL,
  `subscription_id` bigint(20) DEFAULT NULL,
  `coins` decimal(65,2) DEFAULT NULL,
  `points` decimal(65,2) DEFAULT NULL,
  `type` ENUM('0','1') NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
ALTER TABLE `wallet_history` CHANGE `type` `type` ENUM( '0', '1' ) CHARACTER
 SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '(''0''=>''free initial_game_points'',''1''=>''subscription'')';
ALTER TABLE wallet_history CHANGE type type ENUM('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '(\'0\'=>\'free initial_game_points\',\'1\'=>\'subscription\',2=>\'gift game coins\')';

CREATE TABLE IF NOT EXISTS `redeem_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `coins` decimal(65,2) NOT NULL,
  `status` ENUM ('0','1','2') NOT NULL DEFAULT '0' COMMENT '(''0''=>''Request'',''1''=>''Accept'',2=>''Cancel'')',
  `created_date` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


DROP TRIGGER IF EXISTS `update_swipe_count`;CREATE DEFINER=`root`@`localhost` TRIGGER `update_swipe_count` AFTER INSERT ON `executed_predictions` FOR EACH ROW BEGIN IF (new.swipe_status = 'agreed') THEN UPDATE `predictions` SET `agreed`= (agreed + 1) where id = new.prediction_id; INSERT INTO `summary_history` (user_id, game_id, prediction_id, swipe_status, sell_points, buy_points) VALUES (new.user_id, new.game_id, new.prediction_id, new.swipe_status, 0, new.executed_points); ELSEIF (new.swipe_status = 'disagreed') THEN UPDATE `predictions` SET `disagreed`= (disagreed + 1) where id = new.prediction_id; INSERT INTO `summary_history` (user_id, game_id, prediction_id, swipe_status, sell_points, buy_points) VALUES (new.user_id, new.game_id, new.prediction_id, new.swipe_status, 0, 0); END IF; END

ALTER TABLE `points` ADD `update_type` ENUM('0','1','2','3') NOT NULL DEFAULT '0' AFTER `modified_date`;

ALTER TABLE `points` CHANGE `update_type` `update_type` ENUM('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '\'0\'=>\'Insert points\', \'1\'=>\'Card swipe to Yes\' ';


ALTER TABLE `points_log` ADD `update_type` ENUM('0','1','2','3') NOT NULL COMMENT '\'0\'=>\'Insert points\', \'1\'=>\'Card swipe to Yes\' ' AFTER `created_date`;

CREATE TRIGGER `points_log` AFTER UPDATE ON `points` FOR EACH ROW BEGIN IF !(NEW.points <=> OLD.points) THEN INSERT INTO points_log(user_id, game_id, points_before, update_points, points_after, update_type) VALUES (old.user_id,old.game_id,old.points,new.points - old.points, new.points,new.update_type); END IF; END


ALTER TABLE `points_log` CHANGE `update_type` `update_type` ENUM('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '\'0\'=>\'Insert points\', \'1\'=>\'Card swipe to Yes\', \'2\'=>\'Change to Yes\', \'3\'=>\'Change to No\' ';

ALTER TABLE `points` CHANGE `update_type` `update_type` ENUM('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '\'0\'=>\'Insert points\', \'1\'=>\'Card swipe to Yes\', \'2\'=>\'Change to Yes\', \'3\'=>\'Change to No\' ';

ALTER TABLE `wallet_history` CHANGE `type` `type` ENUM('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '(\'0\'=>\'free initial_game_points\',\'1\'=>\'subscription\',2=>\'gift game coins\',3=>\'require game points\')';



