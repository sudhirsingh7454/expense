<?php 
	/*
	Plugin Name: EXPENSES
	Version: 1.0
	Plugin URI: 
	Author: susheelhbti
	Author URI: 
	Description: This is a expenses plugin with this you can add and track your expenses details.To get started activate it.When activated you can see a Expenses menu page in your admin screen .
	*/
	
// Hook for adding admin menus
add_action('admin_menu', admin_pages);
// action function for above hook
function admin_pages() {
    add_menu_page(__('Add Expenses','menu-test'),__('Expenses','menu-test'), 'manage_options', 'expenses', 'add_expenses_page' );
    add_submenu_page('expenses', __('View Expenses','menu-test'), __('View Expenses','menu-test'), 'manage_options', 'view_expenses', 'view_expenses_page');
    add_submenu_page('expenses', __('Add Category','menu-test'), __('Add Category','menu-test'), 'manage_options', 'add_category', 'add_category_page');
    add_submenu_page('expenses', __('View Category','menu-test'), __('View Category','menu-test'), 'manage_options', 'view_category', 'view_category_page');
}
function add_expenses_page(){	
  global $wpdb;
   echo '
  <form action="" method="POST">
              <div><h3>Add Your Expenses Details</h3></div>
                   <div class="col-xs-4">
  <label> Date : </label><input class="form-control" type="date" id="edate" name="edate" required>
    </div>    
             <div class="col-xs-4">
            <label> Category : </label>
            <select class="form-control" id="category1" name="category1">';
	$p1 = $wpdb->get_results($v1 = "SELECT DISTINCT category1 FROM wpb9_category");
           foreach($p1 as $n1){
 echo' <option>  '.$n1->category1.'</option>';
           }
echo'   </select>
        </div>
 <div class="col-xs-4">
          <label> Amount: </label>
                 <input class="form-control" type="text" id="amount" name="amount" placeholder="Enter amount" required>
</div>
 <div class="col-xs-4">
          <label> Vendor: </label>
                 <input class="form-control" type="text" id="vendor" name="vendor" placeholder="Enter vendor name" required>
</div>

 <div class="col-xs-4">
           <label> Invoice: </label>
		 <input class="form-control" type="text" id="invoice" name="invoice" placeholder="Enter invoive number" required>
</div>

  <div class="col-xs-4">
            <label> Notes: </label>
                 <input class="form-control" type="text" id="notes" name="notes" required>
</div>

  <div class="col-xs-4 text-center">
                <button class="btn btn-success btn-lg" name="Submit">Add Expenses</button>
</div>
</form></div>
';
	 $edate = $_POST['edate'];	   
         $cat = $_POST['category1']; 
         $amount = $_POST['amount'];
	 $vendor = $_POST['vendor'];
	 $invoice = $_POST['invoice'];
	 $notes = $_POST['notes'];  
	 if(!empty($_POST['edate'])){
         $wpdb->query("INSERT  INTO wpb9_expenses(date,category1,amount,vendor,invoice,notes)
	 VALUES('$edate', '$cat', '$amount', '$vendor', '$invoice', '$notes')");
     }
}
function view_expenses_page() {
    global $wpdb;
     echo '
    <form  action="#" method="POST"><table class="table table-bordered ">
 <br><tr><td><div><h3>View Your Expenses</h3></div>
  <div class="col-xs-4">
     <label> Select Start Date :  </label>
                <input class="form-control" type="date" id="sdate" name="sdate" required>
		</div>
    <div class="col-xs-4">
 <label> Select End Date :  </label>
                <input class="form-control" type="date" id="ldate" name="ldate" required>
</div>
           
    <p><input type="submit" class="btn btn-info btn-info" value="Submit" name="Submit"></p>
                      
            </td></tr>  </table>
       </form>
';        
          if(isset($_POST['Submit'])){
          $sdate = $_POST['sdate'];	
	  $ldate = $_POST['ldate'];	
       	  $report = $wpdb->get_results("SELECT * FROM wpb9_expenses  WHERE date BETWEEN '$sdate' AND '$ldate'");
	  if(!empty($report)){ echo "<table class='table table-bordered table-hover'>";
     echo"<th>ID</th>"; echo"<th>Date</th>"; echo"<th>Category</th>"; echo"<th>Amount</th>"; echo"<th>Vendor</th>"; echo"<th>Invoice</th>";
     echo"<th>Notes</th>";}
               echo "<b>Your Expenses Details Are:</b>";
               foreach($report as $t1){
     	   echo "<tr><td>".$t1->id."</td>"; echo "<td>".$t1->date."</td>"; echo "<td>".$t1->category1."</td>"; echo "<td>".$t1->amount."</td>"; echo "<td>".$t1->vendor."</td>"; echo "<td>".$t1->invoice."</td>"; echo "<td>".$t1->notes."</td></tr>";
 }            echo "</table>";
     }
  }
 /* End Function View Expenses */
function add_category_page() {
	 global $wpdb;
         echo '
 <form action="" method="POST">
 <table class="table table-bordered table-hover"><tr><td>
<div class="col-xs-4">
 <label>Add Category:</label>
  <input type="text" class="form-control" name="category1" required>
</div>
            
    <p><input type="submit" class="btn btn-info btn-info" value="Submit" name="Submit"></p>
                     
</td></tr></table>
	 </form>
';       
        if(!empty($_POST['Submit'])){
	$category = $_POST['category1'];
       	$wpdb->query("INSERT INTO wpb9_category(category1)
	             VALUES ('$category')");
	}/* End If */
}/* End Function */
function view_category_page() {
    global $wpdb;
    if($_GET['caase']=="delete"){
    $id=$_GET['id'];
    $wpdb->query("DELETE FROM wpb9_category WHERE id='$id' "); 
}/* End If */ 
       $p = $wpdb->get_results("SELECT DISTINCT id,category1 FROM wpb9_category");
       echo '
       <table class="table table-bordered table-hover">';
     
       echo"<th>Id</th>"; echo"<th>Category</th>";  echo"<th>Delete</th>";  
           foreach($p as $n){ 
               echo "<tr><td>".$n->id."</td>"; echo "<td>".$n->category1."</td>";echo '<td><a href="admin.php?page=view_category&caase=delete&id='.$n->id.'">Delete</a></td></tr>'; 
}         echo "</table>";  
}/* End Function */
?>

