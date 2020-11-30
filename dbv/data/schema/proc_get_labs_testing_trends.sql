DROP PROCEDURE IF EXISTS `proc_get_labs_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_labs_testing_trends`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vls`.`lab`,
                    `lb`.`labname`, 
                    `vls`.`alltests`,
                    `vls`.`eqa`,
                    `vls`.`confirmtx`, 
                    `vls`.`rejected`, 
                    `vls`.`received`, 
                    `vls`.`month`, 
                    `vls`.`year` 
                FROM `vl_lab_summary` `vls` 
                LEFT JOIN `labs` `lb` 
                    ON `vls`.`lab` = `lb`.`ID`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `vls`.`year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
