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
                    SUM((`lablogs`.`oldestinqueuesample`)) AS `oldestinqueuesample`
                FROM `lablogs`

                JOIN `labs` 
                    ON `lablogs`.`lab` = `labs`.`ID`
                WHERE 1 AND DATE(logdate) = CURDATE()
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

                WHERE 1 AND DATE(logdate) = CURDATE()";
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;