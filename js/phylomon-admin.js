/************************************
 *
 * Phylomon Admin JS
 * 
 *
 ****/
jQuery(document).ready(function($) {
	// add terms to the Classification Order Input 
	$("#classification_in_order_action").click(function(){
		var phylomon_classification_order_val  = $("#phylomon_classification_order").val();
		
			if(!phylomon_classification_order_val)
				phylomon_classification_order_val += $("#classification_in_order").html();
			else
				phylomon_classification_order_val += ", "+$("#classification_in_order").html();
			
		$("#phylomon_classification_order").val(phylomon_classification_order_val);
		return false;
	});
	
	// add terms to the Classification Taxonomy Input 
	$("#classification_in_terms_action").click(function(){
		var new_tag_classification_val  = $("#new-tag-classification").val();
		
			if(!new_tag_classification_val)
				new_tag_classification_val += $("#classification_in_terms").html();
			else
				new_tag_classification_val += ", "+$("#classification_in_terms").html();
			
		$("#new-tag-classification").val(new_tag_classification_val);
		$("#classification .taghint").hide();
		return false;
	});
	
	// add terms to the DIY Classification Order Input 
	$("#diy_classification_in_order_action").click(function(){
		var phylomon_diy_classification_order_val  = $("#phylomon_diy_classification_order").val();
		
			if(!phylomon_diy_classification_order_val)
				phylomon_diy_classification_order_val += $("#diy_classification_in_order").html();
			else
				phylomon_diy_classification_order_val += ", "+$("#diy_classification_in_order").html();
			
		$("#phylomon_diy_classification_order").val(phylomon_diy_classification_order_val);
		return false;
	});
	
	// add terms to the DIY Classification Taxonomy Input 
	$("#diy_classification_in_terms_action").click(function(){
		var new_tag_diy_classification_val  = $("#new-tag-diy-classification").val();
		
			if(!new_tag_diy_classification_val)
				new_tag_diy_classification_val += $("#diy_classification_in_terms").html();
			else
				new_tag_diy_classification_val += ", "+$("#diy_classification_in_terms").html();
			
		$("#new-tag-diy-classification").val(new_tag_diy_classification_val);
		$("#diy-classification .taghint").hide();
		return false;
	});
	
});