DROP PROCEDURE IF EXISTS `proc_get_vl_county_partners`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_partners`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`name` AS `county`,
                    `p`.`name` AS `partner`,
                    SUM(`vss`.`alltests`) AS `tests`, 
                    SUM(`vss`.`sustxfail`) AS `sustxfail`,
                    SUM(`vss`.`confirmtx`) AS `confirmtx`, 
                    SUM(`vss`.`rejected`) AS `rejected`, 
                    SUM(`vss`.`adults`) AS `adults`, 
                    SUM(`vss`.`paeds`) AS `paeds`, 
                    SUM(`vss`.`maletest`) AS `maletest`, 
                    SUM(`vss`.`femaletest`) AS `femaletest` 
                    FROM `vl_site_summary` `vss`
                  LEFT JOIN `view_facilitys` `vf` ON `vf`.`ID` = `vss`.`facility`
                  LEFT JOIN `partners` `p` ON `p`.`ID` = `vf`.`partner`
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' GROUP BY `p`.`name` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

