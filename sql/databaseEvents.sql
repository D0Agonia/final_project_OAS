CREATE EVENT refreshTokens
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM LoginTokens
    WHERE token_expiration <= NOW();
END;

CREATE EVENT deleteExpiredGuestCredentials
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DELETE FROM GuestCredentials 
    WHERE otp_expiration <= NOW();
END;

CREATE EVENT deleteExpiredChangePasswordRequest
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DELETE FROM ChangePasswordRequest 
    WHERE changePassword_expiration <= NOW();
END;