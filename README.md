# Kas ir MyWiki? :cd:

**MyWiki** ir lokāla Vikipēdija, kurā varat vaidot rakstus.

Varat to izmantot kā vietu, kur glabāt jums noderīgu informāciju.

# Kā darbojas MyWiki? :wrench:

Lietotāji var **skatīt**, **rediģēt**, **izveidot** un **dzēst** rakstus.

Ir iespējams arī meklēt rakstus.

Raksti tiek saglabāti ar izveides laika zīmogu.
Ja raksts tiek rediģēts un izmaiņas tiek saglabātas, tad rakstam būs arī laika zīmogs ***Atjaunināts plkst.***.

## MyWiki datubāzes tabulas:

**Lietotāju tabula**<br>
| id | lietotājvārds | parole | loma

**Rakstu tabula**<br>
| id | nosaukums | saturs | izveidots_laikā | atjaunināts_laikā | autora_id

**Rakstu attēlu table**<br>
| id | raksta_id | faila_ceļš

**Lomu tabula**<br>
| id | role

# Kā sākt lietot MyWiki? :arrow_down:

1. Atveriet savu IDE/teksta redaktoru.<br>
2. Klonējiet šo repozitoriju, terminālī ierakstot šo:
`git clone https://github.com/sandriskozubs/MyWiki.git`<br>
3. Pēc tam izveidojiet datubāzi un nepieciešamās tabulas.

### Lomas

`CREATE TABLE roles (`
    `   id INT AUTO_INCREMENT PRIMARY KEY,`
    `   role VARCHAR(50) NOT NULL`
`);`
<br>

### Lietotāji

`CREATE TABLE users (`
    `   id INT AUTO_INCREMENT PRIMARY KEY,`
    `   username VARCHAR(100) NOT NULL UNIQUE,`
    `   password VARCHAR(255) NOT NULL,`
    `   role INT NOT NULL,`
    `   FOREIGN KEY (role) REFERENCES roles(id)`
`);`
<br>

### Raksti

`CREATE TABLE articles (`
    `   id INT AUTO_INCREMENT PRIMARY KEY,`
    `   title VARCHAR(255) NOT NULL,`
    `   content TEXT NOT NULL,`
    `   created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,`
    `   updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP`
`);`
<br>

### Rakstu attēli

`CREATE TABLE article_images (`
    `   id INT AUTO_INCREMENT PRIMARY KEY,`
    `   article_id INT NOT NULL,`
    `   file_path VARCHAR(255) NOT NULL,`
    `   FOREIGN KEY (article_id) REFERENCES articles(id)`
`);`<br>
4. Mainiet konstanšu vērtības `connection.php` failā.

const HOST = ""; // Jūsu servera nosaukums
const USERNAME = ""; // Jūsu datu bāzes lietotājvārds
const PASSWORD = ""; // Jūsu datu bāzes parole
const DB_NAME= "my_wiki1"; // Datu bāzes nosaukums<br>
5. Un tas arī viss!