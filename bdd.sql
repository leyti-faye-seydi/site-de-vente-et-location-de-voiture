CREATE DATABASE CarsDB;

USE CarsDB;

CREATE TABLE Voitures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(50),
    modele VARCHAR(50),
    disponible VARCHAR(15),
    image_url VARCHAR(255),
    prix VARCHAR(10),
    details VARCHAR(255)
);

INSERT INTO Voitures (marque, modele, disponible, image_url, prix, details) VALUES
('BMW', 'Serie 3', 'vente', '/images/BMWSeries3.png', '50000', 'Cylindrée : 2.0L, Année : 2022'),
('BMW', 'X5', 'location', '/images/bmwx5.png', '700', 'Cylindrée : 3.0L, Année : 2023'),
('BMW', 'X3', 'vente', '/images/bmwx3.png', '70000', 'Cylindrée : 2.5L, Année : 2021'),
('BMW', 'i8', 'location', '/images/i8.png', '1200', 'Cylindrée : 1.5L, Année : 2022'),
('Mercedes', 'Classe A', 'vente', '/images/CLA.png', '45000', 'Cylindrée : 2.0L, Année : 2022'),
('Mercedes', 'Classe C', 'location', '/images/CLC.png', '600', 'Cylindrée : 2.5L, Année : 2023'),
('Mercedes', 'Classe E', 'vente', '/images/CLE.png', '70000', 'Cylindrée : 3.0L, Année : 2021'),
('Mercedes', 'Classe G', 'location', '/images/CLG.png', '900', 'Cylindrée : 4.0L, Année : 2022'),
('Toyota', 'Corolla', 'vente', '/images/corolla.png', '35000', 'Cylindrée : 1.8L, Année : 2023'),
('Toyota', 'RAV4', 'location', '/images/rav4.png', '400', 'Cylindrée : 2.0L, Année : 2022'),
('Toyota', 'Camry', 'vente', '/images/camry.png', '45000', 'Cylindrée : 2.5L, Année : 2021'),
('Toyota', 'Land Cruiser', 'location', '/images/lc.png', '800', 'Cylindrée : 4.5L, Année : 2023'),
('Audi', 'A3', 'vente', '/images/a3.png', '40000', 'Cylindrée : 2.0L, Année : 2022'),
('Audi', 'Q5', 'location', '/images/q5.png', '600', 'Cylindrée : 2.5L, Année : 2023'),
('Audi', 'A6', 'vente', '/images/A6.png', '70000', 'Cylindrée : 3.0L, Année : 2021'),
('Audi', 'Q7', 'location', '/images/q7.png', '900', 'Cylindrée : 4.0L, Année : 2022'),
('Rolls Royce', 'Phantom', 'vente', '/images/p1.png', '30000', 'Cylindrée : 6.0L, Année : 2023'),
('Rolls Royce', 'Ghost', 'location', '/images/ghost.png', '4000', 'Cylindrée : 6.5L, Année : 2022'),
('Rolls Royce', 'Wraith', 'vente', '/images/Ww.png', '35000', 'Cylindrée : 5.0L, Année : 2021'),
('Rolls Royce', 'Dawn', 'location', '/images/dawn.png', '4500', 'Cylindrée : 6.2L, Année : 2022');




