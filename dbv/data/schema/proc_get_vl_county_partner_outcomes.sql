DROP PROCEDURE IF EXISTS `proc_get_vl_county_partner_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_partner_outcomes`
(IN `C_id` INT(11), IN `filter_year` INT(11), IN `from_month` INT(11), IN `to_year` INT(11), IN `to_month` INT(11))
BEGIN
  SET @QUERY =    "SELECT                  
                  `vf`.`partnername`, 
                  SUM(`vs`.`undetected`) AS `undetected`, 
                  SUM(`vs`.`less1000`) AS `less1000`, 
                  (SUM(`vs`.`undetected`)+SUM(`vs`.`less1000`)) AS `suppressed`, 
                  (SUM(`vs`.`less5000`)+SUM(`vs`.`above5000`)) AS `nonsuppressed`,
                  (SUM(`vs`.`undetected`)+SUM(`vs`.`less1000`)+SUM(`vs`.`less5000`)+SUM(`vs`.`above5000`)) AS `total` 
                  FROM `vl_site_summary` `vs`
                  LEFT JOIN `view_facilitys` `vf` ON `vf`.`ID` = `vs`.`facility`
                  WHERE 1
                  ";
   IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;


    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY vf.`partnername` ORDER BY `total` DESC LIMIT 0, 50 ");

   PREPARE stmt FROM @QUERY;
   EXECUTE stmt;
END //
DELIMITER ;

