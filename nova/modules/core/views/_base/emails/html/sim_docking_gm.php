<html>
	<head>
		<style type="text/css">
			body {
				font-family: "lucida grande", verdana, sans-serif;
				font-size: 12px;
			}
		</style>
	</head>
	<body>
		<h1>{email_subject}</h1>
		<h3>{email_from}</h3>
		
		{info}
			<p>
				<strong>{label}</strong><br />
				{data}
			<p>
		{/info}
		
		{sections}
			<h3>{title}</h3>
			{fields}
				<p>
					<strong>{field}</strong><br />
					{data}
				</p>
			{/fields}
		{/sections}

		<p><em>This is an automated email, please don't reply to this message.</em></p>
	</body>
</html>