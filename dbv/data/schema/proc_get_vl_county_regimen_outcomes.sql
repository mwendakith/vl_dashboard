DROP PROCEDURE IF EXISTS `proc_get_vl_county_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_regimen_outcomes`
(IN filter_regimen INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM(`vcr`.`undetected`+`vcr`.`less1000`) AS `suppressed`,
                    SUM(`vcr`.`less5000`+`vcr`.`above5000`) AS `nonsuppressed` 
                FROM `vl_county_regimen` `vcr`
                    JOIN `countys` `c` ON `vcr`.`county` = `c`.`ID`
    WHERE 1 ";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' GROUP BY `vcr`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
