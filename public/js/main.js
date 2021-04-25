( function ( $ ) {

	let ajaxUrl = $( '#myUrlRoot' ).val();

	let CellN1 = {
		loadModal: ( func_name, data ) => {
			$.ajax( {
				method: 'POST',
				dataType: 'json',
				url: ajaxUrl + '/Cells/' + func_name,
				data: data,
				success: function ( response ) {
					$( '.modal-content div' ).html( response.html );
					$( '#myModal' ).show();
				}
			} );
		}
	};

	$( '.cell' ).on( 'click', function () {

		CellN1.loadModal( 'get_cell_info', { id:  $( this ).attr( 'id' ) } );
	} );

	$( '#closeModal' ).on( 'click', function () {
		$( '#myModal' ).hide();
	} )


	$( document ).on( 'click', '#save-country' , function () {
		$.ajax( {
			method: 'POST',
			dataType: 'json',
			url:  ajaxUrl + '/Cells/createCountry',
			data: {
				id: $( '#cell-id' ).val(),
				name: $( '#country-name' ).val()
			}, success: function ()
			{
				location.reload();
			}
		} );
	} );
} )( jQuery )


/*
response.cells.forEach( cell => {

					switch ( cell[ 'type' ] )
					{
						case 'base':
							document.getElementById( cell[ 'id' ] ).classList.add( 'cell-base' );
							break;
						case 'cave':
							document.getElementById( cell[ 'id' ] ).classList.add( 'base-cave' );
							break;
						case 'lab':
							document.getElementById( cell[ 'id' ] ).classList.add( 'base-lab' );
							break;
						case 'forest':
							document.getElementById( cell[ 'id' ] ).classList.add( 'base-forest' );
							break;
						case 'army':
							document.getElementById( cell[ 'id' ] ).classList.add( 'base-army' );
							break;
					}
					document.getElementById( cell[ 'id' ] ).classList.remove( 'cell-sea' )
				} );
*/