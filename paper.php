<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<title>author page</title>
<style type="text/css">
	body {
		text-align: center;
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
			echo "<table border=\"1\";text-align:center'><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
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
		}
	?>

</body>

</html>