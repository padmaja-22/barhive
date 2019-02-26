<?php
/**
 * Created by PhpStorm.
 * User: boblu
 * Date: 24/02/2019
 * Time: 21:11
 */

namespace App\Http\Controllers\api\v1;


use App\Bill;
use App\Table;

class BillController
{
    public function pay($id)
    {
        $oBill = Bill::where('id', $id)->first();
        $oBill->iStatus = 1;
        $oBill->save();

        $oTable = Table::where('iTableId', $oBill->iTableId)->first();
        $oTable->sCurrentStatus = 'empty';
        $oTable->save();
    }
}