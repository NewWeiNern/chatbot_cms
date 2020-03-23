<?php
    include_once "./vendor/autoload.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYP SIDM Chatbot</title>
    <style>
        body{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        h1,h2,h3,h4,h5,h6{
            width: 100%;
            font-family: 'Noto Serif', serif;
        }
        .list{
            background-color: blanchedalmond;
            width: 33.33%;
        }
        .list .header{
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            padding: 10px 20px;
        }
        .list .header h4{
            margin: 0;
            flex: 1;
        }
        .list .header span{
            font-size: 20px;
            font-weight: bolder;
        }
        .list .content{
            margin: 20px 20px;
            padding: 10px 10px;
            background-color: rgba(255,255,255,0.4);
        }
        .list .content h2{
            margin: 0;
        }

        .list .content h4 span{
            font-family: 'Bellota Text', cursive;
        }
        .list .content input{
            height: inherit;
            font-family: inherit;
            background: none;
            border: none;
            font-size: inherit;
            font-weight: inherit;
        }
        .list .content input[type="button"]{
            background-color: grey;
            color: white;
            padding: 10px 15px;
        }
    </style>
    <script>
        function generateDocument(ele){
            ele = ele.parentElement.parentElement.lastElementChild;
            ele.style.display = "block";
            ele.classList.add("active");
            let cloned = ele.cloneNode(true);
            cloned.style.display = "none";
            ele.parentElement.appendChild(cloned);
            console.log(cloned);
        }

        function saveDocument(type){
            let inputs = this.parentElement.querySelectorAll("input"),
            form = new FormData(),
            m,s;
            for(let i = 0; i < inputs.length; i++){
                form.append(inputs[i].name, inputs[i].value);
            }
            fetch("save.php?type=" + type, {
                method : "POST",
                body : form
            });
            this.parentElement.dataset.id = form.get("full_name").match(/\b(\w)/g).join("").toLowerCase();
        }
        function deleteDocument(type){
            let inputs = this.parentElement.querySelectorAll("input"),
            form = new FormData();
            for(let i = 0; i < inputs.length; i++){
                form.append(inputs[i].name, inputs[i].value);
            }
            fetch("delete.php?type=" + type, {
                method : "POST",
                body : form
            });
            
        }
    </script>
    <link href="https://fonts.googleapis.com/css?family=Bellota+Text:300,300i,400,400i,700,700i|Noto+Serif:400,400i,700,700i&display=swap" rel="stylesheet">

</head>
<body>
    <h1>SIDM Chatbot CMS</h1>
    <div class="programme-container list">
        <div class="header">
            <h4>Programme</h4>
            <span onclick="generateDocument(this)">+</span>
        </div>
        <?php include_once "component/programme/content.php"?>
        <div class="content" style="display: none;">
            <h2 class="name"><input type="text" value="Title" name="full_name"/></h2>
            <h4>Duration: <span class="duration"><input type="text" value="Duration" name="duration"/></span></h4>
            <h4>Description: <br><span class="description"><input type="text" value="Description" name="description"/></span></h4>
            <input type="button" value="save" onclick="saveDocument.call(this, 'programme')"/>
            <input type="button" value="delete" onclick="deleteDocument.call(this, 'programme')"/>
        </div>
    </div>
    <div class="course-container list">
        <div class="header">
            <h4>Course</h4>
            <span onclick="generateDocument(this)">+</span>
        </div>
        <?php include_once "component/course/content.php"?>
    </div>
</body>
</html>