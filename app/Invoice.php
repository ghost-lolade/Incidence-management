<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no', 'invoice_date', 'due_date',
        'title', 'sub_total', 'discount','status','wht',
        'grand_total', 'client','banker',
        'client_address','tax','contact_person'
    ];

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function companyAccount()
    {
        return $this->hasMany(CompanyAccount::class);
    }
}
