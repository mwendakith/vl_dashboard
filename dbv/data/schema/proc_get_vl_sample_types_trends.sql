DROP PROCEDURE IF EXISTS `proc_get_vl_sample_types_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_sample_types_trends`
(IN type INT(11), IN id INT(11), IN from_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
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
					(SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`";

    IF (type = 0 || type = '') THEN # fOR THE NATIONAL
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_national_summary` WHERE 1 ");
    END IF;
    IF (type = 1) THEN # For the county
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_county_summary` WHERE `county` = '",id,"' ");
    END IF;
    IF (type = 2) THEN # For the sub-county
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_summary` WHERE `subcounty` = '",id,"' ");
    END IF;
    IF (type = 3) THEN # For the facility
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_summary` WHERE `facility` = '",id,"' ");
    END IF;
    IF (type = 4) THEN # For the partner
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_partner_summary` WHERE `partner` = '",id,"' ");
    END IF;
    IF (type = 5) THEN # For the labs
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_lab_summary` WHERE `lab` = '",id,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && from_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && from_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",from_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",from_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' AND `month`='",from_month,"' ");
      END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
