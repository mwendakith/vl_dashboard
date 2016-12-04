DROP PROCEDURE IF EXISTS `proc_get_avg_labs_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_avg_labs_testing_trends`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    AVG(`vls`.`alltests`) AS `alltests`, 
                    AVG(`vls`.`rejected`) AS `rejected`, 
                    `vls`.`month`, 
                    `vls`.`year` 
                FROM `vl_lab_summary` `vls` 
                JOIN `labs` `lb` 
                    ON `vls`.`lab` = `lb`.`ID`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `vls`.`year` = '",filter_year,"' ");
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;