# Register API Endpoint Documentation

## Overview
The register endpoint has been added to your existing AuthController and follows the same patterns as your other API endpoints. It uses Jetstream's built-in validation and user creation logic to ensure consistency with your web registration.

## Endpoint Details

**URL:** `POST /api/register`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com", 
    "password": "password123",
    "password_confirmation": "password123",
    "role": "buyer",
    "device_name": "mobile_app"
}
```

**Required Fields:**
- `name` (string, max 255 characters)
- `email` (string, valid email, unique)
- `password` (string, meets password requirements)
- `password_confirmation` (string, must match password)
- `role` (string, either "buyer" or "seller")

**Optional Fields:**
- `device_name` (string) - defaults to request IP if not provided
- `terms` (boolean) - defaults to true for API requests

## Response Examples

### Success Response (HTTP 201)
```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": "user_id_here",
            "name": "John Doe",
            "email": "john@example.com",
            "role": "buyer"
        },
        "token": "token_id|plain_text_token"
    }
}
```

### Validation Error Response (HTTP 422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password confirmation does not match."]
    }
}
```

### Server Error Response (HTTP 500)
```json
{
    "success": false,
    "message": "Registration failed. Please try again."
}
```

## Integration Notes

### How it works
1. **Validation**: Uses Jetstream's `CreateNewUser` action which includes all the validation rules from your web registration
2. **User Creation**: Creates user with the same logic as web registration, ensuring consistency
3. **Token Generation**: Uses the same MongoDB-compatible token creation as your login endpoint
4. **Response Format**: Follows the same response structure as your existing API endpoints

### Benefits
- ✅ **Consistent with Web Registration**: Uses exact same validation and creation logic
- ✅ **MongoDB Compatible**: Works with your MongoDB setup and custom token handling
- ✅ **Role-based**: Supports both buyer and seller registration
- ✅ **API Token**: Returns authentication token immediately after registration
- ✅ **Error Handling**: Consistent error responses matching your existing API pattern
- ✅ **Non-disruptive**: Doesn't affect any existing functionality

### Testing
You can test the endpoint using the provided `test_register_api.php` script:

```bash
php test_register_api.php
```

Or manually with curl:
```bash
curl -X POST http://your-domain.com/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123", 
    "password_confirmation": "password123",
    "role": "buyer"
  }'
```

## Existing API Endpoints (Unchanged)
- `POST /api/login` - Login endpoint (unchanged)
- `GET /api/me` - Get user info (unchanged)
- `POST /api/logout` - Logout endpoint (unchanged)
- All other existing endpoints remain exactly the same

The register endpoint seamlessly integrates with your existing authentication flow and doesn't modify any existing functionality.
