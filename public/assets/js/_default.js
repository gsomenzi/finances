$('.uk-form').submit(function (e) {
    const submitBtn = $(this).find('button[type="submit"]');
    submitBtn.attr('disabled', 'true');
    const loader = submitBtn.find("div[uk-spinner]");
    loader.css("display", "inline");
});