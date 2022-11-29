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
