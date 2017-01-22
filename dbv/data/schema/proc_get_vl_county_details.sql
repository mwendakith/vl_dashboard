DROP PROCEDURE IF EXISTS `proc_get_vl_county_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_details`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `countys`.`name` AS `county`,
                    SUM(`vcs`.`alltests`) AS `tests`, 
                    SUM(`vcs`.`sustxfail`) AS `sustxfail`,
                    SUM(`vcs`.`confirmtx`) AS `confirmtx`, 
                    SUM(`vcs`.`rejected`) AS `rejected`, 
                    SUM(`vcs`.`adults`) AS `adults`, 
                    SUM(`vcs`.`paeds`) AS `paeds`, 
                    SUM(`vcs`.`maletest`) AS `maletest`, 
                    SUM(`vcs`.`femaletest`) AS `femaletest` FROM `vl_county_summary` `vcs`
                   JOIN `countys` ON `vcs`.`county` = `countys`.`ID`  WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, "  AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, "  AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `countys`.`name` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;