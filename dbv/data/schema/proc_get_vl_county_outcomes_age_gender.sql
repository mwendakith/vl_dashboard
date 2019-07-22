DROP PROCEDURE IF EXISTS `proc_get_vl_county_outcomes_age_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_outcomes_age_gender`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                `c`.`name` AS `region`, 
                     `vcag`.`gender`, 
                     `vcag`.`age` AS `age`,  
                     SUM(`vcag`.`undetected` + `vcag`.`less1000` + `vcag`.`less5000` + `vcag`.`above5000`) AS `tests`, 
                     SUM(`vcag`.`less5000` + `vcag`.`above5000`) AS `nonsup`
                FROM `vl_county_age_gender` `vcag`
                LEFT JOIN `countys` `c` ON `c`.`id` = `vcag`.`county`
                LEFT JOIN `agecategory` `ac` ON `ac`.`id` = `vcag`.`age`
                WHERE 1
                ";


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
    SET @QUERY = CONCAT(@QUERY,"GROUP BY c.`name`, `gender`, age");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
