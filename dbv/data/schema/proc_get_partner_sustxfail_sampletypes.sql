DROP PROCEDURE IF EXISTS `proc_get_partner_sustxfail_sampletypes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sustxfail_sampletypes`
<<<<<<< HEAD
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
=======
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
BEGIN
  SET @QUERY =    "SELECT 
                        `vsd`.`name`, 
                        SUM(`vcs`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_partner_sampletype` `vcs` 
                    JOIN `viralsampletypedetails` `vsd` 
                        ON `vcs`.`sampletype` = `vsd`.`ID`
                WHERE 1";

<<<<<<< HEAD
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`partner` = '",P_id,"' AND `vcs`.`year` = '",filter_year,"' AND `vcs`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`partner` = '",P_id,"' AND `vcs`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vsd`.`name` ");
=======
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
    
    SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`partner` = '",P_id,"' GROUP BY `vsd`.`name` ");
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
<<<<<<< HEAD
DELIMITER ;
=======
DELIMITER ;
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
