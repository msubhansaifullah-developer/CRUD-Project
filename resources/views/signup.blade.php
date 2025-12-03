<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Create Account</h3>
           <form id="signupForm">
    @csrf

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" id="name" required />
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required />
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required />
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" required />
    </div>

    <div id="responseMsg" class="text-center text-danger mb-2"></div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Sign Up</button>
    </div>
     <p class="text-center mt-3">Already have an account? <a href="/">Login</a></p>
</form>


           
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
document.getElementById("signupForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const csrfToken = document.querySelector('input[name="_token"]').value;

    const userData = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
        password_confirmation: document.querySelector('input[name="password_confirmation"]').value
    };

    fetch('/signup/register', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            "Accept": "application/json"
        },
        body: JSON.stringify(userData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = "/";
        } else {
            document.getElementById("responseMsg").innerText = data.message;
        }
    })
    .catch(err => {
        document.getElementById("responseMsg").innerText = "Error!";
        console.error(err);
    });

});
</script>

</body>
</html>
