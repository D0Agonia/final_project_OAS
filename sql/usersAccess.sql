USE OnlineAppointment;

CREATE USER guest;

GRANT EXECUTE ON FUNCTION OnlineAppointment.insertCredentials TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.insertDetails TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyLogin TO guest;
GRANT EXECUTE ON FUNCTION OnlineAppointment.verifyToken TO guest;