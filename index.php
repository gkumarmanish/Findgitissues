<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
        
            <title>
               Fing Git Issues
            </title>
<style type="text/css">
body {
	background-color: white;
	margin:80px 80px 100px 100px;
}
div#fixedheader {
	position:fixed;
	top:0px;
	left:0px;
	width:100%;
	color:white;
	background:#333;
	padding:-10px;
}
div#fixedfooter {
	position:fixed;
	bottom:0px;
	left:0px;
	width:100%;
	color:#CCC;
	background:#333;
	padding:8px;
}

/*tr:nth-child(odd) {
    background-color: #dddddd;
}*/

.ui-autocomplete {
    position: absolute;
    z-index: 1000;
    cursor: default;
    padding: 0;
    margin-top: 2px;
    list-style: none;
    background-color: #ffffff;
    border: 1px solid #ccc;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
       -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}
.ui-autocomplete > li {
  padding: 3px 20px;
}
.ui-autocomplete > li.ui-state-focus {
  background-color: #DDD;
}
.ui-helper-hidden-accessible {
  display: none;
}

</style>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
 	
<body>
    <div class="navbar navbar-default navbar-fixed-top" style="background-color: #333;">
    <div class="container">
      <div class="navbar-header">
          <a class="navbar-brand" href="" style="color: white;">Find Git Issues</a>
      </div>
     
    </div>
  </div>
<br><br>
<div class="container-fluid">
    <br><br>
    <div class="col-md-12">   
<div class="col-md-3"></div>
    <div class="col-md-6">
        
        <form action="submit.php" method="POST">
            <input class="form-control" type="text" name="url" placeholder="Please Enter the path of Git Repository" >
            <button style="float:right;" type="submit" class="btn btn-primary">Go</button>
        </form>
         <br>
          <br> 
          <br> 
         <?php 
         if($_SESSION && empty($_SESSION['error'])){
         ?>
         <div id="third_div">
<h2>Git Issues Report</h2>   
                        <table class="table table-bordered">
              
          <tr>
          <td>
            Total number of open issues
          </td>
          <td>
          <?php
echo $_SESSION['total_issues'];
?>

          </td>
          
          </tr>
          <tr>
            <td>Number of open issues that were opened in the last 24 hours</td><td><?php
echo $_SESSION['last24_issues'];
?>

          </td>
          </tr>
          <tr>
            <td>Number of open issues that were opened more than 24 hours ago but less than 7 days ago</td><td><?php
echo $_SESSION['last7days_issues'];
?>
          </td>
          </tr>
          <tr>
            <td> Number of open issues that were opened more than 7 days ago </td><td><?php
echo $_SESSION['morethan7days_issues'];
?>
          </td>
          </tr>
          </table>
    </div>
         <?php 
         }
         else if(!empty($_SESSION)){
           
            echo "<span style = 'color:red'><b>Invalid Url!! Url format is : <br>https://github.com/{org_name or username}/{repo_name}/<br></b></span>";
           
         }
         session_destroy();
         ?>
    </div>    
        
    </div>    
  </div>

 
<div id="fixedfooter"></div>
</body>
</html>
