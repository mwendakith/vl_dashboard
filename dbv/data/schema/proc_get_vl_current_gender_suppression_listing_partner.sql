DROP PROCEDURE IF EXISTS `proc_get_vl_current_gender_suppression_listing_partner`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_current_gender_suppression_listing_partner`
(IN type INT(11), IN partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `view_facilitys`.`countyname`, `view_facilitys`.`subcounty`,
                     `view_facilitys`.`partnername`, `view_facilitys`.`name`,

                    SUM(`male_suppressed`) AS `male_suppressed`, SUM(`male_nonsuppressed`) AS `male_nonsuppressed`,
                    SUM(`female_suppressed`) AS `female_suppressed`, SUM(`female_nonsuppressed`) AS `female_nonsuppressed`,
                    SUM(`nogender_suppressed`) AS `nogender_suppressed`, SUM(`nogender_nonsuppressed`) AS `nogender_nonsuppressed`
                    
                     FROM `vl_site_suppression` 
                  JOIN `view_facilitys` ON `vl_site_suppression`.`facility` = `view_facilitys`.`ID` 
                  WHERE 1";
    
    IF(partner != 1000) THEN 
      SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",partner,"' ");
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

    SET @QUERY = CONCAT(@QUERY, " ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
