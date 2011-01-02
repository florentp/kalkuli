(function($) {
    $.extend({
        doGet: function(url, params) {
			if (params)
				url += '?' + $.param(params);
            window.location.href = url;
        },
        doPost: function(url, params) {
            var $form = $("<form>")
                .attr("method", "post")
                .attr("action", url);
            $.each(params, function(name, value) {
                $("<input type='hidden'>")
                    .attr("name", name)
                    .attr("value", value)
                    .appendTo($form);
            });
            $form.appendTo("body");
            $form.submit();
        }
    });
})(jQuery);
