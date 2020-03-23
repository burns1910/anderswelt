$(document).ready(function(){
  var dataTable = $('#permTable').DataTable({
    'language': {
      "lengthMenu": "_MENU_ Eintr&auml;ge pro Seite",
      "emptyTable": "Noch keine Eintr&auml;ge gespeichert",
      "zeroRecords": "Nix gefunden, sorry",
      "search": "Suchen:",
      "info": "Seite _PAGE_ von _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)",
      "paginate": {
          "first":      "Start",
          "last":       "Ende",
          "next":       "Vor",
          "previous":   "Zur&uuml;ck"
      }
    },
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
        'url':'../persistence/controller/permission_form_controller.php',
        'data' : {action:'listPermissions'}
    },
    'columns': [
        { data: 'id' },
        { data: 'name' },
        { data: 'update', "orderable": false },
        { data: 'delete', "orderable": false }
    ]
  });
  $('#addPermission').click(function(){
    $('#permissionModal').modal('show');
    $('#permissionForm')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Berechtigung hinzuf&uuml;gen");
    $('#action').val('addPermission');
    $('#save').val('hinzufügen');
  });
  $("#permissionModal").on('submit','#permissionForm', function(event){
    event.preventDefault();
    $('#save').attr('disabled','disabled');
    var formData = $(this).serialize();
    $.ajax({
      url:"../persistence/controller/permission_form_controller.php",
      method:"POST",
      data:formData,
      dataType: "json",
      success:function(data){
        $('#permissionForm')[0].reset();
        $('#permissionModal').modal('hide');
        $('#save').attr('disabled', false);
        dataTable.ajax.reload();
        setMessage(data);
      }
    })
  });
  $("#permTable").on('click', '.delete', function(){
    var permId = $(this).attr("id");
    var action = "deletePermission";
    if(confirm("Bist du dir sicher?")) {
      $.ajax({
        url:"../persistence/controller/permission_form_controller.php",
        method:"POST",
        data:{permId:permId, action:action},
        dataType:"json",
        success:function(data) {
          dataTable.ajax.reload();
          setMessage(data);
        }
      })
    } else {
      return false;
    }
  });
  $("#permTable").on('click', '.update', function(){
    var permId = $(this).attr("id");
    var action = 'getPermission';
    $.ajax({
      url:'../persistence/controller/permission_form_controller.php',
      method:"POST",
      data:{permId:permId, action:action},
      dataType:"json",
      success:function(data){
        $('#permissionModal').modal('show');
        $('#permId').val(data.id);
        $('#permName').val(data.name);
        $('#permDescription').val(data.description);
        $('.modal-title').html("<i class='fa fa-plus'></i> Berechtigung bearbeiten");
        $('#action').val('updatePermission');
        $('#save').val('Speichern');
      }
    })
  });
});
