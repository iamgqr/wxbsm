<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<title>search page example</title>
<style type="text/css">
	body {
		text-align: center;
	}
</style>
</head>

<body>
	<h1>Search Page Result</h1>
	<?php
		$paper_title = $_GET["paper_title"];
		if ($paper_title) {
			echo "Search for Title: ".$paper_title;
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $paper_title));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=Title:".$query."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);
			echo "<table border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";			
			foreach ($result['response']['docs'] as $paper) {
				echo "<tr>";
				echo "<td>";
				echo $paper['Title'];

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author</a>; ";
					
				}
				echo "</td>";
				echo "<td>";
				echo $paper['ConferenceName'];
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
		$Author_Name = $_GET["Author_Name"];
		if ($Author_Name) {
			echo "Search for Author Name: ".$Author_Name;
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $Author_Name));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=AuthorsName:".$query."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);
			echo "<table border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";			
			foreach ($result['response']['docs'] as $paper) {
				echo "<tr>";
				echo "<td>";
				echo $paper['Title'];

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author</a>; ";
					
				}
				echo "</td>";
				echo "<td>";
				echo $paper['ConferenceName'];
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
		$Conference_Name = $_GET["Conference_Name"];
		if ($Conference_Name) {
			echo "Search for Conference Name: ".$Conference_Name;
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $Conference_Name));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=ConferenceName:".$query."&wt=json";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);
			echo "<table border=\"1\"><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";			
			foreach ($result['response']['docs'] as $paper) {
				echo "<tr>";
				echo "<td>";
				echo $paper['Title'];

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author</a>; ";
					
				}
				echo "</td>";
				echo "<td>";
				echo $paper['ConferenceName'];
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
	?>
</body>

</html>