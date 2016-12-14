DROP PROCEDURE IF EXISTS `proc_get_vl_lab_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_lab_performance_stats`
(IN filter_year INT(11), IN filter_month INT(11))
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
                    SUM(`ls`.`confirmtx`) AS `confirmtx`
                  FROM `vl_lab_summary` `ls` JOIN `labs` `l` ON `ls`.`lab` = `l`.`ID` 
                WHERE 1 ";

      IF (filter_month != 0 && filter_month != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' AND `ls`.`month`='",filter_month,"' ");
      ELSE
          SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
      END IF;

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;