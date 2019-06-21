<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8"> 
    <title>Paper Page</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
	body {
		text-align: center;
	}
	.table{
		text-align: left;
	}
</style>
</head>

<body>
	<h1>Paper Page</h1>
	<?php
		$PaperID = $_GET["PaperID"];
		$link = mysqli_connect("localhost:3306", 'root', '', 'test');
		$result = mysqli_query($link, "SELECT Title from papers where PaperID='$PaperID'");
		if ($result) {
			echo "PaperID: $PaperID<br>";
		} else {
			echo "Paper not found";
		}
		$result = mysqli_query($link, "SELECT Title from papers where PaperID='$PaperID'");
		if ($result) {
			?>
			<table class="table table-hover table-bordered";>
			<thead><tr><th>Title</th><th>Authors</th><th>Conference</th></tr></thead>
			<?php		
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				if($row){
				$paper_info = mysqli_fetch_array(mysqli_query($link, "SELECT Title, ConferenceID from Papers where PaperID='$PaperID'"));
				$paper_title = $paper_info['Title'];
				$conf_id = $paper_info['ConferenceID'];
				
				echo "<td><a href=\"/paper.php?PaperID=$PaperID\">$paper_title</a></td>";
				echo "<td>";
				$author_1 = mysqli_fetch_all(mysqli_query($link, "SELECT AuthorName,authors.AuthorID from paper_author_affiliation  INNER JOIN authors  on authors.AuthorID=paper_author_affiliation.AuthorID where PaperID='$PaperID' order by AuthorSequence ASC"));
				foreach ($author_1 as $author) {
					$author_id = $author[1];
					echo "<a href='author.php?author_id=$author_id&page=".(1)."'>$author[0]</a>; ";
					
				}
				$conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conf_id'"));
				$conf_name=$conf_info['ConferenceName'];
				echo "<td><a href='conference.php?Conference_Name=$conf_name&page=".(1)."'>$conf_name</a></td>";
				}
				
				echo "</tr>";
			}
			echo "</table>";
			echo "<br><br><a style='border-radius:25px;'  class='btn btn-default btn-lg' role='button' href='index.php'>Homepage</a> ";
		}
	?>

</body>

</html>