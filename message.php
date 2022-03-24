<?php

// get the type of message
$type = (isset($_GET['type'])) ? $_GET['type'] : false;

switch ($type) {
    case 'php':
        $title = 'Incompatible PHP version';
        $header = 'Incompatible PHP version';
        $headerClass = 'text-rose-600';
        $message = 'Your server is using an incompatible version of PHP. In order to run Nova 2.7, your server must be running <span class="font-bold text-slate-800">PHP 7.0</span> or higher, but it looks it\'s only running <span class="font-bold text-rose-600">PHP '.PHP_VERSION.'</span>. Please contact your host to resolve this issue.';
        $additionalHelp = true;
    break;

    case 'maintenance':
        $title = 'Site down for maintenance';
        $header = 'Site down for maintenance';
        $headerClass = 'text-sky-500';
        $message = "We're doing some maintenance on the site right now and it isn't available. This shouldn't take very long, so please try again in a little while.";
        $additionalHelp = false;
    break;

    case 'banned':
        $title = 'Entry disallowed';
        $header = 'Entry disallowed';
        $headerClass = 'text-rose-600';
        $message = "The Game Master has issue a complete ban against your account. <a href=\"index.php/main/contact\" class='pb-px border-b border-slate-300 hover:border-slate-400'>Contact the Game Master</a> to discuss lifting the ban. You will not be able to access the site until the ban has been removed.";
        $additionalHelp = false;
    break;

    case 'browser':
        $title = 'Unsupported browser version';
        $header = 'Unsupported browser version';
        $headerClass = 'text-sky-500';
        $message = "You're running a version of Internet Explorer that isn't supported. In order to use Nova 2.7, you need to be running Internet Explorer 11 or higher (we recommend Microsoft Edge). You can find updates to Internet Explorer in Windows Update or from <a href=\"https://microsoft.com/windows/internet-explorer/default.aspx\" target=\"_blank\" class='pb-px border-b border-slate-300 hover:border-slate-400'>microsoft.com</a>. Or better yet, switch to <a href=\"https://getfirefox.com\" target=\"_blank\" class='pb-px border-b border-slate-300 hover:border-slate-400'>Firefox</a> or <a href=\"https://google.com/chrome\" target=\"_blank\" class='pb-px border-b border-slate-300 hover:border-slate-400'>Google Chrome</a> for a better experience.";
        $additionalHelp = true;
    break;
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title;?></title>
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="font-sans text-slate-500 antialiased bg-slate-100">
		<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-xl">
				<div class="bg-white rounded-lg shadow-xl ring-1 ring-slate-900/5 overflow-hidden">
                    <div class="p-6">
                        <h1 class="text-4xl font-extrabold tracking-tight <?php echo $headerClass;?>"><?php echo $header;?></h1>
                        <p class="mt-4 text-lg font-medium leading-relaxed"><?php echo $message;?></p>
                    </div>

					<?php if ($additionalHelp === true) { ?>
                        <div class="bg-slate-50 border-t border-slate-900/5 py-4 px-6">
                            <a href="https://discord.gg/7WmKUks" target="_blank" class="inline-flex items-center group space-x-1 rounded-md py-2 px-4 bg-white text-slate-500 ring-1 ring-gray-900/5 hover:bg-slate-100 hover:ring-gray-900/10 hover:text-slate-600 font-semibold">
                                <span>Get additional help from Anodyne</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-slate-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>