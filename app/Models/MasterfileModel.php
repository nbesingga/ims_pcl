<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterfileModel extends Model
{
    use HasFactory;

    protected $table = 'masterfiles';
    protected $primaryKey = 'masterfile_id';

    protected $fillable = [
        'ref_no',
        'product_id',
        'storage_location_id',
        'status',
        'item_type',
        'trans_type',
        'inv_qty',
        'inv_uom',
        'whse_qty',
        'whse_uom',
        'warehouse_id',
        'client_id',
        'store_id',
        'rack',
        'level',
        'updated_at',
        'created_at'
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function receiving()
    {
        return $this->hasOne(RcvHdr::class, 'rcv_no', 'ref_no');
    }

    public function uom()
    {
        return $this->hasOne(UOM::class, 'uom_id', 'inv_uom');
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function location()
    {
        return $this->hasOne(StorageLocationModel::class, 'storage_location_id', 'storage_location_id');
    }

}
