$(function() {
	var form = $('#contact-form');
	if (!form.length) {
		return;
	}

	var formMessages = form.find('.form-message');
	if (!formMessages.length) {
		formMessages = $('<p class="form-message" role="status"></p>').prependTo(form);
	}

	form.on('submit', function(e) {
		e.preventDefault();

		var submitBtn = form.find('[type="submit"]');
		submitBtn.prop('disabled', true);

		$.ajax({
			type: 'POST',
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'Accept': 'application/json',
				'X-CSRF-TOKEN': form.find('input[name="_token"]').val()
			}
		})
		.done(function(response) {
			formMessages.removeClass('error').addClass('success');
			formMessages.text(response.message || 'Votre message a bien été envoyé.');
			form.find('input[name!="_token"], textarea').val('');
		})
		.fail(function(xhr) {
			formMessages.removeClass('success').addClass('error');

			var payload = xhr.responseJSON;
			if (payload && payload.errors) {
				var first = Object.values(payload.errors)[0];
				formMessages.text(Array.isArray(first) ? first[0] : first);
			} else if (payload && payload.message) {
				formMessages.text(payload.message);
			} else {
				formMessages.text('Une erreur est survenue. Votre message n’a pas pu être envoyé.');
			}
		})
		.always(function() {
			submitBtn.prop('disabled', false);
		});
	});
});
