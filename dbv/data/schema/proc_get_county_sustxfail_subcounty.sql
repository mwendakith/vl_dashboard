DROP PROCEDURE IF EXISTS `proc_get_county_sustxfail_subcounty`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_sustxfail_subcounty`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `d`.`name`, 
                      ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `percentages`, 
                      SUM(`vss`.`sustxfail`) AS `sustxfail` 
                  FROM `vl_subcounty_summary` `vss` 
                  JOIN `districts` `d` 
                  ON `vss`.`subcounty` = `d`.`ID`
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `d`.`name` ORDER BY `percentages` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
