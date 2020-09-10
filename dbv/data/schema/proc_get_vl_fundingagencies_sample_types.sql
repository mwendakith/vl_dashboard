DROP PROCEDURE IF EXISTS `proc_get_vl_fundingagencies_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_fundingagencies_sample_types`
(IN filter_year INT(11), IN to_year INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT
					`month`,
					`year`,
					SUM(`edta`) AS `edta`,
					SUM(`dbs`) AS `dbs`,
					SUM(`plasma`) AS `plasma`,
					SUM(`alledta`) AS `alledta`,
					SUM(`alldbs`) AS `alldbs`,
					SUM(`allplasma`) AS `allplasma`,
					SUM(`Undetected`)+SUM(`less1000`) AS `suppressed`,
					SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`) AS `tests`,
					(SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`
				FROM `vl_partner_summary` `vps`
				JOIN `partners` `p` ON `p`.`ID` = `vps`.`partner`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `p`.`funding_agency_id` = '",agency,"' AND (`year` = '",filter_year,"' OR  `year` = '",to_year,"') GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
