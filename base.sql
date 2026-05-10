CREATE DATABASE IF NOT EXISTS comejaimeitu;

USE comejaimeitu;

INSERT INTO objectifs (nom) VALUES
('Augmenter son poids'),
('Reduire son poids'),
('Atteindre son IMC ideal');

INSERT INTO regimes (description, viande, poisson, volaille, variation, duree, type) VALUES
('Boost calorique proteine', 45, 20, 35, 0.60, 1, 'augmentation'),
('Masse propre quotidienne', 35, 25, 40, 0.40, 1, 'augmentation'),
('Deficit leger fibre', 25, 45, 30, 0.35, 1, 'diminution'),
('Reset glucidique controle', 20, 50, 30, 0.55, 1, 'diminution'),
('Equilibre metabolique', 30, 35, 35, 0.25, 1, 'diminution');

INSERT INTO config_regime (id_regime, duree_jours, prix) VALUES
(1, 1, 4200.00),
(1, 7, 28000.00),
(1, 10, 39000.00),
(1, 15, 56500.00),
(1, 30, 108000.00),
(2, 1, 3900.00),
(2, 7, 26000.00),
(2, 10, 36000.00),
(2, 15, 52000.00),
(2, 30, 99500.00),
(3, 1, 3600.00),
(3, 7, 23500.00),
(3, 10, 33000.00),
(3, 15, 47000.00),
(3, 30, 89000.00),
(4, 1, 4300.00),
(4, 7, 29500.00),
(4, 10, 41000.00),
(4, 15, 59000.00),
(4, 30, 112000.00),
(5, 1, 3200.00),
(5, 7, 21000.00),
(5, 10, 29500.00),
(5, 15, 42000.00),
(5, 30, 80500.00);

INSERT INTO activites_sportives (description, diminution_poids, frequence, duree) VALUES
('Marche rapide quotidienne', 0.20, 7, 7),
('Cardio fractionne court', 0.35, 4, 7),
('Circuit training maison', 0.45, 5, 7),
('Corde a sauter express', 0.12, 1, 1),
('Natation tonique', 0.30, 3, 7);
