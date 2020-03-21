var msgDismissButton = '<button type="button" class="close">&times;</button>';
function setMessage(data) {
  $('div.'+data.msgType).html(msgDismissButton);
  $('div.'+data.msgType).append(data.msgText);
  if($('div.'+data.msgType).is('[hidden]')) {
    $('div.'+data.msgType).attr('hidden', false);
  }
  $('.close').on('click', function() {
    if(!$(this).parent().is('[hidden]')) {
      $(this).parent().attr('hidden', true);
    }
  });
}
