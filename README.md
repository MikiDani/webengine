### WebEngine by MikiDani - 1.0

In this login engine, I use the basic "Auth" part for identification, and the "laravel passport" add-on is also installed in the api part.

Dont forget to passport : php artisan passport:client --personal

#### USE:

php artisan erve (SERVER), npm run watch(REACT JSX converter)

#### API:
| NAME         | METHOD | AUTH |      URL              | JSON INPUTS                                |
| :-----------:|:------:|:----:|:---------------------:|:------------------------------------------:|
| USER         | GET    |      | /api/user             | -                                          |
| LOGIN        | POST   |  *   | /api/login            | usernameoremail, password                  |
| LOGOUT       | POST   |  *   | /api/logout           | -                                          |
| REGISTER     | POST   |      | /api/register         | name, email, rank, password                |
| UNSUBSCRIBE  | POST   |  *   | /api/unsubscribe      | email, identifier                          |
| FORGOTEMAIL  | POST   |      | /api/forgotemail      | email                                      |
| CONFORMATION | GET    |      | /api/confirmation?    | ?id, ?identifier                           |
| MODIFY       | PATCH  |  *   | /api/modify           | password, new_password, name, email, rank  |

#### WEB:
| NAME         | METHOD | AUTH |      URL              | JSON INPUTS                                |
| :-----------:|:------:|:----:|:---------------------:|:------------------------------------------:|
| LOGIN        | POST   |  *   | /admin/login          | usernameoremail, password                  |
| LOGOUT       | POST   |  *   | /admin/logout         | -                                          |
| REGISTER     | POST   |      | /admin/registration   | name, email, rank, password                |
| UNSUBSCRIBE  | POST   |  *   | /admin/unsubscribe    | email, identifier                          |
| FORGOTEMAIL  | POST   |      | /admin/forgotemail    | email                                      |
| CONFORMATION | GET    |      | /admin/confirmation?  | ?id, ?identifier                           |
| MODIFY       | PATCH  |  *   | /admin/modify         | password, new_password, name, email, rank  |
| NEWPASS      | POST   |      | /admin/newpass        | password, new_password                     |
