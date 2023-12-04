# :desktop_computer: Book Store Application

<img src="./assets/cover.png" alt="Cover projeto" />

## :briefcase: Stacks

- HTML/CSS/JavaScript
- PHP

## :hammer: Tools

- Git
- PHP
- VS Code

## :fire: Run

- Development (Port 5000): `php -S localhost:5000 -t public`

<details>
<summary>:ledger: Banco de dados</summary>

```
  docker exec -it <sevice-name> bash
  mysql -u<user-name> -p<password>
  show databases;
  use <database-name>;
  show tables;
  describe <table-name>;
  docker inspect <service-name> | grep IPAddress
```

```
  CREATE TABLE IF NOT EXISTS users (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `user_type` VARCHAR(20) NOT NULL
  );

  CREATE TABLE IF NOT EXISTS cart (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `price` FLOAT NOT NULL,
    `quantity` INT(11) NOT NULL,
    `image` VARCHAR(100) NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT fk_user_cart FOREIGN KEY (user_id) REFERENCES users(id)
  );

  CREATE TABLE IF NOT EXISTS products (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` FLOAT NOT NULL,
    `image` VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)
  );

  CREATE TABLE IF NOT EXISTS orders (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `number` VARCHAR(12) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `method` VARCHAR(50) NOT NULL,
    `address` VARCHAR(500) NOT NULL,
    `total_products` VARCHAR(1000) NOT NULL,
    `total_price` FLOAT NOT NULL,
    `placed_on` VARCHAR(50) NOT NULL,
    `payment_status` VARCHAR(20) NOT NULL default 'pending',

    PRIMARY KEY (id),
    CONSTRAINT fk_user_order FOREIGN KEY (user_id) REFERENCES users(id)
  );

  CREATE TABLE IF NOT EXISTS message (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `number` VARCHAR(100) NOT NULL,
    `message` VARCHAR(500) NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT fk_user_message FOREIGN KEY (user_id) REFERENCES users(id)
  );

```

</details>
