<?php

/**
 * Created by Cristian.
 * Date: 12/10/16 12:09 AM.
 */

namespace Reliese\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request;

class WhoDidIt
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Blamable constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function creating(Eloquent $model)
    {
        $model->created_by = $this->doer();
    }

    public function updating(Eloquent $model)
    {
        $model->updated_by = $this->doer();
    }

    /**
     * @return mixed|string
     */
    protected function doer()
    {
        if (app()->runningInConsole()) {
            return 'CLI';
        }

        return $this->authenticated() ? $this->userId() : '????';
    }

    /**
     * @return mixed
     */
    protected function authenticated()
    {
        return $this->request->user();
    }

    /**
     * @return mixed
     */
    protected function userId()
    {
        return $this->authenticated()->id;
    }
}
