<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
       input {
                outline: none !important;
                box-shadow: none !important;    
            }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Login </h3>
                    </div>
                    <div class="card-body">
                        <form >
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button id="loginbutton" class="btn btn-success btn-md">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#loginbutton').on('click',function(e){
                e.preventDefault();
                const email=$("#email").val();
                const password=$("#password").val();
               
                $.ajax({
                    url:'api/login',
                    type:'POST',
                    contentType:'application/json',
                    data:JSON.stringify({
                        email:email,
                        password:password,
                    }),
                    success:function(response){
                        localStorage.setItem('apitoken',response.token);
                        window.location.href="/allposts";
                    },error:function(xhr,status,error){
                        alert('Error:'+xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>