DROP PROCEDURE IF EXISTS `proc_get_vl_site_patients`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_site_patients`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    SUM((`alltests`)) AS `alltests`,
                    SUM((`onevl`)) AS `onevl`,
                    SUM((`twovl`)) AS `twovl`,
                    SUM((`threevl`)) AS `threevl`,
                    SUM((`above3vl`)) AS `above3vl`,
                    SUM((`vf`.`totalartmar`)) AS `totalartmar`
                    FROM `vl_site_patient_tracking` `vspt`
                    JOIN `view_facilitys` `vf` 
                    ON `vspt`.`facility` = `vf`.`ID`
                WHERE 1";

   
    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' ");

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

