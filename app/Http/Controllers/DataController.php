<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\items;
use App\Models\his_tokens;
use App\Models\personels;
use App\Models\depts;


class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data(request $request)
    {
        $info = [
            'draw' => $request->draw,
            'data' => [],
            'total' => 0,
        ];
        
        $data_array = [];
      
        $search = $request->input('search.value');
        
            $items = items::join('personels','personels.id','=','items.personel_id')->join('depts','depts.id','=','personels.dept_id')
            
                ->orWhere( function($data) use ( $search ) {
                    $data   
                            ->orwhere( "personels.name", "LIKE", "%".$search."%" )
                            ->orwhere( "depts.dept_name", "LIKE", "%".$search."%" )
                            ->orwhere( "items.description", "LIKE", "%".$search."%" )
                            ->orwhere( "items.asset_code", "LIKE", "%".$search."%" )
                            ->orwhere( "items.serial_num", "LIKE", "%".$search."%" )
                            ->orwhere( "items.mac_address", "LIKE", "%".$search."%" )
                            ->orwhere( "items.brand", "LIKE", "%".$search."%" )
                            ->orwhere( "items.asset_type", "LIKE", "%".$search."%" )
                            ->orwhere( "items.availability", "LIKE", "%".$search."%" )
                            ->orwhere( "items.created_at", "LIKE", "%".$search."%" );
                    } )
                ->orderBy('items.created_at','ASC')
                            ->dateFilter(
                                    $request->brand, 
                                    $request->Type,
                                    $request->Availability,
                                    $request->dept
                                )
                            ->take( $request->length )->skip( $request->start )->get();
    
            $info['total'] = items::join('personels','personels.id','=','items.personel_id' )->join('depts','depts.id','=','personels.dept_id')
                        ->orWhere( function($data) use ( $search ) {

                            $data   
                            ->orwhere( "personels.name", "LIKE", "%".$search."%" )
                            ->orwhere( "depts.dept_name", "LIKE", "%".$search."%" )
                            ->orwhere( "items.description", "LIKE", "%".$search."%" )
                            ->orwhere( "items.asset_code", "LIKE", "%".$search."%" )
                            ->orwhere( "items.serial_num", "LIKE", "%".$search."%" )
                            ->orwhere( "items.mac_address", "LIKE", "%".$search."%" )
                            ->orwhere( "items.brand", "LIKE", "%".$search."%" )
                            ->orwhere( "items.asset_type", "LIKE", "%".$search."%" )
                            ->orwhere( "items.availability", "LIKE", "%".$search."%" )
                            ->orwhere( "items.created_at", "LIKE", "%".$search."%" );
                    } )
                ->dateFilter(
                                $request->brand,
                                $request->Type,
                                $request->Availability,
                                $request->dept
                            )
                        ->count();

        $sl_no_counter = ( $request->start == 0 )? 1 : $request->start+1;


        foreach( $items as $item => $value ){
            
            $value->sl_no = $sl_no_counter;
            $issued = str_split($value->updated_at,10);

              array_push($data_array,[
                    '#' => $sl_no_counter,
                    'item_id' => $value->item_id,
                    'personel_id' => $value->personel_id,
                    'name' => $value->name,
                    'dept_name' => $value->dept_name,
                    'description' => $value->description,
                    'asset_code' => $value->asset_code,
                    'serial_num' => $value->serial_num,
                    'mac_address' => $value->mac_address,
                    'brand' => $value->brand,
                    'asset_type' => $value->asset_type,
                    'availability' => $value->availability,
                    'updated_at' => $issued[0]
                ]);   
                $sl_no_counter++;
        }
        $info['data'] = $data_array;
      
        return $info;
    }

     
}
