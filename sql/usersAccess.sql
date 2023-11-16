USE OnlineAppointment;

CREATE USER guest;

GRANT EXECUTE ON FUNCTION OnlineAppointment.insertDetails TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.insertGuest TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.requestPasswordChange TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyChangePasswordCode TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyGuestLogin TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyUserLogin TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyToken TO guest;
GRANT EXECUTE ON PROCEDURE OnlineAppointment.ChangeCredentials TO guest;