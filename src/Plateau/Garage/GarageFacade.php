<?php
namespace Plateau\Garage;
use Illuminate\Support\Facades\Facade;

class GarageFacade extends Facade {
	
	 /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'garage'; }
}