<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-8 bg-primary text-white mb-4">
                <h1>All posts</h1>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-8">
                <a href="{{('/addposts')}}" class="btn btn-sm btn-primary">Add New</a>
                <button class="btn btn-sm btn-danger" id="logoutbtn">Logout</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="postcontainer">
                   
                </div>
            </div>
        </div>
    </div>

    <!--single post Modal -->
    <div class="modal fade" id="singlepostmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="singlepostLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="singlepostLabel">single Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    {{-- End post Model --}}

    {{-- Update Post Model --}}
     <div class="modal fade" id="updatepostmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatepost" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="updatepost">Update Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
         <form id="updateform">
        <div class="modal-body">
                <input type="hidden"  id="postid" class="form-control" value="">
                <b>Title:</b><input type="text"  id="posttitle" class="form-control" value="">
                <b>Description:</b><textarea   id="postbody" class="form-control" value=""></textarea>
                <img id="showimage" width="150px">
                <p>Upload Image:</p><input type="file"  width="100px" height="100px"  id="postimage" class="form-control">
        </div>
        <input type="submit" value="save changes" class="btn btn-primary ms-2">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            
        </div>
        </form> 
        </div>
    </div>
</div>
    {{-- End Update model --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.querySelector("#logoutbtn").addEventListener('click',function(){
        const token=localStorage.getItem('apitoken');
        fetch('/api/logout',{
            method:"post",
            headers:{
                Authorization:`Bearer ${token}`
            }
        }).then(response=>response.json()).then(data=>{
        //    console.log(data);
        localStorage.removeItem('apitoken');
            window.location.href="http://localhost:8000/";
        });
    })
    //post Api
    function loaddata(){
        const token=localStorage.getItem('apitoken');

         fetch('/api/posts',{
            method:"GET",
            headers:{
                Authorization:`Bearer ${token}`
            }
        }).then(response=>response.json()).then(data=>{
           var allposts=data.data.posts;
           const postcontainer=document.querySelector("#postcontainer");
           var tabledata=`<table class="table table-bordered">
                        <tr class="table-dark">
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>View</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>`;
                        allposts.forEach(posts => {
                            tabledata+=`<tr>
                            <td><img src="/storage/${posts.image}" height="100px" width="100px"/></td>
                            <td><h6>${posts.title}</h6></td>
                            <td><p>${posts.description}</p></td>
                            <td><button type="button" class="btn btn-md btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#singlepostmodel" data-bs-post="${posts.id}">View</button></td>
                            <td><button type="button" class="btn btn-md btn-success  mt-3" data-bs-toggle="modal" data-bs-target="#updatepostmodel" data-bs-post="${posts.id}">Update</button></td>
                            <td><button class="btn btn-md btn-danger  mt-3" onclick="deletepost(${posts.id})">Delete</button></td>
                        </tr>`;
                        });
                        
                    tabledata += `</table>`;
           postcontainer.innerHTML=tabledata;
        });
    }
    loaddata();

    //open single post model
    var singlemodel=document.querySelector("#singlepostmodel");
    if(singlemodel){
         singlemodel.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        const id = button.getAttribute('data-bs-post')
        const token=localStorage.getItem('apitoken');
        fetch(`/api/posts/${id}`,{
            method:"GET",
            headers:{
                Authorization:`Bearer ${token}`,
                'content-Type':'application/json'
            }
        }).then(response=>response.json()).then(data=>{
            const post=data.data.post[0];
            const modalbody=document.querySelector("#singlepostmodel .modal-body");
            modalbody.innerHTML=`
           <b> Title:</b>${post.title}<br>
           <b> Description:</b>${post.description}<br>
           <img src="/storage/${post.image}" width="150px" height="100px" class=" mt-2">
            `
        });
  
        })
    }


    //update Model

    //update post model
   var updatemodel = document.querySelector("#updatepostmodel");

if (updatemodel) {
    updatemodel.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        const id = button.getAttribute('data-bs-post');
        const token = localStorage.getItem('apitoken');

        fetch(`/api/posts/${id}`, {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            const post = data.data.post[0];
            document.querySelector("#postid").value = post.id;
            document.querySelector("#posttitle").value = post.title;
            document.querySelector("#postbody").value = post.description;
             document.querySelector("#postimage").src = `/storage/${post.image}`;
        })
        .catch(err => console.error("Error fetching post:", err));
    });
}

// update post
var updateform = document.querySelector("#updateform");

updateform.onsubmit = async (e) => {
    e.preventDefault();

    const token = localStorage.getItem('apitoken');
    const postid = document.querySelector("#postid").value;
    const title = document.querySelector("#posttitle").value;
    const description = document.querySelector("#postbody").value;

    const formdata = new FormData();
    const imageFile = document.querySelector("#postimage").files[0];
    if (imageFile) {
        formdata.append('image', imageFile);
    }

    formdata.append('id', postid);
    formdata.append('title', title);
    formdata.append('description', description);

    const response = await fetch(`/api/posts/${postid}`, {
        method: "POST",
        body: formdata,
        headers: {
            Authorization: `Bearer ${token}`,
            "X-HTTP-Method-Override": "PUT"
        }
    });

    const data = await response.json();
    
     window.location.href = "/allposts";
};

//Delete post
async function deletepost(postid) {
    const token = localStorage.getItem('apitoken');

    try {
        const response = await fetch(`api/posts/${postid}`, {
            method: "DELETE",
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        if (!response.ok) {
            throw new Error(`Failed to delete post: ${response.status}`);
        }

        const data = await response.json();

        // Optional: redirect or show alert
        alert("Post deleted successfully!");
        window.location.href = "/allposts";

    } catch (error) {
        alert("Failed to delete the post!");
    }
}



    </script>
</body>
</html>



