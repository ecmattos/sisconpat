<?php

namespace SisConPat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\Revisionable;
use DB;

class PatrimonialType extends Revisionable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 9999999; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = [];
    #protected $revisionFormattedFields = array('title'  => 'string:<strong>%s</strong>', 'public' => 'boolean:No|Yes', 'deleted_at' => 'isEmpty:Active|Deleted');
    protected $revisionFormattedFieldNames = [
        'code' => 'Código', 
        'description' => 'Descrição',
        'asset_accounting_account_id'  => 'Conta Ativo',
        'depreciation_accounting_account_id' => 'Conta Depreciação',
        'useful_life_years' => 'Vida útil (anos)', 
        'deleted_at' => 'Excluído'
    ];
    protected $revisionNullString = 'nada';
    protected $revisionUnknownString = 'desconhecido';

    public function identifiableName() 
    {
        return $this->description;
    }

    protected $fillable = [
    	'code',
    	'description',
        'asset_accounting_account_id',
        'depreciation_accounting_account_id',
        'useful_life_years'
    ];

    public function patrimonials()
    {
        return $this->hasMany('SisConPat\Patrimonial');   
    }

    public function asset_accounting_account()
    {
        return $this->belongsTo('SisConPat\AccountingAccount', 'asset_accounting_account_id', 'id'); 
    }

    public function depreciation_accounting_account()
    {
        return $this->belongsTo('SisConPat\AccountingAccount', 'depreciation_accounting_account_id', 'id'); 
    }
}