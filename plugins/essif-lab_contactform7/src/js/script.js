(function ($) {
    $(window).load(function () {
        let input
        Object.keys(sessionStorage).map(function (slug) {
            input = $('.' + slug + ' input');
            let value = JSON.parse(sessionStorage.getItem(slug));
            input.val(value.name);
            if (value.immutable === true) input.prop('disabled', value.immutable);
        });

        const urlParams = new URLSearchParams(window.location.search);

        const immutable = urlParams.get('immutable') === 'true';
        urlParams.delete('immutable')

        for (const entry of urlParams.entries()) {
            input = $('.' + entry[0] + ' input');
            input.val(entry[1]);
            if (immutable === true) input.prop('disabled', immutable);
        }
        window.history.replaceState({}, document.title, window.location.href.split('?')[0]);

        $('.wpcf7 .essif-lab.submit').click(function (e) {
            e.preventDefault();
            redirectToWallet($(this)[0].name);
        });

        $('.wpcf7 .essif-lab.reset').click(function (e) {
            e.preventDefault();
            getCredentialInputs($(this)[0].name)
        });

        function redirectToWallet(name)
        {
            const callbackUrl = window.location.href + '../wp-json/jwt/v1/page=' + window.location.href + '&inputslug=' + name + '&jwt=';
            $.ajax({
                type: 'GET',
                url: '../wp-json/jwt/v1/callbackurl=' + callbackUrl + '&inputslug=' + name,
                success: function (data) {
                    if (data != null) {
                        window.location.href = 'https://service.ssi-lab.sensorlab.tno.nl/verify/' + data;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Status: ' + textStatus + errorThrown);
                }
            });
        }

        function getCredentialInputs(name)
        {
            $.ajax({
                type: 'GET',
                url: '../wp-json/jwt/v1/inputs/inputslug=' + name,
                success: function (data) {
                    if (data != null) {
                        data.forEach(function (name) {
                            name = name.replace(' ', '-');
                            input = $('.' + name + ' input');
                            input.val('');
                            input.removeProp('disabled');
                        });
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Status: ' + textStatus + errorThrown);
                }
            });
        }
    });

    $(window).unload(function () {
        $('.wpcf7-form-control').not('.wpcf7-submit, .essif-lab').each(function () {
            if ($(this).val()) {
                sessionStorage.setItem($(this).attr('name'), JSON.stringify({
                    name: $(this).val(),
                    immutable: $(this).prop('disabled')
                }));
            } else {
                sessionStorage.removeItem($(this).attr('name'));
            }
        });
    });
})(jQuery);
