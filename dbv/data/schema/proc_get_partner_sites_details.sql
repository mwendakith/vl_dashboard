DROP PROCEDURE IF EXISTS `proc_get_partner_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sites_details`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `view_facilitys`.`facilitycode` AS `MFLCode`, 
                    `view_facilitys`.`name`, 
                    `countys`.`name` AS `county`,
                    SUM(`vl_site_summary`.`alltests`) AS `tests`, 
                    SUM(`vl_site_summary`.`sustxfail`) AS `sustxfail`,
                    SUM(`vl_site_summary`.`confirmtx`) AS `confirmtx`, 
                    SUM(`vl_site_summary`.`rejected`) AS `rejected`, 
                    SUM(`vl_site_summary`.`adults`) AS `adults`, 
                    SUM(`vl_site_summary`.`paeds`) AS `paeds`, 
                    SUM(`vl_site_summary`.`maletest`) AS `maletest`, 
                    SUM(`vl_site_summary`.`femaletest`) AS `femaletest` FROM `vl_site_summary` 
                  LEFT JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID` 
                  LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID`  WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
