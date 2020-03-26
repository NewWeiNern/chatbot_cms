<?php
    include_once "./vendor/autoload.php";
    include_once "./google/firestore/index.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYP SIDM Chatbot</title>
    <link href="https://fonts.googleapis.com/css?family=Bellota+Text:300,300i,400,400i,700,700i|Noto+Serif:400,400i,700,700i&display=swap" rel="stylesheet">
    <script>
        const _ = e=>document.querySelectorAll(e);
        const get = async function(data){
            return fetch(`course_data.php?data=${data}`, {
                headers : {
                    'Content-Type' : "application/json"
                },
                method : "GET"
            }).then(e=>e.json());
        }
    </script>
</head>
<body>
    <h1>SIDM Chatbot CMS</h1>
    <div class="programme" style="width:40%; float:left;">
        <?php include_once "./template/programming/__content.php";?>
    </div>
    <div class="course" style="width:60%; float:left;">
    <h2>Course By:
    <select id="choice">
        <?php foreach($data_programme as $data): ?>        
            <option value="<?=$data['key'];?>"><?=$data["full_name"];?></option>
        <?php endforeach;?>
    </select>
    </h2>    
        <?php include_once "./template/course/__content.php";?>
    </div>

    <script>
        document.getElementById("choice").onchange = async function(){
            const course = await get(this.value);
            console.log(course);
        }
    </script>

</body>
</html>