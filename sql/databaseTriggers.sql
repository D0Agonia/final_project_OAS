CREATE TRIGGER generate_guest_id
BEFORE INSERT ON GuestCredentials
FOR EACH ROW
BEGIN
    DECLARE num_string VARCHAR(6);
    REPEAT
        SET num_string = LPAD(FLOOR(RAND() * 1000000), 6, '0');
    UNTIL NOT EXISTS(SELECT guest_id FROM GuestCredentials WHERE guest_id = CONCAT('GUEST', num_string))
    END REPEAT;

    SET NEW.guest_id = CONCAT('GUEST', num_string);
END;