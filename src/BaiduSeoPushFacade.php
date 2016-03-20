<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace HyanCat\BaiduSeoPush;

use Illuminate\Support\Facades\Facade;

class BaiduSeoPushFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'baiduseopush';
	}

}