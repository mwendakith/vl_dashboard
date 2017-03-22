DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_justification`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vj`.`name`,
                        SUM(`vcj`.`sustxfail`) AS `sustxfail`
                    FROM `vl_county_justification` `vcj`
                    JOIN `viraljustifications` `vj`
                        ON `vcj`.`justification` = `vj`.`ID`
                WHERE 1 ";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vcj`.`year` = '",filter_year,"' AND `vcj`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vcj`.`year` = '",filter_year,"' AND `vcj`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vcj`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `vcj`.`county` = '",C_id,"' GROUP BY `vj`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
