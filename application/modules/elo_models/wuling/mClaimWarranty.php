<?php

namespace app\modules\elo_models\wuling;

use Illuminate\Database\Eloquent\Model;

class mClaimWarranty extends Model
{
    protected $table = 'db_wuling_as.claim_warranty';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKodeSGMw()
    {
        return $this->belongsTo(mKodeCabangSGMW::class, 'kode_cabang_sgmw', 'id_sgmw');
    }

}

// invoice_no,
// invoice_date,
// claim_cost,
// deduction_cost,
// before_tax,
// tax,
// after_tax,
// invoice_status