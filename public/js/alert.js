
		$(document).on('click', '#success', function(e) {
			swal(
				'Success',
				'You clicked the <b style="color:green;">Success</b> button!',
				'success'
			)
		});


		$(document).on('click', '#error', function(e) {
			swal(
				'Error!',
				'You clicked the <b style="color:red;">error</b> button!',
				'error'
			)
		});

		$(document).on('click', '#warning', function(e) {
			swal(
				'Warning!',
				'You clicked the <b style="color:coral;">warning</b> button!',
				'warning'
			)
		});

		$(document).on('click', '#info', function(e) {
			swal(
				'Info!',
				'You clicked the <b style="color:cornflowerblue;">info</b> button!',
				'info'
			)
		});
