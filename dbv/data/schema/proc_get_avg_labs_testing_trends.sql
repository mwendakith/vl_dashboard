DROP PROCEDURE IF EXISTS `proc_get_avg_labs_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_avg_labs_testing_trends`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    AVG(`vns`.`alltests`) AS `alltests`, 
                    AVG(`vns`.`rejected`) AS `rejected`, 
                    AVG(`vns`.`received`) AS `received`, 
                    `vns`.`month`, 
                    `vns`.`year` 
                FROM `vl_lab_summary` `vns` 
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' ");
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;