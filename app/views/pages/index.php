	<div class="world-table">
			<?php for( $i = 0; $i < 10000; $i++ ): ?>
				<?php if ( isset( $data[ $i ] ) ): ?>
					<?php if ( $data[ $i ][ 'type' ] === 'base' ): ?>
						<div class="cell cell-base" id="<?= $i ?>"></div>
					<?php else: ?>
						<div class="cell base-<?=$data[ $i ][ 'type' ] ?>" id="<?= $i ?>"></div>
					<?php endif; ?>
				<?php else: ?>
					<div class="cell cell-sea" id="<?= $i ?>"></div>
				<?php endif; ?>
			<?php endfor;?>
	</div>