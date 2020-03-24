$(document).ready(function(){
  var dataTable = $('#userTable').DataTable({
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
        'url':'../persistence/controller/user_form_controller.php',
        'data' : {action:'listUsers'}
    },
    'columns': [
        { data: 'id' },
        { data: 'vorname' },
        { data: 'nachname' },
        { data: 'email' },
        { data: 'role', "orderable": false },
        { data: 'update', "orderable": false },
        { data: 'delete', "orderable": false }
    ]
  });
  $("#userModal").on('submit','#userForm', function(event){
    event.preventDefault();
    $('#save').attr('disabled','disabled');
    var formData = $(this).serialize();
    $.ajax({
      url:"../persistence/controller/user_form_controller.php",
      method:"POST",
      data:formData,
      dataType:"json",
      success:function(data){
        $('#userForm')[0].reset();
        $('#userModal').modal('hide');
        $('#save').attr('disabled', false);
        dataTable.ajax.reload();
        setMessage(data);
      }
    })
  });
  $("#userTable").on('click', '.delete', function(){
    var userId = $(this).attr("id");
    var action = "deleteUser";
    if(confirm("Bist du dir sicher?")) {
      $.ajax({
        url:"../persistence/controller/user_form_controller.php",
        method:"POST",
        data:{userId:userId, action:action},
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
  $("#userTable").on('click', '.update', function(){
    var userId = $(this).attr("id");
    var action = 'getUser';
    $.ajax({
      url:'../persistence/controller/user_form_controller.php',
      method:"POST",
      data:{userId:userId, action:action},
      dataType:"json",
      success:function(data){
        $('#userModal').modal('show');
        $('#userId').val(data.id);
        $('#userVorname').val(data.vorname);
        $('#userNachname').val(data.nachname);
        $('#userEmail').val(data.email);
        $('#userRole').val(data.role_id);
        $('.modal-title').html("<i class='fa fa-plus'></i> Rolle zuweisen");
        $('#action').val('updateUser');
        $('#save').val('Speichern');
      }
    })
  });

//  $(document).ready(function () {
      $('.bd-toc-item').on('click', function () {
          $(this).toggleClass('active');
      });
      $('.nav-item').on('click', function () {
          $(this).toggleClass('active');
      });
//  });
});
