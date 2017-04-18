DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_gender`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `gn`.`name`, 
                        SUM(`vrg`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_county_gender` `vrg` 
                    JOIN `gender` `gn` 
                        ON `vrg`.`gender` = `gn`.`ID`
                WHERE 1 ";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `vrg`.`county` = '",C_id,"' GROUP BY `gn`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
