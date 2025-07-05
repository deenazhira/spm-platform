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
---

## 2.0 Input Validation
### 2.1 Server-Side Validation

Server-side validation is implemented using **Laravel Form Request Classes**, namely:

#### `RegisterRequest.php`

Located at `app/Http/Requests/RegisterRequest.php`, this file ensures robust validation during user registration.

```php
public function rules()
{
    return [
        'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
        ],
    ];
}
```

* **Name**: Must only contain letters and spaces (`regex:/^[a-zA-Z\s]+$/`)
* **Email**: Valid format, unique
* **Password**: Strong complexity required:

  * Minimum 8 characters
  * At least one lowercase letter
  * At least one uppercase letter
  * At least one digit
  * At least one special character
  * Must match password confirmation

Custom message for name:

```php
'name.regex' => 'The name may only contain letters and spaces.'
```

#### `LoginRequest.php`

Validates login inputs:

```php
'email' => 'required|string|email',
'password' => 'required|string',
```

Ensures both fields are present and correctly formatted.

---

### 2.2 Client-Side Validation

Client-side validations are embedded in the **Blade view forms**, such as `login.blade.php` and `register.blade.php`.

Example from `login.blade.php`:

```blade
<x-input id="email"
         type="email"
         name="email"
         required
         autocomplete="username" />
```

**HTML5 input types and attributes used:**

* `type="email"` for format checking
* `required` to ensure field is not empty
* `autocomplete` for user convenience
* Password field also uses `type="password"` and `required`

These prevent submission of empty or invalid format fields before even reaching the server.

---

### Summary of Validation Techniques

| Layer         | Technique                             | File(s)                                   |
| ------------- | ------------------------------------- | ----------------------------------------- |
| Client-side   | HTML5 attributes (`required`, `type`) | `register.blade.php`, `login.blade.php`   |
| Server-side   | Laravel Form Request validation rules | `RegisterRequest.php`, `LoginRequest.php` |
| Regex         | Custom format enforcement             | `RegisterRequest.php`                     |
| Confirm match | Password + password confirmation      | `RegisterRequest.php`                     |

---

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

---

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

---
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

---
  
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

---

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

---

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

---

## **4.0 Authorization**
### 4.1 Role-Based Access Control (RBAC)

The platform uses a dynamic **Role and Permission** model to enforce access control. Each user can have one or more roles, and each role can be linked to multiple permissions.

#### Models Involved:

* `User`: Has many roles via `user_roles` table.
* `Role`: Belongs to many permissions via `role_permissions` table.
* `Permission`: Defines fine-grained access rights.

#### Example Database Tables:

* `users`
* `roles`
* `permissions`
* `user_roles` (pivot)
* `role_permissions` (pivot)

#### Code Implementation:

##### `User.php`

```php
public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles');
}

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

##### `Role.php`

```php
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'role_permissions');
}

public function users()
{
    return $this->belongsToMany(User::class, 'user_roles');
}
```

##### `Permission.php`

```php
public function roles()
{
    return $this->belongsToMany(Role::class, 'role_permissions');
}
```

---

### 4.2 Middleware Authorization

A custom middleware named `IsStudent` restricts access to pages that should only be available to users with the `student` role.

##### `app/Http/Middleware/IsStudent.php`

```php
public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->hasRole('student')) {
        return $next($request);
    }

    abort(403, 'Unauthorized access. Students only.');
}
```

##### `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    ...
    'isStudent' => \App\Http\Middleware\IsStudent::class,
];
```

##### `web.php` (Route Restriction Example)

```php
Route::middleware(['auth', 'isStudent'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});
```

---

### 4.3 Auto-Assign Role on Registration

During registration, the system automatically assigns the `student` role to new users.

##### `RegisterController.php`

```php
public function register(RegisterRequest $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Auto assign role
    $studentRole = Role::where('name', 'student')->first();
    if ($studentRole) {
        $user->roles()->attach($studentRole->id);
    }

    Auth::login($user);
    return redirect()->intended('/dashboard');
}
```

---

### 4.4 Authorization Best Practices Implementation

| Best Practice                       | Implimentation                                                                   |
| ----------------------------------- | --------------------------------------------------------------------------------------- |
| **Failing Closed**                  | All middleware aborts with 403 if access isn't explicitly granted.                      |
| **Least Privilege**                 | Roles restrict what each user can access.            |
| **Separation of Duties**            | Admin roles (e.g., `admin`, `student`) are handled separately in RBAC logic.            |
| **Centralized Authorization Logic** | All permissions and roles are managed via database and reusable model methods.          |
| **Minimized Custom Code**           | Authorization checks use reusable helper methods like `hasRole()` and `hasPermission()`. |
| **Server-Side Enforcement**         | All checks (middleware, controller) are done on the server, no client-side logic.      |
| **Unique Accounts**                 | Each user registers uniquely.     |
| **Authorization on Every Request**  | Middleware checks are enforced before access to routes or resources.                    |

---

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
---
## 6.0 Database Security Principles
### **6.1 SQL Injection Prevention**
#### **Input Validation and Sanitization**

* All user inputs are validated using **Form Request classes** like `RegisterRequest` and `LoginRequest`.
* Rules are applied to ensure inputs are of the correct format and type (e.g., valid email, password rules).

```php
'email' => 'required|string|email',
'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
```

This prevents malicious SQL content from being passed through inputs.

---

### **6.2 Database User Privilege Limitation**

Following the **"least privilege" principle**, a dedicated MySQL user was created with limited rights:

```sql
CREATE USER 'spm'@'localhost' IDENTIFIED BY 'securePass123!';
GRANT SELECT, INSERT, UPDATE, DELETE ON `spm-project`.* TO 'spm'@'localhost';
```

* Avoids using the default `root` user
* Ensures that even if the app is compromised, attackers cannot drop tables or access other databases

**Updated `.env` file:**

```env
DB_USERNAME=spm
DB_PASSWORD=securePass123!
```

---

### **6.3 Secure Laravel DB Configuration**

Laravel `.env` file is configured securely:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spm-project
DB_USERNAME=spm
DB_PASSWORD=securePass123!
```

* `.env` file is excluded from GitHub to prevent password leaks.
* Database connection settings are not hardcoded into codebase.

---
## 7.0 File Security Principles
- Run `php artisan storage:link` to create a symbolic link
- This means only intended files like syllabus PDFs are accessible, not everything in storage.
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
- Arias, D. (2025, Jan 17). Add Salt to Hashing: A better way to store passwords. https://auth0.com/blog/adding-salt-to-hashing-a-better-way-to-store-passwords/
- Brkovic, R. (2024, March 29). How to make two-factor authentication in Laravel. https://medium.com/@brkovic.radomir/how-to-make-two-factor-authentication-in-laravel-c136c79c6c2a 
- What is cross-site scripting (XSS) and how to prevent it? | Web Security Academy. (n.d.). https://portswigger.net/web-security/cross-site-scripting
- OpenAI. (2025). ChatGPT (June 2025 version). https://chat.openai.com/
  
After enhancement
![image](https://github.com/user-attachments/assets/8e879bb9-f92b-474b-8d1e-287c1422af22)

