<?php

namespace App\Http\Controllers\IC\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BaseSystem;
use Illuminate\Support\Facades\DB;
use App\Goods;

class GoodsController extends Controller
{
    public function TestAPI()
    {
        $BaseSystem = new BaseSystem();
        $where = $BaseSystem->defaultWhere();
        $OrderBy = 'CreatedDate';
        $Goods = $BaseSystem->sqlQueryWithPagination('smGoods', $where, $OrderBy, 15);
        return Response()->json($Goods);
    }

    public function GetGoodsByBarcode($GoodsBarcode)
    {
        $BaseSystem = new BaseSystem();
        $where = $BaseSystem->defaultWhere();
        $where = array_merge($where, array('GoodsBarcode' => $GoodsBarcode));
        $fields = array('GoodsID','GoodsName','GoodsPrice');
        $Goods = $BaseSystem->sqlQuerySomeFields('smGoods', $where, $fields, true);
        if ($Goods) {
            $Goods->GoodsPrice = number_format($Goods->GoodsPrice,2);
            return Response()->json($Goods);
        }else {
            return response('Not Data!', 205)->header('Content-Type', 'text/plain');
        }
    }
}
