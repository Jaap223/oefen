CREATE TABLE users (
u_id int auto_increment,
naam varchar(255),
adres varchar(255),
wachtwoord varchar(255),
tel_nr int(10),
PRIMARY KEY (u_id)
);


CREATE TABLE Updaten (
    update_id INT PRIMARY KEY AUTO_INCREMENT,
    u_id INT,
    status VARCHAR(255),
    datum DATE,
    tijd TIME,
    factuur_id INT,
    FOREIGN KEY (u_id) REFERENCES users(u_id),
    FOREIGN KEY (u_id) REFERENCES users(u_id)
);