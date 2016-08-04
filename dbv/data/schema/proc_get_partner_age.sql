DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vca`.`sustxfail`) AS `sustxfail`,
                    SUM((`vca`.`tests`)) AS `agegroups`
                FROM `vl_partner_age` `vca`
                JOIN `agecategory` `ac`
                    ON `vca`.`age` = `ac`.`subID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vca`.`partner` = '",P_id,"' AND `vca`.`year` = '",filter_year,"' AND `vca`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vca`.`partner` = '",P_id,"' AND `vca`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;