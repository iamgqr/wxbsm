<html>

<head>
<meta charset="utf-8">
<title>homepage</title>
<style type="text/css">
	body {
		text-align: center;
	}
</style>
</head>

<body>
	<h1 style="font-family:arial;color:red;font-size:20px;">Homepage</h1>
	<form action="/search_1.php"method="get">
		<p style="font-family:arial;color:orange;font-size:15px;">Paper Title:</p>
		<input type="text" name="paper_title">
		<p style="font-family:arial;color:green;font-size:15px;">Author Name:</p>
		<input type="text" name="Author_Name">
		<p style="font-family:arial;color:cyan;font-size:15px;">Conference Name:</p>
		<input type="text" name="Conference_Name">

		<br>
		<br>
		<input type="submit" value="Submit">
	</form>
</body>

</html>
