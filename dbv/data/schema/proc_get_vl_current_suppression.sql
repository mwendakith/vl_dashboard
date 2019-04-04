DROP PROCEDURE IF EXISTS `proc_get_vl_current_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_suppression`
(IN type INT(11), IN id INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`suppressed`) AS `suppressed`, 
                    SUM(`nonsuppressed`) AS `nonsuppressed`, 
                    SUM(`undetected`) AS `undetected`, 
                    SUM(`less1000`) AS `less1000`, 
                    AVG(`suppression`) AS `suppression`, 
                    AVG(`coverage`) AS `coverage`, 
                    SUM(`totalartmar`) AS `totallstrpt`";

  IF (type = 5) THEN
    SET @QUERY = CONCAT(@QUERY, " , `partners`.`name` as `partners` FROM `vl_site_suppression` ");
  ELSE
    SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_suppression` ");
  END IF;

  SET @QUERY = CONCAT(@QUERY, " JOIN `view_facilitys` ON `vl_site_suppression`.`facility` = `view_facilitys`.`ID` ");

   
  IF(type = '' || type = 0) THEN 
    SET @QUERY = CONCAT(@QUERY, " WHERE (`vl_site_suppression`.`suppressed` > 0 || `vl_site_suppression`.`nonsuppressed` > 0) ");
  END IF;   
  IF(type = 1) THEN
    SET @QUERY = CONCAT(@QUERY, "  WHERE `view_facilitys`.`county` = '",id,"' ");
  END IF;
  IF(type = 2) THEN
    SET @QUERY = CONCAT(@QUERY, "  WHERE `view_facilitys`.`district` = '",id,"' ");
  END IF;
  IF(type = 3) THEN
    SET @QUERY = CONCAT(@QUERY, "  WHERE `view_facilitys`.`partner` = '",id,"' ");
  END IF;
  IF(type = 4) THEN
    SET @QUERY = CONCAT(@QUERY, "  WHERE `vl_site_suppression`.`facility` = '",id,"' ");
  END IF;
  IF(type = 5) THEN
    SET @QUERY = CONCAT(@QUERY, "  JOIN `partners` ON `partners`.`ID` = `view_facilitys`.`partner` WHERE `partners`.`funding_agency_id` = '",id,"' GROUP BY `partners` ORDER BY `suppressed` desc, `nonsuppressed` desc ");
  END IF;

  PREPARE stmt FROM @QUERY;
  EXECUTE stmt;
END //
DELIMITER ;
