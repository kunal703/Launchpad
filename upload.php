<?php
  ini_set('mysql.connect_timeout', 300);
  ini_set('default_socket_timeout', 300);
  error_reporting(0);
?>
<html style="overflow-x: hidden">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LaunchPad</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">    
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
   
   <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
   <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


</head>

<body>
  
<?php
  session_start();
  
  require "navbar.php";
  require "db_conn.php";
  
  
  $user_name = $_SESSION['user_session'];
  

  if(isset($_POST['btncancel']))
  { 
      header("Location: home.php");
  }

  if(isset($_POST['btnsubmit']))
  {
      $pname = $_POST['projname'];
      $pdesc = $_POST['projdesc'];
      $pminamt = $_POST['minamt'];
      $pmaxamt = $_POST['maxamt'];
      $penddate = $_POST['penddate'];
      $pcompdate = $_POST['pcompdate'];
      $tags = $_POST['tags'];
      $location = $_POST['location'];

      $pname = htmlspecialchars($pname);
      $pdesc = htmlspecialchars($pdesc);
      $location = htmlspecialchars($location);
      

      $tagarr = explode(",", $tags);   
     
     
      if(getimagesize($_FILES['covpic']['tmp_name']) == FALSE)
      {
        // echo "Please select an image.";
      }
      
      $imageFile = $_FILES['covpic']['name'];
      $imgExt = strtolower(pathinfo($imageFile,PATHINFO_EXTENSION));
      $image = addslashes($_FILES['covpic']['tmp_name']);
      $image = file_get_contents($image);
      $image = base64_encode($image);

      $sqlquery = "insert into projects values('$pname', '$user_name', '$pdesc', '$pminamt', '$pmaxamt', '$penddate', '$pcompdate', 'Funding', now(), '$image','$location')";
      $result = $conn->query($sqlquery);

      for($i = 0; $i < sizeof($tagarr);$i++)
      {
          $tag = $tagarr[$i];
          $sqlquery4 = "insert into tags values('$pname','$tag')";
          $conn->query($sqlquery4);
      }

       echo '<div class="alert alert-dismissible alert-success" style = "margin-top:-22px">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Well done!</strong> Your project has been successfully added</a>.
        </div>';

  }
?>

<div class="container">
  <form method="post" enctype="multipart/form-data" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="projectName" class="col-lg-2 control-label">Campaign Name:</label>
      <div class="col-lg-5">
        <input type="text" class="form-control" name="projname" placeholder="Campaign Name" required="">
      </div>
    </div>
    
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Campaign Description:</label>
      <div class="col-lg-6">
        <textarea class="form-control" rows="3" name="projdesc"></textarea>
        <span class="help-block">A short description about the campaign</span>
      </div>
    </div>

    <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Min Funding Required :</label>
      <div class="col-lg-2">
        <input type="number" class="form-control" name="minamt" placeholder="$" required="">
      </div>
    </div>

    <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Max Funding Limit :</label>
      <div class="col-lg-2">
        <input type="number" class="form-control" name="maxamt" placeholder="$" required="">
      </div>
    </div>

    <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Campaign Last Date:</label>
      <div class="col-lg-3">
        <input type="date" class="form-control" name="penddate" required="">
      </div>
    </div>

     <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Completion Date:</label>
      <div class="col-lg-3">
        <input type="date" class="form-control" name="pcompdate" required="">
      </div>
    </div>

    <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Campaign Cover Image:</label>
      <div class="col-lg-4">
        <input class="input-group" type="file" name="covpic" accept="image/*" style="margin-top: 12px"/>
      </div>
    </div>

    <div class="form-group">
      <label for="tags" class="col-lg-2 control-label">Tags:</label>
      <div class="col-lg-6">
        <input type="text" class="form-control" name="tags" placeholder="Separate tags by comma (,)" required="">
      </div>
    </div>

    <div class="form-group">
      <label for="location" class="col-lg-2 control-label">Location:</label>
      <div class="col-lg-3">
        <input type="text" class="form-control" name="location" placeholder="Location" required="">
      </div>
    </div>


    <br>
    <div class="form-group">
      <div class="col-lg-8 col-lg-offset-2">
        <button type="submit" class="btn btn-primary" name="btncancel" style="margin-right: 15px;" formnovalidate>Cancel</button>
        <button type="submit" class="btn btn-info" name="btnsubmit">Submit</button>
      </div>
    </div>

  </fieldset>
  </form>
</div>
  </body>
</html>
