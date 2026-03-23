# Kas ir MyWiki? :cd:

**MyWiki** ir lokāla Vikipēdija, kurā varat veidot rakstus.

Varat to izmantot kā vietu, kur glabāt jums noderīgu informāciju.

# Kā darbojas MyWiki? :wrench:

Administratori var **skatīt**, **rediģēt**, **izveidot** un **dzēst** rakstus.

Ir iespējams arī meklēt rakstus.

Raksti tiek saglabāti ar izveides laika zīmogu.
Ja raksts tiek rediģēts un izmaiņas tiek saglabātas, tad rakstam būs arī laika zīmogs ***Atjaunināts plkst.***.

## MyWiki datubāzes tabulas:

**Administratora tabula**

| id | lietotājvārds | parole | loma

**Rakstu tabula**

| id | nosaukums | saturs | izveidots_laikā | atjaunināts_laikā | autora_id

**Rakstu_attēlu_table**

| id | raksta_id | faila_ceļš

**Lomu tabula**

| id | role |

# Kā sākt lietot MyWiki? :arrow_down:

1. Atveriet savu IDE/teksta redaktoru.

2. Klonējiet šo repozitoriju, terminālī ierakstot šo:
`git clone https://github.com/sandriskozubs/MyWiki.git`
<br>
3. Pēc tam izveidojiet datubāzi un nepieciešamās tabulas.

### Lomas

`CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) NOT NULL
);`

### Lietotāji

`CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL,
    FOREIGN KEY (role) REFERENCES roles(id)
);`

### Raksti

`CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
);`

### Rakstu attēli

`CREATE TABLE article_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);`

4. Mainiet konstantes vērtības `connection.php` failā.

const HOST = "localhost"; // Jūsu resursdatora nosaukums
const USERNAME = "root"; // Jūsu datubāzes lietotājvārds
const PASSWORD = ""; // Jūsu datubāzes parole
const DB_NAME= "my_wiki1"; // Datubāzes nosaukums
<br>
5. Un tas arī viss!
