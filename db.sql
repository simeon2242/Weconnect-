-- Active: 1726762063690@@127.0.0.1@3306@weconnect
CREATE DATABASE weconnect;

DROP DATABASE weconnect;

USE weconnect;

CREATE Table user(
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(200),
    prenom VARCHAR(200),
    email VARCHAR(200) UNIQUE,
    numero INT UNIQUE,
    dates DATE,
    genre VARCHAR(200),
    pays VARCHAR(200),
    password VARCHAR(200),
    bio TEXT,
    photo VARCHAR(200) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

DROP Table user;

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('simeon','balume','simeo@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','000087989','','homme','congo','2242','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('alice','Shukuru','alice@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','7989','','femme','congo','12345','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('Bob','Johnson','Johnson@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','4587989','','homme','congo','1234','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('Alex','Jacqkson','alex@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','037989','','homme','congo','123456','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('Peterson','Balume','peter@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','09909145732','','homme','congo','50498','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('Marie','Antoinette','anto@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','0999145737','','homme','congo','123456','profile_photo/images.png')

INSERT INTO user(nom,prenom,email,bio,numero,dates,genre,pays,password,photo) VALUES('Alison','Margueritte','Alison@gmail.com','Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur magnam iure quas ab veniam possimus iste','097478392','','femme','congo','123456','profile_photo/images.png')


CREATE Table actualite(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    pub_pic VARCHAR(200),
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
)

drop Table actualite;

CREATE Table profile(
    profile_id INT PRIMARY KEY AUTO_INCREMENT,
    profile_photo VARCHAR(200),
    bio TEXT
)

CREATE TABLE friend(
    user_id BIGINT NOT NULL,
    friend_id BIGINT NOT NULL,
    status ENUM('friends','not_friends')DEFAULT 'not_friends',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id,friend_id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (friend_id) REFERENCES user(id)
)

DROP Table friend;

INSERT INTO friend(user_id,friend_id,status) VALUES
(1,2,'friends'), -- Alice et Bob sont des amis
(1,3,'not_friends'), -- Alice et Charlie ne sont plus amis
(1,4,'friends'), -- Bob et Dianna sont amis
(1,5, 'friends'),
(1,6, 'not_friends'),
(1,7, 'friends')


--Indexation
--Creation des index sur les sur les colonnes user_id et friend_id dans la table friend


--CREATE INDEX id_user_id ON friend(user_id);



--CREATE INDEX id_friend_id ON friend(friend_id);





CREATE TABLE messages(
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(sender_id) REFERENCES user(id),
    FOREIGN KEY(receiver_id) REFERENCES user(id)
)



DROP Table messages;