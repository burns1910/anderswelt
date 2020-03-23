$(document).ready(function(){
  var dataTable = $('#roleTable').DataTable({
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
        'url':'../persistence/controller/role_form_controller.php',
        'data' : {action:'listRoles'}
    },
    'columns': [
        { data: 'id' },
        { data: 'name' },
        { data: 'update', "orderable": false },
        { data: 'delete', "orderable": false }
    ]
  });
  $('#addRole').click(function(){
    $('#roleModal').modal('show');
    $('#roleForm')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Rolle hinzuf&uuml;gen");
    $('#action').val('addRole');
    $('#save').val('hinzufügen');
  });
  $("#roleModal").on('submit','#roleForm', function(event){
    event.preventDefault();
    $('#save').attr('disabled','disabled');
    var formData = $(this).serialize();
    $.ajax({
      url:"../persistence/controller/role_form_controller.php",
      method:"POST",
      data:formData,
      dataType:"json",
      success:function(data){
        $('#roleForm')[0].reset();
        $('#roleModal').modal('hide');
        $('#save').attr('disabled', false);
        dataTable.ajax.reload();
      }
    })
  });
  $("#roleTable").on('click', '.delete', function(){
    var roleId = $(this).attr("id");
    var action = "deleteRole";
    if(confirm("Bist du dir sicher?")) {
      $.ajax({
        url:"../persistence/controller/role_form_controller.php",
        method:"POST",
        data:{roleId:roleId, action:action},
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
  $("#roleTable").on('click', '.update', function(){
    var roleId = $(this).attr("id");
    var action = 'getRole';
    $.ajax({
      url:'../persistence/controller/role_form_controller.php',
      method:"POST",
      data:{roleId:roleId, action:action},
      dataType:"json",
      success:function(data){
        $('#roleModal').modal('show');
        $('#roleId').val(data.id);
        $('#roleName').val(data.name);
        $('#roleDescription').val(data.description);
        $('#rolePermissions').val(data.permissions);
        $('.modal-title').html("<i class='fa fa-plus'></i> Rolle bearbeiten");
        $('#action').val('updateRole');
        $('#save').val('Speichern');
        dataTable.ajax.reload();
        setMessage(data);
      }
    })
  });
});
