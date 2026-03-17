# Laravel 10 Event Booking System

A **full-featured Event Booking System** built with Laravel 10, including:

- User authentication (Sanctum)  
- Role-based access control (Admin, Organizer, Customer)  
- Event & Ticket management  
- Booking & mocked payment system  
- Middleware, Services & Traits  
- Notifications & Queues  
- Caching for frequently accessed events  
- REST API with consistent responses  
- Feature & Unit testing with 85%+ coverage  

---

## 🛠 Prerequisites

- PHP >= 8.1  
- Composer  
- Node.js & npm  
- MySQL / PostgreSQL / SQLite  

---

## ⚡ Installation

### 1. Clone the repository
```bash
git clone <repo-url>
cd event-booking-system
2. Install dependencies
composer install
npm install
npm run dev
3. Environment setup
cp .env.example .env
php artisan key:generate

Update .env with your database settings:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_booking
DB_USERNAME=root
DB_PASSWORD=
4. Run migrations and seeders
php artisan migrate --seed

This will create:

2 Admins

3 Organizers

10 Customers

5 Events

15 Tickets

20 Bookings

5. Run Application
php artisan serve

Open in browser: http://127.0.0.1:8000

📂 API Endpoints
Events
Method	Endpoint	Description
GET	/api/events	List events (search, filter, pagination)
GET	/api/events/{id}	View event & tickets
POST	/api/events	Create event (organizer only)
PUT	/api/events/{id}	Update event (organizer only)
DELETE	/api/events/{id}	Delete event (organizer only)
Tickets
Method	Endpoint	Description
POST	/api/events/{event_id}/tickets	Create ticket (organizer only)
PUT	/api/tickets/{id}	Update ticket (organizer only)
DELETE	/api/tickets/{id}	Delete ticket (organizer only)
Bookings
Method	Endpoint	Description
POST	/api/tickets/{id}/bookings	Book ticket (customer)
GET	/api/bookings	List customer bookings
PUT	/api/bookings/{id}/cancel	Cancel booking (customer)
Payments
Method	Endpoint	Description
POST	/api/bookings/{id}/payment	Make payment (mocked)
GET	/api/payments/{id}	Payment details

All responses follow REST standard with success, message, and data fields.

📦 Postman Collection

Import the included EventBooking.postman_collection.json
Set environment variables:

base_url = http://127.0.0.1:8000
token = <sanctum_token_after_login>
🔧 Testing

Run Feature & Unit tests:

php artisan test --coverage

Coverage goal: 85%+

Tests include:

Registration / Login

Event creation / update / delete

Ticket booking & cancellation

Payment success & failure

Edge cases like double booking, exceeding ticket quantity

⚡ Queues & Notifications

Uses Laravel queue for booking confirmation notifications.

Set up queue (database driver):

php artisan queue:table
php artisan migrate
php artisan queue:work

Example notification: Booking confirmed email / in-app alert

🗂 Seeder Data

Users: 2 admins, 3 organizers, 10 customers

Events: 5 events

Tickets: 15 tickets

Bookings: 20 bookings