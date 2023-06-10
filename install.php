<?php

$vendorDir = __DIR__ . '/build/'; // Path to the vendor directory
$libDir    = dirname( dirname( dirname( __DIR__ ) ) ) . '/lib/wp-package-updater-lib/'; // Path to the target directory for library files

createDirectory( $libDir );
syncDirectory( $vendorDir, $libDir );

function createDirectory( $dir ) {
	if ( ! file_exists( $dir ) ) {
		mkdir( $dir, 0777, true );
	}
}

function syncDirectory( $source, $destination ) {
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $source, RecursiveDirectoryIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::SELF_FIRST
	);

	foreach ( $iterator as $item ) {
		if ( $item->isDir() ) {
			$targetDir = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			createDirectory( $targetDir );
		} else {
			$targetFile = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			copy( $item, $targetFile );
		}
	}
}
