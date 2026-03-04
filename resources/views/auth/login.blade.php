<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>eOcamBo Technology - Login</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
  
  <style>
    body {
      /* background: #0d1b2a; */
      color: #e0e1dd;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
    .login-container {
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
      /* border-color: #e07a5f; */
      box-shadow: 0 0 0 0.25rem rgba(224,122,95,0.25);
      background: #0d1b2a;
      color: white;
    }
    .form-control::placeholder {
      color: #778da9;
    }
    .btn-blued {
      background: blue;
      border: none;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      color: white;

    }
   
   
    a {
      color: #e07a5f;
    }
    a:hover {
      color: #f4a261;
      text-decoration: underline;
    }
    hr {
      border-color: #415a77;
    }
  </style>
</head>
<body>

<div class="login-container">

  <div class="logo">
    <!-- Replace with your actual logo file or keep text -->
    {{-- Logo public  --}}
        <img src="{{ asset('logo.png') }}" alt="eOcamBo Technology">
  </div>

  <h4 class="text-center mb-4">Please sign in</h4>

  <form method="POST" action="{{ route('login.post') }}">  <!-- change if your route name is different -->
    @csrf

    @if ($errors->any())
      <div class="alert alert-danger mb-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" 
             class="form-control @error('username') is-invalid @enderror" 
             id="username" 
             name="username"
             placeholder="Username" 
             value="{{ old('username') }}"
             required 
             autofocus>
      @error('username')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" 
             class="form-control @error('password') is-invalid @enderror" 
             id="password" 
             name="password"
             placeholder="Password" 
             required>
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
        <label class="form-check-label" for="rememberMe">
          Remember me
        </label>
      </div>

      <a href="#" class="small">Forgot Your Password?</a>
    </div>

    <button class="btn-blued w-100" type="submit">
      Login
    </button>
</form>
    <div class="text-center mt-4">
      <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
    </div>

</div>

<!-- Bootstrap 5 JS (optional - only if you need dropdowns, modals, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
</body>
</html>