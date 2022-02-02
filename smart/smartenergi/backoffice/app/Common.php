<?php namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Common extends Model {

	public function scopeSitecontent() {

	    return DB::select('SELECT a.id,a.term,MAX( CASE WHEN b.language_id = 1 THEN language_term END ) as term_english , MAX(CASE WHEN b.language_id = 2 THEN language_term END ) as term_spanish FROM `smc_terms` a join `smc_term_language` b on a.id=b.term_id join `smc_languages` c on c.id=b.language_id  group by b.term_id order by a.id desc');
	}

	public function scopeSpecificTermData($id) {
		//print_r($id);die();
	    return DB::select("SELECT a.id,a.term,MAX( CASE WHEN b.language_id = 1 THEN language_term END ) as term_english , MAX(CASE WHEN b.language_id = 2 THEN language_term END ) as term_spanish FROM `smc_terms` a join `smc_term_language` b on a.id=b.term_id join `smc_languages` c on c.id=b.language_id where a.id='$id' group by b.term_id");
	}

}