### WebEngine by MikiDani - 1.0

In this login engine, I use the basic "Auth" part for identification, and the "laravel passport" add-on is also installed in the api part.

#### API:
| NAME         | METHOD | AUTH |               URL                        | JSON INPUTS |
| :-----------:|:------:|:----:|:----------------------------------------:|:-----------:|
| USER         | GET    |      | http://localhost:8000/api/user           | - |
| LOGIN        | POST   |  *   | http://localhost:8000/api/login          | usernameoremail, password |
| LOGOUT       | POST   |  *   | http://localhost:8000/api/logout         | - |
| REGISTER     | POST   |      | http://localhost:8000/api/login          | name, email, rank, password |
| UNSUBSCRIBE  | POST   |  *   | http://localhost:8000/api/unsubscribe    | email, identifier |
| FORGOTEMAIL  | POST   |      | http://localhost:8000/api/forgotemail    | email |
| CONFORMATION | GET    |      | http://localhost:8000/api/confirmation?  | ?id, ?identifier |
| MODIFY       | PATCH  |  *   | http://localhost:8000/api/modify         | password, new_password, name, email, rank |

#### WEB:
| NAME         | METHOD | AUTH |               URL                        | JSON INPUTS |
| :-----------:|:------:|:----:|:----------------------------------------:|:-----------:|
| LOGIN        | POST   |  *   | http://localhost:8000/admin/login          | usernameoremail, password |
| LOGOUT       | POST   |  *   | http://localhost:8000/admin/logout         | - |
| REGISTER     | POST   |      | http://localhost:8000/admin/registration   | name, email, rank, password |
| UNSUBSCRIBE  | POST   |  *   | http://localhost:8000/admin/unsubscribe    | email, identifier |
| FORGOTEMAIL  | POST   |      | http://localhost:8000/admin/forgotemail    | email |
| CONFORMATION | GET    |      | http://localhost:8000/admin/confirmation?  | ?id, ?identifier |
| MODIFY       | PATCH  |  *   | http://localhost:8000/admin/modify         | password, new_password, name, email, rank |
| NEWPASS      | POST   |      | http://localhost:8000/admin/newpass        | password, new_password |