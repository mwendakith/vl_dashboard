DROP PROCEDURE IF EXISTS `proc_get_labs_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_labs_tat`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `lb`.`labname`, 
                        AVG(`vls`.`tat1`) AS `tat1`, 
                        AVG(`vls`.`tat2`) AS `tat2`, 
                        AVG(`vls`.`tat3`) AS `tat3`, 
                        AVG((`vls`.`tat1`+`vls`.`tat2`+`vls`.`tat3`)) AS `tat4` 
                    FROM `vl_lab_summary` `vls` 
                    JOIN `labs` `lb` 
                        ON `vls`.`lab` = `lb`.`ID` WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vls`.`year` = '",filter_year,"' AND `vls`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vls`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `lb`.`labname` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;