DROP PROCEDURE IF EXISTS `proc_get_vl_current_suppression_listing`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_suppression_listing`
(IN type INT(11), IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `view_facilitys`.`countyname`, `view_facilitys`.`subcounty`,
                     `view_facilitys`.`partnername`, `view_facilitys`.`name`,
                    SUM(`suppressed`) AS `suppressed`, 
                    SUM(`nonsuppressed`) AS `nonsuppressed`, 
                    AVG(`suppression`) AS `suppression`, 
                    AVG(`coverage`) AS `coverage`, 
                    SUM(`totalartmar`) AS `totallstrpt`
                     FROM `vl_site_suppression` 
                  JOIN `view_facilitys` ON `vl_site_suppression`.`facility` = `view_facilitys`.`ID` 
                  WHERE 1";
    
    IF(county != 0) THEN 
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`county` = '",county,"' ");
    END IF; 
    

    IF(type != 4) THEN 
      SET @QUERY = CONCAT(@QUERY, " AND (`vl_site_suppression`.`suppressed` > 0 || `vl_site_suppression`.`nonsuppressed` > 0) ");
    END IF; 
    
    IF(type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`county` ");
    END IF;
    IF(type = 2) THEN
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`district`  ");
    END IF;
    IF(type = 3) THEN
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`partner`  ");
    END IF;
    IF(type = 4) THEN
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `vl_site_suppression`.`facility` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " ORDER BY `suppression` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
