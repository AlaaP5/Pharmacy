# pharmacy_management
## Installing Laravel 9 Passport from GitHub

1. Clone the repository:
``
git clone https://github.com/AlaaP5/Pharmacy.git
```
2. Navigate to the project directory:
```
3. Install dependencies:
```
composer install
```

4. Create a `.env` file:


```
cp .env.example .env
```

5. Generate the application key:


```
php artisan key:generate
```

6. Run database migrations:


```
php artisan migrate
```

7. Install Passport:


```
php artisan passport:install
```

8. Start the server:


```
php artisan serve
```

That's it! You now have a Laravel 9 Passport project installed from GitHub and ready to use.

-------------------------------------------------------------------------------------------------------

Project Description: 
  -Enhance the efficiency of pharmacy management and streamline daily operations.

Key Features:
  -Inventory Management: Track medications and update quantities regularly.

Order System: 
  -Simplify the process of ordering medications from suppliers.

Patient Records:
  -Maintain and update patient information and prescriptions.

Reports and Analytics: 
  -Detailed reports on sales, inventory, and pharmacy performance.  
