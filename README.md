<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://scontent.xx.fbcdn.net/v/t1.15752-9/467473558_3999128883649739_3904109331498328680_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=0024fc&_nc_eui2=AeESgWeygsXi3srXhsG2Fbw77gULT93uIWLuBQtP3e4hYoApIehbTS4LQhZY2F4ZtlMtMu9CCOk8YHo0QudN4l4X&_nc_ohc=sp4U4E1hyYYQ7kNvgFQ33qd&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=scontent.xx&oh=03_Q7cD1QGY-44rfeWSpWxHE06GQfHtWFS6ntJ-wL2OwnDYf042yQ&oe=677098A2" width="400" alt="Laravel Logo"></a></p>

# Running a Cloned Smart Recyclable Waste Monitoring system Project

E Follow ni nga mga steps para ma pa run ninyo ang ang project after ninyo ma download

---

## Prerequisites

Ensure you have the following installed on your system:
- **PHP (>= 8.2)**
- **Composer** (Dependency Manager for PHP)
- **XAMPP WITH MSQL** or another supported database

---

## Step 1: Create new .env file, and configure DATABASE

1. Open the the project using VScode
2. Create new .env file inside project
3. Look for the .env.example and copy the contents to the newly created .env file
4. Replace the current configuration of the database inside the .env  with these one:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=smart-recyclable-waste-monitoring-system
    DB_USERNAME=root
    DB_PASSWORD=


## Step 2: Download my sql file, para dinamo mag pa run sa script og naa nay graph

1.Download this mysql file, link:
  ```bash
    https://www.mediafire.com/file/y9l1tjlftsv8jux/smart-recyclable-waste-monitoring-system.sql/file
  ```
3. Open xampp->phpmyadmin
4. Import the mysql you downloaded


## Step 3: Generating key , running MIGRATIONS, and running/serving the system

1. Generate key for .env file, open terminal and run:
   ```bash
   php artisan key:generate
   ```
2. Start table migrations, open terminal and run:
   ```bash
   php artisan migrate
   ```
3. Serve / Start the system, open terminal and run:
   ```bash
   php artisan serve
   ```
4. Open browser and type url:
   ```bash
   http://localhost:8000/dashboard
   ```
5. Done! Makita na dapat nimo ang GRAPHS diras dashboards



