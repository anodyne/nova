<?php

$signature = require_once __DIR__.'/signature.php';

function hashDirectory(string $directory, array $exclude = [], array $excludeDirectories = []): string
{
    $root = realpath($directory);
    if ($root === false || !is_dir($root)) {
        throw new InvalidArgumentException("Invalid directory: {$directory}");
    }

    $root = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );

    $exclude = array_flip(array_map(
        static fn (string $path): string => str_replace(DIRECTORY_SEPARATOR, '/', ltrim($path, '/')),
        $exclude
    ));
    $excludeDirectories = array_map(
        static fn (string $path): string => rtrim(str_replace(DIRECTORY_SEPARATOR, '/', ltrim($path, '/')), '/'),
        $excludeDirectories
    );

    $files = [];

    foreach ($it as $file) {
        if (!$file->isFile()) {
            continue;
        }

        $fullPath = $file->getPathname();
        $relPath = str_replace(DIRECTORY_SEPARATOR, '/', substr($fullPath, strlen($root)));

        if (isset($exclude[$relPath])) {
            continue;
        }

        $isInExcludedDirectory = false;
        foreach ($excludeDirectories as $excludedDirectory) {
            if ($excludedDirectory !== '' && strpos($relPath, $excludedDirectory . '/') === 0) {
                $isInExcludedDirectory = true;
                break;
            }
        }
        if ($isInExcludedDirectory) {
            continue;
        }

        $files[$relPath] = md5_file($fullPath); // file content hash
    }

    ksort($files, SORT_STRING); // deterministic order

    $ctx = hash_init('md5');
    foreach ($files as $path => $fileMd5) {
        hash_update($ctx, $path . "\0" . $fileMd5 . "\0"); // include path + content
    }

    return hash_final($ctx);
}

$signatureCheck = hashDirectory(__DIR__, ['signature-check.php', 'signature.php'], ['sessions']);

if ($signature === '') {
    $header = 'Signature Not Found';
    $headerClass = 'text-amber-600';
    $message = 'We could not find a saved signature, so this folder cannot be verified yet.';
} elseif ($signature === $signatureCheck) {
    $header = 'Nova Folder Verified';
    $headerClass = 'text-sky-500';
    $message = 'This folder matches the expected release signature.';
} else {
    $header = 'Verification Failed';
    $headerClass = 'text-rose-600';
    $message = 'This folder does not match the expected release signature. Files may be missing, extra, or changed.';
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Signature check</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-slate-500 antialiased bg-white">
        <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-md">
                <div class="lg:col-start-3 lg:row-end-1">
                    <h2 class="sr-only">Summary</h2>
                    <div class="rounded-lg bg-gray-50 shadow-xs border border-gray-900/5">
                        <dl class="flex flex-wrap">
                            <div class="flex-auto pt-6 pl-6">
                                <dt class="text-sm/6 font-semibold text-gray-900"><?php echo $header;?></dt>
                            </div>
                            <div class="flex-none self-end px-6 pt-4">
                                <dt class="sr-only">Status</dt>

                                <?php if ($signature === '') { ?>
                                    <dd class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Setup needed</dd>
                                <?php } elseif ($signature === $signatureCheck) { ?>
                                    <dd class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Verified</dd>
                                <?php } else { ?>
                                    <dd class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Needs attention</dd>
                                <?php } ?>
                            </div>
                            <div class="text-sm/6 px-6 pt-4">
                                <?php echo $message;?>
                            </div>
                            <div class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6">
                                <dt class="flex-none">
                                    <span class="sr-only">Expected Signature</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                </dt>
                                <dd class="text-sm/6 font-mono font-medium text-gray-900"><?php echo $signature;?></dd>
                            </div>
                            <div class="mt-4 mb-6 flex w-full flex-none gap-x-4 px-6">
                                <dt class="flex-none">
                                    <span class="sr-only">Actual Signature</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3m3 3a3 3 0 1 0 0 6h13.5a3 3 0 1 0 0-6m-16.5-3a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3m-19.5 0a4.5 4.5 0 0 1 .9-2.7L5.737 5.1a3.375 3.375 0 0 1 2.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 0 1 .9 2.7m0 0a3 3 0 0 1-3 3m0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm-3 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z" />
                                    </svg>
                                </dt>
                                <dd class="text-sm/6 font-mono font-medium text-gray-900"><?php echo $signatureCheck;?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
