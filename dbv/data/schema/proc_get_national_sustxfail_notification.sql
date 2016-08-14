DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_notification`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`sustxfail`) AS `sustxfail`, 
                        ((SUM(`sustxfail`)/SUM(`alltests`))*100) AS `sustxfail_rate` 
                    FROM `vl_national_summary`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;