DROP PROCEDURE IF EXISTS `proc_get_partner_sustxfail_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sustxfail_gender`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `gn`.`name`, 
                        SUM(`vrg`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_partner_gender` `vrg` 
                    JOIN `gender` `gn` 
                        ON `vrg`.`gender` = `gn`.`ID`
                WHERE 1  ";

  
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vrg`.`partner` = '",P_id,"' AND `vrg`.`year` = '",filter_year,"' AND `vrg`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vrg`.`partner` = '",P_id,"' AND `vrg`.`year` = '",filter_year,"' AND `vrg`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vrg`.`partner` = '",P_id,"' AND `vrg`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `gn`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
