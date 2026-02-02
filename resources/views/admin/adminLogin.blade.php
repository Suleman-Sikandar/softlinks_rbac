<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Softlinks RBAC</title>
    <!-- Link to the package CSS, assuming it is published to public/admin/css/login.css -->
    <link rel="stylesheet" href="{{ asset('adminPanel/assets/css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <!-- Left Side: Brand Section -->
        <div class="brand-section">
            <div class="brand-content">
                <h1 class="brand-title">Softlinks RBAC</h1>
                <p class="brand-subtitle">Secure, Scalable, and Smart Role-Based Access Control System provided by <strong>Softlinks FZCO</strong>.</p>
            </div>
        </div>

        <!-- Right Side: Form Section -->
        <div class="form-section">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2 class="form-title">Welcome Back</h2>
                    <p class="form-subtitle">Please sign in to your dashboard.</p>
                </div>

                @if(Session::has('flash_message_error'))
                    <div class="alert alert-danger">
                        {{ Session::get('flash_message_error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="#" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="user_name" class="form-control" placeholder="Enter your username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn-login">Sign In</button>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>
