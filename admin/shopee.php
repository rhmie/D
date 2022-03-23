<?php

	include('../simple_html_dom.php');

	//$ch = curl_init('https://shopee.tw/api/v4/search/search_items?by=pop&entry_point=ShopByPDP&limit=30&match_id=28712629&newest=30&order=desc&page_type=shop&pdp_l3cat=5905&scenario=PAGE_OTHERS&version=2');
	
	$ch = curl_init('https://www.momoshop.com.tw/goods/GoodsDetail.jsp?i_code=8457199&str_category_code=2900900253');
	
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$str = curl_exec($ch);
	$html = str_get_html($str);

	echo $str;

?>