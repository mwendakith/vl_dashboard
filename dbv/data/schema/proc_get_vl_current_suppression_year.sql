DROP PROCEDURE IF EXISTS `proc_get_vl_current_suppression_year`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_suppression_year`
(IN type INT(11), IN id INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`suppressed`) AS `suppressed`, 
                    SUM(`nonsuppressed`) AS `nonsuppressed`, 
                    SUM(`undetected`) AS `undetected`, 
                    SUM(`less1000`) AS `less1000`, 
                    AVG(`suppression`) AS `suppression`, 
                    AVG(`coverage`) AS `coverage`, 
                    SUM(`totalartmar`) AS `totallstrpt` 
                     FROM `vl_site_suppression_year` 
                  JOIN `view_facilitys` ON `vl_site_suppression_year`.`facility` = `view_facilitys`.`ID` 
                  WHERE 1";
    
    

    IF(type != 4) THEN 
      SET @QUERY = CONCAT(@QUERY, " AND (`vl_site_suppression_year`.`suppressed` > 0 || `vl_site_suppression_year`.`nonsuppressed` > 0) ");
    END IF; 
    
    IF(type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`county` = '",id,"' ");
    END IF;
    IF(type = 2) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`district` = '",id,"' ");
    END IF;
    IF(type = 3) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",id,"' ");
    END IF;
    IF(type = 4) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vl_site_suppression_year`.`facility` = '",id,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
