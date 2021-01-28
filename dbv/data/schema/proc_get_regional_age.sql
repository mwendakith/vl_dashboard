DROP PROCEDURE IF EXISTS `proc_get_regional_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_age`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vca`.`tests`) AS `agegroups`, 
                    SUM(`vca`.`undetected`) AS `undetected`,
                    SUM(`vca`.`less1000`) AS `less1000`,
                    SUM(`vca`.`less5000`) AS `less5000`,
                    SUM(`vca`.`above5000`) AS `above5000`,
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)) AS `suppressed`,
                    (SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `nonsuppressed`
                FROM `vl_county_age` `vca`
                JOIN `agecategory` `ac`
                    ON `vca`.`age` = `ac`.`ID`
                WHERE 1 ";

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


    SET @QUERY = CONCAT(@QUERY, " AND `vca`.`county` = '",C_id,"' GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
