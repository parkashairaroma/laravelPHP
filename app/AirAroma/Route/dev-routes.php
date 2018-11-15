<?php


/* display develop branch in header */
if (preg_match('~(develop$|feature)~', File::get(base_path().'/.git/HEAD'), $branch)) {
	$config = app()['config']['branch'] = $branch[0];
}

if ( ! env('APP_DEBUGBAR')) {
	Debugbar::disable();
}