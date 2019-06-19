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
	<h1>Conference Page</h1>
	<div id="paperchart" style="width: 600px;height:400px;margin:0 auto;"></div>
	<?php
		$Conference_Name = $_GET["Conference_Name"];
		$link = mysqli_connect("localhost:3306", 'root', '', 'test');
		$result = mysqli_query($link, "SELECT ConferenceID from conferences where ConferenceName='$Conference_Name '");
		if ($result) {
			$conferece_id = mysqli_fetch_array($result)['ConferenceID'];
			echo "ConferenceName: $Conference_Name<br>";
			echo "ConferenceID: $conferece_id<br>";
		} else {
			echo "Conference name not found";
		}
	
		
		$conference_statistics = array();
		$result = mysqli_fetch_all(mysqli_query($link, "SELECT PaperPublishYear from Papers where ConferenceID='$conferece_id'"));
		foreach ($result as $paper_info) {
			$publish_year = $paper_info[0];
			if(array_key_exists($publish_year, $conference_statistics))
				$conference_statistics[$publish_year]++;
			else
				$conference_statistics[$publish_year]=1;
		}

		$result = mysqli_query($link, "SELECT PaperID,Title from papers where ConferenceID='$conferece_id'");
		
		if ($result) {
			echo "<table border=\"1\";text-align:center'><tr><th>Title</th><th>Authors</th><th>Conference</th></tr>";
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				if($row){
				$paper_title = $row['Title'];
				$PaperID = $row['PaperID'];
				
				echo "<td><a href=\"/paper.php?PaperID=$PaperID\">$paper_title; </a></td>";
				echo "<td>";
				$author_1 = mysqli_fetch_all(mysqli_query($link, "SELECT AuthorName,authors.AuthorID from paper_author_affiliation  INNER JOIN authors  on authors.AuthorID=paper_author_affiliation.AuthorID where PaperID='$PaperID' order by AuthorSequence ASC"));
				foreach ($author_1 as $author) {
					$author_id = $author[1];
					echo "<a href=\"/author.php?author_id=$author_id\">$author[0]</a>; ";
					
				}
				echo "<td><a href=\"/conference.php?Conference_Name=$Conference_Name\">$Conference_Name; </a></td>";
				}
				
				echo "</tr>";
			}
			echo "</table>";
		}
	?>
	
	<script type="text/javascript">
		var myChart = echarts.init(document.getElementById('paperchart'));
		<?php
			ksort($conference_statistics);
			$years=array_keys($conference_statistics);
			for ($y=$years[0]; $y<=$years[count($years)-1]; $y++) if(!array_key_exists($y,$conference_statistics)) $conference_statistics[$y]=0;
			ksort($conference_statistics);
			$years=implode(", ",array_keys($conference_statistics));
			$counts=implode(", ",array_values($conference_statistics));
			echo "var years = [$years];";
			echo "var counts = [$counts];";
			echo "var Conference_Name = \"$Conference_Name\";";
			echo "//"
		?>

		option = {
			title: {
				text: 'Conference Papers Statistics'
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
				name: Conference_Name,
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