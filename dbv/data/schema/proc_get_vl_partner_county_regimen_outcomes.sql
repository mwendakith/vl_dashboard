DROP PROCEDURE IF EXISTS `proc_get_vl_partner_county_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_county_regimen_outcomes`
(IN P_Id INT(11), IN filter_regimen INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    (SUM(`vcr`.`undetected`)+SUM(`vcr`.`less1000`)) AS `suppressed`,
                    (SUM(`vcr`.`less5000`)+SUM(`vcr`.`above5000`)) AS `nonsuppressed` 
                FROM `vl_partner_regimen` `vcr`
                    LEFT JOIN view_facilitys vf
                    ON vf.partner = vcr.partner
                  LEFT JOIN countys c
                    ON c.ID = vf.county
    WHERE 1 ";


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

    SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' AND `vcr`.`partner` = '",P_Id,"' GROUP BY `c`.`name` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
