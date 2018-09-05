DROP PROCEDURE IF EXISTS `proc_get_labs_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_labs_testing_trends`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `lb`.`labname`, 
<<<<<<< HEAD
                    `vls`.`alltests`, 
                    `vls`.`rejected`, 
=======
                    `vls`.`alltests`,
                    `vls`.`eqa`,
                    `vls`.`confirmtx`, 
                    `vls`.`rejected`, 
                    `vls`.`received`, 
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
                    `vls`.`month`, 
                    `vls`.`year` 
                FROM `vl_lab_summary` `vls` 
                JOIN `labs` `lb` 
                    ON `vls`.`lab` = `lb`.`ID`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `vls`.`year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
