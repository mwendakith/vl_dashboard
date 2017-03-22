DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`ID`, 
                    `c`.`name`, 
                    ((SUM(`vcs`.`sustxfail`)/SUM(`vcs`.`alltests`))*100) AS `sustxfail` 
                    FROM `vl_county_summary` `vcs` 
                    JOIN `countys` `c` 
                    ON `vcs`.`county` = `c`.`ID`
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`year` = '",filter_year,"' AND `vcs`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`year` = '",filter_year,"' AND `vcs`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.`name` ORDER BY `sustxfail` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
