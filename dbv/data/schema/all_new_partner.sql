DROP PROCEDURE IF EXISTS `proc_get_vl_partner_regimen_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_partner_regimen_outcomes`
(IN P_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`vp`.`name`, 
						SUM(`vnr`.`less5000`+`vnr`.`above5000`) AS `nonsuppressed`, 
						SUM(`vnr`.`Undetected`+`vnr`.`less1000`) AS `suppressed` 
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
          SUM(`Undetected`+`less1000`) AS `suppressed`,
          SUM(`Undetected`+`less1000`+`less5000`+`above5000`) AS `tests`,
          SUM((`Undetected`+`less1000`)*100/(`Undetected`+`less1000`+`less5000`+`above5000`)) AS `suppression`  
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
                    SUM(`vcr`.`undetected`+`vcr`.`less1000`) AS `suppressed`,
                    SUM(`vcr`.`less5000`+`vcr`.`above5000`) AS `nonsuppressed` 
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
                    SUM(`vpa`.`undetected`+`vpa`.`less1000`) AS `suppressed`,
                    SUM(`vpa`.`less5000`+`vpa`.`above5000`) AS `nonsuppressed`
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
          SUM(`Undetected`+`less1000`) AS `suppressed`,
          SUM(`Undetected`+`less1000`+`less5000`+`above5000`) AS `tests`,
          SUM((`Undetected`+`less1000`)*100/(`Undetected`+`less1000`+`less5000`+`above5000`)) AS `suppression` 

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
                        SUM(`vna`.`less5000`+`vna`.`above5000`) AS `nonsuppressed`, 
                        SUM(`vna`.`Undetected`+`vna`.`less1000`) AS `suppressed` 
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
