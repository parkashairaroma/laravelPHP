<?php

namespace AirAroma\Library;

/**
 * 
 *
 */
class FeatureSwitch
{
	public function check($token)
	{	
		$features = app('config')['features'];

		if (! array_key_exists($token, $features)) {
			return true;
		}
	}
}