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

    public function BindLoadGoods(Request $request)
    {
        $BaseSystem = new BaseSystem();
        $where = $BaseSystem->defaultWhere();
        $where = array_merge($where, $BaseSystem->GenSqlWhereSearch('Goods', $request['thisFilter'], $request['txtSearch']));
        $OrderBy = 'CreatedDate';
        $Goods = $BaseSystem->sqlQueryWithPagination('smGoods', $where, $OrderBy, 15);
        return Response()->json($Goods);
    }

    public function BindManage(Request $request)
    {
        $IsSuccess = false;
        $IsDupicate = false;
        
        try {
            $IsBarcode = boolval($request['IsBarcode']);
            $GoodsBarcode = $request['GoodsBarcode'];
    
            $Goods = new Goods();
            $Goods->GoodsID = substr(uniqid(), 3);
            $Goods->GoodsNo = $request['GoodsNo'];
            $Goods->GoodsBarcode = $IsBarcode ? $GoodsBarcode : null;
            $Goods->GoodsName = $request['GoodsName'];
            $Goods->GoodsQty = 1;
            $Goods->GoodsPrice = $request['GoodsPrice'];
            $Goods->GoodsCost = $request['GoodsCost'] != null ? $request['GoodsCost'] : 0;
            // $Goods->GoodsUnitID = $UnitID;
            // $Goods->GoodsUnitName = $UnitData->UnitName;
            $Goods->CreatedByID = '1';
            //strval(Auth::user()->UserID);
            $Goods->ModifiedByID = null;
            $Goods->ModifiedDate = null;
            $Goods->IsBarcode = $IsBarcode;
            $Goods->IsDelete = false;
            $Goods->IsInactive = false;
            $Goods->save();
            return response()->json($Goods, 201);
        } catch (\Throwable $th) {
            dd($th);
            //return response('Not Data!', 205)->header('Content-Type', 'text/plain');
        }
        
        

        // if ($request->ajax()) {
        //     try {
        //         $BaseSystem = new BaseSystem();
        //         $IsBarcode = boolval($request->input('IsBarcode'));
        //         $GoodsBarcode = $request->input('GoodsBarcode');
        //         $where = $BaseSystem->defaultWhere();
        //         $whereBarcode = $where;
        //         $whereBarcode['GoodsBarcode'] = $GoodsBarcode;
        //         if (boolval($IsBarcode)) {
        //             $Count = $BaseSystem->sqlCount('smGoods',$whereBarcode,'GoodsBarcode');
        //         }

        //         if ($Count == 0) {
        //             $UnitID = $request->input('unitGoods');
        //             $where = $BaseSystem->defaultWhere();
        //             //array_push($where, 'UnitID');
        //             $where['UnitID'] = $UnitID;
        //             $fields = array('UnitName');
        //             $UnitData = $BaseSystem->sqlQuerySomeFields('smUnit', $where, $fields, true);
    
        //             $Goods = new Goods();
        //             $Goods->GoodsID = substr(uniqid(), 3);
        //             $Goods->GoodsNo = $request->input('GoodsNo');
        //             $Goods->GoodsBarcode = $IsBarcode ? $GoodsBarcode : null;
        //             $Goods->GoodsName = $request->input('GoodsName');
        //             $Goods->GoodsQty = 1;
        //             $Goods->GoodsPrice = $request->input('GoodsPrice');
        //             $Goods->GoodsCost = $request->input('GoodsCost') != null ? $request->input('GoodsCost') : 0;
        //             $Goods->GoodsUnitID = $UnitID;
        //             $Goods->GoodsUnitName = $UnitData->UnitName;
        //             $Goods->CreatedByID = strval(Auth::user()->UserID);
        //             $Goods->ModifiedByID = null;
        //             $Goods->ModifiedDate = null;
        //             $Goods->IsBarcode = boolval($IsBarcode);
        //             $Goods->IsDelete = false;
        //             $Goods->IsInactive = false;
        //             $Goods->save();
    
        //             $IsSuccess = true;
        //         }else {
        //             $IsSuccess = false;
        //             $IsDupicate = true;
        //         }
                
        //         return Response()->json(array($IsSuccess,$IsDupicate));
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //         return Response()->json(array($IsSuccess,$IsDupicate));
        //     }
        // }
    }
}
