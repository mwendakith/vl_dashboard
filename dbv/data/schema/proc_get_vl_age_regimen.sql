DROP PROCEDURE IF EXISTS `proc_get_vl_age_regimen`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_regimen`
(IN filter_age INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT ";

    IF (filter_age = 6 && filter_age = '6') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`less2` - `less2_nonsuppressed`) as `suppressed`, SUM(`less2_nonsuppressed`) as`nonsuppressed`, ");
    END IF;
    IF (filter_age = 7 && filter_age = '7') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`less9` - `less9_nonsuppressed`) as `suppressed`, SUM(`less9_nonsuppressed`) as`nonsuppressed`, ");
    END IF;
    IF (filter_age = 8 && filter_age = '8') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`less14` - `less14_nonsuppressed`) as `suppressed`, SUM(`less14_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 9 && filter_age = '9') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`less19` - `less19_nonsuppressed`) as `suppressed`, SUM(`less19_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 10 && filter_age = '10') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`less24` - `less24_nonsuppressed`) as `suppressed`, SUM(`less24_nonsuppressed`) as `nonsuppressed`, ");
    END IF;
    IF (filter_age = 11 && filter_age = '11') THEN
      SET @QUERY = CONCAT(@QUERY, " SUM(`over25` - `over25_nonsuppressed`) as `suppressed`, SUM(`over25_nonsuppressed`) as `nonsuppressed`, ");
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