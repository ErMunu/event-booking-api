# Event Booking System API

A RESTful API backend for an Event Booking System built with Laravel 12.

## Features

- **Event Management**: Create, update, delete, and list events
- **Attendee Management**: Register attendees
- **Booking System**: Book attendees into events with validation for capacity and duplicates
- **API Documentation**: Swagger/OpenAPI documentation
- **Tests**: PHPUnit tests for all endpoints

## Requirements

- PHP 8.2+
- Composer
- MySQL or compatible database

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/ErMunu/event-booking-api.git
    cd event-booking-api
2. Install dependencies:
    ```bash
    composer install
3. Copy the environment file:
    ```bash
    cp .env.example .env
4. Configure your database in the `.env` file:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=event_booking
    DB_USERNAME=root
    DB_PASSWORD=
5. Generate application key:
    ```bash
    php artisan key:generate
6. Run migrations and seeders:
    ```bash
    php artisan migrate --seed
7. Start the development server:
    ```bash
    php artisan serve

## API Endpoints
### Events
- `GET /api/events` - List all events (with optional country filter)
- `POST /api/events` - Create a new event
- `GET /api/events/{id}` - Get a specific event
- `PUT /api/events/{id}` - Update a specific event
- `DELETE /api/events/{id}` - Delete a specific event

### Attendees
- `POST /api/attendees` - Register a new attendee

### Bookings
- `POST /api/bookings` - Book an attendee into an event

## Testing
Run the tests with:
```bash
php artisan test

