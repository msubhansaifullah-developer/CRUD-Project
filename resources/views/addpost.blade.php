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
            textarea{
                 outline: none !important;
                box-shadow: none !important;   
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-8 bg-primary text-white mb-4"><h2>Create Post</h2></div>
        </div>
        <div class="row">
            <div class="col-8">
               <form id="addform" enctype="multipart/form-data">
                    <input type="text" name="title" id="title" class="form-control mb-3" placeholder="Title">

                    <textarea name="description" id="description" class="form-control mb-3" placeholder="Description"></textarea>

                    <input type="file" name="image" id="image" class="form-control mb-3">

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/allposts" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
document.getElementById("addform").onsubmit = async function (e) {
    e.preventDefault();

    const token = localStorage.getItem("apitoken");

    let formdata = new FormData();
    formdata.append("title", document.getElementById("title").value);
    formdata.append("description", document.getElementById("description").value);

    let imageFile = document.getElementById("image").files[0];
    if (imageFile) {
        formdata.append("image", imageFile);
    }

    let response = await fetch("/api/posts", {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token,
            "Accept": "application/json"
        },
        body: formdata
    });

    let result = await response.json();
    console.log(result);

    if (response.ok) {
        window.location.href = "/allposts";
    } else {
        alert("Error: " + result.message);
    }
};
</script>

</body>
</html>