<div class="container-login">
	<div class="wrapper-login">
		<h2>Sign up</h2>
		<form action="<?= URLROOT ?>/players/register" method="post">
			<input type="text" name="username" placeholder="Username*">
			<span class="invalidFeedback" id="message">
				<?= $data[ 'usernameError' ] ?>
			</span>
			<br>
			<input type="email" name="email" placeholder="Email*">
			<span class="invalidFeedback" id="message">
				<?= $data[ 'emailError' ] ?>
			</span>
			<br>
			<input type="password" name="password" placeholder="Password*">
			<span class="invalidFeedback" id="message">
				<?= $data[ 'passwordError' ] ?>
			</span>
			<br>
			<input type="password" name="confirmPassword" placeholder="Confirm Password*">
			<span class="invalidFeedback" id="message">
				<?= $data[ 'confirmPasswordError' ] ?>
			</span>
			<br>
			<button type="submit" id="submit" name="submit" value="submit">submit</button>
			<p class="options">Already have an account?
				<a href="<?= URLROOT ?>/players/login">Sign in!</a>
			</p>
		</form>
	</div>
</div>