DROP PROCEDURE IF EXISTS `proc_get_vl_national_yearly_tests_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_national_yearly_tests_age`
()
BEGIN
  SET @QUERY =    "SELECT
                    `vna`.`year`, `vna`.`age`,  `ac`.`name`, 

                    SUM(`vna`.`tests`) AS `tests`

                FROM `vl_national_age` `vna`
                  LEFT JOIN `agecategory` `ac` 
                    ON `vna`.`age` = `ac`.`ID`

                WHERE 1 AND `ac`.`subID`=1 ";

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `vna`.`year`, `vna`.`age` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `vna`.`year` ASC, `vna`.`age` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
