DROP PROCEDURE IF EXISTS `proc_get_vl_sample_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_sample_summary`
(IN S_id INT(11), IN from_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            SUM(`Undetected`)+SUM(`less1000`) AS `suppressed`,
            SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`) AS `tests`,
            (SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`
            FROM `vl_national_sampletype`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && from_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && from_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",from_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",from_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' AND `month`='",from_month,"' ");
      END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `sampletype` = '",S_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
