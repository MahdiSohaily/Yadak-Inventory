DELIMITER $$

CREATE FUNCTION gregorian_to_shamsi_datec(days_interval INT)
RETURNS VARCHAR(10)
BEGIN
    DECLARE persian_year INT;
    DECLARE persian_month INT;
    DECLARE persian_day INT;
    DECLARE gregorian_date DATE;

    SET gregorian_date = CURDATE() - INTERVAL days_interval DAY; -- Subtract the days_interval from the current date in Gregorian calendar

    SET persian_year = YEAR(gregorian_date) - 621;

    IF MONTH(gregorian_date) < 3 OR (MONTH(gregorian_date) = 3 AND DAY(gregorian_date) < 21) THEN
        SET persian_year = persian_year - 1;
    END IF;

    SET persian_month = (MONTH(gregorian_date) + 9) % 12 + 1;

    IF persian_month < 3 THEN
        SET persian_day = DAY(gregorian_date) + 31 - 20;
    ELSE
        SET persian_day = DAY(gregorian_date) - 20;
    END IF;

    RETURN CONCAT(LPAD(persian_year, 4, '0'), '/', LPAD(persian_month, 2, '0'), '/', LPAD(persian_day, 2, '0'));
END$$

DELIMITER ;

SELECT gregorian_to_shamsi_datec(2); -- Returns Shamsi date 30 days ago from today

SELECT *
FROM exitrecord
WHERE invoice_date >= gregorian_to_shamsi_date(30)
  AND invoice_date <= gregorian_to_shamsi_date(0);
