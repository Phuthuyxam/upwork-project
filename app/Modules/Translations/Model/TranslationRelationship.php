<?php


namespace App\Modules\Translations\Model;


use Illuminate\Database\Eloquent\Model;

class TranslationRelationship extends Model
{
    protected $table = 'translation_relationship';
    protected $fillable = ['to_object_id','from_object_id','to_lang','from_lang', 'type'];


}
