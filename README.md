# Meeting Room Booking

Laravel 12 + Inertia/Vue 3 application for reserving meeting rooms in 30 minute slots (09:00–18:00). Includes a Filament 4 admin panel to manage rooms, time slots, bookings, and users.

## Features
- Browse rooms, check availability by date, and book 30 minute slots with double-booking prevention.
- Dashboard shows a user's booking history and allows cancellations.
- Filament admin at `/admin` to manage rooms, time slots, bookings, and users.
- Seeders provide 3 sample rooms and a full day of 30 minute slots.
- Backend endpoints power the booking flow (`/room/booked-slots`, `/room/book`).

## Tech Stack
- Laravel 12, PHP 8.2+
- Inertia + Vue 3, TailwindCSS, Vite 7
- Filament 4 admin panel
- DB is MySql

## Quick Start
1) Install dependencies  
```
composer install
npm install
```

2) Copy environment and configure DB (SQLite default)  
Set in `.env`:
```
DB_CONNECTION=mysql
DB_DATABASE=meetings
```
Adjust `APP_URL` if needed.

3) Generate key and migrate with seeds  
```
php artisan key:generate
php artisan migrate --seed
```

4) Run the app  
- Backend: `php artisan serve`
- Frontend assets: `npm run dev` (or `npm run build` for production)
- Convenience: `composer dev` runs serve + queue + logs + Vite together.

## Admin Access
Create an admin user for Filament:  
```
php artisan make:filament-user
```
Then sign in at `/admin`. Regular users can register/login via the standard auth screens and use `/rooms` to book.

## Booking Flow
- Go to `/rooms` (authenticated) to pick a date, room, and available slot.  
- View and cancel your bookings from `/dashboard`.

## Screenshots
## User
![Login](/public/screenshots/Screenshot%20from%202025-12-08%2018-17-28.png)
![Register](/public/screenshots/Screenshot%20from%202025-12-08%2018-17-35.png)
![Dashboard](/public/screenshots/Screenshot%20from%202025-12-08%2018-17-49.png)
![Welcome](/public/screenshots/Screenshot%20from%202025-12-08%2012-07-13.png)
![Bookings Table](/public/screenshots/Screenshot%20from%202025-12-08%2018-18-08.png)
![Create Booking](/public/screenshots/Screenshot%20from%202025-12-08%2018-18-22.png)

## Admin
![User Table](/public/screenshots/Screenshot%20from%202025-12-08%2018-19-39.png)
![Bookings List](/public/screenshots/Screenshot%20from%202025-12-08%2018-18-53.png)
![Booking Detail](/public/screenshots/Screenshot%20from%202025-12-08%2018-18-59.png)
![Time Slots](/public/screenshots/Screenshot%20from%202025-12-08%2018-19-04.png)
![Rooms List](/public/screenshots/Screenshot%20from%202025-12-08%2018-19-10.png)
![Room Form](/public/screenshots/Screenshot%20from%202025-12-08%2018-19-26.png)


