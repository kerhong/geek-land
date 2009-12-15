<h1 class="access_denied">Vous n'avez pas les permissions nécéssaires pour venir sur cette page</h1>
<script type="text/javascript">
	a( function ()
	{
		$( 'h1.access_denied' )
			.addClass( 'error' )
			.wrap( '<p align="center"></p>' )
			.after( '<br /><br />' );
	} );
</script>
<?php anchor( 'index', 'Retourner à l\'acceuil' );