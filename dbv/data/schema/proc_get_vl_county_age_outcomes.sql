DROP PROCEDURE IF EXISTS `proc_get_vl_county_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_age_outcomes`
(IN filter_age INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM(`vca`.`undetected`+`vca`.`less1000`) AS `suppressed`,
                    SUM(`vca`.`less5000`+`vca`.`above5000`) AS `nonsuppressed` 
                FROM `vl_county_age` `vca`
                    JOIN `countys` `c` ON `vca`.`county` = `c`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `age` = '",filter_age,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `age` = '",filter_age,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vca`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;