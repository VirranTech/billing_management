<?php 
/*
 * Author        :   BARATHI/KARPAGAM
 * Date          :   03-07-2019
 * Modified      :   
 * Modified By   :   
 * Description   :  
 */

$portal_name =  $_SESSION['portal_name'];
?>
<?php
require_once ("../config/db.php");
require_once ("../config/Connection.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if (isset($_GET['id'])){
$user_id=intval($_GET['id']);
$query=mysqli_query($con, "select * from `{$portal_name}_users` where user_id='".$user_id."'");
$rw_user=mysqli_fetch_array($query);
$count=$rw_user['user_id'];
if ($user_id!=1){
    if ($delete1=mysqli_query($con,"DELETE FROM `{$portal_name}_users` WHERE user_id='".$user_id."'")){
    ?>
    <div class="alert alert-success alert-dismissible" role="alert" style="width: 361px;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success</strong> Deleted data successfully.
    </div>
    <?php 
}else {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert" style="width: 361px;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error</strong> Sorry something went wrong try again.
    </div>
    <?php
}
} else {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert" style="width: 361px;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error</strong> You can not delete the admin user. 
    </div>
    <?php
}
}
if($action == 'ajax'){
$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
 $aColumns = array('firstname', 'lastname');//Columnas de busqueda
 $sTable = "`{$portal_name}_users`";
 $sWhere = "";
if ( $_GET['q'] != "" )
{
    $sWhere = "WHERE (";
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
            $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}
$sWhere.=" order by user_id asc";
include 'pagination.php'; 
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
$per_page = 10;
$adjacents  = 4;
$offset = ($page - 1) * $per_page;
$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
$row= mysqli_fetch_array($count_query);
$numrows = $row['numrows'];
$total_pages = ceil($numrows/$per_page);
$reload = './usuarios.php';
$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
$query = mysqli_query($con, $sql);
if ($numrows>0){
        ?>
        <div class="table-responsive">
          <table class="table">
            <tr  class="red">
            <th>ID</th>
            <th>Names</th>
            <th>User</th>
            <th>Email</th>
            <th>Date</th>
            <th class='text-center'>Actions</th>
            </tr>
            <?php
            while ($row=mysqli_fetch_array($query)){
                            $user_id=$row['user_id'];
                            $fullname=$row['firstname']." ".$row["lastname"];
                            $user_name=$row['user_name'];
                            $user_email=$row['user_email'];
                            $date_added= date('d/m/Y', strtotime($row['date_added']));
                    ?>
                    <input type="hidden" value="<?php echo $row['firstname'];?>" id="nombres<?php echo $user_id;?>">
                    <input type="hidden" value="<?php echo $row['lastname'];?>" id="apellidos<?php echo $user_id;?>">
                    <input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
                    <input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
                    <tr>
                        <td><?php echo $user_id; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td><?php echo $user_name; ?></td>
                        <td><?php echo $user_email; ?></td>
                        <td><?php echo $date_added;?></td>
                    <td class='text-center'>
                    <a href="#" class='btn btn-danger' title='edit user' onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class='btn btn-danger' title='Change Password � a' onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>
                    <a class='btn btn-danger' title='delete user' onclick="eliminar('<?php echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></td>&nbsp;				
                     </tr>
                        <?php
                }
                ?>
                 </table>
                <tr>
                <td colspan=9><span class="pull-right">
                <?php
                 echo paginate($reload, $page, $total_pages, $adjacents);
                ?></span></td>
                </tr>

        </div>
        <?php
}
}
?>