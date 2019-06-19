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
    <script src="echarts.min.js"></script>
</head>

<body>
	<h1>Author Page</h1>
	<div id="paperchart" style="width: 600px;height:400px;"></div>
	<?php
		$author_id = $_GET["author_id"];
		$link = mysqli_connect("localhost:3306", 'root', '', 'test');
		$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'");
		if ($result) {
			$author_name = mysqli_fetch_array($result)['AuthorName'];
			echo "Name: $author_name<br>";
			echo "Author_id: $author_id<br>";
		} else {
			echo "Name not found";
			return;
		}
		$result = mysqli_query($link, "SELECT affiliations.AffiliationID, affiliations.AffiliationName from (select AffiliationID, count(*) as cnt from paper_author_affiliation where AuthorID='$author_id' and AffiliationID is not null group by AffiliationID order by cnt desc) as tmp inner join affiliations on tmp.AffiliationID = affiliations.AffiliationID");
	
		$affiliation_name = mysqli_fetch_array($result)['AffiliationName'];
		//echo "Affiliation:$affiliation_name";
		$pagesize=10;
		$page=$_GET['page']?$_GET['page'] : 1;
		$startpage=($page-1)*$pagesize;
		$totalpage = ceil(mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) from paper_author_affiliation where AuthorID='$author_id'"))[0]/$pagesize);
		$result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id'limit $startpage,$pagesize");
		$author_statistics = array();
		if ($result) {
			echo "<table border=\"1\";text-align:center'><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				$paper_id = $row['PaperID'];
				if($row){
				$paper_info = mysqli_fetch_array(mysqli_query($link, "SELECT Title, ConferenceID, PaperPublishYear from Papers where PaperID='$paper_id'"));
				$paper_title = $paper_info['Title'];
				$conf_id = $paper_info['ConferenceID'];
				$publish_year = $paper_info['PaperPublishYear'];
				if(array_key_exists($publish_year, $author_statistics))
					$author_statistics[$publish_year]++;
				else
					$author_statistics[$publish_year]=1;
				
				echo "<td><a href=\"/paper.php?paper_title=$paper_title\">$paper_title; </a></td>";
				echo "<td>";
				$author_1 = mysqli_fetch_all(mysqli_query($link, "SELECT AuthorName,authors.AuthorID from paper_author_affiliation  INNER JOIN authors  on authors.AuthorID=paper_author_affiliation.AuthorID where PaperID='$paper_id' order by AuthorSequence ASC"));
				foreach ($author_1 as $author) {
					$author_id = $author[1];
					echo "<a href=\"/author.php?author_id=$author_id\">$author[0]</a>; ";
					
				}
				$conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conf_id'"));
				$conf_name=$conf_info['ConferenceName'];
				echo "<td><a href=\"/conference.php?Conference_Name=$conf_name\">$conf_name; </a></td>";
				}
				
				echo "</tr>";
			}
			echo "</table>";
			echo "当前页数： $page/$totalpage  ";
			echo "<a href='author.php?author_id=$author_id&page=".(1)."'>首页 </a>";
			if($page!=1)echo "<a href='author.php?author_id=$author_id&page=".($page-1)."'>上一页 </a>";
			if($page!=$totalpage)echo "<a href='author.php?author_id=$author_id&page=".($page+1)."'>下一页 </a>";
			echo "<a href='author.php?author_id=$author_id&page=".$totalpage."'>尾页 </a>";
		}
	?>
	
	<script type="text/javascript">
		var myChart = echarts.init(document.getElementById('paperchart'));
		<?php
			ksort($author_statistics);
			$years=array_keys($author_statistics);
			for ($y=$years[0]; $y<=$years[count($years)-1]; $y++) if(!array_key_exists($y,$author_statistics)) $author_statistics[$y]=0;
			ksort($author_statistics);
			$years=implode(", ",array_keys($author_statistics));
			$counts=implode(", ",array_values($author_statistics));
			echo "var years = [$years];";
			echo "var counts = [$counts];";
			echo "var author_name = \"$author_name\";";
			echo "//"
		?>

		option = {
			title: {
				text: 'Author Papers Statistics'
			},
			legend: {
				data: [years],
				align: 'left'
			},
			toolbox: {
				// y: 'bottom',
				feature: {
					magicType: {
						type: ['stack', 'tiled']
					},
					dataView: {},
					saveAsImage: {
						pixelRatio: 2
					}
				}
			},
			tooltip: {},
			xAxis: {
				data: years,
				silent: false,
				splitLine: {
					show: false
				}
			},
			yAxis: {
			},
			series: [{
				name: author_name,
				type: 'bar',
				data: counts,
				animationDelay: function (idx) {
					return idx * 10;
				}
			}],
			animationEasing: 'elasticOut',
			animationDelayUpdate: function (idx) {
				return idx * 5;
			}
		};
		
		myChart.setOption(option);
	</script>
</body>

</html>