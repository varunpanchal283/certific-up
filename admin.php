<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


?>
<!DOCTYPE html>
<html>
<head>
  <title>My website</title>
</head>



<body>

	<style type="text/css">
  *{
    margin: 0;
    padding: 0;
    font-family: Century Gothic;
  }
  
  header {
    background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(imgsrc/back2.jpg);
    height: 100vh;
    background-size: cover;
    background-position: center;
  }
  
  ul{
    float: right;
    list-style-type: none;
    margin-top: 25px;
  }
  
  ul li{
    display: inline-block;
  }
  
  ul li a{
    text-decoration: none;
    color: #fff;
    padding: 5px 20px;
    border: 1px solid transparent;
    transition: 0.6s ease;
  }
  
  ul li a:hover{
    background-color: #4da6ff;
    color: #000;
  }
  
  ul li.active a{
    background-color: #4da6ff;
    color: #000;
  }
  
  .logo img{
    float: left;
    width: 170px;
    height: auto;
    margin-top: 10px;
    margin-left: 0px;
  }
  
  .main{
    max-width: 1200px;
    margin: auto;
  }
  
  .title{
    position: absolute;
    top: 50%;
    left: 16%;
    transform: translate(-50%, -50%);
  }
  
  .title h1{
    margin-left:15px;
    color: #fff;
    font-size: 50px;
  }
  .title h2{
    color: #fff;
    font-size: 17px;
  }
  
  .title2{
    position: absolute;
    top: 50%;
    left: 65%;
    transform: translate(-50%, -50%);
  }
  
  .title2 h1{
    margin-left:15px;
    color: #fff;
    font-size: 50px;
  }
  .title2 h2{
    color: #fff;
    font-size: 17px;
  }
  
  table{
    border-collapse: collapse;
    color: #fff;
    font-family: monospace;
    font-size: 15px;
    text-align: left;
    border-color: #fff;
  }
  
  th {
    background-color: #000000;
    color: white;
  }
  tr {
    background-color: #000000;
    color: white;
  }
  table tbody{
  display: block;
  height: 300px;
  width: 100%;
  overflow-x: auto;
  overflow-y: scroll;
}
  #button{

    background: #fff;
  font-size: 14px;
  margin-top: 2px;
  padding: 16px 20px;
  border-radius: 2px;
  border: 1px solid #fff;
  text-transform: uppercase;
  font-weight: 700;
  
  align-items: center;
  width: 30dx;
  color: #000000;
  
  cursor: pointer;
  transition: .2s;
  
  }
  
  
  
  </style>
	
	<header>

	<div class="main">
      <div class="logo">
        <img src="imgsrc/logo1.jpg">
      </div>
      <ul>
		<li class="active"><a href="logout.php">Log out</a></li>
      </ul> 
      </div>

	<div class="title">
        <center><h1>Users Table</h1></center><br>
	
        <?php 
         $stmt = $con->prepare("SELECT * FROM users");
    $stmt->execute();
    $res =  $stmt->get_result();
    echo"<input type='text' id='myi' onkeyup='myFun()'' placeholder='Search for names..''><select id='fi'>
    	<option value='0'>User Name</option>
      </select>
      <table id='myt'>";
    echo "<th>User Name</th><th>Password</th>";
    while($row = mysqli_fetch_array($res))
      {
     echo "<tr><td>" . $row['user_name'] . "</td><td>" . $row['password'] . "</td>
      <td><form method='POST' action='deladmin.php'>
        <input type='hidden' name='delete' value='".$row['user_name']."'>
        <input type='submit' value='Delete'>
      </form>

     </td></tr>"; 
  }
echo "</table>";
echo "<style>
  table, th, td {
    border: 1px solid orange;
    padding: 10px;
  }
  #myi {
  width: 40%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}
</style>

<script>
function myFun() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  var select = document.getElementById('fi');
  var value = parseInt(select.options[select.selectedIndex].value);
  input = document.getElementById('myi');
  filter = input.value.toUpperCase();
  table = document.getElementById('myt');
  tr = table.getElementsByTagName('tr');

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName('td')[value];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = '';
      } else {
        tr[i].style.display = 'none';
      }
    }
  }
}
</script>";
?>
</div>

<div class="title2">
        <center><h1>Certificates</h1></center><br>


<?php 


    $stmt = $con->prepare("SELECT * FROM certificates");
    $stmt->execute();
    $res =  $stmt->get_result();
    echo "
    <input type='text' id='myInput' onkeyup='myFunction()'' placeholder='Search for names..''><select id='fil'>
    	<option value='0'>User Name</option>
        <option value='1'>Employee Name</option>
        <option value='2'>CSP</option>
        <option value='3'>Certification Name</option>
        <option value='4'>Certification Level</option>
        <option value='5'>Certification ID</option>
        <option value='6'>Issue Date</option>
        <option value='7'>Expiry Date</option>
        <option value='8'>Validity</option>
      </select>
      <table id='myTable'>";
    echo "<th>User Name</th><th>Employee Name</th><th>CSP</th><th>Certification Name</th><th>Certification Level</th><th>Certification ID</th><th>Issue Date</th><th>Expiry Date</th><th>Validity</th>";
    while($row = mysqli_fetch_array($res))
      {
        $date1 = new DateTime($row['dateof_cert']);
        $date2 = new DateTime($row['expiry_cert']);
        $interval = $date1->diff($date2);
        $days=$interval->days;
     echo "<tr><td>" . $row['user_name'] . "</td><td>" . $row['emp_name'] . "</td><td> " . $row['certification_type'] . " </td><td> " . $row['cert_id'] . "</td><td> " . $row['cert_level'] . "</td><td> " . $row['certification_id'] . "</td><td> " . $row['dateof_cert'] . "</td><td> " . $row['expiry_cert'] . "</td><td>" . $days . " Days</td></tr>"; 
  }
echo "</table>";
echo "<style>
  table, th, td {
    border: 1px solid orange;
    padding: 10px;
  }
  #myInput {
  width: 40%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}
</style>
<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  var select = document.getElementById('fil');
  var value = parseInt(select.options[select.selectedIndex].value);
  input = document.getElementById('myInput');
  filter = input.value.toUpperCase();
  table = document.getElementById('myTable');
  tr = table.getElementsByTagName('tr');

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName('td')[value];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = '';
      } else {
        tr[i].style.display = 'none';
      }
    }
  }
}
</script>"



?>
</div>

</header>
</body>
</html>