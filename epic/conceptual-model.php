<!DOCTYPE html>
<html>
		<head>

			<meta charset="UTF-8"/>

			<title>Conceptual Model</title>

		</head>

		<body>

			<header>

				<h1>Conceptual Model</h1>
			</header>
			<p><strong>Profile</strong></p>
			<ul>
				<li>profileID (primary key)</li>
				<li>profileActivationToken</li>
				<li>profileEmail</li>
				<li>profileHash</li>
				<li>profilePhone</li>
				<li>profileSalt</li>
			</ul>
			<br>
			<p><strong>Favorite</strong></p>
			<ul>
				<li>likeProfileID</li>(foreign key)
				<li>likeProductName</li>(foreign key)
				<li>likeDate</li>
			</ul>
			<br>
				<p><strong>Relations</strong></p>
				<p>One verfied user can favorite many products one time</p>
				<p>Many verified users can favorite many products one time </p>
				<p>One verified user can unfavorite many products one time</p>
				<p>Many verified users can unfavorite many products one time</p>

		</body>










</html>