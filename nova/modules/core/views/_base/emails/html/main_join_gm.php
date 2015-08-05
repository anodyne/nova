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
		
		<h3>{basic_title}</h3>
		{user}
			<p>
				<strong>{label}</strong><br />
				{data}
			<p>
		{/user}
		
		{character}
			<p>
				<strong>{label}</strong><br />
				{data}
			<p>
		{/character}
		
		{sections}
			<h3>{title}</h3>
			{fields}
				<p>
					<strong>{field}</strong><br />
					{data}
				</p>
			{/fields}
		{/sections}
		
		<h3>{sample_post_label}</h3>
		{sample_post}

		<p><em>This is an automated email, please don't reply to this message.</em></p>
	</body>
</html>