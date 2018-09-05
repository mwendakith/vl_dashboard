DROP PROCEDURE IF EXISTS `proc_get_vl_lab_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_lab_performance_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `l`.`labname` AS `name`, 
                    AVG(`ls`.`sitessending`) AS `sitesending`, 
                    SUM(`ls`.`received`) AS `received`, 
                    SUM(`ls`.`rejected`) AS `rejected`,  
                    SUM(`ls`.`invalids`) AS `invalids`,
                    SUM(`ls`.`alltests`) AS `alltests`,  
                    SUM(`ls`.`Undetected`) AS `undetected`,  
                    SUM(`ls`.`less1000`) AS `less1000`,  
                    SUM(`ls`.`less5000`) AS `less5000`,  
                    SUM(`ls`.`above5000`) AS `above5000`,  
                    SUM(`ls`.`eqa`) AS `eqa`,  
                    SUM(`ls`.`controls`) AS `controls`,   
                    SUM(`ls`.`confirmtx`) AS `confirmtx`,
                    SUM(`ls`.`confirm2vl`) AS `confirm2vl`,
                    SUM(`ls`.`fake_confirmatory`) AS `fake_confirmatory`,
                    SUM(`ls`.`baseline`) AS `baseline`,
                    SUM(`ls`.`baselinesustxfail`) AS `baselinesustxfail`
                  FROM `vl_lab_summary` `ls` JOIN `labs` `l` ON `ls`.`lab` = `l`.`ID` 
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
