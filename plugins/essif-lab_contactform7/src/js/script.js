(function ($) {
	$(window).load(function () {
        $(".wpcf7 .essif-lab").click(function (e) {
            e.preventDefault();
            redirectToWallet($(this)[0].name, $(this));
        });

        function redirectToWallet(name)
        {
            const callbackUrl = window.location.href + "/wp-json/";
            $.ajax({
                type: 'GET',
                url: '../wp-json/jwt/v1/callbackurl=' + callbackUrl + '&inputslug=' + name,
                success: function (data) {
                    if (data != null) {
                        const redirectUrl = 'https://service.ssi-lab.sensorlab.tno.nl/verify/' + data;
                        window.location.href = redirectUrl;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus + errorThrown);
                }
            });
        }
    });
})(jQuery);
