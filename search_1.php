<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<title>search page</title>
<style type="text/css">
	body {
		text-align: center;
	}
</style>
</head>

<body>
	<h1>Search Page Result</h1>
	<?php
	echo $_GET["paper_title"];;
		$paper_title = $_GET["paper_title"];
		$Author_Name = $_GET["Author_Name"];
		$Conference_Name = $_GET["Conference_Name"];
		
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
			$totalsize=$result['response']['numFound'];
		    $pagesize=10;
		    $totalpage=ceil($totalsize/$pagesize);
		    $page=$_GET['page']?$_GET['page']:1;
		    $start=($page-1)*10;
			echo "<table border=\"1\";text-align:center'><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";			
			foreach ($result['response']['docs'] as $paper) {
				echo "<tr>";
				echo "<td>";
				$paper_title=$paper['Title'];
				echo "<a href=\"/paper.php?paper_title=$paper_title\">$paper_title; </a>";

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
					
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href=\"/conference.php?Conference_Name=$Conference_Name\">$Conference_Name; </a>";
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
		$paper_title = $_GET["paper_title"];
		$Author_Name = $_GET["Author_Name"];
		$Conference_Name = $_GET["Conference_Name"];
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
				$paper_title=$paper['Title'];
				echo "<a href=\"/paper.php?paper_title=$paper_title\">$paper_title; </a>";

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
					
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href=\"/conference.php?Conference_Name=$Conference_Name\">$Conference_Name; </a>";
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
		$paper_title = $_GET["paper_title"];
		$Author_Name = $_GET["Author_Name"];
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
				$paper_title=$paper['Title'];
				echo "<a href=\"/paper.php?paper_title=$paper_title\">$paper_title; </a>";

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href=\"/author.php?author_id=$author_id\">$author; </a>";
					
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href=\"/conference.php?Conference_Name=$Conference_Name\">$Conference_Name; </a>";
				echo "<td>";

				echo "</tr>";
			}
			echo "</table><br><br>";
			
		}
	?>
</body>

</html> 