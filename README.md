## About Holiday Requests

<ul>
    <li>Register and log in users. Every user has to verify their email before having access. </li>
    <li>There are 3 types of users: admins, managers and employees</li>
    <li>Admins see the information of all users. They can update and delete users. They can fully modify the information about every user. They also define which employee is connected to which manager. One employee can have multiple managers, and one manager can have multiple employees.</li>
    <li>Managers can see the information of all the employees that they are managers to.</li>
    <li>Employees can see the information of all managers that they are employees to. They can also create holiday requests and partially change their own personal information.</li>
    <li>Holiday requests are prefilled with the information from the user, but it is allowed for them to be changed. The vacation has to start on a future date. The end of the vacation cannot be before the start of the vacation. They can be edited only if they are not already send. Only Employees can create Holiday Requests</li>
    <li>Every work day (Mon-Fri) at 9 AM, the app checks all requests that are new. For each manager it creates a .csv file with the information for every employees' holiday requests. Then, it sends them to the managers through email. The .csv files are save in storage/app/holidayRequests. The files are separated by date.</li>
    <li>Created using Laravel v8.37.0 (PHP v7.4.12), Bootstrap 4.0.0, bootstrap-icons, bootstrap-select, datatables.net</li>
</ul>

## How to start the project
<ul>
    <li>Clone the project</li>
    <li>Copy .env.example in .env (cp .env.example .env)</li>
    <li>Set APP_KEY, DB and MAIL information in .env. </li>
    <li>Run composer install</li>
    <li>Run npm install</li>
    <li>Run the migrations: php artisan migrate</li>
    <li>Run the seeder: php artisan db:seed</li>
</ul>

## You can start the project now
 <ul>
    <li>All users that are seeded have password "password"</li>
    <li>An admin user is created with email "admin@admin.com". The password is also "password"</li>
</ul>
