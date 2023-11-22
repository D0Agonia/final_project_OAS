USE OnlineAppointment;

CREATE FUNCTION insertCredentials(
    input_kldID VARCHAR(13),
    input_password VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE input_salt VARCHAR(32);
    DECLARE input_hashPassword BINARY(32);

    IF searchKLDID(input_kldID) = false THEN
        REPEAT
            SET input_salt = MD5(CONCAT(RAND(), NOW()));
        UNTIL NOT EXISTS (SELECT salt_password FROM UserCredentials WHERE salt_password = input_salt)
        END REPEAT;

        SET input_hashPassword = UNHEX(SHA2(CONCAT(input_password, input_salt), 256));
        
        INSERT INTO UserCredentials(kld_id, hash_password, salt_password) VALUES(
            input_kldID, input_hashPassword, input_salt
        );

        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION insertDetails(
    input_kldID VARCHAR(13),
    input_firstname VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    IF searchKLDID(input_kldID) = true THEN
        INSERT INTO UserDetails(kld_id, name) VALUES(
            input_kldID, input_name
        );
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION insertGuest()
RETURNS VARCHAR(6)
READS SQL DATA
BEGIN
    DECLARE otp VARCHAR(6);

    REPEAT
        SET otp := MD5(CONCAT(RAND(), NOW()));
    UNTIL NOT EXISTS(SELECT otp_code FROM GuestCredentials WHERE otp_code = otp)
    END REPEAT;

    INSERT INTO GuestCredentials(otp_code, otp_expiration) VALUES(
        otp, NOW() + INTERVAL 1 HOUR
    );

    RETURN otp;
END;

CREATE FUNCTION requestPasswordChange(
    input_email VARCHAR(128)
)
RETURNS VARCHAR(64)
READS SQL DATA
BEGIN
    DECLARE result VARCHAR(64);
    DECLARE user_kldID VARCHAR(13);

    SELECT kld_id INTO user_kldID
    FROM UserDetails WHERE email = input_email;

    IF user_kldID IS NOT NULL AND NOT EXISTS(SELECT * FROM ChangePasswordRequest WHERE kld_id = user_kldID) THEN
        CALL CreateChangePasswordCode(user_kldID);
        SELECT changePassword_code INTO result
        FROM ChangePasswordRequest WHERE kld_id = user_kldID;
    ELSEIF user_kldID IS NOT NULL AND EXISTS(SELECT * FROM ChangePasswordRequest WHERE kld_id = user_kldID) THEN
        SELECT changePassword_code INTO result
        FROM ChangePasswordRequest WHERE kld_id = user_kldID;
    ELSE
        SET result = '1';
    END IF;

    RETURN result;
END;

CREATE FUNCTION verifyChangePasswordCode(
    input_code VARCHAR(64)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    IF EXISTS(SELECT * FROM ChangePasswordRequest WHERE changePassword_code = input_code) THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION verifyGuestLogin(
    input_otp VARCHAR(6)
) RETURNS VARCHAR(32)
READS SQL DATA
BEGIN
    DECLARE result VARCHAR(32);
    DECLARE guest_guestId VARCHAR(11);

    SELECT guest_id INTO guest_guestId
    FROM GuestCredentials WHERE otp_code = input_otp;

    IF guest_guestId IS NOT NULL THEN
        CALL CreateGuestSessionToken(guest_guestId);

        UPDATE GuestCredentials 
        SET otp_code = NULL, otp_expiration = NULL
        WHERE otp_code = input_otp;

        SELECT session_token INTO result 
        FROM LoginTokens WHERE guest_id = guest_guestId;
    ELSE
        SET result = '1';
    END IF;

    RETURN result;
END;

-- Output >>> [Token]: Success; 1: No User; 2: Wrong Password
CREATE FUNCTION verifyUserLogin(
    input_kldID VARCHAR(13),
    input_password VARCHAR(32)
) RETURNS VARCHAR(32)
READS SQL DATA
BEGIN
    DECLARE result VARCHAR(32);
    DECLARE user_password BINARY(32);
    DECLARE user_salt VARCHAR(32);

    SELECT hash_password, salt_password 
    INTO user_password, user_salt 
    FROM UserCredentials WHERE kld_id = input_kldID;

    IF SHA2(CONCAT(input_password, user_salt), 256) = HEX(user_password) THEN
        CALL CreateUserSessionToken(input_kldID);
        SELECT session_token INTO result 
        FROM LoginTokens WHERE kld_id = input_kldID;
    ELSEIF searchKLDID(input_kldID) = false THEN
        SET result = '1';
    ELSE
        SET result = '2';
    END IF;

    RETURN result;
END;

CREATE FUNCTION verifyToken(
    input_token VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_tokenExpiration DATETIME;

    SELECT token_expiration INTO user_tokenExpiration
    FROM LoginTokens WHERE session_token = input_token;

    IF user_tokenExpiration <= NOW() THEN
        CALL DestroySessionToken(input_token);
        RETURN false;
    ELSEIF searchToken(input_token) = false THEN
        RETURN false;
    ELSE
        RETURN true;
    END IF;
END;

CREATE FUNCTION searchKLDID(
    input_kldID VARCHAR(13)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_kldID VARCHAR(13);

    SELECT kld_id INTO user_kldID 
    FROM UserCredentials WHERE kld_id = input_kldID;

    IF user_kldID IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION searchUserId(
    input_id VARCHAR(11)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_userId VARCHAR(11);

    SELECT user_id INTO user_userId 
    FROM UserDetails WHERE user_id = input_id;

    IF user_userId IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;

CREATE FUNCTION searchToken(
    input_token VARCHAR(32)
) RETURNS BOOLEAN
READS SQL DATA
BEGIN
    DECLARE user_token VARCHAR(32);

    SELECT session_token INTO user_token
    FROM LoginTokens WHERE session_token = input_token;

    IF user_token IS NOT NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;



CREATE PROCEDURE ChangeCredentials(
    IN input_code VARCHAR(64),
    IN input_password VARCHAR(32)
)
BEGIN
    DECLARE user_kldID VARCHAR(13);
    DECLARE input_salt VARCHAR(32);
    DECLARE input_hashPassword BINARY(32);

    IF verifyChangePasswordCode(input_code) = true THEN
        SELECT kld_id INTO user_kldID
        FROM ChangePasswordRequest WHERE changePassword_code = input_code;
    
        REPEAT
            SET input_salt = MD5(CONCAT(RAND(), NOW()));
        UNTIL NOT EXISTS (SELECT salt_password FROM UserCredentials WHERE salt_password = input_salt)
        END REPEAT;

        SET input_hashPassword = UNHEX(SHA2(CONCAT(input_password, input_salt), 256));

        UPDATE UserCredentials
        SET hash_password = input_hashPassword, salt_password = input_salt
        WHERE kld_id = user_kldID;

        DELETE FROM ChangePasswordRequest
        WHERE changePassword_code = input_code;
    END IF;
END;

CREATE PROCEDURE CreateChangePasswordCode(
    IN input_kldID VARCHAR(13)
)
BEGIN
    DECLARE code VARCHAR(64);

    REPEAT
        SET code := MD5(CONCAT(RAND(), NOW()));
    UNTIL NOT EXISTS(SELECT changePassword_code FROM ChangePasswordRequest WHERE changePassword_code = code)
    END REPEAT;

    INSERT INTO ChangePasswordRequest(changePassword_code, changePassword_expiration, kld_id) VALUES(
        code, NOW() + INTERVAL 1 HOUR, input_kldID
    );
END;

CREATE PROCEDURE CreateGuestSessionToken(
    IN input_guest VARCHAR(11)
)
BEGIN
    DECLARE token VARCHAR(32);
    
    REPEAT
        SET token := MD5(CONCAT(RAND(), NOW()));
    UNTIL NOT EXISTS(SELECT session_token FROM LoginTokens WHERE session_token = token)
    END REPEAT;

    INSERT INTO LoginTokens(session_token, token_expiration, guest_id) VALUES(
        token, NOW() + INTERVAL 1 DAY, input_guest
    );
END;

CREATE PROCEDURE CreateUserSessionToken(
    IN input_kldID VARCHAR(13)
)
BEGIN
    DECLARE token VARCHAR(32);
    
    REPEAT
        SET token := MD5(CONCAT(RAND(), NOW()));
    UNTIL NOT EXISTS(SELECT session_token FROM LoginTokens WHERE session_token = token)
    END REPEAT;

    INSERT INTO LoginTokens(session_token, token_expiration, kld_id) VALUES(
        token, NOW() + INTERVAL 1 DAY, input_kldID
    );
END;

CREATE PROCEDURE DestroyChangePasswordCode(
    IN input_code VARCHAR(64)
)
BEGIN
    DELETE FROM ChangePasswordRequest
    WHERE changePassword_code = input_code;
END;

CREATE PROCEDURE DestroySessionToken(
    IN input_token VARCHAR(32)
)
BEGIN
    DELETE FROM LoginTokens
    WHERE session_token = input_token;
END;