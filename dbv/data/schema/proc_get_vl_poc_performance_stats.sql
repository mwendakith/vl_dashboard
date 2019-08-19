DROP PROCEDURE IF EXISTS `proc_get_vl_poc_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_poc_performance_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `f`.`id`, 
                    `f`.`name`, 
                    `f`.`facilitycode`, 
                    `c`.`name` AS `county`,
                    AVG(`vps`.`sitessending`) AS `sitesending`, 
                    SUM(`vps`.`received`) AS `received`, 
                    SUM(`vps`.`rejected`) AS `rejected`,  
                    SUM(`vps`.`invalids`) AS `invalids`,
                    SUM(`vps`.`alltests`) AS `alltests`,  
                    SUM(`vps`.`Undetected`) AS `undetected`,  
                    SUM(`vps`.`less1000`) AS `less1000`,  
                    SUM(`vps`.`less5000`) AS `less5000`,  
                    SUM(`vps`.`above5000`) AS `above5000`,  
                    SUM(`vps`.`eqa`) AS `eqa`,  
                    SUM(`vps`.`controls`) AS `controls`,   
                    SUM(`vps`.`confirmtx`) AS `confirmtx`,
                    SUM(`vps`.`confirm2vl`) AS `confirm2vl`,
                    SUM(`vps`.`fake_confirmatory`) AS `fake_confirmatory`,
                    SUM(`vps`.`baseline`) AS `baseline`,
                    SUM(`vps`.`baselinesustxfail`) AS `baselinesustxfail`
                  FROM `vl_poc_summary` `vps` 
                        LEFT JOIN `facilitys` `f` ON `vps`.`facility` = `f`.`ID`
                        LEFT JOIN `districts` `d` ON `f`.`district` = `d`.`id`
                        LEFT JOIN `countys` `c` ON `d`.`county` = `c`.`ID`
                WHERE 1 ";

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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `f`.`ID` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
