DROP PROCEDURE IF EXISTS `proc_get_vl_county_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `countys`.`name` AS `county`,
                    AVG(`vcs`.`sitessending`) AS `sitesending`, 
                    SUM(`vcs`.`received`) AS `received`, 
                    SUM(`vcs`.`rejected`) AS `rejected`,  
                    SUM(`vcs`.`invalids`) AS `invalids`,
                    SUM(`vcs`.`alltests`) AS `alltests`,  
                    SUM(`vcs`.`Undetected`) AS `undetected`,  
                    SUM(`vcs`.`less1000`) AS `less1000`,  
                    SUM(`vcs`.`less5000`) AS `less5000`,  
                    SUM(`vcs`.`above5000`) AS `above5000`,
                    SUM(`vcs`.`confirmtx`) AS `confirmtx`,
                    SUM(`vcs`.`confirm2vl`) AS `confirm2vl`,
                    SUM(`vcs`.`baseline`) AS `baseline`,
                    SUM(`vcs`.`baselinesustxfail`) AS `baselinesustxfail`
                  FROM `vl_county_summary` `vcs`
                  JOIN `countys` ON `vcs`.`county` = `countys`.`ID`  WHERE 1";

  
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `countys`.`name` ORDER BY `alltests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
