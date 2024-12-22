# DexWin Task Manager

A modern task management system with a Laravel backend API and React Native mobile app.

## Backend Setup (Laravel)

### Prerequisites

- PHP 8.2 or higher
- Composer
- SQLite (for development)

### Quick Start

1. Clone the repository:
```bash
git clone <repository-url>
cd dexwin
```

2. Install dependencies:
```bash
composer install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database:
```bash
touch database/database.sqlite
```

Update `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

5. Run migrations:
```bash
php artisan migrate:refresh --seed
```

6. Start the development server:
```bash
php artisan serve --port 2024
```

The API will be available at `http://localhost:2024/api/v1`.

> [!TIP]
> API documentation is available at [http://localhost:2024/api/documentation](http://localhost:2024/api/documentation)

## Frontend Setup (React Native)

The mobile app is in a separate directory. Follow these steps to set it up:

1. Enter the app directory:
```bash
cd react-native
```

2. Install dependencies:
```bash
npm install
# or
yarn install
```

3. Configure the API endpoint:
Update `src/services/api.js` to point to your local backend:
```javascript
const API_URL = 'http://localhost:2024/api/v1';
```

4. Start the development server:
```bash
npm start
# or
yarn start
```

5. Run the app:
- Scan the QR code with Expo Go on your mobile device
- Press 'a' for Android emulator
- Press 'i' for iOS simulator

## Features

### Backend
- Modern Laravel 11.x
- Interactive API Documentation (Redocly)
- Advanced filtering and sorting
- Comprehensive validation
- Clean Architecture with DTOs and Service Layer

### Frontend
- React Native with Expo
- Clean and intuitive UI with React Native Elements
- Status-based task filtering
- Real-time updates
- Smooth animations and transitions

## API Endpoints

- `GET /api/v1/todos` - List all tasks
- `POST /api/v1/todos` - Create a new task
- `GET /api/v1/todos/{id}` - Get task details
- `PUT /api/v1/todos/{id}` - Update a task
- `DELETE /api/v1/todos/{id}` - Delete a task

Query parameters for filtering:
- `status`: Filter by status (not started, in progress, completed)
- `search`: Search in title and details
- `sort_by`: Sort by field (title, created_at, status)

## Production Deployment

The production API is hosted at `https://dexwin-test.fly.dev`. To use the production API:

1. Update the React Native app's API URL in `src/services/api.js`:
```javascript
const API_URL = 'https://dexwin-test.fly.dev/api/v1';
```

2. Rebuild and deploy your app

> [!WARNING]
> For production deployment, ensure proper security measures are in place.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
