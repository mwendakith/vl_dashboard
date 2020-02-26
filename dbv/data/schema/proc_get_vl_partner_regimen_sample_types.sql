DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_sample_types`
(IN P_id INT(11), IN R_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
          `month`,
          `year`,
          SUM(`edta`) AS `edta`,
          SUM(`dbs`) AS `dbs`,
          SUM(`plasma`) AS `plasma`,
          (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
          (SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `tests`,
          (SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`  
    FROM `vl_partner_prophylaxis`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
