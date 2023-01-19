function sendEmail(formId) {
  $(formId + " button").attr("disabled", true);
  let data = $(formId).serialize();
  let message = "";
  if ($("#message_ifr").length) {
    message = $("#message_ifr").contents().find("body").html();
    data += "&message=" + message;
  }
  $.post(
    apiUrl + "/send-email",
    data,
    function (response) {
      if (response.error) {
        $("#success").hide();
        $("#error").show().html(response.error);
      } else {
        $("#error").hide();
        $("#success").show().html(response.success);
        $(formId + " textarea").val("");
      }
      $(formId + " button").attr("disabled", false);
    },
    "json"
  );
}
