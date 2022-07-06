<?php 
	if(isset($_POST['signup'])) {
		$screenName = $_POST['screenName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$error = '';

		if(empty($screenName) or empty($password) or empty($email)) {
			$error = 'All inputs required';
		} else {
			$email = $getFromU->checkInput($email);
			$password = $getFromU->checkInput($password);
			$screenName = $getFromU->checkInput($screenName);

			if(!filter_var($email)) {
				$error = 'Invalid Email';
			} else if(strlen($screenName) < 7) {
				$error = 'Screen name must be more than 8 characters';
			} else if(strlen($password) < 5) {
				$error = 'Password too short';
			} else {
				if($getFromU->checkEmail($email) === true) {
					$error = 'Email existing';
				} else {
					//$getFromU->register($email, $screenName, $password);
					$user_id = $getFromU->create('users', array('email' => $email, 'screenName' => $screenName, 'password' => md5($password), 'profileImage' => 'assets/images/defaultprofileimage.png', 'profileCover' => 'assets/images/defaultCoverImage.png'));
					$_SESSION['user_id'] = $user_id;
					header('Location: includes/signup.php?step=1');
				}
			}
		}
	}
?>

<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
	</ul>
	<?php 
		if(isset($error)) {
			echo '<li class="error-li"><div class="span-fp-error">'.$error.'</div></li>';
		}
	?> 

</div>
</form>
