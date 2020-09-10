DROP PROCEDURE IF EXISTS `proc_get_vl_regional_poc_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_regional_poc_gender`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `ac`.`name`, 
                    SUM(`ssp`.`tests`) AS `tests`, 
                    SUM(`ssp`.`undetected`) AS `undetected`,
                    SUM(`ssp`.`less1000`) AS `less1000`,
                    (SUM(`ssp`.`undetected`)+SUM(`ssp`.`less1000`)) AS `suppressed`,
                    (SUM(`ssp`.`less5000`)+SUM(`ssp`.`above5000`)) AS `nonsuppressed`
                  FROM `vl_site_gender_poc` `ssp`
                  JOIN `gender` `ac`
                      ON `ssp`.`gender` = `ac`.`ID`
                  LEFT JOIN `view_facilitys` `vf` ON `ssp`.`facility` = `vf`.`ID` 
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

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `county` = '",filter_county,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
