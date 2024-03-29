<!DOCTYPE html> 
<html>

<head>
    <meta charset="utf-8"> 
    <title>Search Page</title>
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
			$totalsize=$result['response']['numFound'];
		    $pagesize=10;
		    $totalpage=ceil($totalsize/$pagesize);
		    $page=$_GET['page']?$_GET['page'] : 1;
			$start=($page-1)*10;
			
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $paper_title));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=Title:".$query."&wt=json&rows=10&start=$start";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			curl_close($ch);
			?>
			<table class="table table-hover table-bordered";>
			<thead><tr><th>Title</th><th>Authors</th><th>Conference</th></tr></thead>
			<?php		
			foreach ($result['response']['docs'] as $paper) {
				echo "<tbody><tr>";
				echo "<td>";
				$paper_title_1=$paper['Title'];
				$PaperID=$paper['PaperID'];
				echo "<a href=\"/paper.php?PaperID=$PaperID\">$paper_title_1</a>";

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href='author.php?author_id=$author_id&page=".(1)."'>$author</a>; ";
					
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href='conference.php?Conference_Name=$Conference_Name&page=".(1)."'>$Conference_Name</a>";
				echo "</td>";

				echo "</tbody></tr>";
			}
			echo "</table><br><br>";
			
			echo "<a  class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=$paper_title&Author_Name=&Conference_Name=&page=".(1)."'>Front Page</a> ";
			if($page!=1)echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=$paper_title&Author_Name=&Conference_Name=&page=".($page-1)."'>Previous Page</a> ";
			echo "<a  class='btn btn-default btn-sm disabled' style='opacity:0.8;' role='button'>Current Page： $page/$totalpage</a>";
			if($page!=$totalpage)echo "<a  class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=$paper_title&Author_Name=&Conference_Name=&page=".($page+1)."'>Next Page</a> ";
			echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=$paper_title&Author_Name=&Conference_Name=&page=".$totalpage."'>Last Page</a><br><br><br>";
			
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
			$totalsize=$result['response']['numFound'];
		    $pagesize=10;
		    $totalpage=ceil($totalsize/$pagesize);
		    $page=$_GET['page']?$_GET['page'] : 1;
			$start=($page-1)*10;
			
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $Author_Name));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=AuthorsName:".$query."&wt=json&rows=10&start=$start";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			?>
			<table class="table table-hover table-bordered";>
			<thead><tr><th>Title</th><th>Authors</th><th>Conference</th></tr></thead>
			<?php		
			curl_close($ch);
			foreach ($result['response']['docs'] as $paper) {
				echo "<tbody><tr>";
				echo "<td>";
				$paper_title_1=$paper['Title'];
				$PaperID=$paper['PaperID'];
				echo "<a href=\"/paper.php?PaperID=$PaperID\">$paper_title_1</a>";
				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href='author.php?author_id=$author_id&page=".(1)."'>$author</a>; ";
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href='conference.php?Conference_Name=$Conference_Name&page=".(1)."'>$Conference_Name</a>";
				echo "</td>";

				echo "</tbody></tr>";
			}
			echo "</table><br><br>";
			echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=$Author_Name&Conference_Name=&page=".(1)."'>Front Page</a> ";
			if($page!=1)echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=$Author_Name&Conference_Name=&page=".($page-1)."'>Previous Page</a> ";
			echo "<a  class='btn btn-default btn-sm disabled' style='opacity:0.8;' role='button'>Current Page： $page/$totalpage</a>";
			if($page!=$totalpage)echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=$Author_Name&Conference_Name=&page=".($page+1)."'>Next Page</a> ";
			echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=$Author_Name&Conference_Name=&page=".$totalpage."'>Last Page</a><br><br><br>";
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
			$totalsize=$result['response']['numFound'];
		    $pagesize=10;
		    $totalpage=ceil($totalsize/$pagesize);
		    $page=$_GET['page']?$_GET['page'] : 1;
			$start=($page-1)*10;
			
			$ch = curl_init();
			$timeout = 5;
			$query = urlencode(str_replace(' ', '+', $Conference_Name));
			$url = "http://localhost:8983/solr/core_new/select?indent=on&q=ConferenceName:".$query."&wt=json&rows=10&start=$start";

			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = json_decode(curl_exec($ch), true);
			?>
			<table class="table table-hover table-bordered";>
			<thead><tr><th>Title</th><th>Authors</th><th>Conference</th></tr></thead>
			<?php		
			curl_close($ch);
			foreach ($result['response']['docs'] as $paper) {
				echo "<tbody><tr>";
				echo "<td>";
				$paper_title_1=$paper['Title'];
				$PaperID=$paper['PaperID'];
				echo "<a href=\"/paper.php?PaperID=$PaperID\">$paper_title_1</a>";

				echo "</td>";
				echo "<td>";
				foreach ($paper['AuthorsName'] as $idx => $author) {
					$author_id = $paper['AuthorsID'][$idx];
					echo "<a href='author.php?author_id=$author_id&page=".(1)."'>$author</a>; ";
					
				}
				echo "</td>";
				echo "<td>";
				$Conference_Name=$paper['ConferenceName'];
				echo "<a href='conference.php?Conference_Name=$Conference_Name&page=".(1)."'>$Conference_Name</a>";
				echo "</td>";

				echo "</tbody></tr>";
			}
			echo "</table><br><br>";
			echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=&Conference_Name=$Conference_Name&page=".(1)."'>Front Page</a> ";
			if($page!=1)echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=&Conference_Name=$Conference_Name&page=".($page-1)."'>Previous Page</a> ";
			echo "<a  class='btn btn-default btn-sm disabled' style='opacity:0.8;' role='button'>Current Page： $page/$totalpage</a>";
			if($page!=$totalpage)echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=&Conference_Name=$Conference_Name&page=".($page+1)."'>Next Page</a> ";
			echo "<a class='btn btn-default btn-sm' role='button' href='search_1.php?paper_title=&Author_Name=&Conference_Name=$Conference_Name&page=".$totalpage."'>Last Page</a>";
		}
		echo "<br><br><a style='border-radius:25px;'  class='btn btn-default btn-lg' role='button' href='index.php'>Homepage</a> ";
	?>
</body>

</html> 