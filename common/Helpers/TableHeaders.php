<?php
class Helpers_TableHeaders{
    public function tableHeaders(array $headers){
        $html = '<tr>';
        foreach ($headers as $header){
        	$html .= "<th>{$header}</th>";
        }
        $html .= '</tr>';
		return $html;
    }
}