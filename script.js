function raise_error(message) {
	$('#alertbox').append(`	<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                	<strong>Warning!</strong> ` + message + `
                                	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        	<span aria-hidden="true">&times;</span>
                                	</button>
                        	</div>`);

	setTimeout(function() {
		$('.alert').fadeTo(2000,500).slideUp(500, function() {
			$('.alert').remove();	
		});
	}, 1000);

}

