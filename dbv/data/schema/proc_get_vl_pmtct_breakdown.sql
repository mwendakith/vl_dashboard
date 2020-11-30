DROP PROCEDURE IF EXISTS `proc_get_vl_pmtct_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_pmtct_breakdown`
(IN Pm_ID INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN subcounty INT(11), IN partner INT(11), IN site INT(11))
BEGIN
  SET @QUERY =    "SELECT
          `com`.`name`,
  				SUM(`vcs`.`rejected`) AS `rejected`,  
          SUM(`vcs`.`invalids`) AS `invalids`,  
          SUM(`vcs`.`Undetected`) AS `undetected`,  
          SUM(`vcs`.`less1000`) AS `less1000`,  
          SUM(`vcs`.`less5000`) AS `less5000`,  
          SUM(`vcs`.`above5000`) AS `above5000`,
          SUM(`vcs`.`confirmtx`) AS `confirmtx`,
          SUM(`vcs`.`confirm2vl`) AS `confirm2vl`,
          SUM(`vcs`.`baseline`) AS `baseline`,
          SUM(`vcs`.`baselinesustxfail`) AS `baselinesustxfail`,
          (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`)+SUM(`vcs`.`less5000`)+SUM(`vcs`.`above5000`)) AS `routine` ";

    IF (county != 0 || county != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `vl_county_pmtct` `vcs` LEFT JOIN `countys` `com` ON `vcs`.`county` = `com`.`ID` ");
    END IF;           
		IF (subcounty != 0 || subcounty != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `vl_subcounty_pmtct` `vcs` LEFT JOIN `districts` `com` ON `vcs`.`subcounty` = `com`.`ID` ");
    END IF;
    IF (partner != 0 || partner != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `vl_partner_pmtct` `vcs` LEFT JOIN `partners` `com` ON `vcs`.`partner` = `com`.`ID` ");
    END IF;
    IF (site != 0 || site != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `vl_site_pmtct` `vcs` LEFT JOIN `view_facilitys` `com` ON `vcs`.`facility` = `com`.`ID` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE `vcs`.`pmtcttype` = '",Pm_ID,"' ");

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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `com`.`ID` ORDER BY `routine` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
