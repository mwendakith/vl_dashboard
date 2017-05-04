DROP PROCEDURE IF EXISTS `proc_get_vl_lab_live_data`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_lab_live_data`
()
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
                WHERE 1 AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype=2) AND testtype=2
                GROUP BY `labs`.`ID`";
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_vl_live_data_totals`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_live_data_totals`
()
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
                    SUM((`lablogs`.`rocheprocessed`)) AS `rocheprocessed`
                FROM `lablogs`

                WHERE 1 AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype=2) AND testtype=2";
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_lab_live_data`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_live_data`
()
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
                WHERE 1 AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype=1) AND testtype=1
                GROUP BY `labs`.`ID`";
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_live_data_totals`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_live_data_totals`
()
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
                    SUM((`lablogs`.`rocheprocessed`)) AS `rocheprocessed`
                FROM `lablogs`

                WHERE 1 AND DATE(logdate) = (SELECT MAX(logdate) from lablogs WHERE testtype=1) AND testtype=1";
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
