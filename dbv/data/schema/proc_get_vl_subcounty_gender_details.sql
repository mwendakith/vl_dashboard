DROP PROCEDURE IF EXISTS `proc_get_vl_subcounty_gender_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_vl_subcounty_gender_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    SUM(`vg`.`tests`) AS `tests`,
                    SUM(`vg`.`Undetected`) AS `Undetected`, 
                    SUM(`vg`.`less1000`) AS `less1000`, 
                    SUM(`vg`.`less5000`) AS `less5000`, 
                    SUM(`vg`.`above5000`) AS `above5000`,
                    `g`.`name`, ";
   IF (type=0 OR type='0') THEN 
      SET @QUERY = CONCAT(@QUERY, " `jt`.`name` as `selection` FROM `vl_subcounty_gender` `vg` JOIN `gender` `g` ON `g`.`ID` = `vg`.`gender` JOIN `districts` `jt` ON `jt`.`id` = `vg`.`subcounty` WHERE 1 ");
   END IF;
   IF (type=1 OR type='1') THEN 
      SET @QUERY = CONCAT(@QUERY, " `jt`.`name` as `selection` FROM `vl_site_gender` `vg` JOIN `gender` `g` ON `g`.`ID` = `vg`.`gender` JOIN `view_facilitys` `jt` ON `jt`.`id` = `vg`.`facility` WHERE `jt`.`district` = '",ID,"' ");
   END IF;
                        
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

   SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name`, `selection` ");

   PREPARE stmt FROM @QUERY;
   EXECUTE stmt;
END //
DELIMITER ;

