DROP PROCEDURE IF EXISTS `proc_get_vl_agencies_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_agencies_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency_id INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        fa.name as `agency`,
                        (SUM(`vps`.`less5000`)+SUM(`vps`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vps`.`Undetected`)+SUM(`vps`.`less1000`)) AS `suppressed` 
                        FROM vl_partner_summary vps
                    JOIN partners p on p.ID = vps.partner
                    JOIN funding_agencies fa on fa.id = p.funding_agency_id";

 
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


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `agency` ORDER BY `suppressed` desc, `nonsuppressed` desc ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;