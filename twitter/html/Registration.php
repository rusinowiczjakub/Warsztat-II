<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Warsztat II</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 542px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    .col-centered{
    margin: 0 auto;
    float: none;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href=""><span class="glyphicon glyphicon-log-in"></span> Register</a></li>
        <li><a href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    </div>
    <div class="col-sm-8 text-left"> 
        <form method="POST" action="" >
            <div class="col-sm-8 col-md-9 col-md-offset-4" style="min-width: 270px;">
                <label for="username">Username</label>
                <input name="username" class="form-control" id="inputdefault" type="text" style="width:30%">
            </div>
            <div class="col-sm-8 col-md-9 col-md-offset-4" style="min-width: 270px;">
                <label for="email">E-mail</label>
                <input name="email" class="form-control" id="inputdefault" type="email" style="width:30%">
            </div>
            <div class="col-sm-8 col-md-9 col-md-offset-4" style="min-width: 270px;">
                <label for="password">Password</label>
                <input name="password" class="form-control" id="inputdefault" type="password" style="width:30%">
            </div>
            <div class="col-sm-8 col-md-9 col-md-offset-4" style="min-width: 270px;">
                <label for="password_valid">Confirm password</label>
                <input name="password_valid" class="form-control" id="inputdefault" type="password" style="width:30%"><br>
            </div>
            <div class="col-md-11 text-center">
                <input type="submit" class="col-md-2 col-md-offset-5 btn btn-info" value="SIGN-UP"></input>
            </div>
        </form>
        <div class="col-md-11 text-center">
        <?php
        
        require '../Class/User.php';
//        require '../config.php';
        
        
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){


            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            if($_POST['password'] === $_POST['password_valid'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){


                try{
                    $user = new User();
                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setPass($password);
                    $user->saveToDB($conn);

                } catch (Exception $ex) {
                    echo "Registration failed" . $ex->getMessage();
                }
                }elseif($_POST['password'] != $_POST['password_valid'] && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    echo "Password confirmation is invalid" . "<br>" . "Email is not valid";
                }elseif($_POST['password'] != $_POST['password_valid']){
                    echo "Password confirmation is invalid ";
                }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    echo "Email is not valid ";
                }   
            }
        }
                 
            
        ?>
        </div>
    </div>
    <div class="col-sm-2 sidenav">
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Simple like-a-Twitter app</p>
  <p>Jakub Rusinowicz</p>
</footer>

</body>
</html>
