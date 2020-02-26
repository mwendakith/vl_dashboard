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
        SUM(`over25`) AS `over25`,
        SUM(`noage_nonsuppressed`) AS `noage_nonsuppressed`,
        SUM(`less2_nonsuppressed`) AS `less2_nonsuppressed`,
        SUM(`less9_nonsuppressed`) AS `less9_nonsuppressed`,
        SUM(`less14_nonsuppressed`) AS `less14_nonsuppressed`,
        SUM(`less19_nonsuppressed`) AS `less19_nonsuppressed`,
        SUM(`less24_nonsuppressed`) AS `less24_nonsuppressed`,
        SUM(`over25_nonsuppressed`) AS `over25_nonsuppressed`
    FROM `vl_partner_prophylaxis`
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
