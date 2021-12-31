SCHOOL MANAGEMENT WEB APPLICATION IN PHP

This is a complete school management web application

**CONTAINS**

ADMIN PANEL

Seperate Sections For Students and Teachers

**FUNCTIONS**


ADD, REMOVE, MODIFY  Teachers, SUbjects, Courses, Students

Generate Marksheets and send automatically to parents

View results with symbol no


**SETUP**

1. Install a PHP and MySQL stack such as XAMPP and copy this folder into its web root.
2. Create a database named `schoolmanagement` and import `schoolmanagement.sql`.
3. If your database does not use the XAMPP defaults (`localhost`, user `root`, empty password), set `DB_HOST`, `DB_USER`, `DB_PASSWORD` and `DB_NAME` in the web server environment.
4. Open `index.php` in the browser and sign in from `pages/login.php`. The sample data has the admin login `admin` with the password `admin`. Change it after the first sign in.

**TESTS**

```
php tests/password_matches_test.php
```

**NOTES**

- Passwords in `tbl_login` can be plain text or bcrypt hashes. Store a hash created with `password_hash()` to stop keeping plain text.
- The admin session starts only after the login id and password have been checked.

**DOCS**

- [Pages](docs/pages.md)
- [Database](docs/database.md)
