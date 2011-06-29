<?php

class fedSpendingApi extends APIBaseClass{
// supports XML and HTML
	public static $api_url = 'http://www.fedspending.org';
	
	public static $base_options = 
				array('datype' => array('X'),
				'detail'=>array(-1,0,1,2,3,4),
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
			foreach($options as $key=>$value){
					if((is_array($valid_options[$key]) && in_array($value,$valid_options[$key])) || array_key_exists($key,$valid_options))
					$data[$key] = $value;
			}
		}
		
		// add datatype - disable this line to return HTML
		$data['datype'] = 'X';
		return self::_request($method_name,'GET',$data);
	}
	
	public function contracts($options,$detail=-1){

		$valid_options =array( 
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
	
	public function assistance($options,$detail=-1,$state=NULL){
		$options['detail'] = $detail;
		if($state != NULL) $options['state'] = $state;	
		$valid_options = array('fiscal_year'=>'','fiscal_year_range'=>'','last_year_range'=>'','recipient_name'=>'','recipient_city_name'=>'','recipient_state_code'=>'','recipient_zip'=>'','recipient_county_name'=>'','recipient_cd'=>'','principal_place_state_code'=>'','principal_place_cc'=>'','agency_code'=>'','maj_agency_cat'=>'','recip_cat_type'=>array('f','g','h','i','n','o'), 'asst_cat_type'=>array('d','g','i','l','o'),'project_description'=>'','cfda_program_num'=>'','federal_award_id'=>'');
		
		$options = array_intersect_key($options,array_merge(self::$base_options,$valid_options));
		
		return self::make_request($options,'/faads/faads.php',$valid_options);	
	
	}
	
	public function recover($options,$detail=-1){
	//doesn't use 'sort' option ,it is 'sortp', remove and add value before doing array merges
		$temp_array = self::$base_options;
		unset($temp_array['sort']);
		$temp_array['sortp'] ='';
		$options = array_intersect_key($options,$temp_array);
		return self::make_request($options,'/faads/faads.php');	
	}
}