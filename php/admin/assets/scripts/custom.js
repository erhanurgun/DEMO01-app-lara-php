const isCheck = (is, item) => {
    if ($(is).is(":checked")) {
        $(item).show();
    } else {
        if ($(item).is(":checkbox")) {
            $(item).prop("checked", false);
           } else {
            $(item).hide();
        }
    }
};
// ----------------------------------
$(document).ready(function () {
    isCheck("#checkPass", "#showAllPass");
    isCheck("#checkImage", "#showImage");
    isCheck("#checkBtn", "#showBtn");
});
// ----------------------------------
$("#checkPass").click(function () {
    isCheck(this, "#showAllPass");
});

$("#checkImage").click(function () {
    isCheck(this, "#showImage");
    if ($("#checkImage").is(":checked")) {
        $("#selectImg").attr('required', true);
    } else {
        $("#selectImg").attr('required', false);
    }
});
// ----------------------------------
$("#checkBtn").click(function () {
    isCheck(this, "#showBtn");
});

$("#checkAllPerm").click(function () {
    $(".check").prop("checked", this.checked);
});

$("#checkAllImg").click(function () {
    $(".check").prop("checked", this.checked);
});

$("#checkAllInput").click(function () {
    $(".check-data").prop("checked", this.checked);
    isCheck(this, "#delSelectedData");
    if ($(this).is(":checked")) {
        $('[name="select_all"]').val('yes');
    } else {
        $('[name="select_all"]').val('no');
    }
});

$(".check-data").click(function () {
    isCheck(".check-data", "#delSelectedData");
    isCheck(".check-data", "#checkAllInput");
});
// ----------------------------------
$(".check").click(function () {
    if ($(".check").is(':checked')) {
        $("#otherProces").click();
    } else {
        $("#addNewImage").click();
    }
});
// ----------------------------------
let countItem = $("#itemCount").val();
const addNewItem = (id) => {
    $(id).append(
        '<div class="form-content eu-mb-2">' +
        '<input type="text" name="item_' + ++countItem + '[item]"' +
        ' placeholder="yeni özellik giriniz...">' +
        '</div>\n'
    );
    $('#itemCount').val(countItem);
}
const removeOldItem = (id) => {
    $(id).children("div:last").remove();
    $('#itemCount').val(--countItem);
}
$('#addNewItem').on('click', function () {
    addNewItem('#allItems');
});
$('#removeOldItem').on('click', function () {
    removeOldItem('#allItems');
});
// ----------------------------------