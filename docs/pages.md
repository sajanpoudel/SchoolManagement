# Pages

| Page | Purpose |
| --- | --- |
| `index.php` | Landing page |
| `pages/login.php` | Admin sign in |
| `pages/logout.php` | Ends the session |
| `pages/dashboard.php` | Overview charts |
| `pages/add-course.php`, `view-course.php`, `edit-course.php` | Manage courses |
| `pages/add-subject.php`, `view-subject.php`, `edit-sub.php` | Manage the subjects of a course |
| `pages/register.php`, `view.php`, `edit-std.php` | Register, list and edit students |
| `pages/session.php` | Choose the academic session |
| `pages/course_availability.php`, `subject.php` | Ajax helpers for the forms |
| `pages/dbcontroller.php` | PDO connection used by the ajax helpers |

Every page except `login.php` and the ajax helpers checks `$_SESSION['login']` and redirects to `index.php` when it is missing.

## Helper code

- `src/Grades.php`: `percentage()`, `gradeFor()`, `hasPassed()` and `summarize()` for marksheets.
- `src/Validation.php`: checks for the registration form.
- `tests/`: run everything with `php tests/run.php`.
