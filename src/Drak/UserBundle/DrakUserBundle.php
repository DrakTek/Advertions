<?php

namespace Drak\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DrakUserBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
