# 📦 Boxes - Smart Moving & Storage Management

Boxes is a comprehensive box management application that helps you organize your belongings during moves or storage. Track your boxes, find your items, and collaborate with friends - all from your web browser or mobile device.

## ✨ Features

### 🏷️ Smart Box Tracking
- Create and label boxes with names, numbers, and types
- Add custom fields for any additional information
- Nest boxes within boxes for complex organization
- Quick search and filtering by any attribute

### 📸 Photo Documentation
- Take photos of boxes and their contents
- AI-powered content recognition (coming soon)
- Multiple photos per box with custom ordering
- Visual reference when unpacking

### 🏠 Room Organization
- Create rooms with locations
- Assign boxes to current and target rooms
- Filter boxes by room or location
- Track your move progress

### 👥 Collaborate with Friends
- Connect with friends using QR codes
- View each other's boxes to help coordinate
- Accept/reject connection requests
- Privacy-first sharing

### 🔒 Secure Authentication
- **Passkey-first**: No passwords to remember
- Biometric login support
- Email verification for new accounts
- Secure token-based API authentication

### 📱 Multi-Platform
- Responsive web application
- Native iOS app (in development)
- Native Android app (in development)
- Sync across all devices

## 🚀 Quick Start

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js and npm (for frontend assets)
- SQLite, PostgreSQL, or MySQL

### Backend Setup

1. **Clone the repository**
```bash
git clone https://github.com/winfried-van-loon/Boxes.git
cd Boxes/backend
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up database**
```bash
# For SQLite (default)
touch database/database.sqlite

# Run migrations
php artisan migrate
```

5. **Create storage link**
```bash
php artisan storage:link
```

6. **Start the development server**
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### Frontend Setup (Coming Soon)
- Web application using Vue.js or React
- Mobile apps using React Native or Flutter

## 📖 API Documentation

### Authentication Endpoints

#### Register
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com"
}
```

#### Verify Email
```http
POST /api/auth/verify-email
Content-Type: application/json

{
  "token": "verification_token_from_email"
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com"
}
```

### Box Management

#### List Boxes
```http
GET /api/boxes?search=kitchen&current_room_id=1
Authorization: Bearer {token}
```

#### Create Box
```http
POST /api/boxes
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Kitchen Utensils",
  "number": "K-001",
  "type": "Medium Cardboard",
  "current_room_id": 1,
  "target_room_id": 2,
  "description": "All kitchen items",
  "custom_fields": {
    "fragile": true,
    "priority": "high"
  }
}
```

#### Upload Photo
```http
POST /api/boxes/{id}/photos
Authorization: Bearer {token}
Content-Type: multipart/form-data

photo: [file]
```

#### Add Item to Box
```http
POST /api/boxes/{id}/items
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Spatula",
  "quantity": 2,
  "description": "Silicone spatulas"
}
```

### Room Management

#### Create Room
```http
POST /api/rooms
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Kitchen",
  "location": "First Floor",
  "description": "Main kitchen area"
}
```

### User Connections

#### Generate QR Code
```http
POST /api/connections/generate-qr
Authorization: Bearer {token}
```

Returns QR code as base64 image and connection URL.

#### Connect with Token
```http
POST /api/connections/connect
Authorization: Bearer {token}
Content-Type: application/json

{
  "token": "connection_token_from_qr"
}
```

## 🧪 Testing

Run the test suite:
```bash
cd backend
php artisan test
```

Run specific test file:
```bash
php artisan test --filter BoxTest
```

## 🏗️ Project Structure

```
Boxes/
├── backend/                 # Laravel application
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       └── Api/    # API controllers
│   │   ├── Models/         # Eloquent models
│   │   └── Policies/       # Authorization policies
│   ├── database/
│   │   ├── migrations/     # Database migrations
│   │   └── factories/      # Model factories
│   ├── routes/
│   │   ├── api.php         # API routes
│   │   └── web.php         # Web routes
│   └── tests/              # Tests
├── mobile/                 # Mobile apps (coming soon)
└── frontend/               # Web frontend (coming soon)
```

## 🔧 Configuration

### Environment Variables

Key variables in `.env`:
```env
APP_NAME=Boxes
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_CONNECTION=mysql for production

CACHE_DRIVER=file
SESSION_DRIVER=file

MAIL_MAILER=smtp
# Configure mail settings for email verification
```

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Keep commits atomic and well-described

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👥 Authors

- **Winfried van Loon** - *Initial work* - [@winfried-van-loon](https://github.com/winfried-van-loon)

## 🙏 Acknowledgments

- Laravel framework and community
- WebAuthn specification contributors
- All open source packages used in this project

## 📧 Support

For support, please open an issue on GitHub or contact the maintainers.

## 🗺️ Roadmap

### v1.0 (Current)
- [x] Laravel backend with API
- [x] Box management
- [x] Room organization
- [x] User connections via QR codes
- [x] Landing page

### v1.1 (Next)
- [ ] WebAuthn passkey implementation
- [ ] Email verification system
- [ ] Photo AI recognition
- [ ] Web frontend (Vue.js/React)

### v1.2
- [ ] React Native mobile apps
- [ ] Offline mode
- [ ] Push notifications
- [ ] Barcode scanning

### v2.0
- [ ] Move timeline
- [ ] Shared boxes
- [ ] Export/import data
- [ ] Analytics dashboard

## 💡 Use Cases

- **Moving to a new home**: Track all your boxes from packing to unpacking
- **Long-term storage**: Remember what's in storage without digging through boxes
- **Seasonal items**: Organize holiday decorations, sports equipment, etc.
- **Collaborative moves**: Coordinate with friends or family helping you move
- **Business storage**: Organize inventory or archived materials

---

Made with ❤️ by the Boxes team
