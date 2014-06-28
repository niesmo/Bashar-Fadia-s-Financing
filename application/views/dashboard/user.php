<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
			$hidden = array(); 
			if(isset($user) && $user !== NULL){
				$hidden = array("user_id"=>$user->get_user_id(),
					"avatar"=>$user->get_avatar_name()
					);
			}

			echo heading("Edit your account", 1);
			echo "<hr />";

			if(isset($errors)){
				echo "<div class='row'>";
					echo "<div class='col-md-5'>";
						echo "<ul class='list-unstyled'>";
						foreach($errors as $error){
							echo $error;
						}
						echo "</ul>";
					echo "</div>";
				echo "</div>";
			}

			echo heading("Your avatar", 2);

			//user form
			echo form_open_multipart("dashboard/submit", array("role"=>"form","method"=>"POST"), $hidden);
				
			//avatar
			echo "<div class='form-group'>";
				echo form_upload(array("name"=>"userfile", "class='form-control'"));	
			echo "<p class='help-block'>Please select a file</p>";
			echo "</div>";

			echo "<div class='row'>";
				echo "<div class='col-md-4'>";
					//avatar image
					echo "<div class='form-group'>";
						echo "<img ".(isset($user)?"src='".$user->get_avatar()."'":"data-src='holder.js/240x240'")." alt='avatar' class='img-thumbnail'>";
					echo "</div>";

					//username
					echo "<div class='form-group'>";
						echo form_input(array("name"=>"username", "placeholder"=>"Username", "class"=>"form-control", "value"=>(isset($user)?$user->get_username():"")));
					echo "</div>";
					

					//fullname
					echo "<div class='form-group'>";
						echo form_input(array("name"=>"name", "placeholder"=>"Full name", "class"=>"form-control", "value"=>(isset($user)?$user->get_fullname():"")));
					echo "</div>";
				echo "</div>";
			echo "</div>";

			echo "<hr />";
			echo heading("Save Changes", 2);
			echo form_submit(array("value"=>"Update Profile"));

			echo form_close();
			?>
		</div>
	</div>
</div>