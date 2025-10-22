Instruction to run the project
 Before running the project, execute the following command to install/update all dependencies:
1) Before run the project Please run the command "composer update".
2) Create a database named: laravel_project_app
3) run the command "php artisan module:migrate Expense" . "this will create expenses table in laravel_project_app"
4) The project utilizes the nwidart/laravel-modules package to implement a modular architecture.
5) All log files are maintained in the storage/data-logs directory for easier tracking and debugging.
6) The project follows a Repository and Service Layer pattern to ensure clean separation of concerns and maintainable code.
7) Please run "php artisan serve".
8) Please check in Postman APIs Routes.

9) i) (http://127.0.0.1:8000)/api/v1/expenses  Fetch all expenses. Request Method(GET)
  ii) (http://127.0.0.1:8000)/api/v1/expenses/{id} [id is mandatory] Fetch Particular expense Request Method(GET)
  iii) (http://127.0.0.1:8000)/api/v1/expenses (Store Expense) Request Method(POST)
    add request Form data for storing ( title,amount,expense_date example (21/10/2025),category(1,2,3) defined in config 1=>Food,2=>Transport,3=> Accomodation)
iii) (http://127.0.0.1:8000)/api/v1/expenses/{id}  [id is mandatory] (Update Expense) Request Method(POST)
    add request Form data for storing ( title,amount,expense_date example (21/10/2025),category(1,2,3) defined in config 1=>Food,2=>Transport,3=> Accomodation,

   iv) (http://127.0.0.1:8000)/api/v1/expenses/{id} (Delete Expense) Request Method(POST) [id is mandatory]
   
   v) (http://127.0.0.1:8000)/api/v1/expenses  Fetch all expenses by Category. add category in Form Data for filtering the expense by category.
