<?php 
    require 'core/init.php';
    if($getFromU->loggedIn() === false) {
        header('Location: index.php');
    }
    $user_id = $_SESSION['user_id'];
    $user = $getFromU -> userData($user_id);

    if(isset($_POST['screenName'])) {
        if(!empty($_POST['screenName'])) {
            $screenName = $getFromU-> checkInput($_POST['screenName']);
            $profileBio = $getFromU-> checkInput($_POST['bio']);
            $country = $getFromU-> checkInput($_POST['country']);
            $website = $getFromU-> checkInput($_POST['website']);
            if(strlen($screenName) < 5) {
                $error = 'ScreenName too short';
            } else {
                $getFromU->update('users', $user_id, array('screenName' => $screenName, 'bio' => $profileBio, 'country' => $country, 'website' => $website));
                header('Location: '.$user -> username);
            }
        } else {
            $error = 'Name can\'t be blank please';
        }
    }

	if(isset($_FILES['profileImage'])) {
		if(!empty($_FILES['profileImage']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profileImage']);
			$getFromU->update('users', $user_id, array('profileImage' => $fileRoot));
			header('Location:' .$user->username);
		}
	}

	if(isset($_FILES['profileCover'])) {
		if(!empty($_FILES['profileCover']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profileCover']);
			$getFromU->update('users', $user_id, array('profileCover' => $fileRoot));
			header('Location:' .$user->username);
		}
	}
?>

<!doctype html>
<html>
<head>
	<title>Profile edit page</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
	<link rel="stylesheet" href="assets/css/style-complete.css"/>
	<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
</head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
	<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
	<!-- Nav -->
	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
				<l><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
			</ul>
		</div>
		<!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
				<div class="search-result">
					 			
				</div></li>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?= $user->profileImage; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?= $user->username; ?>"><?= $user->username; ?></a></li>
							<li><a href="settings/account">Settings</a></li>
							<li><a href="includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Tweet</label></li>
			</ul>
		</div>
		<!-- nav right ends-->
	</div>
	<!-- nav ends -->
</div>
<!-- nav container ends -->
</div>
<!-- header wrapper end -->

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
	   <!-- PROFILE-COVER -->
		<img src="<?php echo $user->profileCover; ?>"/>
 
		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Change your profile photo
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload photo
								</label>
								<input type="file" onchange="this.form.submit();" name="profileCover" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						TWEETS
					</div>
					<div class="n-bottom">
						0
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
                    <?= $user->following; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
						<?= $user->followers; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
						0
					</div>
				</a>
			</li>
			
		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" value="Cancel" onclick="window.location.href='<?= $user->username; ?>'">Cancel</button>
			</span>
			<span>
				<input type="submit" id="save" value="Save Changes">
			</span>
		 
		</div>
	</div>
</div>
</div><!--Profile Cover End-->

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
		<!--PROFILE INFO WRAPPER END-->
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			<!-- PROFILE-IMAGE -->
			<img src="<?php echo $user->profileImage; ?>"/>
 			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Change your profile photo
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profileImage">
									Upload photo
								</label>
								<input id="profileImage" onchange="this.form.submit();" type="file"  name="profileImage"/>
								
							</li>
							<li><a href="#">Remove</a></li>
							<li>
								<label for="img-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			  <!-- img upload end-->
			</div>
		</div>

			    <form id="editForm" method="post" enctype="multipart/Form-data">	
				<div class="profile-name-wrap">
				<?php
					if(isset($imageError)) {
						echo '<ul>
								<li class="error-li">
									<div class="span-pe-error">'.$imageError.'</div>
								</li>
							</ul>';
					}
				?>
					<div class="profile-name">
						<input type="text" name="screenName" value="<?= $user->screenName; ?>"/>
					</div>
					<div class="profile-tname">
						@<?= $user->username; ?>
					</div>
				</div>
				<div class="profile-bio-wrap">
					<div class="profile-bio-inner">
						<textarea class="status" name="bio"><?= $user->bio; ?></textarea>
						<div class="hash-box">
					 		<ul>
					 		</ul>
					 	</div>
					</div>
				</div>
					<div class="profile-extra-info">
					<div class="profile-extra-inner">
						<ul>
							<li>
								<div class="profile-ex-location">
									<input id="cn" type="text" name="country" placeholder="Country" value="<?= $user->country; ?>" />
								</div>
							</li>
							<li>
								<div class="profile-ex-location">
									<input type="text" name="website" placeholder="Website" value="<?= $user->website; ?>"/>
								</div>
							</li>
				<?php
					if(isset($error)) {
						echo '<li class="error-li">
									<div class="span-pe-error">'.$error.'</div>
								</li>';
					}
				?>
				</form>

                <script type="text/javascript">
                    $('#save').click(function() {
                        $('#editForm').submit();
                    });
                </script>
						</ul>						
					</div>
				</div>

				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Photos and videos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  <!-- <li><img src="#"></li> -->
						</ul>
					</div>
				</div>
			</div>
			<!--PROFILE INFO INNER END-->
		</div>
		<!--PROFILE INFO WRAPPER END-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">	
		<!-- HERE WILL BE TWEETS -->
	</div>
	<!-- in left wrap-->
   <div class="popupTweet"></div>

</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
		<!--==WHO TO FOLLOW==-->
           <!-- HERE -->
		<!--==WHO TO FOLLOW==-->
			
		<!--==TRENDS==-->
 	 	   <!-- HERE -->
	 	<!--==TRENDS==-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in right end -->

   </div>
   <!--in full wrap end-->
 
  </div>
  <!-- in wrappper ends-->

</div>
<!-- ends wrapper -->
</body>
</html>