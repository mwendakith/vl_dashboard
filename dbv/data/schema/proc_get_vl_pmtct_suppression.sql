DROP PROCEDURE IF EXISTS `proc_get_vl_pmtct_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_pmtct_suppression`
(IN Pm_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN national INT(11), IN county INT(11), IN partner INT(11), IN subcounty INT(11), IN site INT(11))
BEGIN
  SET @QUERY =    "SELECT
          `vcs`.`month`,
          `vcs`.`year`,
          (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`)) AS `suppressed`,
          (SUM(`vcs`.`less5000`)+SUM(`vcs`.`above5000`)) AS `nonsuppressed`,
          (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`)+SUM(`vcs`.`less5000`)+SUM(`vcs`.`above5000`)) AS `tests`,
          (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`))*100/SUM(`vcs`.`undetected`+`vcs`.`less1000`+`vcs`.`less5000`+`vcs`.`above5000`) AS `suppression`
                  ";

    IF (national != 0 && national != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_national_pmtct` `vcs`
                  JOIN `viralpmtcttype` `pt` ON `vcs`.`pmtcttype` = `pt`.`ID`  WHERE 1 ");
    END IF;
    IF (county != 0 && county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " ,
                  `ac`.`name` FROM `vl_county_pmtct` `vcs`
                  JOIN `viralpmtcttype` `pt` ON `vcs`.`pmtcttype` = `pt`.`ID` JOIN `countys` `ac` ON `ac`.`ID` = `vcs`.`county`  WHERE `vcs`.`county` = '",county,"' ");
    END IF;
    IF (partner != 0 && partner != '') THEN
      SET @QUERY = CONCAT(@QUERY, " ,
                  `ac`.`name` FROM `vl_partner_pmtct` `vcs`
                  JOIN `viralpmtcttype` `pt` ON `vcs`.`pmtcttype` = `pt`.`ID` JOIN `partners` `ac` ON `ac`.`ID` = `vcs`.`partner`  WHERE `vcs`.`partner` = '",partner,"' ");
    END IF;
    IF (subcounty != 0 && subcounty != '') THEN
      SET @QUERY = CONCAT(@QUERY, " ,
                  `ac`.`name` FROM `vl_subcounty_pmtct` `vcs`
                  JOIN `viralpmtcttype` `pt` ON `vcs`.`pmtcttype` = `pt`.`ID` JOIN `districts` `ac` ON `ac`.`ID` = `vcs`.`subcounty`  WHERE `vcs`.`subcounty` = '",subcounty,"' ");
    END IF;
    IF (site != 0 && site != '') THEN
      SET @QUERY = CONCAT(@QUERY, " ,
                  `ac`.`name` FROM `vl_site_pmtct` `vcs`
                  JOIN `viralpmtcttype` `pt` ON `vcs`.`pmtcttype` = `pt`.`ID` JOIN `view_facilitys` `ac` ON `ac`.`ID` = `vcs`.`facility`  WHERE `vcs`.`facility` = '",site,"' ");
    END IF;

    IF (Pm_id != 0 && Pm_id != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `pmtcttype` = '",Pm_id,"' ");
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
    
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
