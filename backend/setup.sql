CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    EAN VARCHAR(13),
    format INT(5),
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status INT(2) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO products (
    id,
    name,
    description,
    EAN,
    format,
    price,
    quantity
)
VALUES
    (1,'MOUTARDE DE DIJON-BOCAL 10CL EDMOND FALLOT', 'moutarde classique de la maison Edmond fallot', 3230140002429, 10, 1.48, 13),
    (2,'MOUTARDE DE DIJON-BOCAL 21CL EDMOND FALLOT', 'moutarde classique de la maison Edmond fallot', 3230140002412, 21, 1.77, 45),
    (3,'MOUTARDE DE DIJON-BOCAL 37CL EDMOND FALLOT', 'moutarde classique de la maison Edmond fallot', 3230140002214, 37, 2.02, 12),
    (4,'MOUTARDE DE DIJON-BOCAL 85CL EDMOND FALLOT', 'moutarde classique de la maison Edmond fallot', 3230140002221, 85, 3.59, 9),
    (5,'MOUTARDE EN GRAINS-BOCAL 10CL EDMOND FALLOT', 'moutarde en grains Edmond fallot', 3230140002528, 10, 1.56, 76),
    (6,'MOUTARDE EN GRAINS-BOCAL 21CL EDMOND FALLOT', 'moutarde en grains Edmond fallot', 3230140002511, 21, 2.00, 23),
    (7,'MOUTARDE EN GRAINS-BOCAL 37CL EDMOND FALLOT', 'moutarde en grains Edmond fallot', 3230140002573, 37, 2.27, 14),
    (8,'MOUTARDE EN GRAINS-BOCAL 85CL EDMOND FALLOT', 'moutarde en grains Edmond fallot', 3230140002467, 105, 3.76, 45),
    (9,'MOUTARDE MIEL+BALSAMIQUE-BOCAL 10CL E.FALLOT', 'moutarde gout miel et vinaigre balsamique Edmond Fallot', 3230140003723, 10, 1.76, 400),
    (10,'MOUTARDE AU BASILIC-BOCAL 21CL EDMOND FALLOT', 'moutarde gout miel et vinaigre balsamique Edmond Fallot', 3230140004409, 21, 1.97, 200),
    (11,'MOUTARDE AU POIVRE VERT-BOCAL 10CL FALLOT', 'moutarde gout poivre vert Edmond Fallot', 3230140002627, 10, 1.55, 45),
    (12,'MOUTARDE AU POIVRE VERT-BOCAL 21CL FALLOT', 'moutarde gout poivre vert Edmond Fallot', 3230140002610, 21, 1.97, 12),
    (13,'MOUTARDE VERTE ESTRAGON-BOCAL 10CL FALLOT', 'moutarde verte gout estragon Edmond Fallot', 3230140002726, 10, 1.55, 35),
    (14,'MOUTARDE VERTE ESTRAGON-BOCAL 21CL FALLOT', 'moutarde verte gout estragon Edmond Fallot', 3230140002719, 21, 1.97, 67),
    (15,'MOUTARDE AUX NOIX - BOCAL 10CL EDMOND FALLOT', 'moutarde aux noix Edmond Fallot', 3230140006229, 10, 1.55, 456),
    (16,'MOUTARDE AUX NOIX - BOCAL 21CL EDMOND FALLOT', 'moutarde aux noix Edmond Fallot', 3230140006229, 21, 1.97, 345),
    (17,'MOUTARDE DE DIJON AU VIN BLANC-BOCAL 10CL FALLOT', 'moutarde classique au vin blanc Edmond Fallot', 3230140002825, 10, 1.56, 323),
    (18,'MOUTARDE DE DIJON AU VIN BLANC-BOCAL 21CL FALLOT', 'moutarde classique au vin blanc Edmond Fallot', 3230140002818, 21, 2.00, 123),
    (19,'MOUTARDE BRUNE DOUCE AROMATISEE-BOCAL 21CL FALLOT', 'moutarde douce aux aromates Edmond Fallot', 3230140002917, 21, 1.97, 78),
    (20,'MOUTARDE AU CURRY DE MADRAS - BOCAL 10cl EDMOND FALLOT', 'moutarde au curry Edmond Fallot', 3230140010622, 10, 2.27, 145),
    (21,'MOUTARDE AU PINOT NOIR - BOCAL 10cl EDMOND FALLOT', 'moutarde au pinot noir Edmond Fallot', 3230140010424, 10, 2.16, 34),
    (22,'MOUTARDE AU PINOT NOIR - BOCAL 21cl EDMOND FALLOT', 'moutarde au pinot noir Edmond Fallot', 3230140010417, 21, 3.42, 89),
    (23,'MOUTARDE AU YUZU - BOCAL 10cl EDMOND FALLOT', 'moutarde au yuzu Edmond Fallot', 3230140010325, 10, 2.30, 475),
    (24,'MOUTARDE MIEL & FIGUE -BOCAL 10CL EDMOND FALLOT', 'moutarde miel et figue Edmond Fallot', 3230140010929, 10, 2.14, 412);


INSERT INTO users (username, password, first_name, last_name, email) VALUES
    ('user1', 'hashed_password1', 'user1', 'test1', 'user1.test@gmail.com' ),
    ('user2', 'hashed_password2', 'user2', 'test2', 'user2.test@gmail.com'),
    ('user3', 'hashed_password3', 'user3', 'test3', 'user3.test@gmail.com');

INSERT INTO orders (user_id, status) VALUES
    (1, 1),
    (2, 1),
    (3, 1);

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
    (1, 1, 2, 1.48),
    (1, 9, 1, 1.76);

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
    (2, 5, 3, 1.56),
    (2, 14, 2, 1.97);

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
    (3, 17, 1, 1.56),
    (3, 20, 4, 2.27);


