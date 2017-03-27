DROP PROCEDURE IF EXISTS `proc_get_sites_listing`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_listing`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						SUM(`vss`.`sustxfail`) AS `sustxfail`, 
                        SUM(`vss`.`alltests`) AS `alltests`,
                        SUM(`vss`.`sustxfail`), 
                        ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `non supp`, 
                        `vf`.`ID`, 
                        `vf`.`name` 
					FROM `vl_site_summary` `vss` LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
                    WHERE 1";

  
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vss`.`year` = '",filter_year,"' AND `vss`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vss`.`year` = '",filter_year,"' AND `vss`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vss`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`ID` ORDER BY `non supp` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
