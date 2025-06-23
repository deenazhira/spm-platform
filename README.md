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
## **4.0 Authorization – Best Practices**

Authorization was implemented using **Role-Based Access Control (RBAC)** to ensure users access only what they are permitted to. The system enforces restrictions using roles and middleware to comply with several key **web authorization security best practices**.

### Role Assignment

When a new user registers, they are automatically assigned the **`student`** role:

* In **`RegisterController.php`**:

```php
$studentRole = Role::where('name', 'student')->first();
if ($studentRole) {
    $user->roles()->attach($studentRole->id);
}
```

### Middleware: Failing Closed & Least Privilege

A custom middleware `IsStudent` ensures only users with the student role can access student-specific features:

* **`app/Http/Middleware/IsStudent.php`**

```php
if (Auth::check() && Auth::user()->hasRole('student')) {
    return $next($request);
}
abort(403, 'Unauthorized access. Students only.');
```

### Protected Routes: Centralized Authorization

* Middleware is applied in **`web.php`**:

```php
Route::middleware(['auth', 'isStudent'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});
```

This limits access to student routes and ensures **authorization is enforced on every request.**

### RBAC: Centralized & Flexible Authorization

* The `User`, `Role`, and `Permission` models are connected via pivot tables:

```php
public function hasRole($roleName)
{
    return $this->roles()->where('name', $roleName)->exists();
}

public function hasPermission($permission)
{
    foreach ($this->roles as $role) {
        if ($role->permissions()->where('description', $permission)->exists()) {
            return true;
        }
    }
    return false;
}
```

* This allows defining roles like `student`, `admin`, etc., and assigning permissions accordingly.

---

### 🔐 How This Implements Best Practices:

| Best Practice                 | Implementation                                                                              |
| ----------------------------- | ------------------------------------------------------------------------------------------- |
| **Failing Closed**            | Unauthorized users see 403 error via middleware.                                            |
| **Least Privilege**           | New users get "student" role with minimal rights.                                           |
| **Separating Duties**         | Admin routes (to be added) can be separated from student routes using `isAdmin` middleware. |
| **Strong Policies**           | Role checks are consistently enforced with middleware and role checks.                      |
| **Unique Accounts**           | Each user registers uniquely via email.                                                     |
| **Authorize Every Request**   | All protected routes use middleware to authorize access.                                    |
| **Centralized Authorization** | Roles and permissions are stored in DB and checked through shared model logic.              |
| **Minimize Custom Logic**     | Laravel middleware and Eloquent ORM used for clean, reusable logic.                         |
| **Server-side Authorization** | No role logic is handled on the frontend.                                                   |
| **Mistrust Inputs**           | Authorization is checked on the server regardless of frontend state.                        |


## 5.0 XSS and CSRF prevention
### 5.1 Content Security Policy (CSP)
- CSP helps prevent XSS by limiting which scripts can run in the browser.
- Add CSP header in **`app/Http/Middleware/ContentSecurityPolicy.php`**
```php
public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        // Add Content-Security-Policy headers
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline'; img-src 'self' data:");
        return $response;
    }
```
- **`app/Http/Kernel.php`**
```php
\App\Http\Middleware\ContentSecurityPolicy::class,
```
- **`ReflectionController.php`**
```php
            $request->validate([
            'reflection' => 'required|string|max:2000',]);
        // Sanitize input to remove potentially dangerous HTML
        $cleanInput = strip_tags($request->input('reflection'));
        Reflection::create([
            'reflection' => $cleanInput
        ]);
```
- `script_tags` function removes any HTML tags, including <script> that could cause XSS.

### 5.2 Cross-site Scripting (XSS)
- Use `{{ }}` instead of `{!! !!}`
```php
<x-label for="email" value="{{ __('Email') }}" />
<x-label for="password" value="{{ __('Password') }}" />
<span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
```
### 5.3 Cross-Site Request Forgery (CSRF)
- **`app/Http/Kernel.php`**
```php
\App\Http\Middleware\VerifyCsrfToken::class,
```
- Tokens **`@csrf`** are used in all forms
```php
<form method="POST" action="{{ route('login') }}">
            @csrf
```
## 6.0 Database Security Principles
## 7.0 File Security Principles
- Only allow specific file format, PDF only, to avoid malicious file upload like .exe, ,zip and .php.
- Prevent large files to avoid Denial of Service(DoS) attack
- File Upload using Laravel's Secure API
- Regex `/^[\w\-.]+$/` ensures only valid filenames. This will prevent path traversal like `../../`
- Uploaded files are stored inside `storage/app/public/syllabi`, not inside public/.
- `download()` method prevents direct file access via URL
- **`SubjectController.php`**
```php
$validated = $request->validate([
            'syllabus' => 'required|file|mimes:pdf|max:2048', // validate PDF only, max 2MB
        ]);
        $syllabusPath = $request->file('syllabus')->store('syllabi', 'public');
        
        $subject->syllabus_path = $syllabusPath; 
        $subject->save();
public function downloadSyllabus($filename)
    {
    // Sanitize filename to prevent traversal
    if (!preg_match('/^[\w\-.]+$/', $filename)) {
        abort(400, 'Invalid filename');
    }

    $filePath = 'syllabi/' . $filename;

    // Use Laravel storage to securely fetch file
    if (!Storage::disk('public')->exists($filePath)) {
        abort(404, 'File not found');
    }

    return Storage::disk('public')->download($filePath);
```

## References
# spm-platform
>>>>>>> 218459cccdc1890a17bcc997b414fe4f9c48f615
