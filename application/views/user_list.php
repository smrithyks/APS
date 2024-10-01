<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php if(!empty($users)){ ?>
    <h1>Users</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Parent ID</th>
            <th>Level</th>
        </tr>
        <?php foreach ($users as $user){ ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->username; ?></td>
            <td><?php echo $user->parent_id; ?></td>
            <td><?php echo $user->level; ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>

    <h2>Add User</h2>
    <form id="addUserForm">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="number" name="parent_id" id="parent_id" placeholder="Parent ID (optional)">
        <button type="button" id="addUserButton" onclick="adduser();">Add User</button>
    </form>
    
    <h2>Record Sale</h2>
    <form id="recordSaleForm">
        <input type="number" name="user_id" id="user_id" placeholder="User ID" required>
        <input type="number" name="amount" id="amount" placeholder="Sale Amount" required>
        <button type="button" id="recordSaleButton" onclick="recordsale();">Record Sale</button>
        <button type="button" id="commissionButton" onclick="viewcommission();"> View Commission</button>
    </form>
    <div id="commission_chart"></div>

    <script>
        $(document).ready(function() {
            $('#commissionButton').hide();
        });
        function adduser(){
                var formData = $('#addUserForm').serialize();
                $.ajax({
                    url: '<?php echo base_url('affilliate/add_user'); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('User added successfully!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Error adding user: ' + error);
                    }
                });
            }

        function recordsale(){
            var formData = $('#recordSaleForm').serialize();
                $.ajax({
                    url: '<?php echo base_url('affilliate/record_sale'); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response);
                        if(response!=null){
                            alert('Sale recorded successfully!');
                        }
                        else{
                            alert('Sales exist...');
                        }
                        $('#commissionButton').show();
                    },
                    error: function(xhr, status, error) {
                        alert('Error recording sale: ' + error);
                    }
                });
        }
        function viewcommission(){
            var userid = $('#user_id').val();
            var amount = $('#amount').val();
            $.ajax({
                    url: '<?php echo base_url('affilliate/view_commission'); ?>',
                    type: 'POST',
                    data: {userid:userid,amount:amount},
                    success: function(response) {
                        // alert('User added successfully!');
                        // location.reload();
                        $('#commission_chart').html(response);
                    },
                    error: function(xhr, status, error) {
                        alert('Error adding user: ' + error);
                    }
                });
        }
    </script>
</body>
</html>
