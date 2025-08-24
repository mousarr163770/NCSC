<?php
if(isset($_FILES['file'])){
    $name = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    // محاولة "شكلية" للمنع لكنها ما تمنع الهجوم فعلياً
    if(strpos($name,'.php') !== false){
        echo "Dangerous file but uploaded: ".$name;
    }

    move_uploaded_file($tmp, "uploads/".$name);
    echo "Uploaded: ".$name;
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>
