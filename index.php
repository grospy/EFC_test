<?php
 
  $db = mysqli_connect("localhost", "adplatform", "adplatform", "image_upload");


  $msg = "";

  
  if (isset($_POST['upload'])) {
  	$image = $_FILES['image']['name'];
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
    $Title=mysqli_real_escape_string($db, $_POST['Title']);
  	$target = "images/".basename($image);
  	$sql = "INSERT INTO images (image, image_text,Title) VALUES ('$image', '$image_text','$Title')";
  	mysqli_query($db, $sql);
  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM images");
?>
<!DOCTYPE html>
<html>
<head> <H1> This is an advertising platform created by Shamil Karimli</H1>
<title>Image Upload</title>
<style type="text/css">
   #content{
   	width: 100%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 100%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 400px;
   	height: 300px;
   }
</style>
</head>
<body>
<div id="content">
  <?php
    while ($row = mysqli_fetch_array($result)) {
      echo "<div id='img_div'>";
      	echo "<img src='images/".$row['image']."' >";
		  echo "<p>".$row['Title']."</p>";
          echo "<p>".$row['uploaded_on']."</p>";
      	echo "<p>".$row['image_text']."</p>";
        
      echo "</div>";
    }
  ?>
  <form method="POST" action="index.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="1" 
      	name="Title" 
      	placeholder="define the title "></textarea>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="4" 
      	name="image_text" 
      	placeholder="You need to describe this advert..."></textarea>
  	</div>
  	<div>
  		<button type="submit" name="upload">POST THIS ADVERT</button>
  	</div>
  </form>
</div>
</body>
</html>