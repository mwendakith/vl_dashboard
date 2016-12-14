DROP PROCEDURE IF EXISTS `proc_get_vl_age_vl_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_age_vl_outcomes`
(IN A_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
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
    FROM `vl_national_age`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `age` = '",A_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;