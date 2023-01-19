function contact(formId) {
    if ($(formId).length) {
        $(formId).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true
                },
                phone: "required",
                subject: "required",
                mssg: "required",
            },

            messages: {
                name: {
                    required: "Lütfen adınızı giriniz!",
                    minlength: "Lütfen en az 3 karakter giriniz!",
                },
                email: {
                    required: "Lütfen e-posta adresinizi giriniz!",
                    email: "Lütfen geçerli bir e-posta adresi giriniz!",
                },
                phone: "Lütfen telefon numaranızı giriniz!",
                subject: "Lütfen konuyu giriniz!",
                mssg: "Lütfen mesajınızı giriniz!",
            },
            submitHandler: function () {
                let data = $(formId).serialize();
                $.post(apiUrl + '/send-contact', data, function (response) {
                    if (response.success) {
                        $("#loader").hide();
                        $("#success").slideDown("slow").html(response.success);
                        $('[type="submit"]').attr("disabled", true);
                        setTimeout(function () {
                            $("#success").slideUp("slow");
                            $('[type="submit"]').attr("disabled", false);
                            $(formId).trigger("reset");
                        }, 4000);
                    } else {
                        $("#loader").hide();
                        $("#error").slideDown("slow").html(response.error);
                        setTimeout(function () {
                            $("#error").slideUp("slow");
                        }, 3000);
                    }
                }, 'json');
            },
        });
    }
}

function addNewsletter(formId) {
    if ($(formId).length) {
        $(formId).validate({
            rules: {
                news_name: {
                    required: true,
                    minlength: 3,
                },
                news_email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                news_name: {
                    required: "Lütfen adınızı ve soyadınızı giriniz!",
                    minlength: "Lütfen en az 3 karakter giriniz!",
                },
                news_email: {
                    required: "Lütfen e-posta adresinizi giriniz!",
                    email: "Lütfen geçerli bir e-posta adresi giriniz!",
                }
            },
            submitHandler: function () {
                let data = $(formId).serialize();
                $.post(apiUrl + '/send-newsletter', data, function (response) {
                    if (response.success) {
                        $("#loader").hide();
                        $("#newsSuccess").slideDown("slow").html(response.success);
                        $('[type="submit"]').attr("disabled", true);
                        setTimeout(function () {
                            $("#newsSuccess").slideUp("slow");
                            $('[type="submit"]').attr("disabled", false);
                            $(formId).trigger("reset");
                        }, 4000);
                    } else {
                        $("#loader").hide();
                        $("#newsError").slideDown("slow").html(response.error);
                        setTimeout(function () {
                            $("#newsError").slideUp("slow");
                        }, 3000);
                    }
                }, 'json');
            },
        });
    }
}

function addComment(formId) {
    if ($(formId).length) {
        $(formId).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true
                },
                mssg: "required",
            },

            messages: {
                name: {
                    required: "Lütfen adınızı giriniz!",
                    minlength: "Lütfen en az 3 karakter giriniz!",
                },
                email: {
                    required: "Lütfen e-posta adresinizi giriniz!",
                    email: "Lütfen geçerli bir e-posta adresi giriniz!",
                },
                mssg: "Lütfen mesajınızı giriniz!",
            },
            submitHandler: function () {
                let data = $(formId).serialize();
                $.post(apiUrl + '/send-comment', data, function (response) {
                    if (response.success) {
                        $("#loader").hide();
                        $("#success").slideDown("slow").html(response.success);
                        $('[type="submit"]').attr("disabled", true);
                        setTimeout(function () {
                            $("#success").slideUp("slow");
                            $('[type="submit"]').attr("disabled", false);
                            $(formId).trigger("reset");
                        }, 4000);
                    } else {
                        $("#loader").hide();
                        $("#error").slideDown("slow").html(response.error);
                        setTimeout(function () {
                            $("#error").slideUp("slow");
                        }, 3000);
                    }
                }, 'json');
            },
        });
    }
}

function addPostComment(formId) {
    if ($(formId).length) {
        $(formId).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true
                },
                comment: "required",
            },
            messages: {
                name: {
                    required: "Lütfen adınızı yazınız!",
                    minlength: "Lütfen en az 3 karakter giriniz!",
                },
                email: {
                    required: "Lütfen e-posta adresinizi yazınız!",
                    email: "Lütfen geçerli bir e-posta adresi giriniz!",
                },
                website: {
                    url: "Lütfen website kısmını http ile kullanınız! ÖR: http://urgun.com.tr",
                },
                comment: "Lütfen yorumunuzu yazınız!",
            },
            submitHandler: function () {
                let postId = $(formId).data('id');
                let data = $(formId).serialize() + '&post_id=' + postId;
                $.post(apiUrl + '/send-post-comment', data, function (response) {
                    if (response.success) {
                        $(".res-mssg .success").slideDown("slow").html(response.success);
                        $('[type="submit"]').attr("disabled", true);
                        setTimeout(function () {
                            $(".res-mssg .success").slideUp("slow");
                            $('[type="submit"]').attr("disabled", false);
                            $(formId).trigger("reset");
                        }, 4500);
                    } else {
                        $(".res-mssg .error").slideDown("slow").html(response.error);
                        setTimeout(function () {
                            $(".res-mssg .error").slideUp("slow");
                        }, 4500);
                    }
                }, 'json');
            },
        });
    }
}