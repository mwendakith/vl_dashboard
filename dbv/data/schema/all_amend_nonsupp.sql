DROP PROCEDURE IF EXISTS `proc_get_counties_sustxfail_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_counties_sustxfail_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
                    SUM(`Undetected`+`less1000`) AS `suppressed`,
                    SUM(`less5000`+`above5000`) AS `nonsuppressed`,
                    (SUM(`Undetected`+`less1000`)/(SUM(`Undetected`+`less1000`)+SUM(`less5000`+`above5000`))) AS `pecentage`
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
