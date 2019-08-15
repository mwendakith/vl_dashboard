DROP PROCEDURE IF EXISTS `proc_get_vl_current_age_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_age_suppression`
(IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    SUM(`noage_suppressed`) AS `noage_suppressed`, SUM(`noage_nonsuppressed`) AS `noage_nonsuppressed`,
                    SUM(`less2_suppressed`) AS `less2_suppressed`, SUM(`less2_nonsuppressed`) AS `less2_nonsuppressed`,
                    SUM(`less9_suppressed`) AS `less9_suppressed`, SUM(`less9_nonsuppressed`) AS `less9_nonsuppressed`,
                    SUM(`less14_suppressed`) AS `less14_suppressed`, SUM(`less14_nonsuppressed`) AS `less14_nonsuppressed`,
                    SUM(`less19_suppressed`) AS `less19_suppressed`, SUM(`less19_nonsuppressed`) AS `less19_nonsuppressed`,
                    SUM(`less24_suppressed`) AS `less24_suppressed`, SUM(`less24_nonsuppressed`) AS `less24_nonsuppressed`,
                    SUM(`over25_suppressed`) AS `over25_suppressed`, SUM(`over25_nonsuppressed`) AS `over25_nonsuppressed`
                  FROM `vl_site_suppression` 
                  JOIN `view_facilitys` ON `vl_site_suppression`.`facility` = `view_facilitys`.`ID` 
                  WHERE 1";
    IF(type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`county` = '",ID,"' ");
    END IF;
    IF(type = 2) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`subcounty` = '",ID,"' ");
    END IF;
    IF(type = 3) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`id` = '",ID,"' ");
    END IF;
    IF(type = 4) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",ID,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
