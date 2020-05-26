DROP PROCEDURE IF EXISTS `proc_get_vl_site_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_site_summary`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `partners`.`name` AS `partner`,
                    AVG(`vss`.`sitessending`) AS `sitesending`, 
                    SUM(`vss`.`received`) AS `received`, 
                    SUM(`vss`.`rejected`) AS `rejected`,  
                    SUM(`vss`.`invalids`) AS `invalids`,
                    SUM(`vss`.`alltests`) AS `alltests`,  
                    SUM(`vss`.`Undetected`) AS `undetected`,  
                    SUM(`vss`.`less1000`) AS `less1000`,  
                    SUM(`vss`.`less5000`) AS `less5000`,  
                    SUM(`vss`.`above5000`) AS `above5000`,
                    SUM(`vss`.`confirmtx`) AS `confirmtx`,
                    SUM(`vss`.`confirm2vl`) AS `confirm2vl`,
                    SUM(`vss`.`baseline`) AS `baseline`,
                    SUM(`vss`.`baselinesustxfail`) AS `baselinesustxfail`
                  FROM `vl_site_summary` `vss`
                  JOIN `facilitys` ON `vss`.`facility` = `facilitys`.`ID`
                  LEFT JOIN `partners` ON `facilitys`.`partner` = `partners`.`id`  WHERE 1";
             
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `partners`.`name` ORDER BY `alltests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
