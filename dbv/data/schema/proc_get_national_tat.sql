DROP PROCEDURE IF EXISTS `proc_get_national_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_tat`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vns`.`tat1`, 
                        `vns`.`tat2`, 
                        `vns`.`tat3`, 
                        `vns`.`tat4` 
                    FROM `vl_national_summary` `vns` 
                    WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' AND `vns`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' AND `vns`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' ");
    END IF;



     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
