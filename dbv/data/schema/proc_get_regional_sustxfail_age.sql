DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_age`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        SUM(`vca`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_county_age` `vca` 
                    JOIN `agecategory` `ac` 
                        ON `vca`.`age` = `ac`.`subID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vca`.`year` = '",filter_year,"' AND `vca`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vca`.`year` = '",filter_year,"' AND `vca`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vca`.`year` = '",filter_year,"' ");
    END IF;



    SET @QUERY = CONCAT(@QUERY, " AND `vca`.`county` = '",C_id,"'  GROUP BY `ac`.`name` ORDER BY `ac`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
