<?php

if ( ! class_exists( 'InstagramSource' ) ) {

	class InstagramSource{

		private	$id_user;
		private $token;
		private $source;
		public $source_status;
		private $limit;

		public function __construct( $id_user, $token, $limit = 20 ){
			$source					= array();
			$limit					= intval( $limit );
			$this->source_status	= '';
			$this->token			= $token;
			$this->id_user			= $id_user;
			$this->limit			= ( $limit <= 0 && $limit > 20 )? $limit = 20 : $limit = $limit;

			$data = $this->get_data_form_instagram();

			if( 'curl_error' != $data ){
				$this->source	= $this->fetch_data( $data );
			}
			else $this->source_status = 'instagram error: - 1';
		}//end __constructor


		private function get_data_form_instagram(){

			if( !function_exists('curl_version') ) {
				$data = 'curl_error';
			}else{
				$url = 'https://api.instagram.com/v1/users/' . $this->id_user. '/media/recent/?access_token=' . $this->token;

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");

				$data = curl_exec($ch);
				curl_close($ch);
				$data = json_decode( $data );
				$data = $data->data;
			}

			return $data;
		}//end get_data_form_instagram

		private function fetch_data( $data ){

			$result	= array();
			$data_C	= count( $data );

			for( $i=0, $j = 0; $i < $data_C && $j < $this->limit; $i++ ){

				if( 'image' == $data[ $i ]->type ){
					$j++;
					$result[] = array(
						'url'		=> $data[ $i ]->link,
						'comments'	=> $data[ $i ]->comments->count,
						'likes'		=> $data[ $i ]->likes->count,
						'img'		=> $data[ $i ]->images->standard_resolution->url,
					);
				}
			}
			return $result;
		}

		public function getData(){
			return $this->source;
		}
	}//end InstagramSource
}

