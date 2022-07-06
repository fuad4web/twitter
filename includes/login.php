<?php 
    if(isset($_POST['login']) && !empty($_POST['login'])) {
        //email and password listed from this post is from the database
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($email) or !empty($password)) {
            //this is checking it from databse through the class created
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid Format";
            } else {
                if($getFromU->login($email, md5($password)) === false) {
                    $error = "The email or password is incorrect";
                }
            }
        } else {
            $error = "Please enter Username and Password";
        }
    }
?>

<div class="login-div">
    <form method="post"> 
	<ul>
		<li>
		  <input type="text" name="email" placeholder="Please enter your Email here"/>
		</li>
		<li>
          <input type="password" name="password" placeholder="password"/>
          <input type="submit" name="login" value="Log in"/>
		</li>&nbsp;&nbsp;
		<li>
		  <input type="checkbox" Value="Remember me">&nbsp;&nbsp;Remember me
		</li>
    </ul>
    <?php 
        if(isset($error)) {
            echo '<li class="error-li" name="error"><div class="span-fp-error">'.$error.'</div></li>';
        }
    ?> 
	</form>
</div>
