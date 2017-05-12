DROP PROCEDURE IF EXISTS `proc_get_vl_lab_live_data`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_lab_live_data`
(IN filter_type INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `labs`.`ID` AS `ID`,
                    `labs`.`name` AS `name`,
                    SUM((`lablogs`.`enteredsamplesatsite`)) AS `enteredsamplesatsite`,
                    SUM((`lablogs`.`enteredsamplesatlab`)) AS `enteredsamplesatlab`,
                    SUM((`lablogs`.`receivedsamples`)) AS `receivedsamples`,
                    SUM((`lablogs`.`inqueuesamples`)) AS `inqueuesamples`,
                    SUM((`lablogs`.`inprocesssamples`)) AS `inprocesssamples`,
                    SUM((`lablogs`.`processedsamples`)) AS `processedsamples`,
                    SUM((`lablogs`.`pendingapproval`)) AS `pendingapproval`,
                    SUM((`lablogs`.`dispatchedresults`)) AS `dispatchedresults`,
                    SUM((`lablogs`.`oldestinqueuesample`)) AS `oldestinqueuesample`,
                    `dateupdated`
                FROM `lablogs`

                JOIN `labs` 
                    ON `lablogs`.`lab` = `labs`.`ID`
                WHERE 1 ";

                SET @QUERY = CONCAT(@QUERY, " AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype = '",filter_type,"') AND testtype = '",filter_type,"'");

                SET @QUERY = CONCAT(@QUERY, " GROUP BY `labs`.`ID` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_live_data_totals`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_live_data_totals`
(IN filter_type INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    SUM((`lablogs`.`receivedsamples`)) AS `receivedsamples`,
                    SUM((`lablogs`.`inqueuesamples`)) AS `inqueuesamples`,
                    SUM((`lablogs`.`inprocesssamples`)) AS `inprocesssamples`,
                    SUM((`lablogs`.`processedsamples`)) AS `processedsamples`,
                    SUM((`lablogs`.`pendingapproval`)) AS `pendingapproval`,
                    SUM((`lablogs`.`dispatchedresults`)) AS `dispatchedresults`,
                    SUM((`lablogs`.`enteredsamplesatlab`)) AS `enteredsamplesatlab`,
                    SUM((`lablogs`.`enteredsamplesatsite`)) AS `enteredsamplesatsite`,
                    SUM((`lablogs`.`enteredreceivedsameday`)) AS `enteredreceivedsameday`,
                    SUM((`lablogs`.`enterednotreceivedsameday`)) AS `enterednotreceivedsameday`,
                    SUM((`lablogs`.`abbottinprocess`)) AS `abbottinprocess`,
                    SUM((`lablogs`.`panthainprocess`)) AS `panthainprocess`,
                    SUM((`lablogs`.`rocheinprocess`)) AS `rocheinprocess`,
                    SUM((`lablogs`.`abbottprocessed`)) AS `abbottprocessed`,
                    SUM((`lablogs`.`panthaprocessed`)) AS `panthaprocessed`,
                    SUM((`lablogs`.`rocheprocessed`)) AS `rocheprocessed`,
                    SUM((`lablogs`.`yeartodate`)) AS `yeartodate`,
                    SUM((`lablogs`.`monthtodate`)) AS `monthtodate`
                FROM `lablogs`

                WHERE 1 ";
  
                SET @QUERY = CONCAT(@QUERY, " AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype = '",filter_type,"') AND testtype = '",filter_type,"'");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_live_lab_samples`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_live_lab_samples`
(IN filter_type INT(11), IN filter_lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    SUM((`lablogs`.`oneweek`)) AS `oneweek`,
                    SUM((`lablogs`.`twoweeks`)) AS `twoweeks`,
                    SUM((`lablogs`.`threeweeks`)) AS `threeweeks`,
                    SUM((`lablogs`.`aboveamonth`)) AS `aboveamonth`
                FROM `lablogs`

                WHERE 1 ";
  
                SET @QUERY = CONCAT(@QUERY, " AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype = '",filter_type,"') AND testtype = '",filter_type,"'");
                SET @QUERY = CONCAT(@QUERY, " AND lab = '",filter_lab,"'");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
