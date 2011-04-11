<?php



class Helpers_Currency  {

  public function Currency($amount, $no_zeros = FALSE, $no_sign = FALSE, $sign = '$' ){
   		$value = $amount;
        
        if( is_numeric( $value ) ){
            
            if($value == 0 && $no_zeros){
                $currency = '-';
            } else {
                
                $value = $this->cleanNumber( $value );
            
                $currency = number_format( $value, 2, '.', ',' );
            
                if($no_sign){
                    $sign = '';
                } else {
                    //ya tenemos un signo default
                }
                
                $currency = "{$sign} {$currency}";
                
            }
            
        } else {
            $currency = $value;
        }
        
        return $currency;
    }
    
    private function cleanNumber( $number )
    {
        
        if( strpos( $number, '.' ) ){
            $number = substr( $number, 0, strpos( $number, '.' ) );    
        } else {
            $number = $number;
        }
        
        return $number;
    }
}


?>