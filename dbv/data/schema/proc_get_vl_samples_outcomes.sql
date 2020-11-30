DROP PROCEDURE IF EXISTS `proc_get_vl_samples_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_samples_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						IF(`vs`.`name` = 'EDTA' OR `vs`.`name` = 'Frozen Plasma', 'Plasma', `vs`.`name`) AS `sample_type_name`, 
						SUM(`vns`.`less5000`+`vns`.`above5000`) AS `nonsuppressed`, 
						SUM(`vns`.`Undetected`+`vns`.`less1000`) AS `suppressed` 
						FROM `vl_national_sampletype` `vns`
						LEFT JOIN `viralsampletypedetails` `vs` 
						ON `vns`.`sampletype` = `vs`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `sample_type_name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
