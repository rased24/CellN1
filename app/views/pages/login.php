<div class="container-login">
	<div class="wrapper-login">
		<h2>Sign in</h2>
		<form action="<?= URLROOT ?>/players/login" method="post">
			<input type="text" name="email" placeholder="Email*">
			<br>
			<span class="invalidFeedback" id="message">
				<?= $data[ 'emailError' ] ?>
			</span>
			<br>
			<input type="password" name="password" placeholder="Password*">
			<br>
			<span class="invalidFeedback" id="message">
				<?= $data[ 'passwordError' ] ?>
			</span>
			<br>
			<button type="submit" id="submit" name="submit" value="submit">submit</button>
			<p class="options">Not registered yet?
				<a href="<?= URLROOT ?>/players/register">Create an account!</a>
			</p>
		</form>
	</div>
</div>