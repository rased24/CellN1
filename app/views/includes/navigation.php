<div class="navbar">
	<nav class="top-nav">
		<ul>
			<li>
				<a href="<?= URLROOT ?>">Home</a>
			</li>
			<?php if ( isset( $_SESSION[ 'token' ] ) ): ?>
				<li>
					<a href="<?= URLROOT ?>/">
						<?= Store::$player->username ?>
					</a>
				</li>
				<li>
					<a href="<?= URLROOT ?>/players/logout">Logout</a>
				</li>
			<?php else: ?>
				<li>
					<a href="<?= URLROOT ?>/players/login">Login</a>
				</li>
				<li>
					<a href="<?= URLROOT ?>/players/register">Register</a>
				</li>
			<?php endif; ?>
		</ul>
	</nav>
</div>