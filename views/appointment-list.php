<?php
 global $wpdb;
 $table_name = $wpdb->prefix . 'liveshoutbox';
$all_app = $wpdb->get_results(
        $wpdb->prepare(
                "SELECT * from  ". $table_name . "  ORDER by id DESC", " "
        ), ARRAY_A
);
$action = isset($_GET['action']) ? trim($_GET['action']) : "";
$id = isset($_GET['id']) ? intval($_GET['id']) : "";
if (!empty($action) && $action == "delete") {

   
        $wpdb->delete('wp_liveshoutbox', array(
            "id" => $id
        ));
    
    ?>
    <script>
        location.href = "<?php echo site_url() ?>/wp-admin/admin.php?page=appointment-list";
    </script>
<?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
  </script>
</head>
<body>

<div class="container">           
  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Book Date</th>
                <th>Sex</th>
                <th>Doctor</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
                        
                            $i = 1;
                            foreach ($all_app as  $value) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $value['name'];?></td>
                                    <td><?php echo $value['book_date'];?></td>
                                    <td><?php echo $value['sex']; ?></td>
                                    <td><?php echo $value['doctor']; ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="admin.php?page=appointment-list&id=<?php echo $value['id']; ?>&action=delete" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        
                        ?>
           
           
        </tbody>
       
    </table>
</div>

</body>
</html>












