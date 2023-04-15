<?php

namespace Pius\Shop\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class CSVReportFacade extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'csv.report.generator';
    }
}
