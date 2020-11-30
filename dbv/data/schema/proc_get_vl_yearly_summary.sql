DROP PROCEDURE IF EXISTS `proc_get_vl_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_yearly_summary`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, 
                    SUM(`cs`.`Undetected` + `cs`.`less1000`) AS `suppressed`, 
                    SUM(`cs`.`above5000` + `cs`.`less5000`) AS `nonsuppressed`
                FROM `vl_county_summary` `cs`
                WHERE 1  ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, "  GROUP BY `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
