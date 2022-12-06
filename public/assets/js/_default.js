$('.uk-form').submit(function (e) {
    const submitBtn = $(this).find('button[type="submit"]');
    submitBtn.attr('disabled', 'true');
    const loader = submitBtn.find("div[uk-spinner]");
    loader.css("display", "inline");
});

$('a.confirmable').click(function (e) {
    e.preventDefault();
    const confirmText = $(this).data('confirm-text') || "Você tem certeza?";
    const href = $(this).attr('href');
    UIkit.modal.confirm(confirmText).then(function() {
        location.href = href;
    }, function () {
       return; 
    });
});

$.fn.selectField = function () {
    const ref = $(this);
    const realInput = $(this).find(".uk-select-realinput");
    const fakeInput = $(this).find(".uk-select-fakeinput");
    // const menu = $(this).find('.uk-custom-select-menu')[0];
    fakeInput.attr('readonly', 'true');
    fakeInput.css('cursor', 'pointer');

    /**
     * Cria popper para posicionamento do menu
     */
    const pureRef = document.querySelector(`#${$(this).attr('id')}`);
    Popper.createPopper(pureRef, pureRef.querySelector('.uk-custom-select-menu'), {
        placement: 'bottom-start',
        strategy: 'absolute'
    });

    /**
     * Ao clicar no fakeInput, mostra ou oculta o menu
     */
    fakeInput.on('click', () => {
        $(this).toggleClass('active');
        $(window).on('click.selectfield', () => {
            $(this).toggleClass('active');
            $(window).off('click.selectfield');
        });
    });

    fakeInput.click(function(event){
        event.stopPropagation();
    });

    $(this).find('.uk-custom-select-item').on('click', function (e) {
        const label = $(this).text();
        const value = $(this).data('value');
        realInput.val(value);
        fakeInput.val(label);
    });
    
    return this;
}