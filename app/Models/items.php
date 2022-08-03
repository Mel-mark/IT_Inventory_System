<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;

    protected $fillable = [
        'personel_id',
    	'description',
    	'asset_code',
    	'serial_num',
    	'mac_address',
    	'brand',
    	'asset_type',
    	'availability'
    ];

	public function scopeDateFilter( $data, $brand=null,$Type, $Availability,$dept)
	{
		if( $brand ==  null && $Type =='' && $Availability =='' && $Type =='' && $dept =='') 
		{
			$data->select('*');
		}
		else
		{
			if($brand !=  null )
			{
				if( $Type != '')
				{
					if( $Availability != '')
					{
						if($dept != '')
						{
							$data->where('brand','=',$brand)->where('asset_type','=',$Type)->where('Availability','=',$Availability)->where('dept_name','=',$dept);
							
						}
						else
						{
							$data->where('brand','=',$brand)->where('asset_type','=',$Type)->where('Availability','=',$Availability);
						}
					}
					else
					{
						if($dept != '')
						{
							$data->where('brand','=',$brand)->where('asset_type','=',$Type)->where('dept_name','=',$dept);

						}
						else
						{

							$data->where('brand','=',$brand)->where('asset_type','=',$Type);
						}
					}
				}
				else
				{
					if( $Availability != '')
					{
						if($dept != '')
						{
							$data->where('brand','=',$brand)->where('Availability','=',$Availability)->where('dept_name','=',$dept);
						}
						else
						{
							
							$data->where('brand','=',$brand)->where('Availability','=',$Availability);
						}

					}
					else
					{
						if($dept != '')
						{
							$data->where('brand','=',$brand)->where('dept_name','=',$dept);

						}
						else
						{
							
							$data->where('brand','=',$brand);
						}
					}
				}
			}
			else
			{
				if( $Type != '')
				{
					if( $Availability != '')
					{
						if($dept != '')
						{
							$data->where('asset_type','=',$Type)->where('Availability','=',$Availability)->where('dept_name','=',$dept);
						}
						else
						{
							
							$data->where('asset_type','=',$Type)->where('Availability','=',$Availability);
						}
					}
					else
					{
						if($dept != '')
						{
							$data->where('asset_type','=',$Type)->where('dept_name','=',$dept);

						}
						else
						{
							
							$data->where('asset_type','=',$Type);
						}
					}
				}
				else
				{
					if( $Availability != '')
					{
						if($dept != '')
						{
							$data->where('Availability','=',$Availability)->where('dept_name','=',$dept);

						}
						else
						{
							$data->where('Availability','=',$Availability);
						}
					}
					else
					{
						if($dept != '')
						{
							$data->where('depts.dept_name','=',$dept);
						}
						else
						{
							$data->select('*');
						}
					}
				}
			}
		
		}
		return $data;
	}
}
