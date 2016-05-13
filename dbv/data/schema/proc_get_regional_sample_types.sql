DROP PROCEDURE IF EXISTS `proc_get_regional_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sample_types`
(IN C_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
					`month`,
					`year`,
					`edta`,
					`dbs`,
					`plasma`
				FROM `vl_county_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",from_year,"' OR `year`='",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;