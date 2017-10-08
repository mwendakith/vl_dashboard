DROP PROCEDURE IF EXISTS `proc_get_vl_current_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_suppression`
(IN type INT(11), IN id INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`suppressed`) AS `suppressed`, 
                    SUM(`nonsuppressed`) AS `nonsuppressed`, 
                    AVG(`suppression`) AS `suppression`, 
                    SUM(`totalartmar`) AS `totallstrpt` 
                     FROM `vl_site_suppression` 
                  LEFT JOIN `view_facilitys` ON `vl_site_suppression`.`facility` = `view_facilitys`.`ID` 
                  WHERE 1";
    
    

    IF(type != 4) THEN 
      SET @QUERY = CONCAT(@QUERY, " AND (`vl_site_suppression`.`suppressed` > 0 || `vl_site_suppression`.`nonsuppressed` > 0) ");
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
      SET @QUERY = CONCAT(@QUERY, " AND `vl_site_suppression`.`facility` = '",id,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
