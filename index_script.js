$(document).ready(function(){

	var category = $("#voting_container").find("h2").map(function(){return $(this).attr("data-category")}).get();

	$("#check").click(function(){
		
		console.log(category);
		
		for(var i = 0; i < category.length; i++){
			
			var vote = $("#voting_container").find("[name='" + category[i] + "']:checked");
			
			console.log(vote);
			
			var check_category = $("#check_vote").find("[name='" + category[i] + "']");
			
			check_category.next().text(vote.val());
			
			if(vote.attr("data-id") === undefined){
				
				check_category.next().attr("id", "0");
				check_category.next().val("0");
				check_category.next().val("0");
			
			}else{
				
				check_category.next().attr("id", vote.attr("data-id"));
				check_category.next().attr("checked", true);
				check_category.next().attr("type", "radio");
				check_category.next().val(vote.attr("data-id"));
				check_category.next().next().text(vote.val());
			
			}
		}
		
	});
	
});