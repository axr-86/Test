(function() {
	'use strict';
	window.addEventListener('load', function() {

		var form = document.getElementById('feedback-form');

		form.addEventListener('submit', function(event) {

			event.preventDefault();
			event.stopPropagation();

			$('#ajax-response').html('');

			if (form.checkValidity() === true) {

				var feedbackData = {
					'ajax_mode': 'Y',
					'fio': $('#fio').val(),
					'email': $('#email').val(),
					'phone': $('#phone').val(),
					'events': $('#events').val()
				};

				JSON.stringify(feedbackData);

				$.ajax({
					type: 'POST',
					data: feedbackData,
					cache: false,
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					success: function (response) {
						var data = JSON.parse(response);

						if (data.result === 'ok') {
							$('#fio').val('');
							$('#email').val('');
							$('#phone').val('');
							$('#events').val('');
							form.classList.remove('was-validated');

							$('#ajax-response').html('<div class="alert alert-success" role="alert">Заявка успешно отправлена.</div>');
						}
						else if (data.result === 'error') {
							$('#ajax-response').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
						}
					},
					error: function (xhr, textStatus, error) {
						console.log(xhr.statusText);

					}
				});

			}

			form.classList.add('was-validated');
		});

		$('#phone').mask('+7 (999) 999-99-99');

	}, false);
})();
