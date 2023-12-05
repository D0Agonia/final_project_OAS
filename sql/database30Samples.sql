INSERT INTO AppointmentDocument(doc_abbreviation, doc_name) VALUES
    ('NONE', 'No Document Requested'),
    ('TOR', 'Transcript of Records'),
    ('TRC', 'Transfer Credentials'),
    ('COG', 'Certificate of Grades'),
    ('COE', 'Certificate of Enrollment')
;

INSERT INTO AppointmentType(type_id, type_name) VALUES
    ('INFOCEN', 'Information Center'),
    ('DOCREQ', 'Document Request')
;

INSERT INTO AuthenticationID(auth_abbreviation, auth_name) VALUES
    ('SCH', 'School ID'),
    ('GOV', 'Government-Issued ID'),
    ('PVT', 'Private ID'),
    ('KLD', 'KLD School ID')
;

INSERT INTO TypeDocRelationship(type_id, doc_abbreviation) VALUES
    ('INFOCEN', 'NONE'),
    ('DOCREQ', 'TOR'),
    ('DOCREQ', 'TRC'),
    ('DOCREQ', 'COG'),
    ('DOCREQ', 'COE')
;

SELECT insertCredentials('KLD-22-000101', 'password1') AS STATUS;
SELECT insertCredentials('KLD-22-000102', 'password2') AS STATUS;
SELECT insertCredentials('KLD-22-000103', 'password3') AS STATUS;
SELECT insertCredentials('KLD-22-000104', 'password4') AS STATUS;
SELECT insertCredentials('KLD-22-000105', 'password5') AS STATUS;
SELECT insertCredentials('KLD-22-000106', 'password6') AS STATUS;
SELECT insertCredentials('KLD-22-000107', 'password7') AS STATUS;
SELECT insertCredentials('KLD-22-000108', 'password8') AS STATUS;
SELECT insertCredentials('KLD-22-000109', 'password9') AS STATUS;
SELECT insertCredentials('KLD-22-000110', 'password10') AS STATUS;
SELECT insertCredentials('KLD-22-000111', 'password11') AS STATUS;
SELECT insertCredentials('KLD-22-000112', 'password12') AS STATUS;
SELECT insertCredentials('KLD-22-000113', 'password13') AS STATUS;
SELECT insertCredentials('KLD-22-000114', 'password14') AS STATUS;
SELECT insertCredentials('KLD-22-000115', 'password15') AS STATUS;
SELECT insertCredentials('KLD-22-000116', 'password16') AS STATUS;
SELECT insertCredentials('KLD-22-000117', 'password17') AS STATUS;
SELECT insertCredentials('KLD-22-000118', 'password18') AS STATUS;
SELECT insertCredentials('KLD-22-000119', 'password19') AS STATUS;
SELECT insertCredentials('KLD-22-000120', 'password20') AS STATUS;
SELECT insertCredentials('KLD-22-000121', 'password21') AS STATUS;
SELECT insertCredentials('KLD-22-000122', 'password22') AS STATUS;
SELECT insertCredentials('KLD-22-000123', 'password23') AS STATUS;
SELECT insertCredentials('KLD-22-000124', 'password24') AS STATUS;
SELECT insertCredentials('KLD-22-000125', 'password25') AS STATUS;
SELECT insertCredentials('KLD-22-000126', 'password26') AS STATUS;
SELECT insertCredentials('KLD-22-000127', 'password27') AS STATUS;
SELECT insertCredentials('KLD-22-000128', 'password28') AS STATUS;
SELECT insertCredentials('KLD-22-000129', 'password29') AS STATUS;
SELECT insertCredentials('KLD-22-000130', 'password30') AS STATUS;

INSERT INTO UserDetails(kld_id, firstname, middlename, surname, email, phone_number) VALUES
    ('KLD-22-000101', 'Maria', 'Santos', 'Reyes', 'reyes.maria.s.kld@gmail.com', '+639171234567'),
    ('KLD-22-000102', 'Juanito', '', 'dela Cruz', 'delacruz.juanito.kld@gmail.com', ''),
    ('KLD-22-000103', 'Ana', 'Marie', 'Mendoza', 'mendoza.ana.m.kld@gmail.com', ''),
    ('KLD-22-000104', 'Jose', 'Luiz', 'Gonzales', 'gonzales.jose.l.kld@gmail.com', '+639338765432'),
    ('KLD-22-000105', 'Rosario', '', 'Lim', 'lim.rosario.kld@gmail.com', ''),
    ('KLD-22-000106', 'Ferdinand', '', 'Garcia', 'garcia.ferdinand.kld@gmail.com', '+639259876543'),
    ('KLD-22-000107', 'Carmela', '', 'dela Rosa', 'delarosa.carmela.kld@gmail.com', '+639328765432'),
    ('KLD-22-000108', 'Eduardo', '', 'Cruz', 'cruz.eduardo.kld@gmail.com', ''),
    ('KLD-22-000109', 'Lourdes', '', 'Aquino', 'aquino.lourdes.kld@gmail.com', ''),
    ('KLD-22-000110', 'Manuelito', '', 'Santos', 'santos.manuelito.kld@gmail.com', '+639182345678'),
    ('KLD-22-000111', 'Antonia', '', 'Ramos', 'ramos.antonia.kld@gmail.com', ''),
    ('KLD-22-000112', 'Alberto', '', 'Villanueva', 'villanueva.alberto.kld@gmail.com', '+639398765432'),
    ('KLD-22-000113', 'Felicia', '', 'Yap', 'yap.felicia.kld@gmail.com', '+639277654321'),
    ('KLD-22-000114', 'Renato', '', 'Reyes', 'reyes.renato.kld@gmail.com', ''),
    ('KLD-22-000115', 'Elisa', '', 'Tan', 'tan.elisa.kld@gmail.com', ''),
    ('KLD-22-000116', 'Ricardo', '', 'Gomez', 'gomez.ricardo.kld@gmail.com', ''),
    ('KLD-22-000117', 'Josefina', '', 'Fernandez', 'fernandez.josefina.kld@gmail.com', '+639212345678'),
    ('KLD-22-000118', 'Carlos', '', 'Rivera', 'rivera.carlos.kld@gmail.com', ''),
    ('KLD-22-000119', 'Lorna', '', 'Cruz', 'cruz.lorna.kld@gmail.com', ''),
    ('KLD-22-000120', 'Reynaldo', '', 'Santos', 'santos.reynaldo.kld@gmail.com', '+639358765432'),
    ('KLD-22-000121', 'Marivic', '', 'Flores', 'flores.marivic.kld@gmail.com', ''),
    ('KLD-22-000122', 'Ernesto', '', 'Lim', 'lim.ernesto.kld@gmail.com', '+639347654321'),
    ('KLD-22-000123', 'Consuelo', '', 'Alvaro', 'alvaro.consuelo.kld@gmail.com', ''),
    ('KLD-22-000124', 'Armando', '', 'Deguzman', 'deguzman.armando.kld@gmail.com', ''),
    ('KLD-22-000125', 'Milagros', '', 'Cruz', 'cruz.milagros.kld@gmail.com', '+639201234567'),
    ('KLD-22-000126', 'Rafael', '', 'Alonzo', 'alonzo.rafael.kld@gmail.com', '+639266543210'),
    ('KLD-22-000127', 'Imelda', '', 'Santos', 'santos.imelda.kld@gmail.com', ''),
    ('KLD-22-000128', 'Romulo', '', 'Mendoza', 'mendoza.romulo.kld@gmail.com', ''),
    ('KLD-22-000129', 'Evangeline', '', 'Velasco', 'velasco.evangeline.kld@gmail.com', ''),
    ('KLD-22-000130', 'Rodrigo', '', 'Sison', 'sison.rodrigo.kld@gmail.com', '+639193456789')
;

INSERT INTO AppointmentList(control_number, user_id, auth_abbreviation, appointment_datetime, appointment_location, typeDoc_relationship_id, comment) VALUES
    (4829107532468, 1, 'KLD', '2023-11-18 08:00:00', 'KLD Building No. 1', 1, 'Ask about foundation t-shirt refund'),
    (7263918405723, 2, 'KLD', '2023-11-23 14:00:00', 'KLD Building No. 1', 3, 'Transferee'),
    (6394821753094, 3, 'KLD', '2023-11-18 08:00:00', 'KLD Building No. 1', 1, 'Join clubs'),
    (1548926372058, 4, 'KLD', '2023-11-18 08:00:00', 'KLD Building No. 1', 1, 'Canteen fees'),
    (3094857261934, 5, 'KLD', '2023-11-23 14:00:00', 'KLD Building No. 1', 3, 'Transferee'),
    (8625019348572, 6, 'KLD', '2023-11-23 14:00:00', 'KLD Building No. 1', 1, 'Inquire about library'),
    (7482093651823, 7, 'KLD', '2023-11-23 10:00:00', 'KLD Building No. 1', 3, 'To STI'),
    (9203847651093, 8, 'KLD', '2023-11-23 1:00:00', 'KLD Building No. 1', 1, 'Join IS week event'),
    (5738102948562, 9, 'KLD', '2023-11-23 10:00:00', 'KLD Building No. 1', 2, 'Get grades'),
    (3857492016324, 10, 'KLD', '2023-11-23 10:00:00', 'KLD Building No. 1', 3, 'Needed by CvSU'),
    (4902876315248, 11, 'KLD', '2023-11-18 08:00:00', 'KLD Building No. 1', 1, 'Varsity'),
    (8765023419852, 12, 'KLD', '2023-11-23 10:00:00', 'KLD Building No. 1', 2, 'Get grades'),
    (2150984736254, 13, 'KLD', '2023-11-23 15:00:00', 'KLD Building No. 1', 2, 'Get grades'),
    (7643125098321, 14, 'KLD', '2023-11-23 11:00:00', 'KLD Building No. 1', 4, 'Alumni'),
    (9326481750674, 15, 'KLD', '2023-11-23 14:00:00', 'KLD Building No. 1', 2, 'For grades'),
    (6587412039245, 16, 'KLD', '2023-11-23 15:00:00', 'KLD Building No. 1', 3, 'Transfering ASAP'),
    (3492856701826, 17, 'KLD', '2023-11-23 09:00:00', 'KLD Building No. 1', 4, 'Alumni'),
    (5726318940567, 18, 'KLD', '2023-11-23 11:00:00', 'KLD Building No. 1', 5, 'Needed by security guard'),
    (1098273456823, 19, 'KLD', '2023-11-23 11:00:00', 'KLD Building No. 1', 4, 'Graduated'),
    (4562098132745, 20, 'KLD', '2023-11-23 09:00:00', 'KLD Building No. 1', 2, 'To see grades'),
    (8274361095482, 21, 'KLD', '2023-11-23 11:00:00', 'KLD Building No. 1', 4, 'Graduate'),
    (5032987162475, 22, 'KLD', '2023-11-23 09:00:00', 'KLD Building No. 1', 3, 'Transfering ASAP'),
    (7641285039726, 23, 'KLD', '2023-11-23 09:00:00', 'KLD Building No. 1', 2, 'Get grades'),
    (9358726104328, 24, 'KLD', '2023-11-23 13:00:00', 'KLD Building No. 1', 4, 'Alumni'),
    (2184563970813, 25, 'KLD', '2023-11-23 09:00:00', 'KLD Building No. 1', 3, 'Transfering ASAP'),
    (6793412058236, 26, 'KLD', '2023-11-23 13:00:00', 'KLD Building No. 1', 5, 'To see courses'),
    (3948671520618, 27, 'KLD', '2023-11-23 13:00:00', 'KLD Building No. 1', 4, 'To get degree'),
    (5621934807894, 28, 'KLD', '2023-11-23 15:00:00', 'KLD Building No. 1', 2, 'Get grades'),
    (1093847526083, 29, 'KLD', '2023-11-23 13:00:00', 'KLD Building No. 1', 5, 'Need schedule'),
    (8456723901627, 30, 'KLD', '2023-11-23 13:00:00', 'KLD Building No. 1', 5, 'Need schedule')
;