DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_justification`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
                FROM vl_national_justification `vnj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vnj.justification
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
