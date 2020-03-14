<?php
include '../config.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {

?>
  <div class="container">
    <?php include '../utils/messages.php' ?>
    <h2>Berechtigungen</h2>
    <button type="button" name="add" id="addPermission" class="btn btn-primary">+ hinzuf&uuml;gen</button>
    <table id="permTable" class="table table-hover display dataTable">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
    </table>

    <!-- Script -->
    <script>

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
            { data: 'update' },
            { data: 'delete' },
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
          success:function(data){
            $('#permissionForm')[0].reset();
            $('#permissionModal').modal('hide');
            $('#save').attr('disabled', false);
            dataTable.ajax.reload();
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
            success:function(data) {
              dataTable.ajax.reload();
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

    </script>

  <div class="modal fade" id="permissionModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Berechtigung anpassen</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" action="" id="permissionForm" class="needs-validation" novalidate>
              <div class="form-group">
                  <label for="permName">Name</label>
                  <input type="text" class="form-control" id="permName" name="permName" required />
              </div>
              <div class="form-group">
                  <label for="permDescription">Beschreibung</label>
                  <textarea class="form-control" id="permDescription" name="permDescription" rows="5" required></textarea>
              </div>
              <input type="hidden" name="permId" id="permId" />
              <input type="hidden" name="action" id="action" />
              <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
              <button type="button" class="btn btn-default" data-dismiss="modal">X</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
}
include BASE_PATH.'/footer.php';
?>
