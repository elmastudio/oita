(function ($) {
	$(
		function () {
			$( 'div[data-dismissible] button.notice-dismiss' ).click(
				function (event) {
					event.preventDefault();
					var $this = $( this );

					var option_name, data;

					option_name = $this.parent().attr( 'data-dismissible' );

					data = {
						'action': 'dismiss_admin_notice',
						'option_name': option_name,
						'nonce': dismissible_notice.nonce
					};

					$.post( ajaxurl, data );
				}
			);
		}
	)
}(jQuery));
