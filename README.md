# What is MyWiki? :cd:

**MyWiki** is a local Wikipedia, in which you can add your own articles.

You can use it as a place, where you store information thats useful to you.

# How does MyWiki work? :wrench:

Administrators can **view**, **edit**, **create** and **delete** articles.

You can also search for articles. 
It's a basic search functionality, so it will be improved in the future. 

Articles are saved with a creation time stamp.
If an article is edited and the changes are saved, then the article will also have a ***Updated at*** time stamp.

**!!** *Images havent been implemented yet* **!!**
**!!** *Pagination will be implemented soon* **!!**

## MyWiki's database tables:

**Administrator table**

    | id | username | password | role | 

**Article table**

    | id | title | content | created_at | updated_at |

**Roles table**

    | id | role |

# How do I start using MyWiki? :arrow_down:

1.  Open your IDE/text editor.

2.  Clone this repository by typing this in the terminal:
    `git clone https://github.com/sandriskozubs/MyWiki.git`
<br>
3. Then create a database and the necessary tables.
4. Change the constant values in `connection.php` file.

    
        const HOST = "localhost"; // Your host name 
        const USERNAME = "root"; // Your database username
        const PASSWORD = ""; // Your database password
        const DB_NAME= "my_wiki1"; // The database name
<br>
5. And thats it!