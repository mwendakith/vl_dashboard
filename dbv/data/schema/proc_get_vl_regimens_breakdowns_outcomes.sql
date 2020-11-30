DROP PROCEDURE IF EXISTS `proc_get_vl_regimens_breakdowns_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_regimens_breakdowns_outcomes`
(IN filter_regimen INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN partner INT(11), IN subcounty INT(11), IN site INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM(`vca`.`undetected`+`vca`.`less1000`) AS `suppressed`,
                    SUM(`vca`.`less5000`+`vca`.`above5000`) AS `nonsuppressed`, 
                    SUM(`vca`.`undetected`+`vca`.`less1000`+`vca`.`less5000`+`vca`.`above5000`) AS `total`,
                    ((SUM(`vca`.`undetected`+`vca`.`less1000`)/SUM(`vca`.`undetected`+`vca`.`less1000`+`vca`.`less5000`+`vca`.`above5000`))*100) AS `percentage` ";

    IF (county != 0 && county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_county_prophylaxis` `vca` JOIN `countys` `c` ON `vca`.`county` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (partner != 0 && partner != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_partner_prophylaxis` `vca` JOIN `partners` `c` ON `vca`.`partner` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (subcounty != 0 && subcounty != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_prophylaxis` `vca` JOIN `districts` `c` ON `vca`.`subcounty` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (site != 0 && site != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_prophylaxis` `vca` JOIN `facilitys` `c` ON `vca`.`facility` = `c`.`ID` WHERE 1 ");
    END IF;

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


    SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' GROUP BY `c`.`ID` ORDER BY `percentage` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;