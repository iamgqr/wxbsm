<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1, user-scalable=no" />
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
    <script src="echarts.min.js"></script>
</head>

<body>
	<h1>Author Page</h1>
	
	<?php
	
		$author_id = $_GET["author_id"];
		$link = mysqli_connect("localhost:3306", 'root', '', 'test');
		$result = mysqli_query($link, "SELECT AuthorName from authors where AuthorID='$author_id'");
		if ($result) {
			$author_name = mysqli_fetch_array($result)['AuthorName'];
			echo"<p style='margin:4px auto;border:1px solid;border-radius:15px;Width:150px'>Name: $author_name Author_id: $author_id</p>";
		} else {
			echo "Name not found";
			return;
		}
		?>
        <div id="year_chart" class="col-3" style="margin:0 auto;width: 800px;height:500px;"></div>
	    <div id="affiliation_chart" style="display:inline-block;width: 600px;height:400px;"></div>
	    <div id="conference_chart" style="display:inline-block;width: 600px;height:400px;"></div>
		<?php	
		$author_statistics = array();
		$affiliation_statistics = array();
		$conference_statistics = array();
		$result = mysqli_fetch_all(mysqli_query($link, "SELECT b.PaperPublishYear,a.AffiliationID,b.ConferenceID from paper_author_affiliation a inner join Papers b on a.PaperID=b.PaperID where a.AuthorID='$author_id'"));
		foreach ($result as $paper_info) {
			$publish_year = $paper_info[0];
			if(array_key_exists($publish_year, $author_statistics))
				$author_statistics[$publish_year]++;
			else
				$author_statistics[$publish_year]=1;
			$affiliation = $paper_info[1];
			if(array_key_exists($affiliation, $affiliation_statistics))
				$affiliation_statistics[$affiliation]++;
			else
				$affiliation_statistics[$affiliation]=1;
			$conference = $paper_info[2];
			if(array_key_exists($conference, $conference_statistics))
				$conference_statistics[$conference]++;
			else
				$conference_statistics[$conference]=1;
		}
		
		$pagesize=10;
		$page=$_GET['page']?$_GET['page'] : 1;
		$startpage=($page-1)*$pagesize;
		$totalpage = ceil(mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) from paper_author_affiliation where AuthorID='$author_id'"))[0]/$pagesize);
		$result = mysqli_query($link, "SELECT PaperID from paper_author_affiliation where AuthorID='$author_id'limit $startpage,$pagesize");
		
		if ($result) {
			?>
			<table class="table table-hover table-bordered";>
			<thead><tr><th>Title</th><th>Authors</th><th>Conference</th></tr></thead>
			<?php		
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				$paper_id = $row['PaperID'];
				if($row){
				$paper_info = mysqli_fetch_array(mysqli_query($link, "SELECT Title, ConferenceID from Papers where PaperID='$paper_id'"));
				$paper_title = $paper_info['Title'];
				$conf_id = $paper_info['ConferenceID'];
				
				echo "<td><a href=\"/paper.php?PaperID=$paper_id\">$paper_title</a>; </td>";
				echo "<td>";
				$author_1 = mysqli_fetch_all(mysqli_query($link, "SELECT AuthorName,authors.AuthorID from paper_author_affiliation  INNER JOIN authors on authors.AuthorID=paper_author_affiliation.AuthorID where PaperID='$paper_id' order by AuthorSequence ASC"));
				foreach ($author_1 as $author) {
					$author_id = $author[1];
					echo "<a href='author.php?author_id=$author_id&page=".(1)."'>$author[0]</a>; ";
					
				}
				$conf_info = mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conf_id'"));
				$conf_name=$conf_info['ConferenceName'];
				
				//echo "<td><a href=\"/conference.php?Conference_Name=$conf_name\">$conf_name; </a></td>";
				echo "<td><a href='conference.php?Conference_Name=$conf_name&page=".(1)."'>$conf_name</a></td>";
				}
				
				echo "</tr>";
			}
			echo "</table>";
			echo "<a class='btn btn-default btn-sm' role='button' href='author.php?author_id=$author_id&page=".(1)."'>Front Page</a> ";
			if($page!=1)echo "<a class='btn btn-default btn-sm' role='button' href='author.php?author_id=$author_id&page=".($page-1)."'>Previous Page</a> ";
			echo "<a  class='btn btn-default btn-sm disabled' style='opacity:0.8;' role='button'>Current Page： $page/$totalpage</a>";
			if($page!=$totalpage)echo "<a class='btn btn-default btn-sm' role='button' href='author.php?author_id=$author_id&page=".($page+1)."'>Next Page</a> ";
			echo "<a class='btn btn-default btn-sm' role='button' href='author.php?author_id=$author_id&page=".$totalpage."'>Last Page</a>";
			echo "<br><br><a style='border-radius:25px;'  class='btn btn-default btn-lg' role='button' href='index.php'>Homepage</a> ";
		}
	?>
	
	<script type="text/javascript">
		<?php
			echo "var author_name = \"$author_name\";\n";
			ksort($author_statistics);
			$years=array_keys($author_statistics);
			for ($y=$years[0]; $y<=$years[count($years)-1]; $y++) if(!array_key_exists($y,$author_statistics)) $author_statistics[$y]=0;
			ksort($author_statistics);
			$years=implode(", ",array_keys($author_statistics));
			$counts=implode(", ",array_values($author_statistics));
			echo "var year_name = [$years];\n";
			echo "var year_count = [$counts];\n";
			//echo "//";

			ksort($affiliation_statistics);
			$affiliation_names="";
			$affiliation_datas="";
			foreach ($affiliation_statistics as $affiliation_id=>$count)
			{
				if($affiliation_id=="None") $affiliation_name='None';
				else{
					$result=mysqli_fetch_array(mysqli_query($link, "SELECT AffiliationName from affiliations where AffiliationID='$affiliation_id'"));
					$affiliation_name=$result['AffiliationName'];
				}
				$affiliation_names=$affiliation_names."'$affiliation_name', ";
				$affiliation_datas=$affiliation_datas."{value:$count,name:'$affiliation_name'}, ";
				// $affiliation_names=$affiliation_names."'$affiliation_id',";
				// $affiliation_datas=$affiliation_datas."{value:$count,name:'$affiliation_id'},";
			}
			echo "var affiliation_name = [$affiliation_names];\n";
			echo "var affiliation_data = [$affiliation_datas];\n";


			ksort($conference_statistics);
			$conference_names="";
			$conference_datas="";
			foreach ($conference_statistics as $conference_id=>$count)
			{
				$result=mysqli_fetch_array(mysqli_query($link, "SELECT ConferenceName from conferences where ConferenceID='$conference_id'"));
				$conference_name=$result['ConferenceName'];
				$conference_names=$conference_names."'$conference_name', ";
				$conference_datas=$conference_datas."{value:$count,name:'$conference_name'}, ";
			}
			echo "var conference_name = [$conference_names];\n";
			echo "var conference_data = [$conference_datas];\n";
			//echo "//";


		?>

		var year_chart = echarts.init(document.getElementById('year_chart'));
		option = {
			title: {
				text: 'Author Papers Timeline Statistics'
			},
			legend: {
				data: [year_name],
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
				data: year_name,
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
				data: year_count,
				animationDelay: function (idx) {
					return idx * 10;
				}
			}],
			animationEasing: 'elasticOut',
			animationDelayUpdate: function (idx) {
				return idx * 5;
			}
		};
		year_chart.setOption(option);

		var affiliation_chart = echarts.init(document.getElementById('affiliation_chart'));
		option = {
			title : {
				text: 'Author Affiliations Statistics',
				x:'center'
			},
			tooltip : {
				trigger: 'item',
				formatter: "{b}<br/>{d}% ({c})"
			},
			legend: {
				orient: 'vertical',
				left: 'right',
				data: affiliation_name
			},
			series : [
				{
					name: 'Affiliations',
					type: 'pie',
					radius : '55%',
					center: ['50%', '60%'],
					data:affiliation_data,
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowColor: 'rgba(0, 0, 0, 0.5)'
						}
					}
				}
			]
		};
		affiliation_chart.setOption(option);


		var conference_chart = echarts.init(document.getElementById('conference_chart'));
		option = {
			title : {
				text: 'Author Conferences Statistics',
				x:'center'
			},
			tooltip : {
				trigger: 'item',
				formatter: "{b}<br/>{d}% ({c})"
			},
			legend: {
				orient: 'vertical',
				left: 'right',
				data: conference_name
			},
			series : [
				{
					name: 'Affiliations',
					type: 'pie',
					radius : '55%',
					center: ['50%', '60%'],
					data:conference_data,
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowColor: 'rgba(0, 0, 0, 0.5)'
						}
					}
				}
			]
		};
		conference_chart.setOption(option);


	</script>
</body>

</html>