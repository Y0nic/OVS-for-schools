$(document).ready(function(){
//add voting
	$("input").keyup(function(){

		if($(this).val().length < 1){
			
			$(this).next().show();
		
		}else{
		
			$(this).next().hide();
			
		}

	});
	
	$("#add_voting").click(function(){
		
		if($("#voting_title").val().length < 1){
			
			$("#voting_title").next().show();
		
		}else{
		
			$("#voting_title").next().hide();
			
		}
		
		if($("#voting_description").val().length < 1){
			
			$("#voting_description").next().show();
		
		}else{
		
			$("#voting_description").next().hide();
			
		}
		
		if($("#voting_title").val().length > 0 && $("#voting_description").val().length > 0){
			
			var voting = $("#voting_title").val();
			var des = $("#voting_description").val();
			
			if($.post("ajax.php", {action: "add_voting", title: voting, description: des})){
				
				setTimeout(function(){
					
					success();
					$("#voting_list").load(" #voting_list");
					
				},1500);
				
			} else{
				failed();
			}
			
			$("#voting_title").val("");
			$("#voting_description").val("");
			
		}else{
		
			$("#voting_description").next().show();
			$("#voting_title").next().show();
			
		}
		
	});
});
//add voting

//voting list
//alert modal for remove voting
function remove(element){
	
		var id = $(element).attr("data-id");
		var name = $(element).attr("data-voting");
		
		$("#alert_modal").find(".modal-title").text("Remove Voting");
		$("#alert_modal").find(".modal-body").text("Are you sure you want to remove " + name + " from the list.");
		$("#alert_modal").find(".btn").addClass("btn-danger")

		$("#sure").click(function(){
			
			if($.post("ajax.php", {action: "remove_voting", id: id})){
					
				setTimeout(function(){
					
					success();
					$("#voting_list").load(" #voting_list");
					
				},1500);
					
			} else{
					failed();
			}

	});
};
//alert modal remove voting

//set default display
function set_default(element){
		
		var id = $(element).attr("data-id");
		var dis = $(element).attr("data-display");
		
		$.post("ajax.php", {action: "set_default", id: id, display: dis})
		
		setTimeout(function() {$("#voting_list").load(" #voting_list")},500);

};
//set default display

//voting list