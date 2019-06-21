<html>

<head>
   <meta charset="utf-8"> 
   <title>homepage</title>
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>

<body class="text-center">
	<form action="/search_1.php"method="get">
	<div class="container" style="width:500px;height:180px">
	</div>
	<div class="container" style="width:500px;height:100px;">
      <h1 class=" font-weight-normal">Homepage</h1>
	  <br>
      <input type="text" name="paper_title" class="form-control"style="border:2px solid;
border-radius:25px;" placeholder="Paper Title" >
	  <br>
      <input type="text" name="Author_Name" class="form-control" style="border:2px solid;
border-radius:25px;"placeholder="Author Name" >
	  <br>
      <input type="text" name="Conference_Name" class="form-control"style="border:2px solid;
border-radius:25px;" placeholder="Conference Name" >
	  <input type="hidden" name="page" value="1">
      <br>
	  <button class="btn btn-lg btn-primary btn-block" style="border:2px solid;
border-radius:25px;" type="submit">Search</button>
	  </div>
</form>
  </body>

</html>
<form action="/search_1.php"method="get">
</form>