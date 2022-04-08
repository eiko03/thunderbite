<?php

namespace App\Traits;

/**
 * Trait ManageAPIResponse
 * @package App\Traits
 * Responsible for formatting API response to make the response uniform for all APIs
 */
trait ManageFlashResponse
{
    protected $success='success';
    protected $fail='fail';

    public function suc_flash($data,$operation){
        session()->flash($this->success, 'The'.$data.'has been '.$operation.'ed!');
    }
    public function error_flash($data,$operation){
        session()->flash($this->fail, 'The'.$data.'can not be '.$operation.'ed!');
    }
}
