<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $returnType = PembayaranModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['payment_type', 'order_id', 'gross_amount', 'bank', 'va_number', 'pdf_link', 'status', 'tahun_ajaran'];
}