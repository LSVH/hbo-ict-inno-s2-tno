(function ($) {
	$(window).load(function () {
        $(".wpcf7 .essif-lab").each(function () {
            console.log($(this)[0]);
            $(this)[0].id = getJWTToken($(this)[0].name);
        });

        $(".wpcf7 .essif-lab").click(function (e) {
            e.preventDefault();
            // sendMockCall();
            // getJWTToken();
        });

        function sendMockCall()
        {
            $.ajax({
				type: 'GET',
				url: 'http://localhost:8000/api/credentialverifyrequest/1',
				success: function (data) {
					if (data != null)
					{
                        console.log(data);
                        $('input[name=postalCode]').val(data["credentialData"]["data"]["postcalCode"]);
                        $('input[name=streetAddress]').val(data["credentialData"]["data"]["streetAddress"]);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + errorThrown);
                }
            });
        }

        function getJWTToken(name)
        {
            let callbackurl = 'google.com';
            $.ajax({
                type: 'GET',
                url: '../wp-json/jwt/v1/callbackurl=' + callbackurl + '&inputslug=' + name,
                success: function (data) {
                    if (data != null) {
                        return data;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + errorThrown);
                }
            });
        }
    });
})(jQuery);
