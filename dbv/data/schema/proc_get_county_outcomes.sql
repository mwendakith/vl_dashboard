DROP PROCEDURE IF EXISTS `proc_get_county_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM((`vcs`.`Undetected`+`vcs`.`less1000`)) AS `detectableNless1000`,
                    SUM(`vcs`.`sustxfail`) AS `sustxfl`
                FROM `vl_county_summary` `vcs`
                    JOIN `countys` `c` ON `vcs`.`county` = `c`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`county` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     SELECT @QUERY;
END //
DELIMITER ;