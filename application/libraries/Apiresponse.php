<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Apiresponse {

        private $CI = "";

        function __construct() {
                $this -> CI = & get_instance();

        }

        /**

         * 
         * @param array $data response array
         * @param int $http_code status code
         *      /
         */
        public function sendjson( $data = array (), $http_code = 200, $pp = false ) {
                if ( $pp ) {
                        return $this -> CI -> output
                                        -> set_content_type( 'application/json;charset=utf-8' )
                                        -> set_status_header( $http_code )
                                        -> set_output( json_encode( $data, JSON_PRETTY_PRINT ) );
                } else {
                        return $this -> CI -> output
                                        -> set_content_type( 'application/json;charset=utf-8' )
                                        -> set_status_header( $http_code )
                                        -> set_output( json_encode( $data ) );
                }

        }

}
