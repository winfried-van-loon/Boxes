# GitHub Copilot Instructions for Boxes Project

## Project Overview
Boxes is a comprehensive box management application designed to help users organize their belongings during moves or storage. The application supports web, iOS, and Android platforms with a Laravel backend API.

## Core Features
- **Box Management**: Users can create, track, and organize boxes with photos, items, and custom metadata
- **Room Organization**: Assign boxes to current and target rooms/locations
- **User Connections**: Connect with friends via QR codes to collaborate on moves
- **Passkey Authentication**: Secure authentication without passwords using WebAuthn
- **Multi-platform**: Web, iOS, and Android support

## Architecture

### Backend (Laravel 12)
- **Location**: `/backend` directory
- **Framework**: Laravel 12 with PHP 8.3
- **Database**: SQLite (development), supports PostgreSQL/MySQL
- **Authentication**: Laravel Sanctum + WebAuthn for passkeys
- **API**: RESTful API with JSON responses

### Key Models and Relationships
1. **User**: Has many boxes, rooms, and connections
2. **Box**: Belongs to user, has photos, items, current/target rooms, can be nested
3. **Room**: Belongs to user, has boxes
4. **BoxPhoto**: Belongs to box, stores images with AI descriptions
5. **BoxItem**: Belongs to box, represents items within a box
6. **UserConnection**: Pivot for user-to-user connections with QR code support

### Database Schema
- Users have nullable passwords (passkey-first authentication)
- Boxes support custom fields via JSON column
- Box hierarchy supported via self-referencing parent_box_id
- User connections have status: pending, accepted, rejected

## Development Guidelines

### Code Style
- Follow Laravel best practices and PSR-12 coding standards
- Use type hints for all method parameters and return types
- Keep controllers thin, use service classes for complex business logic
- Use Laravel's built-in validation

### API Design
- All API endpoints under `/api` prefix
- Protected routes use `auth:sanctum` middleware
- RESTful resource controllers for CRUD operations
- Consistent JSON response format:
  ```json
  {
    "data": {},
    "message": "Success message",
    "errors": []
  }
  ```

### Authorization
- Use Laravel policies for model authorization
- Users can only access their own boxes and rooms
- Connected users can view each other's boxes (read-only)

### Testing
- Write feature tests for all API endpoints
- Write unit tests for models and complex business logic
- Use factories and seeders for test data
- Test file located in `/backend/tests`

### Security
- All user inputs must be validated
- Use parameterized queries (Eloquent ORM)
- Implement rate limiting on auth endpoints
- Store sensitive tokens in cache, not database
- Photos stored in storage/app/public with proper access control

## Common Tasks

### Adding a New Feature
1. Create migration if database changes needed
2. Update/create models with relationships
3. Create/update controller methods
4. Add routes to `routes/api.php`
5. Create policy if authorization needed
6. Write feature tests
7. Update API documentation

### Working with Images
- Use Intervention Image package for image processing
- Store in `storage/app/public/box-photos`
- Return URLs using `Storage::url()`
- Validate file types and sizes

### QR Code Generation
- Use SimpleSoftwareIO/SimpleQrCode package
- Generate temporary tokens (15 min expiry)
- Store tokens in cache, not database
- Return base64 encoded QR codes

## Mobile App Development
- Native mobile apps should consume the Laravel API
- Use React Native or Flutter for cross-platform development
- Implement QR code scanning for user connections
- Support offline mode with local storage sync

## Environment Setup
```bash
cd backend
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

## Testing Commands
```bash
cd backend
php artisan test                    # Run all tests
php artisan test --filter BoxTest   # Run specific test
```

## Laravel Boost MCP
- Laravel Boost is installed for AI-assisted development
- Provides context about Laravel application structure
- Use for rapid scaffolding and code generation

## Important Notes
- Email verification required before first login
- Passkeys are the primary authentication method
- Password field is nullable - only used as fallback
- All timestamps use Laravel's built-in `timestamps()`
- Soft deletes not enabled by default

## API Endpoints Overview

### Authentication
- POST `/api/auth/register` - Register new user
- POST `/api/auth/verify-email` - Verify email with token
- POST `/api/auth/login` - Request login link
- POST `/api/auth/logout` - Logout (requires auth)

### Boxes
- GET `/api/boxes` - List user's boxes (with filters)
- POST `/api/boxes` - Create new box
- GET `/api/boxes/{id}` - Get box details
- PUT `/api/boxes/{id}` - Update box
- DELETE `/api/boxes/{id}` - Delete box
- POST `/api/boxes/{id}/photos` - Upload photo
- POST `/api/boxes/{id}/items` - Add item to box

### Rooms
- GET `/api/rooms` - List user's rooms
- POST `/api/rooms` - Create new room
- GET `/api/rooms/{id}` - Get room details
- PUT `/api/rooms/{id}` - Update room
- DELETE `/api/rooms/{id}` - Delete room

### User Connections
- GET `/api/connections` - List connections
- POST `/api/connections/generate-qr` - Generate QR code
- POST `/api/connections/connect` - Connect with token
- POST `/api/connections/{id}/accept` - Accept connection
- POST `/api/connections/{id}/reject` - Reject connection
- DELETE `/api/connections/{id}` - Remove connection

## Future Enhancements
- AI-powered content recognition for box photos
- Push notifications for connection requests
- Export/import functionality
- Barcode scanning for box numbers
- Move timeline and progress tracking
- Shared boxes with multiple owners

## Resources
- Laravel Documentation: https://laravel.com/docs
- Laravel Sanctum: https://laravel.com/docs/sanctum
- WebAuthn: https://webauthn.io
- Intervention Image: http://image.intervention.io
