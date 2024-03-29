<?php 
/*
 * Author        :   BARATHI/KARPAGAM
 * Date          :   03-07-2019
 * Modified      :   
 * Modified By   :   
 * Description   :  
 */
?>
<?php
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}
require_once("config/db.php");
require_once("classes/Login.php");
$login = new Login();
if ($login->isUserLoggedIn() == true) {
   header("location: dashboard.php");
} else {
    ?>
	<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Virran Invoice | Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
 <div class="container">
        <div class="card card-container">
            <img id="profile-img" style="margin-left: 107px;"src="img/logo-round.jpg" />
            <p id="profile-name" class="profile-name-card"></p>
            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
			<?php
				
                        if (isset($login)) {
                                if ($login->errors) {
                                        ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <strong>Error!</strong> 

                                        <?php 
                                        foreach ($login->errors as $error) {
                                                echo $error;
                                        }
                                        ?>
                                        </div>
                                        <?php
                                }
                                if ($login->messages) {
                                        ?>
				<div class="alert alert-success alert-dismissible" role="alert" style="color: #f5f6f5;
                                 background-color: #428e23;border-color: #518a22;" >
						    <strong >Notice!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
                <span id="reauth-email" class="reauth-email"></span>
                <input class="form-control" placeholder="username" name="user_name" type="text" value="" autofocus="" required>
                <input class="form-control" placeholder="userpassword" name="user_password" type="password" value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-danger btn-block btn-signin" name="login" id="submit">submit</button>
            </form>
            
        </div>
    </div>
  </body>
</html>

<?php
}
?>



