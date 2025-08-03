<?php if(isset($msg)) : ?>
  	<div class="updated notice is-dismissible"> 
		<p><strong><?php echo($msg); ?></strong></p>
	</div>
<?php elseif(isset($msge)) : ?>	
	<div class="error notice is-dismissible">
	    <p><strong><?php echo($msge); ?></strong></p>
	</div>
<?php endif; ?>