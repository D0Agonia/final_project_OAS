USE OnlineAppointment;

CREATE USER guest;

GRANT EXECUTE ON FUNCTION OnlineAppointment.insertDetails TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.insertGuest TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyUserLogin TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyToken TO guest;