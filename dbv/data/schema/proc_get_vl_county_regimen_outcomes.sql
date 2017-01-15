DROP PROCEDURE IF EXISTS `proc_get_vl_county_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_regimen_outcomes`
(IN filter_regimen INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM(`vcr`.`undetected`+`vcr`.`less1000`) AS `suppressed`,
                    SUM(`vcr`.`less5000`+`vcr`.`above5000`) AS `nonsuppressed` 
                FROM `vl_county_regimen` `vcr`
                    JOIN `countys` `c` ON `vcr`.`county` = `c`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcr`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;