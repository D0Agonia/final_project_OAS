CREATE EVENT refreshTokens
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    UPDATE UserCredentials
    SET session_token = NULL, token_expiration = NULL
    WHERE token_expiration <= NOW();
END;