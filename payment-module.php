<?php
	require_once 'controllers/authController.php';
	require 'controllers/accessController.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title> View Student </title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
	
		<link rel="icon" type="image/x-icon" href="styles/favicon.ico"/>
		
		<!-- CUSTOM STYLESHEET -->
        <link rel="stylesheet" href="admin-dashboard.css">
		
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
		<script src="https://kit.fontawesome.com/575abfd474.js" crossorigin="anonymous"></script>
		<!-- BOOTSRAP -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	</head>
    <body>

        <!--wrapper start-->
        <div class="wrapper">
            <!--header menu start-->
            <div class="header">
                <div class="header-menu">
					<div class="title">Educa Academy</div>
                </div>
            </div>
            <!--header menu end-->
            <!--sidebar start-->
            <div class="sidebar">
                <div class="sidebar-menu">
                    <center class="profile">
                        <img src="styles/logo.png" alt="">
                        <p><?php echo $_SESSION['username']; ?></p>
                    </center>
					<hr></hr>
                    <li class="item">
                        <a href="admin-dashboard.php" class="menu-btn">
                            <i class="fas fa-desktop"></i>Dashboard
                        </a>
                    </li>
                    <li class="item">
                        <a href="student-module.php" class="menu-btn">
                            <span><i class="fas fa-graduation-cap"></i>Student</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="faculty-module.php" class="menu-btn">
                            <i class="fas fa-users"></i>Faculty
                        </a>
                    </li>
					<li class="item">
                        <a href="courses-module.php" class="menu-btn">
                            <i class="fas fa-clipboard-list"></i>Courses
                        </a>
                    </li>
                    <li class="item">
                        <a href="classes-module.php" class="menu-btn">
                            <i class="fas fa-clipboard-list"></i>Classes
                        </a>
                    </li>
					<li class="item">
                        <a href="grading-module.php" class="menu-btn">
                            <i class="fas fa-file-excel"></i>Grading
                        </a>
                    </li>
					<li class="item">
                        <a href="users-module.php" class="menu-btn">
                            <i class="fas fa-users-cog"></i>Users
                        </a>
                    </li>
					
					<!-- Button trigger modal -->	
					<li class="item">
						<div class="menu-btn">
							<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
								<i class="fas fa-sign-out-alt"></i>Logout
							</button>
						</div>	
					</li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="content">
				<div class="directory">
					<p>Student Module / View Balance</p>
				</div>

                <h1>Statement of Account</h1>

                <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
					    data-bs-target="#addFaculty">Add New Fees
                        <i class="fas fa-user-plus"></i>
                </button>
                <a href="receipts.php?id=<?php echo $_GET['id'];?>">
						<button type="button" class="btn btn-success">Check Receipts 
							<i class="fas fa-file-download"></i>
						</button>
					</a>
   
				<?php
				$id = $_GET['id'];
				
				error_reporting(E_ERROR | E_PARSE);
				$res = mysqli_query ($connection, "SELECT * FROM students WHERE id='$id'");
				while ($row = mysqli_fetch_array($res))
				{
					$id = $row['id'];
					$idnum = $row['idnum'];
					$fname = $row['fname'];
					$mname = $row['mname'];
					$lname = $row['lname'];
					$entlev = $row['entlev'];
					$term = $row['term'];
					$program = $row['program'];
					$class = $row['class'];
					$name = strtoupper($lname) .", ". $fname ." ". substr($mname, 0, 1) . ".";
				}	
			?>
				<hr></hr>


            <div class="modal fade" id="addFaculty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered-scrollable">
			    <div class="modal-content">
			        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Fees</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="payment-module.php">
                    <div class="modal-body">
                        <input name="idnum" value=<?php echo $idnum?> />
                        <label>Select Term</label>
                        
                        <select name="term">
                            <?php
                                $result = mysqli_query ($connection, "SELECT * FROM studentRecords WHERE idnum='$idnum' ");
                                while ($hori = mysqli_fetch_array($result)) { 
                                $yt = $hori['entlev'] . " " . $hori['term'];
                            ?>
                                <option value="<?php echo $yt ?>"><?php echo $yt ?></option>
                            <?php }?>
                        </select>
                        <label> Expense Name:</label>
                        <input name="expensename"/>
                        <label> Expense Price:</label>
                        <input name="expenseprice"/>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn-success" name="add-new-fees"> Submit </button>
                    </div>
                                </form>
                    </div>
			</div>
		  </div>
                
									<?php
									
									$result = mysqli_query ($connection, "SELECT * FROM studentRecords WHERE idnum='$idnum' ");
                                    $temp = array();
                                    
									while ($hori = mysqli_fetch_array($result)) { 
                                        $expr = '/(?<=\s|^)[A-Z]/';
										preg_match_all($expr, $hori['program'], $matches);
										$imp = implode('', $matches[0]);
										$short = strtoupper($imp);
										$yt = $hori['entlev'] . " " . $hori['term'];
                                        $res = mysqli_query ($connection, "SELECT * FROM course_enrolled WHERE idnum='$idnum' and year_term='$yt' ");

                                        $tempArr = array();
                                        while($newRes = mysqli_fetch_array($res) ){
                                            array_push($tempArr,array('course'=>$newRes['course'],'price'=>100));
                                        }

                                        $extraFees = mysqli_query ($connection, "SELECT * FROM students WHERE idnum='$idnum'");

                                        while ($tempRows = mysqli_fetch_assoc($extraFees)){
                                            $json = json_decode($tempRows['extrafees']);
                                            
                                        }
                                        
                                        $temp[$yt] = $tempArr;
                                        
                                    }
                                    
                                    ?>
                                   
                                                <?php 
                                                    foreach($temp as $key => $value){
                                                        ?>
                                                        <h3><?php echo $key?></h3>


                                                        <table class="table table-bordered">
                                        <thead>

                                                        <tr>
                                                        
                                            <th> Course</th>
                                            <th> Price</th>
                                            
                                        
                                                        </tr>
                                        
                                                    </thead>

                                        <tbody>

                                                        <?php
                                                        $price = 0;
                                                        foreach($value as $newVal){
                                                            $price += $newVal['price'];
                                                ?>
                                                    <tr>
                                                        <td> <?php echo $newVal['course']; ?></td>
                                                        <td> <?php echo $newVal['price']; ?></td>
                                                    </tr>
                                                    
                                  
                                                    
                                                <?php
                                                        }
                                                        
                                                        ?>
                                                        <tr>
                                                            <td> Total</td>
                                                            <td> <?php echo $price; ?> </td>

                                                        </tr>
                              </tbody>
                                </table>
                                <table class ="table table-bordered">
                                <thead>
                                    <tr>
                                    <th> Title</th>
                                    <th> Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tuition Fees:</td>
                                        <td>109.50</td>
                                    </tr>
                                    <tr>
                                        <td>Miscellaneous Fees:</td>
                                        <td>105.00</td>
                                    </tr>
                                    <tr>
                                        <td>Other School Fees:</td>
                                        <td>500.00</td>
                                    </tr>
                                    <?php
                                        foreach($json->$key as $new){
                                            
                                    ?>
                                        <tr>
                                            <td> <?php echo $new->expensename; ?></td>
                                            <td> <?php echo $new->expenseprice; ?></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                                </table>

                                            <?php } ?>
                                
										
                                    
									
									
                                    
		
			</div>
            <!--main container end-->
        </div>
        <!--wrapper end-->

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel">Are you sure you want to logout?</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				
				<button class="btn btn-danger">
					<a href="admin-dashboard.php?logout=1" class="menu-btn">
						<i class="fas fa-sign-out-alt"></i>Logout
					</a>
				</button>
			  </div>
			</div>
		  </div>
		</div>
		
		<div>
			<?php
				include("preloader.php")
			?>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        
        <script type="text/javascript">
        $(document).ready(function(){
            $(".sidebar-btn").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
        </script>

    </body>
</html>
      