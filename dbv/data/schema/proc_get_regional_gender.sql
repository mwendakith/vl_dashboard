DROP PROCEDURE IF EXISTS `proc_get_regional_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_gender`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    (SUM(`vng`.`undetected`)+SUM(`vng`.`less1000`)) AS `suppressed`,
                    (SUM(`vng`.`less5000`)+SUM(`vng`.`above5000`)) AS `nonsuppressed`
                FROM `vl_county_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
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

    

    SET @QUERY = CONCAT(@QUERY, " AND `vng`.`county` = '",C_id,"' GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
