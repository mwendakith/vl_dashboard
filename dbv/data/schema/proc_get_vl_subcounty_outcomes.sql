DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`d`.`name`, 
						SUM(`vss`.`less5000`+`vss`.`above5000`) AS `nonsuppressed`, 
						SUM(`vss`.`Undetected`+`vss`.`less1000`) AS `suppressed` 
						FROM `vl_subcounty_summary` `vss`
						JOIN `districts` `d` 
						ON `vss`.`subcounty` = `d`.`ID`
					WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;