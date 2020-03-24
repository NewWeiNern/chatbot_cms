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
        .course-data{
            padding: 20px;
            width: calc(64.66% - 40px);
            background-color: blanchedalmond;
        }
        .course-data h4{
            margin: 0;
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
        .list .content input,
        .course input{
            height: inherit;
            font-family: inherit;
            background: none;
            border: none;
            font-size: inherit;
            font-weight: inherit;
            width: 100%;
            margin-bottom: 5px;
        }
        .course input{
            font-weight: normal;
        }
        .list .content input[type="button"],
        .course-data input[type="button"]{
            background-color: grey;
            color: white;
            padding: 10px 15px;
        }
        .tag{
            display: flex;
            flex-direction: column;
        }
        .tag div.keyword{
            color: white;
            margin-bottom: 10px;
            margin-right: 5px;
            background-color: gray;
            border: 1px solid darkslategray;
            padding: 5px 15px;
            display: inline-block;
            border-radius: 25px;
            width: 15%;
            text-align: center;
        }
        .course-data > ul{
            list-style: none;
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
            // for(let i = 0; i < inputs.length; i++){
            //     form.append(inputs[i].name, inputs[i].value);
            // }
            form.append("doc", this.parentElement.dataset.id);
            fetch("delete.php?type=" + type, {
                method : "POST",
                body : form
            });
            this.parentElement.remove();
            
        }

        function saveCourse(course){
            let inputs = this.parentElement.querySelectorAll("input:not([type='button']"),
            form = new FormData();

            for(let i = 0; i < inputs.length; i++){
                form.append(inputs[i].name, inputs[i].value);
            }
            form.append("tag", 
            Array.prototype.slice.call(this.parentElement.querySelectorAll(".keyword")).map(e=>e.innerText)
            );

            console.log(Array.prototype.slice.call(this.parentElement.querySelectorAll(".keyword")).map(e=>e.innerText));

            fetch("savecourse.php?type=" + document.querySelector(".programme-next").value,{
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
    <div class="course-data">
        <h4>Courses</h4>
        <select class="programme-next">
            <?php $data; foreach( $GFirestore->getCollections("programme") as $document): $data = !isset($data) ? $document["full_name"] : $data;?>
                <option class="name" value="<?= $document["full_name"];?>"><?= $document["full_name"];?></option>
            <?php endforeach;?>
        </select>
        <ul>
            <?php
                $docCollection = $GFirestore->getDocumentFromCollections("course", $data)->snapshot()->data()["data"];
                foreach($docCollection as $data):
            ?>
            <li>
                <div class="course">
                    <h2 class="name">
                        <input type="text" value="<?=$data["name"];?>" name="name"/>
                    </h2>
                    <div class="fee">
                        <h4>Fee: <input type="text" name="fee" value="<?=$data["fee"];?>"/></h4>
                    </div>
                    <div class="date">
                        <h4>Date: <input type="text" name="date" value="<?=$data["date"];?>"/></h4>
                    </div>
                    <div class="description">
                        <h4>Description: <input type="text" name="description" value="<?=$data["description"];?>"/></h4>
                    </div>
                    <div class="requirement">
                        <h4>Requirement: <input type="text" name="requirement" value="<?=$data["requirement"];?>"/></h4>
                    </div>
                    <div class="tag" contenteditable="true">
                        <?php foreach($data["tag"] as $data_tag){echo "<div class='keyword'>$data_tag</div>";} ?>
                    </div>
                    <input type="button" value="save" onclick='saveCourse.call(this, "<?=$data["name"];?>")'/>
                    <input type="button" value="delete" onclick='deleteCourse.call(this, "<?=$data["name"];?>")'/>
                </div>
                <hr>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</body>
</html>