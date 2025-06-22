# Web Application Security Enhancement Report

## Group Members
1. Husna Nadhirah Binti Khairul Anwar - 2211170
2. Irdeena Zahierah Binti Zukipeli - 2210496

## **Title:** SPM Learning Platform 

## Introduction
The Student Learning Platform is a web application designed to support students in their studies by providing a comprehensive and interactive online learning environment. The platform aims to offer a seamless user experience with features designed to meet the specific needs of SPM students.

With the rapid advancement of technology, traditional methods of learning are evolving, and online education is becoming increasingly popular. The Student Learning Platform leverages this trend by providing a convenient and accessible platform for students to engage with their studies anytime, anywhere.

## Objectives of the Enhancements
- To protect user data from unauthorized access
- To apply strong security best practices
- To reduce vulnerabilities reported by OWASP ZAP

## 1.0 Vulnerability Report using OWASP ZAP Scanning
**i) Before Enhancement**

**Tool Used:** OWASP ZAP  
**Scan Type:** Active  
**Date of Scan:** 2025-06-20

The scan detected 8 issues, with 2 medium, 4 low and 2 informational priority alerts.

| Vulnerability     | Risk Level | Confidence Level | 
|-------------------|------------|------------------|
| CSP header not set     | Medium     | High             | 
| Missing anti-clickjacking header              | Medium     | Medium           | 
| Big Redirect Detected (Potential Sensitive Information Leak)     | Low     | Medium             | 
| Cookie No HttpOnly Flag | Low       | Medium             | 
| Server Leaks Information via "X-Powered-By" HTTP Response Header Field(s) | Low | Medium |
| X-Content-Type-Options Header Missing | Low | Medium |
| Information Disclosure - Suspicious Comments | Informational | Low |
| Modern Web Application | Informational | Medium |

![image](https://github.com/user-attachments/assets/419365bf-2977-4532-af3c-14ce0b60f622)
=======
## 2.0 Input Validation
## 3.0 Authentication
### 3.1 Password Policies
During registration, strong password policies are enforced to make sure the passwords are uniques. These rules ensure complexity, uniqueness and minimum length.
Password rules are defined in **`App\Actions\Fortify\CreateNewUser.php`** 
```php
Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',                  // Minimum 8 characters
                'regex:/[a-z]/',          // At least one lowercase letter
                'regex:/[A-Z]/',          // At least one uppercase letter
                'regex:/[0-9]/',          // At least one digit
                'regex:/[@$!%*#?&]/',     // At least one special character
                'confirmed',              // Must match password_confirmation
            ],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
```
- User need to make passwords with a minimum length of 8 characters and requirements for uppercase, lowercase, numbers, and special characters.
### 3.2 Multi-Factor Authentication(MFA)
The enhancement is made based on Time-based One-Time Password(TOTP) 2FA using Laravel Fortify. 
- **`Migrations/add_two_factor_columns_to_users_table.php`**
```php
public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
```
- **`config/fortify.php`**
```php
'features' => [
    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]),
],
```
To enable 2FA, user need to activate it in profile page. Under two factor authentication section, user need to click enable button and system will generate QR code. QR code need to be scanned via Google Authenticator and the code will be generated at their own device. After confirming the identity, user will get random recovery codes. When user wants to login again, TOTP code are required. 
- QR code
![image](https://github.com/user-attachments/assets/ad971298-5f7d-4ce9-817c-47d1bb6f6610)
- Random recovery code
![image](https://github.com/user-attachments/assets/d240a474-6499-43e1-b923-35ed6b38bed8)

### 3.3 Password stored using Bcrypt
Passwords are hashed using Bcrypt. 
- **`app/Actions/Fortify/CreateNewUser.php`**
```php
use Illuminate\Support\Facades\Hash;

return User::create([
            'password' => Hash::make($input['password']),
        ]);
```
- In database, passwords will be generated to ''$2y$12$....'
  
### 3.4 Rate Limit
- Limited login attempts to 3 per minute using `RateLimiter` to prevent brute-force attacks
- **`app/Providers/FortifyServiceProvider.php`**
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
public function boot(): void{
        RateLimiter::for('login', function (Request $request) {
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
        return Limit::perMinute(3)->by($throttleKey)->response(function () {
        return response()->json([
            'message' => 'Forced test - too many attempts'
        ], 429);
    });
```
- `Limit::perMinute(3)` allow user to login max 3 attempts per minute.
- On the 4th attempt, user will get `Forced test - too many attempts` error
![image](https://github.com/user-attachments/assets/722b8590-cc93-4b3f-8d76-e5b9eaea516f)

### 3.5 Salt
- **`app/Models/User.php`**
```php
protected $fillable = [
        'name',
        'email',
        'password',
        'salt',
    ];
```
- **`Migrations\add_salt_to_users_table.php`**
```php
public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('salt')->nullable()->after('password');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('salt');
        });
    }
```
- **`app/Actions/Fortify/CreateNewUser.php`**
```php
use Illuminate\Support\Str;

$salt = Str::random(8); //  generate salt
        return User::create([
            'salt' => $salt, // store salt
        ]);
```
- **`app/Providers/FortifyServiceProvider.php`**
```php
use App\Actions\Fortify\CreateNewUser;
Fortify::createUsersUsing(CreateNewUser::class);
```
- As result, unique salt will be generated in database under salt column. This will ensure, new user get their own salt. 

### 3.6 Session Management
- Cookies use HttpOnly, Secure, SameSite
- Update settings in **`config/session.php`**
```php
'lifetime' => 15, // 15 minutes of inactivity
'expire_on_close' => true, // Session expires on browser close

'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),
'http_only' => env('SESSION_HTTP_ONLY', true),
'same_site' => env('SESSION_SAME_SITE', 'lax'),
```

## 4.0 Authorization

## 5.0 XSS and CSRF prevention
### 5.1 Content Security Policy (CSP)
### 5.2 Cross-site Scripting (XSS)

### 5.3 Cross-Site Request Forgery (CSRF)
- Tokens **`@csrf`** are used in all forms
- 
## 6.0 Database Security Principles
## 7.0 File Security Principles

## References
# spm-platform
>>>>>>> 218459cccdc1890a17bcc997b414fe4f9c48f615
