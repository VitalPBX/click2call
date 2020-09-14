$(document).ready(function () {
  var callButtons = $(".click2call");

  callButtons.unbind('click');
  callButtons.on('click',function () {
	var callee = $(this).attr('data-phone');
	var caller = $(this).attr('data-extension');

	sendNotification("Call In Progress...", "Calling number " + callee + " from extension/number" + caller);

	  $.ajax({
		  dataType: 'json',
		  type: "POST",
		  timeout: 60000,
		  url: window.location.pathname,
		  data: {callee: callee, caller: caller},
		  success: function (data) {
		  	sendNotification("Call Sent", data.msg);
		  },
		  error: function (data) {
		  	sendNotification('Error Happened', data.responseText)
		  }
	  });
  });

    /* Initialize toast notifications*/
	$('.toast').toast({
		animation: true,
		autohide: true,
		delay: 8000
	});

});

/**
 * Dynamically modify/create notifications
 * @param title
 * @param body
 */
function sendNotification(title, body) {
	$("#notification-title").html(title);
	$("#notification-body").html("<p>"+ body +"</p>");

	$("#notifications").toast('show');
}