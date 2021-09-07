<?php 
    // initialize errors variable
  $server_name = "localhost";
  $username = "root";
  $password = "";
  $dbname = "todo_tasks";
	$errors = "";

	// connect to database
	$conn = mysqli_connect($server_name, $username, $password, $dbname);

  
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // $sql = "CREATE TABLE tasks (
  //   id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  //   task VARCHAR(255) NOT NULL,
  //   reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  //   )";
  // if (mysqli_query($conn, $sql)) {
  //   echo "Table tasks created successfully";
  // } else {
  //   echo "Error creating table: " . mysqli_error($conn);
  // }

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($conn, $sql);
			header('location: index.php');
		}
	}	

  if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
  
    mysqli_query($conn, "DELETE FROM tasks WHERE id=".$id);
    header('location: index.php');
  }
  
?>
<html>
<head>
	<title>ToDo List Application PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="main-container">
	<div>
		<h2>ToDo List with PHP and MySQL</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">+</button>
	</form>
  <!-- <div> -->
	
  <div class="todo-wrp-main">
        <div class="todo-wrp">
		<?php 
		// select tasks if page is visited or refreshed
		$tasks = mysqli_query($conn, "SELECT * FROM tasks");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
    <div class="todo">
    <p> <?php echo $i; ?> </p>
            <p><?php echo $row['task']; ?></p>
            <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
          <!-- </div>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
				</td>
			</tr> -->
      </div>
		<?php $i++; } ?>	
    </div>
    </div>
  <?php if (isset($errors)) { ?>
	<p><?php echo $errors; ?></p>
  <?php } ?>
  <!-- </div> -->
</body>
</html>
