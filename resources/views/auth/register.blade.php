<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>eOcamBo Technology - Register</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
  
  <style>
    body {
      /* background: #0d1b2a; */ /* Uncomment if you want dark body background */
      color: #e0e1dd;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
    .register-container {
      max-width: 420px;
      width: 100%;
      margin: auto;
      padding: 2.5rem;
      background: #1b263b;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
      border: 1px solid #415a77;
    }
    .logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    .logo img {
      max-width: 220px;
      height: auto;
    }
    .form-label {
      color: #e0e1dd;
      font-weight: 500;
    }
    .form-control {
      background: #0d1b2a;
      border: 1px solid #415a77;
      color: white;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.25rem rgba(224,122,95,0.25);
      background: #0d1b2a;
      color: white;
    }
    .form-control::placeholder {
      color: #778da9;
    }
    .form-control.is-invalid {
      border-color: #dc3545;
    }
    .invalid-feedback {
      color: #dc3545;
    }
    .btn-blue {
      background: blue;
      border: none;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      color: white;
    }
    .btn-blue:hover {
      background: #0000cc; /* slightly darker blue on hover */
    }
    a {
      color: #e07a5f;
    }
    a:hover {
      color: #f4a261;
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="register-container">

  <div class="logo">
    <img src="{{ asset('logo.png') }}" alt="eOcamBo Technology">
  </div>

  <h4 class="text-center mb-4">Create your account</h4>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Full Name -->
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" 
             class="form-control @error('name') is-invalid @enderror" 
             id="name" 
             name="name" 
             placeholder="Your full name" 
             value="{{ old('name') }}" 
             required 
             autofocus>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    {{-- {{-- username    --}}
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" 
             class="form-control @error('username') is-invalid @enderror" 
             id="username" 
             name="username" 
             placeholder="Choose a username" 
             value="{{ old('username') }}" 
             required>
      @error('username')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" 
             class="form-control @error('email') is-invalid @enderror" 
             id="email" 
             name="email" 
             placeholder="name@example.com" 
             value="{{ old('email') }}" 
             required>
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" 
             class="form-control @error('password') is-invalid @enderror" 
             id="password" 
             name="password" 
             placeholder="Password" 
             required 
             autocomplete="new-password">
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirm Password</label>
      <input type="password" 
             class="form-control" 
             id="password_confirmation" 
             name="password_confirmation" 
             placeholder="Confirm password" 
             required 
             autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-blue w-100">
      Register
    </button>

    <div class="text-center mt-4">
      <small>Already have an account? <a href="{{ route('login.form') }}">Sign in</a></small>
    </div>

  </form>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
</body>
</html>