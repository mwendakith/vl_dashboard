DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_county_summary `vcs`
                LEFT JOIN countys `c`
                    ON c.ID = vcs.county 
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_sustxfail_justification`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_county_justification `vcj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vcj.justification
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_sustxfail_justification`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_subcounty_justification `vsj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vsj.justification
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_justification`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_national_justification `vnj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vnj.justification
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_sustxfail_age`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `ag`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_county_age `vca`
                LEFT JOIN agecategory `ag`
                    ON ag.ID = vca.age

                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;


    SET @QUERY = CONCAT(@QUERY, " AND ag.ID NOT BETWEEN '1' AND '5' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_sustxfail_age`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `ag`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    ((SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_subcounty_age `vsa`
                LEFT JOIN agecategory `ag`
                    ON ag.ID = vsa.age

                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;


    SET @QUERY = CONCAT(@QUERY, " AND ag.ID NOT BETWEEN '1' AND '5' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_age`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `ag`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    ((SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_national_age `vna`
                LEFT JOIN agecategory `ag`
                    ON ag.ID = vna.age

                WHERE 1";

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


    SET @QUERY = CONCAT(@QUERY, " AND ag.ID NOT BETWEEN '1' AND '5' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_subcounty`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_subcounty`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `d`.`name`, 
                      ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `percentages`, 
                      SUM(`vss`.`sustxfail`) AS `sustxfail` 
                  FROM `vl_subcounty_summary` `vss` 
                  JOIN `districts` `d` 
                  ON `vss`.`subcounty` = `d`.`ID`
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `d`.`name` ORDER BY `percentages` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_sustxfail_subcounty`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_sustxfail_subcounty`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `d`.`name`, 
                      ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `percentages`, 
                      SUM(`vss`.`sustxfail`) AS `sustxfail` 
                  FROM `vl_subcounty_summary` `vss` 
                  JOIN `districts` `d` 
                  ON `vss`.`subcounty` = `d`.`ID`
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `d`.`county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `d`.`name` ORDER BY `percentages` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_partner`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_partner`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `p`.`name`, 
                      ((SUM(`vps`.`sustxfail`)/SUM(`vps`.`alltests`))*100) AS `percentages`, 
                      SUM(`vps`.`sustxfail`) AS `sustxfail` 
                  FROM `vl_partner_summary` `vps` 
                  JOIN `partners` `p` 
                  ON `vps`.`partner` = `p`.`ID`
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`name` ORDER BY `percentages` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_regional_sustxfail_partner`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_sustxfail_partner`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      DISTINCT(`p`.`name`) AS `name`,
                      ((SUM(`vps`.`sustxfail`)/SUM(`vps`.`alltests`))*100) AS `percentages`, 
                      SUM(`vps`.`sustxfail`) AS `sustxfail` 
                  FROM `vl_partner_summary` `vps` 
                  JOIN `partners` `p` 
                    ON `vps`.`partner` = `p`.`ID`
                  JOIN `view_facilitys` `vf`
                    ON `p`.`ID` = `vf`.`partner`
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `p`.`name` ORDER BY `percentages` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_sites_listing`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_listing`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`vss`.`sustxfail`) AS `sustxfail`, 
                        SUM(`vss`.`alltests`) AS `alltests`,
                        SUM(`vss`.`sustxfail`), 
                        ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `non supp`, 
                        `vf`.`ID`, 
                        `vf`.`name` 
                    FROM `vl_site_summary` `vss` LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
                    WHERE 1";

  
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`ID` ORDER BY `non supp` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_sites_listing`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_sites_listing`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`vss`.`sustxfail`) AS `sustxfail`, 
                        SUM(`vss`.`alltests`) AS `alltests`, 
                        ((SUM(`vss`.`sustxfail`)/SUM(`vss`.`alltests`))*100) AS `non supp`, 
                        `vf`.`ID`, 
                        `vf`.`name` 
                    FROM `vl_site_summary` `vss` LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
                    WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `vf`.`ID` ORDER BY `non supp` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_outcomes`
(IN P_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vp`.`name`, 
                        (SUM(`vnr`.`less5000`)+SUM(`vnr`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vnr`.`Undetected`)+SUM(`vnr`.`less1000`)) AS `suppressed` 
                        FROM `vl_partner_regimen` `vnr`
                        LEFT JOIN `viralprophylaxis` `vp` 
                        ON `vnr`.`regimen` = `vp`.`ID`
                    WHERE 1";

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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_Id,"' GROUP BY `name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_vl_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_vl_outcomes`
(IN P_id INT(11), IN R_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
       SUM(`confirmtx`) AS `confirmtx`,
        SUM(`confirm2vl`) AS `confirm2vl`,
        SUM(`Undetected`) AS `undetected`,
        SUM(`less1000`) AS `less1000`,
        SUM(`less5000`) AS `less5000`,
        SUM(`above5000`) AS `above5000`,
        SUM(`tests`) AS `alltests`,
        SUM(`sustxfail`) AS `sustxfail`,
        SUM(`rejected`) AS `rejected`, 
        SUM(`repeattests`) AS `repeats`, 
        SUM(`invalids`) AS `invalids`
    FROM `vl_partner_regimen`
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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_gender`
(IN P_id INT(11), IN R_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`maletest`) AS `maletest`,
        SUM(`femaletest`) AS `femaletest`,
        SUM(`nogendertest`) AS `nodata`
    FROM `vl_partner_regimen`
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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' ");

   
     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_age`
(IN P_id INT(11), IN R_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`noage`) AS `noage`,
        SUM(`less2`) AS `less2`,
        SUM(`less9`) AS `less9`,
        SUM(`less14`) AS `less14`,
        SUM(`less19`) AS `less19`,
        SUM(`less24`) AS `less24`,
        SUM(`over25`) AS `over25`
    FROM `vl_partner_regimen`
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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

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
    FROM `vl_partner_regimen`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;


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

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_county_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_county_age_outcomes`
(IN P_Id INT(11), IN filter_age INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`name`,
                    (SUM(`vpa`.`undetected`)+SUM(`vpa`.`less1000`)) AS `suppressed`,
                    (SUM(`vpa`.`less5000`)+SUM(`vpa`.`above5000`)) AS `nonsuppressed`
                  FROM vl_partner_age vpa
                  LEFT JOIN view_facilitys vf
                    ON vf.partner = vpa.partner
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


    SET @QUERY = CONCAT(@QUERY, " AND `age` = '",filter_age,"' AND `vpa`.`partner` = '",P_Id,"' GROUP BY `c`.`name` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_sample_types`
(IN P_Id INT(11), IN A_id INT(11), IN filter_year INT(11))
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

    FROM `vl_partner_age`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `partner` = '",P_Id,"' AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_gender`
(IN P_Id INT(11), IN A_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`maletest`) AS `maletest`,
        SUM(`femaletest`) AS `femaletest`,
        SUM(`nogendertest`) AS `nodata`
    FROM `vl_partner_age`
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

    SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `partner` = '",P_Id,"' ");


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_vl_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_vl_outcomes`
(IN P_id INT(11),IN A_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`confirmtx`) AS `confirmtx`,
        SUM(`confirm2vl`) AS `confirm2vl`,
        SUM(`Undetected`) AS `undetected`,
        SUM(`less1000`) AS `less1000`,
        SUM(`less5000`) AS `less5000`,
        SUM(`above5000`) AS `above5000`,
        SUM(`tests`) AS `alltests`,
        SUM(`sustxfail`) AS `sustxfail`,
        SUM(`rejected`) AS `rejected`, 
        SUM(`repeattests`) AS `repeats`, 
        SUM(`invalids`) AS `invalids`
    FROM `vl_partner_age`
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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `age` = '",A_id,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_outcomes`
(IN P_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        (SUM(`vna`.`less5000`)+SUM(`vna`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vna`.`Undetected`)+SUM(`vna`.`less1000`)) AS `suppressed` 
                        FROM `vl_partner_age` `vna`
                        LEFT JOIN `agecategory` `ac` 
                        ON `vna`.`age` = `ac`.`ID`
                    WHERE `ac`.`ID` NOT BETWEEN '1' AND '5'";

 
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


    SET @QUERY = CONCAT(@QUERY, " AND `vna`.`partner` = '",P_Id,"' GROUP BY `name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_suppression`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM((`vnj`.`tests`)) AS `tests`, 
                    SUM((`vnj`.`undetected`)+(`vnj`.`less1000`)) AS `suppressed`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_non_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_non_suppression`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`, 
                    (SUM(`vnj`.`above5000`)+SUM(`vnj`.`less5000`)) AS `non_suppressed`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_rejected`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_rejected`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM((`vnj`.`tests`)) AS `tests`, 
                    SUM(`vnj`.`rejected`) AS `rejected`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_pregnant_women`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_pregnant_women`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`
                FROM `vl_county_justification` `vnj`
                WHERE 1 AND `vnj`.`justification` = 6 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_lactating_women`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_lactating_women`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`
                FROM `vl_county_justification` `vnj`
                WHERE 1 AND `vnj`.`justification` = 9 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_partner_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_partner_details`
(IN county INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT `p`.`name` AS `partner`, `vf`.`name` AS `facility`, SUM(`vss`.`alltests`) AS `tests`, 
                  (SUM(`vss`.`less1000`) + SUM(`vss`.`undetected`)) AS `suppressed`, 
                  (SUM(`vss`.`less5000`) + SUM(`vss`.`above5000`)) AS `non_suppressed`,
                  SUM(`vss`.`rejected`) AS `rejected`, SUM(`vss`.`adults`) AS `adults`, SUM(`vss`.`paeds`) AS `children`
                FROM `vl_site_summary` `vss`
                JOIN (`view_facilitys` `vf` CROSS JOIN `partners` `p`)
                ON (`vss`.`facility`=`vf`.`ID` AND `p`.`ID`=`vf`.`partner`)
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",county,"' AND `vss`.`year` = '",filter_year,"' AND `vss`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",county,"' AND `vss`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`ID` ");

    SET @QUERY = CONCAT(@QUERY, " ORDER BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_summary`
(IN county INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`,
                    (SUM(`vnj`.`less1000`) + SUM(`vnj`.`undetected`)) AS `suppressed`, 
                    (SUM(`vnj`.`less5000`) + SUM(`vnj`.`above5000`)) AS `non_suppressed`,
                    SUM(`vnj`.`rejected`) AS `rejected`
                FROM `vl_county_justification` `vnj`
                WHERE 1  ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`county` = '",county,"' AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`county` = '",county,"' AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 


DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`ID`, 
                    `c`.`name`, 
                    (((SUM(`less5000`)+SUM(`above5000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)))*100) AS `sustxfail` 
                    FROM `vl_county_summary` `vcs` 
                    JOIN `countys` `c` 
                    ON `vcs`.`county` = `c`.`ID`
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.`name` ORDER BY `sustxfail` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    ((SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`))) AS `pecentage`
                FROM vl_county_summary `vcs`
                LEFT JOIN countys `c`
                    ON c.ID = vcs.county 
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`labname`,
                    (SUM(`vcs`.`Undetected`)+SUM(`vcs`.`less1000`)) AS `detectableNless1000`,
                    SUM(`vcs`.`sustxfail`) AS `sustxfl`
                FROM `vl_lab_summary` `vcs` LEFT JOIN `labs` `l` ON `vcs`.`lab` = `l`.`ID` WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vcs`.`lab` ORDER BY `detectableNless1000` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_national_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_age`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vna`.`tests`) AS `agegroups`, 
                    (SUM(`vna`.`undetected`)+SUM(`vna`.`less1000`)) AS `suppressed`,
                    (SUM(`vna`.`less5000`)+SUM(`vna`.`above5000`)) AS `nonsuppressed`
                FROM `vl_national_age` `vna`
                JOIN `agecategory` `ac`
                    ON `vna`.`age` = `ac`.`ID`
                WHERE 1";

    
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_national_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sample_types`
(IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `month`,
                    `year`,
                    `edta`,
                    `dbs`,
                    `plasma`,
                    `alledta`,
                    `alldbs`,
                    `allplasma`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `tests`,
                    (SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`
                FROM `vl_national_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' OR `year`='",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vca`.`tests`) AS `agegroups`,
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)) AS `suppressed`,
                    (SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_age` `vca`
                JOIN `agecategory` `ac`
                    ON `vca`.`age` = `ac`.`ID`
                WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `vca`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_gender`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    (SUM(`vng`.`undetected`)+SUM(`vng`.`less1000`)) AS `suppressed`,
                    (SUM(`vng`.`less5000`)+SUM(`vng`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
                WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, "  AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, "  AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, "  AND `year` = '",filter_year,"' ");
    END IF;

     SET @QUERY = CONCAT(@QUERY, " AND `vng`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sample_types`
(IN P_id INT(11), IN filter_year INT(11), IN to_year INT(11))
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
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `tests`,
                    (SUM(`Undetected`)+SUM(`less1000`))*100/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `suppression`
                FROM `vl_partner_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND (`year` = '",filter_year,"' OR  `year` = '",to_year,"') GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_regional_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_age`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vca`.`tests`) AS `agegroups`, 
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)) AS `suppressed`,
                    (SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `nonsuppressed`
                FROM `vl_county_age` `vca`
                JOIN `agecategory` `ac`
                    ON `vca`.`age` = `ac`.`ID`
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


    SET @QUERY = CONCAT(@QUERY, " AND `vca`.`county` = '",C_id,"' GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_regional_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_gender`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    (SUM(`vng`.`undetected`)+SUM(`vng`.`less1000`)) AS `suppressed`,
                    (SUM(`vng`.`less5000`)+SUM(`vng`.`above5000`)) AS `nonsuppressed`
                FROM `vl_county_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
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

    

    SET @QUERY = CONCAT(@QUERY, " AND `vng`.`county` = '",C_id,"' GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_sites_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_age`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `ac`.`name`, 
                    SUM(`vsa`.`tests`) AS `agegroups`, 
                    (SUM(`vsa`.`undetected`)+SUM(`vsa`.`less1000`)) AS `suppressed`,
                    (SUM(`vsa`.`less5000`)+SUM(`vsa`.`above5000`)) AS `nonsuppressed`
                FROM `vl_site_age` `vsa`
                JOIN `agecategory` `ac`
                    ON `vsa`.`age` = `ac`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");



    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_sites_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_gender`
(IN S_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    `g`.`name`,
                      (SUM(`vsg`.`Undetected`) + SUM(`vsg`.`less1000`)) AS `suppressed`, 
                      (SUM(`vsg`.`less5000`) + SUM(`vsg`.`above5000`)) AS `nonsuppressed` 
                FROM `vl_site_gender` `vsg`
                JOIN `gender` `g`
                    ON `vsg`.`gender` = `g`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_age_breakdowns_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_breakdowns_outcomes`
(IN filter_age VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN partner INT(11), IN subcounty INT(11), IN site INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)) AS `suppressed`,
                    (SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `nonsuppressed`, 
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)+SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `total`,
                    ((SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`))/(SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)+SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`))*100) AS `percentage` ";

    IF (county != 0 && county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_county_age` `vca` JOIN `countys` `c` ON `vca`.`county` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (partner != 0 && partner != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_partner_age` `vca` JOIN `partners` `c` ON `vca`.`partner` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (subcounty != 0 && subcounty != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_subcounty_age` `vca` JOIN `districts` `c` ON `vca`.`subcounty` = `c`.`ID` WHERE 1 ");
    END IF;
    IF (site != 0 && site != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `vl_site_age` `vca` JOIN `facilitys` `c` ON `vca`.`facility` = `c`.`ID` WHERE 1 ");
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


    SET @QUERY = CONCAT(@QUERY, " AND `age` = ",filter_age," GROUP BY `c`.`ID` ORDER BY `percentage` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        (SUM(`vna`.`less5000`)+SUM(`vna`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vna`.`Undetected`)+SUM(`vna`.`less1000`)) AS `suppressed` 
                        FROM `vl_national_age` `vna`
                        LEFT JOIN `agecategory` `ac` 
                        ON `vna`.`age` = `ac`.`ID`
                    WHERE `ac`.`ID` NOT BETWEEN '1' AND '5'";

 
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


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `ac`.`ID` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_age_regimen`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_regimen`
(IN filter_age INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT ";

    IF (filter_age = 6 && filter_age = '6') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`less2`) - SUM(`less2_nonsuppressed`)) as `suppressed`, SUM(`less2_nonsuppressed`) as`nonsuppressed`, ");
    END IF;
    IF (filter_age = 7 && filter_age = '7') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`less9`) - SUM(`less9_nonsuppressed`)) as `suppressed`, SUM(`less9_nonsuppressed`) as`nonsuppressed`, ");
    END IF;
    IF (filter_age = 8 && filter_age = '8') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`less14`) - SUM(`less14_nonsuppressed`)) as `suppressed`, SUM(`less14_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 9 && filter_age = '9') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`less19`) - SUM(`less19_nonsuppressed`)) as `suppressed`, SUM(`less19_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 10 && filter_age = '10') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`less24`) - SUM(`less24_nonsuppressed`)) as `suppressed`, SUM(`less24_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 11 && filter_age = '11') THEN
      SET @QUERY = CONCAT(@QUERY, " (SUM(`over25`) - SUM(`over25_nonsuppressed`)) as `suppressed`, SUM(`over25_nonsuppressed`) as `nonsuppressed`, ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " name FROM `vl_national_regimen` JOIN `viralprophylaxis` on `viralprophylaxis`.`ID` = `vl_national_regimen`.`regimen` WHERE 1 ");

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


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_age_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_sample_types`
(IN A_id VARCHAR(100), IN filter_year INT(11))
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
    FROM `vl_national_age`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `age` = ",A_id," AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_age_outcomes`
(IN filter_age VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    (SUM(`vca`.`undetected`)+SUM(`vca`.`less1000`)) AS `suppressed`,
                    (SUM(`vca`.`less5000`)+SUM(`vca`.`above5000`)) AS `nonsuppressed` 
                FROM `vl_county_age` `vca`
                    JOIN `countys` `c` ON `vca`.`county` = `c`.`ID`
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


    SET @QUERY = CONCAT(@QUERY, " AND `age` ",filter_age," GROUP BY `vca`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_regimen_outcomes`
(IN filter_regimen INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    (SUM(`vcr`.`undetected`)+SUM(`vcr`.`less1000`)) AS `suppressed`,
                    (SUM(`vcr`.`less5000`)+SUM(`vcr`.`above5000`)) AS `nonsuppressed` 
                FROM `vl_county_regimen` `vcr`
                    JOIN `countys` `c` ON `vcr`.`county` = `c`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " AND `regimen` = '",filter_regimen,"' GROUP BY `vcr`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_samples_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_samples_outcomes`
(IN filter_sampletype INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`)) AS `suppressed`,
                    (SUM(`vcs`.`less5000`)+SUM(`vcs`.`above5000`)) AS `nonsuppressed`
                    FROM `vl_county_sampletype` `vcs`
                    JOIN `countys` `c` ON `vcs`.`county` = `c`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " AND `sampletype` = '",filter_sampletype,"' GROUP BY `vcs`.`county` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_subcounty_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_subcounty_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vf`.`name` AS `name`, 
                        (SUM(`vss`.`less5000`)+SUM(`vss`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vss`.`Undetected`)+SUM(`vss`.`less1000`)) AS `suppressed` 
                        FROM `vl_subcounty_summary` `vss`
                        JOIN `districts` `vf` 
                        ON `vss`.`subcounty` = `vf`.`id`
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

     IF (filter_county != 0 && filter_county != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
     END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`id` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_sustxfail`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_sustxfail`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`
                FROM vl_county_summary `vcs`
                LEFT JOIN countys `c`
                    ON c.ID = vcs.county
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY suppressed DESC, nonsuppressed DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_sustxfail_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_sustxfail_gender`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `g`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`
                FROM vl_county_gender `vcg`
                LEFT JOIN gender `g`
                    ON g.ID = vcg.gender 
                WHERE 1";

  
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_county_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_county_sustxfail_justification`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `pecentage`
                FROM vl_county_justification `vcj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vcj.justification
                WHERE 1";

   
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_fundingagencies_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_fundingagencies_age`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vpa`.`tests`) AS `agegroups`, 
                    (SUM(`vpa`.`undetected`)+SUM(`vpa`.`less1000`)) AS `suppressed`,
                    (SUM(`vpa`.`less5000`)+SUM(`vpa`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_age` `vpa`
                JOIN `partners` `p` ON `p`.`ID` = `vpa`.`partner` 
                JOIN `agecategory` `ac` ON `vpa`.`age` = `ac`.`ID`
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


    SET @QUERY = CONCAT(@QUERY, " AND `p`.`funding_agency_id` = '",agency,"' GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_fundingagencies_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_fundingagencies_gender`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    (SUM(`vpg`.`undetected`)+SUM(`vpg`.`less1000`)) AS `suppressed`,
                    (SUM(`vpg`.`less5000`)+SUM(`vpg`.`above5000`)) AS `nonsuppressed`
                FROM `vl_partner_gender` `vpg`
                JOIN `partners` `p` ON `p`.`ID` = `vpg`.`partner`
                JOIN `gender` `g` ON `vpg`.`gender` = `g`.`ID`
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

    

    SET @QUERY = CONCAT(@QUERY, " AND `p`.`funding_agency_id` = '",agency,"' GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_age`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `ag`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `pecentage`
                FROM vl_national_age `vna`
                LEFT JOIN agecategory `ag`
                    ON ag.ID = vna.age

                WHERE 1";

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


    SET @QUERY = CONCAT(@QUERY, " AND ag.ID NOT BETWEEN '1' AND '5' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_gender`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `g`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`
                FROM vl_national_gender `vng`
                LEFT JOIN gender `g`
                    ON g.ID = vng.gender 
                WHERE 1";

  
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


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_sustxfail_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_sustxfail_justification`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vj`.`name`,
                    (SUM(`Undetected`)+SUM(`less1000`)) AS `suppressed`,
                    (SUM(`less5000`)+SUM(`above5000`)) AS `nonsuppressed`,
                    (SUM(`Undetected`)+SUM(`less1000`))/(SUM(`Undetected`)+SUM(`less1000`)+SUM(`less5000`)+SUM(`above5000`)) AS `pecentage`
                FROM vl_national_justification `vnj`
                LEFT JOIN viraljustifications `vj`
                    ON vj.ID = vnj.justification
                WHERE 1";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_yearly_summary`
()
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`
                FROM `vl_national_summary` `cs`
                WHERE 1  ";
    
      SET @QUERY = CONCAT(@QUERY, "  GROUP BY `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_national_yearly_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_yearly_trends`
()
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`, 
                    SUM(`cs`.`received`) AS `received`, 
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`tat4`) AS `tat4`
                FROM `vl_national_summary` `cs`
                WHERE 1  ";
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_sample_types`
(IN P_Id INT(1), IN A_id VARCHAR(100), IN filter_year INT(11))
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

    FROM `vl_partner_age`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `age` ",A_id," AND `partner` = '",P_Id,"' AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_age_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_age_suppression`
(IN A_id VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        partners.name,
        (SUM(`Undetected`) + SUM(`less1000`)) AS `suppressed`, 
        (SUM(`above5000`) + SUM(`less5000`)) AS `nonsuppressed`
    FROM `vl_partner_age`
    LEFT JOIN partners 
      ON partners.ID = vl_partner_age.partner
    WHERE `partners`.`flag` = '1' ";
  
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

    SET @QUERY = CONCAT(@QUERY, " AND `age` ",A_id," ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `suppressed` desc ");
    

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_county_age_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_county_age_outcomes`
(IN P_Id INT(11), IN filter_age VARCHAR(100), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `c`.`name`,
                    (SUM(`vpa`.`undetected`)+SUM(`vpa`.`less1000`)) AS `suppressed`,
                    (SUM(`vpa`.`less5000`)+SUM(`vpa`.`above5000`)) AS `nonsuppressed`
                  FROM vl_partner_age vpa
                  LEFT JOIN view_facilitys vf
                    ON vf.partner = vpa.partner
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


    SET @QUERY = CONCAT(@QUERY, " AND `age` ",filter_age," AND `vpa`.`partner` = '",P_Id,"' GROUP BY `c`.`name` ORDER BY `suppressed` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

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

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_outcomes`
(IN P_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vp`.`name`, 
                        (SUM(`vnr`.`less5000`)+SUM(`vnr`.`above5000`)) AS `nonsuppressed`, 
                        (SUM(`vnr`.`Undetected`)+SUM(`vnr`.`less1000`)) AS `suppressed` 
                        FROM `vl_partner_regimen` `vnr`
                        LEFT JOIN `viralprophylaxis` `vp` 
                        ON `vnr`.`regimen` = `vp`.`ID`
                    WHERE 1";

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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_Id,"' GROUP BY `name` ORDER BY `suppressed` DESC, `nonsuppressed` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

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
    FROM `vl_partner_regimen`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `regimen` = '",R_id,"' AND `year` = '",filter_year,"' GROUP BY `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_yearly_summary`
(IN P_id INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`
                FROM `vl_partner_summary` `cs`
                WHERE 1  ";

      IF (P_id != 0 && P_id != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`partner` = '",P_id,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, "  GROUP BY `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_partner_yearly_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_yearly_trends`
(IN P_id INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    (SUM(`cs`.`Undetected`) + SUM(`cs`.`less1000`)) AS `suppressed`, 
                    (SUM(`cs`.`above5000`) + SUM(`cs`.`less5000`)) AS `nonsuppressed`, 
                    SUM(`cs`.`received`) AS `received`, 
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`tat4`) AS `tat4`
                FROM `vl_partner_summary` `cs`
                WHERE 1  ";

      IF (P_id != 0 && P_id != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`partner` = '",P_id,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

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

DROP PROCEDURE IF EXISTS `proc_get_vl_pmtct_grouped`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_pmtct_grouped`
(IN Pm_ID INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN subcounty INT(11), IN partner INT(11))
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
          (SUM(`vcs`.`undetected`)+SUM(`vcs`.`less1000`)+SUM(`vcs`.`less5000`)+SUM(`vcs`.`above5000`)) AS `routine` 
          FROM `vl_site_pmtct` `vcs` LEFT JOIN `view_facilitys` `com` ON `vcs`.`facility` = `com`.`ID` WHERE 1 ";

    IF (county != 0 || county != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`county` = '",county,"' ");
    END IF;           
        IF (subcounty != 0 || subcounty != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`district` = '",subcounty,"' ");
    END IF;
    IF (partner != 0 || partner != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `com`.`partner` = '",partner,"' ");
    END IF;
    IF (Pm_ID != 0 || Pm_ID != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`pmtcttype` = '",Pm_ID,"' ");
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `com`.`ID` ORDER BY `routine` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_pmtct_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_pmtct_suppression`
(IN Pm_id INT(11), IN filter_year INT(11), IN filter_month INT(11), IN to_year INT(11), IN to_month INT(11), IN national INT(11), IN county INT(11), IN partner INT(11), IN subcounty INT(11), IN site INT(11))
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

    IF (filter_month !=0 && filter_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `year` BETWEEN '",filter_year,"' AND '",to_year,"' AND `month` BETWEEN '",filter_month,"' AND '",to_month,"' ");
    ELSE 
      SET @QUERY = CONCAT(@QUERY, " AND `year` BETWEEN '",filter_year,"' AND '",to_year,"' ");
    END IF;
    
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

