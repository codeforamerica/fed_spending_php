<?php

class fedSpendingApi extends APIBaseClass{
// supports XML and HTML
	public static $api_url = 'http://www.fedspending.org';
	
	public static $base_options = 
				array('datype' => array('X'),
				'sortby' => array('f','r','g','p','d') ,
				'max_records' => '', 		
				'fiscal_year'=>'',
				'first_year_range'=>'',
				'last_year_range'=>'');
	
	public function __construct($url=NULL)
	{
		parent::new_request(($url?$url:self::$api_url));
	}
	
	public function make_request($options,$method_name,$valid_options=NULL){
	
		if($valid_options != NULL && is_array($valid_options)){
		echo "\n" . print_r($valid_options) . "\n";
			foreach($options as $key=>$value){
					echo "\nkey = $key : value = $value\n";
					if((is_array($valid_options[$key]) && in_array($value,$valid_options[$key])) || array_key_exists($key,$valid_options))
					$data[$key] = $value;
			}
		}
		
		// add datatype - disable this line to return HTML
		$data['datype'] = 'X';
		return self::_request($method_name,'GET',$data);
	}
	
	public function contracts($options,$detail="-1"){

		$valid_options =array( 
			'detail'=>array('-1','0','1','2','3','4'),
			'company_name'=>'',
			'city'=>'',
			'state'=>'',
			'ZIPCode'=>'',
			'vendorCountryCode'=>'',
			'vendor_cd'=>'',
			'pop_cd'=>'',
			'stateCode'=>'',
			'placeOfPerformanceZIPCode'=>'',
			'placeOfPerformanceCountryCode'=>'',
			'mod_agency'=>'',
			'maj_agency_cat'=>'',
			'psc_cat'=>'',
			'psc_sub'=>'',
			'descriptionOfContractRequirement'=>'',
			'PIID',
			'complete_cat'=> array('c','o','p','n','a','f','u')
			);

	
	// pass parameters via options, theres a parameter at the 
	// fpds.php
	// at least one option is required to search
		$options['detail'] = $detail;
		$options = array_intersect_key($options,array_merge(self::$base_options,$valid_options));
		return self::make_request($options,'/fpds/fpds.php',$valid_options);	
	}
	
	public function assistance($options,$detail="-1"){
		$options['detail'] = $detail;
		$valid_options = array(
						'detail'=>array('-1','0','1','2','3','4'),
						'state'=>'',
						'fiscal_year'=>'',
						'fiscal_year_range'=>'',
						'last_year_range'=>'',
						'recipient_name'=>'',
						'recipient_city_name'=>'',
						'recipient_state_code'=>'',
						'recipient_zip'=>'',
						'recipient_county_name'=>'',
						'recipient_cd'=>'',
						'principal_place_state_code'=>'',
						'principal_place_cc'=>'',
						'agency_code'=>'',
						'maj_agency_cat'=>'',
						'recip_cat_type'=>array('f','g','h','i','n','o'),
						'asst_cat_type'=>array('d','g','i','l','o'),
						'project_description'=>'',
						'cfda_program_num'=>'',
						'federal_award_id'=>'');
		
		$options = array_intersect_key($options,array_merge(self::$base_options,$valid_options));
		
		return self::make_request($options,'/faads/faads.php',$valid_options);	
	
	}
	
	public function recover($options,$detail="-1"){
	//doesn't use 'sort' option ,it is 'sortp', remove and add value before doing array merges
		
		$options['detail'] = $detail;
		$temp_array = self::$base_options;
		unset($temp_array['sort']);
		$temp_array['sortp'] ='';
		
		$valid_options = array( 
						'detail'=>array('-1','0','1','2','3','4'),
						'recipient_name' => '', 	
						'entity_duns' => '',
						'recipient_st' => '',
						'recipient_cd' => '', 	
						'recipient_zip_code' => '',
						'recipient_rl' => array('p','s','v'),
						'pop_state_cd' => '',
						'pop_city' => '',
						'pop_cd' => '', 
						'pop_postal_cd' => '',
						'pop_country_cd' => '', 
						'funding_agency_cd' => '',
						'awarding_agency_cd' => '', 	
						'funding_tas ' => '',
						'cfda_number' => '',
						'govt_contract_office_cd' => '',
						'award_type' => array('G','L','C'),
						'award_number' => '',
						'order_number' => '',
						'activity_yn' => array('y','n'), 	
						'project_description' => '',
						'full_text' => '',
						'award_amount' => '',
						'number_of_jobs' => '',
						'recipient_officer_totalcomp_1' => '');
		$valid_options = array_merge($valid_options,$temp_array);				
		return self::make_request($options,'/rcv/rcv.php',$valid_options);	
	}
}