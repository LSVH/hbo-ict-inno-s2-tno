(function ($) {
    $(window).load(function () {
        const urlParams = new URLSearchParams(window.location.search);

        const immutable = urlParams.get("immutable") === 'true';
        urlParams.delete("immutable")

        let input;
        for (const entry of urlParams.entries()) {
            input = $("." + entry[0] + " input");
            input.val(entry[1]);
            if (immutable === true) input.prop("disabled", immutable);
        }
        window.history.replaceState({}, document.title, window.location.href.split("?")[0]);

        $(".wpcf7 .essif-lab").click(function (e) {
            e.preventDefault();
            redirectToWallet($(this)[0].name, $(this));
        });

        function redirectToWallet(name)
        {
            const callbackUrl = window.location.href + "../wp-json/jwt/v1/page=" + window.location.href + "&inputslug=" + name + "&jwt=";
            $.ajax({
                type: 'GET',
                url: '../wp-json/jwt/v1/callbackurl=' + callbackUrl + '&inputslug=' + name,
                success: function (data) {
                    if (data != null) {
                        window.location.href = 'https://service.ssi-lab.sensorlab.tno.nl/verify/' + data;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus + errorThrown);
                }
            });
        }
    });
})(jQuery);
