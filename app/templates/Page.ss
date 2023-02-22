<!DOCTYPE html>
<html lang="en">
<head>
	<% base_tag %>

	$MetaTags(false)
	<title>One Ring Rentals: $Title</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href="http://fonts.googleapis.com/css?family=Raleway:300,500,900%7COpen+Sans:400,700,400italic" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="wrapper">
	
		<header id="header">
			<% include TopBar %>
			<% include MainNav %>
		</header>
		
		$Layout
				
		<% include Footer %>
	
	</div>
</body>
</html>