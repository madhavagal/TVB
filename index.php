<!DOCTYPE html>
<?php include('server.php')?>

<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="assets1/logo.png">
  <title>TVB Review Portal</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap-grid.min.css">
  <!--  Make sure your always using the latest version of Bootstrap here-->
  <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="login.css?v=<?=time();?>">
  <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
</head>

<body class="login-body">
  <br><br><br><br><br>
  <div class="container login-container">
    <div class="row">
      <div class="col"></div>
      <div class="col-md-6">
        <div class="card signin-card">
          <div class="card-block">
            <div class="row">
              <div class="col"></div>
              <div class="col-md-6"><a href="http://www.thevalleybootcamp.com" ><img src="assets1/logo.png" class="img-fluid signin-img"></a></div>
              <div class="col"></div>
            </div>
            <form class="signin-form" method="post" action="index.php">
              <?php include('errors.php');?>
              <div class="form-group">
                <div class="row">
                  <div class="col-4">
                    <p class="loginas">Sign In as </p>
                  </div>
                  <div class="col-8">
                    <select class="form-control form-control-sm" name="cat">
                      <option value="student" selected>Student</option>
                      <option value="teacher">Teacher</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="form-group">
                <input type="email" class="form-control" id="emailInput" placeholder="Email" name="email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" id=passwordInput placeholder="Password" name="password">
              </div>
              <button name="signin" type="submit" class="btn signin-btn btn-lg" style="font-family: Oswald;">Sign In</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>

</html>
