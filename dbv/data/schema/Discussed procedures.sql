-- *********************************************************************************************
-- The procedure "proc_get_county_outcomes" gets the suppressed and the non suppressed for all 
-- the county to populat the county outcomes graph at the bottom of the summaries page
-- ********************************************************************************************
-- To retrieve data from it run the query CALL `proc_get_county_outcomes`('2016', '0');
-- The parameters to be passed into the procedure are year and the month
-- If the month is set to 0 it picks for the entire year.
-- ********************************************************************************************
DROP PROCEDURE IF EXISTS `proc_get_county_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    SUM(`vcs`.`undetected`+`vcs`.`less1000`) AS `suppressed`,
                    SUM(`vcs`.`less5000`+`vcs`.`above5000`) AS `nonsuppressed` 
                FROM `vl_county_summary` `vcs`
                    JOIN `countys` `c` ON `vcs`.`county` = `c`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`county` ORDER BY `detectableNless1000` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;



-- ***********************************************************************************************
-- *********************************************************************************************
-- The procedure "proc_get_partner_outcomes" gets the suppressed and the non suppressed for all 
-- the partners to populate the partner outcomes graph on the partner summaries page
-- ********************************************************************************************
-- To retrieve data from it run the query CALL `proc_get_partner_outcomes`('2016', '0');
-- The parameters to be passed into the procedure are year and the month
-- If the month is set to 0 it picks for the entire year.
-- ********************************************************************************************
DROP PROCEDURE IF EXISTS `proc_get_partner_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`,
                    SUM((`vps`.`Undetected`+`vps`.`less1000`)) AS `suppressed`,
                    SUM((`vps`.`less5000`+`vps`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_summary` `vps`
                    JOIN `partners` `p` ON `vps`.`partner` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vps`.`partner` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;



-- ***********************************************************************************************
-- *********************************************************************************************
-- The procedure "proc_get_county_sites_outcomes" gets the suppressed and the non suppressed for all 
-- the sites in a county to populate the county sites outcomes graph at the bottom of summaries page when a county is selected
-- ********************************************************************************************
-- To retrieve data from it run the query CALL `proc_get_county_sites_outcomes`('2','2016', '0');
-- The parameters to be passed into the procedure are countyID, year and the month
-- If the month is set to 0 it picks for the entire year.
-- ********************************************************************************************
DROP PROCEDURE IF EXISTS `proc_get_county_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_sites_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`,
                    SUM(`vss`.`undetected`+`vss`.`less1000`) AS `suppressed`,
                    SUM(`vss`.`less5000`+`vss`.`above5000`) AS `nonsuppressed`  
                  FROM `vl_site_summary` `vss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility` = `vf`.`ID` 
                  WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vss`.`facility` ORDER BY `detectableNless1000` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;


-- ***********************************************************************************************
-- *********************************************************************************************
-- The procedure "proc_get_all_sites_outcomes" gets the suppressed and the non suppressed for all 
-- the facilites to populate the facilites outcomes graph on the facilites page
-- ********************************************************************************************
-- To retrieve data from it run the query CALL `proc_get_all_sites_outcomes`('2016', '0');
-- The parameters to be passed into the procedure are year and the month
-- If the month is set to 0 it picks for the entire year.
-- ********************************************************************************************
DROP PROCEDURE IF EXISTS `proc_get_all_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_all_sites_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`, 
                    SUM((`vss`.`Undetected`+`vss`.`less1000`)) AS `suppressed`, 
                    SUM(`vss`.`sustxfail`) AS `nonsuppressed` 
                  FROM `vl_site_summary` `vss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vss`.`facility` ORDER BY `suppressed` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;


-- ***********************************************************************************************
-- *********************************************************************************************
-- The procedure "proc_get_partner_sites_outcomes" gets the suppressed and the non suppressed for all 
-- the sites supported by a particular partner to populate the partner sites outcomes graph at the bottom of partner summaries page when a partner is selected
-- ********************************************************************************************
-- To retrieve data from it run the query CALL `proc_get_partner_sites_outcomes`('2','2016', '0');
-- The parameters to be passed into the procedure are partnerID, year and the month
-- If the month is set to 0 it picks for the entire year.
-- ********************************************************************************************
DROP PROCEDURE IF EXISTS `proc_get_partner_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sites_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `view_facilitys`.`name`, 
                    SUM(`vl_site_summary`.`undetected`+`vl_site_summary`.`less1000`) AS `suppressed`,
                    SUM((`vl_site_summary`.`less5000`)+(`vl_site_summary`.`above5000`) AS `nonsuppressed` LEFT JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID` WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;