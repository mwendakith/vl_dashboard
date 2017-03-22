DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_details`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `countys`.`name` AS `county`,
                    `districts`.`name` AS `subcounty`,
                    SUM(`vcs`.`alltests`) AS `tests`, 
                    SUM(`vcs`.`sustxfail`) AS `sustxfail`,
                    SUM(`vcs`.`confirmtx`) AS `confirmtx`, 
                    SUM(`vcs`.`rejected`) AS `rejected`, 
                    SUM(`vcs`.`adults`) AS `adults`, 
                    SUM(`vcs`.`paeds`) AS `paeds`, 
                    SUM(`vcs`.`maletest`) AS `maletest`, 
                    SUM(`vcs`.`femaletest`) AS `femaletest` FROM `vl_subcounty_summary` `vcs`
                   JOIN `districts` ON `vcs`.`subcounty` = `districts`.`ID`
                  JOIN `countys` ON `countys`.`ID` = `districts`.`county`
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

    SET @QUERY = CONCAT(@QUERY, " AND `districts`.`county` = '",filter_county,"' GROUP BY `districts`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

