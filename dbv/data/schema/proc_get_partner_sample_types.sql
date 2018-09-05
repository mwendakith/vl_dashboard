DROP PROCEDURE IF EXISTS `proc_get_partner_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sample_types`
<<<<<<< HEAD
(IN P_id INT(11), IN from_year INT(11), IN to_year INT(11))
=======
(IN P_id INT(11), IN filter_year INT(11), IN to_year INT(11))
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
BEGIN
  SET @QUERY =    "SELECT
					`month`,
					`year`,
					SUM(`edta`) AS `edta`,
 					SUM(`dbs`) AS `dbs`,
<<<<<<< HEAD
 					SUM(`plasma`) AS `plasma`
				FROM `vl_partner_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",from_year,"' OR `year`='",to_year,"' GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
=======
 					SUM(`plasma`) AS `plasma`,
					SUM(`alledta`) AS `alledta`,
 					SUM(`alldbs`) AS `alldbs`,
 					SUM(`allplasma`) AS `allplasma`,
					SUM(`Undetected`+`less1000`) AS `suppressed`,
					SUM(`Undetected`+`less1000`+`less5000`+`above5000`) AS `tests`,
					SUM((`Undetected`+`less1000`)*100/(`Undetected`+`less1000`+`less5000`+`above5000`)) AS `suppression`
				FROM `vl_partner_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND (`year` = '",filter_year,"' OR  `year` = '",to_year,"') GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
