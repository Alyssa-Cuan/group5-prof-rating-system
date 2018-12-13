<?php
require "homeTemplate.php"
?>

<main role="main" class="container" >
    <div class="container">
        <div class="homeContents">
        <div class="row mt-5" >

            <div class="col-lg mx-auto order-md-1" style="margin-bottom:30px;">
                <div class="col-md-12 border border-secondary rounded">
                    <h2 class="text-center">Recently Rated Professors</h2>
                    <ul>
					
					<?php
						@require '../connect/connect.php';
						//get the top 5 most recently rated profs
						$query = "SELECT DISTINCT CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName, professor.professorID FROM rating INNER JOIN professor ON professor.professorID = rating.professorID ORDER BY lastmodified DESC LIMIT 5";
						$recentRatedProfResult = mysqli_query($dbc, $query) or die("ERROR S");
						
						while($recentRatedProf = mysqli_fetch_assoc($recentRatedProfResult)){
							echo "<a href='../search/searchProfessor.php?selectedID=p{$recentRatedProf['professorID']}'><li>{$recentRatedProf['profName']}</li></a>";
						}
					?>

                    </ul>
                    <div class="text-center">
                        <img src="../assets/student.png" style="width:50%; height:50%">
                    </div>
                </div>

            </div>

            <div class="col-lg mx-auto order-md-2" style="margin-bottom:30px;">
                <div class="col-md-12 border border-secondary rounded">
                    <h2 class="text-center">Recently Rated Classes</h2>
                    <ul>
					
					<?php
						//get the top 5 most recently rated classes
						$query = "SELECT DISTINCT courseCode, class.classID FROM rating INNER JOIN class ON class.classID = rating.classID ORDER BY lastmodified DESC LIMIT 5";
						$recentRatedClassResult = mysqli_query($dbc, $query) or die("ERROR S");
						
						while($recentRatedClass = mysqli_fetch_assoc($recentRatedClassResult)){
							echo "<a href='../search/searchProfessor.php?selectedID=c{$recentRatedClass['classID']}'><li>{$recentRatedClass['courseCode']}</li></a>";
						}
					?>

     

                    </ul>
                    <div class="text-center">
                        <img src="../assets/student.png" style="width:50%; height:50%">
                    </div>
                </div>

            </div>

            <div class="col-lg mx-auto order-md-3" style="margin-bottom:30px;">
                <div class="col-md-12 border border-secondary rounded">
                    <h2 class="text-center">Top Professors (to be implemented next sprint)</h2>
                    <!-- <p class="text-center lead lg">Profs you may know</p> -->
                    <ul>
                        <li>Agloro</li>
                        <li>Agloro</li>
                        <li>Agloro</li>
                        <li>Agloro</li>
                        <li>Agloro</li>
                    </ul>
                    <div class="text-center">
                        <img src="../assets/student.png" style="width:50%; height:50%">
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
</main>
    <!-- /.container -->

    <!--
      JavaScript
      ==================================================
    -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
