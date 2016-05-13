DROP PROCEDURE IF EXISTS `proc_get_regional_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_age`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`,
                    SUM((`vna`.`tests`)) AS `agegroups`
                FROM `vl_national_age` `vna`
                JOIN `agecategory` `ac`
                    ON `vna`.`age` = `ac`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vna`.`county` = '",C_id,"' AND `vna`.`year` = '",filter_year,"' AND `vna`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vna`.`county` = '",C_id,"' AND `vna`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;