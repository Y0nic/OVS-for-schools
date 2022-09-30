$(document).ready(function(){
	
	// add category script
	$("#category").keyup(function(){

			if($("#category").val().length < 1){
				
				$("#category").next().show();
				$("#add_category").attr("data-bs-dismiss", "");
			
			}else{
			
				$("#category").next().hide();
				$("#add_category").removeClass("disabled");
				$("#add_category").attr("data-bs-dismiss", "modal");
				
			}

		});
	
	$("#add_category").click(function(){
		
		if($("#category").val().length < 1){
				
			$("#category").next().show();
		
		}else{
		
			$("#category").next().hide();
			
			var category = $("#category").val().replaceAll(" ", "_");
			var voting_id = $("#add_category").attr("data-voting_id");

			if($.post("ajax.php", {action: "add_category", category: category, voting_id: voting_id})){
					
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");
					$("#edit_candidate_category_reloader").load(" #edit_candidate_category_reloader");
					$("#add_candidate_category_reloader").load(" #add_candidate_category_reloader");
					
				},2500);

			} else{
				
				failed();
				
			}
			
			$("#category").val("");
			
		}
		
	});
	// add category script
	
	//add candidate
	$("#add_candidate").click(function(){
		
		var name = $("#add_candidate_modal").find(".first_name").val().replaceAll(" ", "_");
		var surname = $("#add_candidate_modal").find(".last_name").val().replaceAll(" ", "_");
		var category = $("#add_candidate_modal").find(".category").val();
		var img_profile = $("#add_candidate_modal").find(".profile").val();
		var voting_id = $(this).attr("data-voting_id");
		
		if($.post("ajax.php", {action: "add_candidate", name: name, surname: surname, category: category, voting_id: voting_id})){
					
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");
					
				},1500);
				
			} else{
				
				failed();
				
			}
		
		$("#add_candidate_modal").find(".first_name").val("");
		$("#add_candidate_modal").find(".last_name").val("");
		$("#add_candidate_modal").find(".category").val("");
		$("#add_candidate_modal").find(".profile").val("");
		
	});
	//add candidate
	
	//edit candidate
	$("#save_candidate").click(function(){
		
		var id = $(this).attr("data-id");
		var name = $("#edit_candidate_modal").find(".first_name").val().replaceAll(" ", "_");
		var surname = $("#edit_candidate_modal").find(".last_name").val().replaceAll(" ", "_");
		var category = $("#edit_candidate_modal").find(".category").val();
		
		if($.post("ajax.php", {action: "edit_candidate", id: id, name: name, surname: surname, category: category})){
				
				success();
				setTimeout(function(){$("#reloader").load(" #reloader")},1500);
			
		} else{
				
			failed();
				
		}
		
	});
	//edit candidate
	
	//edit category
	$("#save_category").click(function(){
		
		var id = $(this).attr("data-id");
		var category = $("#edit_category_modal").find(".category").val().replaceAll(" ", "_");
		
		if($.post("ajax.php", {action: "edit_category", id: id, category: category})){
				
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");
					$("#edit_candidate_category_reloader").load(" #edit_candidate_category_reloader");
					$("#add_candidate_category_reloader").load(" #add_candidate_category_reloader");
					
				},1500);
			
		} else{
				
			failed();
				
		}
		
		});
	//edit category
	
	//remove function
	$("#sure").click(function(){
		
		var label = $(this).attr("data-label");
		var id = $(this).attr("data-id");
		var voting_id = $(this).attr("data-voting_id");
		
		if(label == "category"){

			var name = $(this).attr("data-category").replaceAll(" ", "_");

			if($.post("ajax.php", {action: "remove_category", id: id, category: name, voting_id: voting_id})){
				
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");
					$("#edit_candidate_category_reloader").load(" #edit_candidate_category_reloader");
					$("#add_candidate_category_reloader").load(" #add_candidate_category_reloader");
					
				},1500);
			
			} else{
				
				failed();
				
			}
			
		}else{
			
			if($.post("ajax.php", {action: "remove_candidate", id: id})){
				
				success();
				setTimeout(function(){$("#reloader").load(" #reloader")},1500);
			
			} else{
				
				failed();
				
			}
			
		}
			
	});
	//remove function
	
});

//alert modal for remove
function remove(element){

	if($(element).attr("data-label") == "category"){
		
		var id = $(element).attr("data-id");
		var name = $(element).attr("data-category");
		
		$("#alert_modal").find(".modal-title").text("Remove Category");
		$("#alert_modal").find(".modal-body").text("Are you sure you want to remove " + name + " from the list.");
		$("#alert_modal").find(".btn").addClass("btn-danger");
		$("#alert_modal").find(".btn").attr("data-label", "category");
		$("#alert_modal").find(".btn").attr("data-id", id);
		$("#alert_modal").find(".btn").attr("data-category", name);
		
	}else{
		
		var id = $(element).attr("data-id");
		var name = $(element).attr("data-first_name");
		var surname = $(element).attr("data-surname");
		
		$("#alert_modal").find(".modal-title").text("Remove Candidate");
		$("#alert_modal").find(".modal-body").text("Are you sure you want to remove " + name + " " + surname + " from the list.");
		$("#alert_modal").find(".btn").addClass("btn-danger");
		$("#alert_modal").find(".btn").attr("data-label", "candidate");
		$("#alert_modal").find(".btn").attr("data-id", id);
		
	}

};
//alert modal remove

// edit candidate and category
function edit(element){
	
	if($(element).attr("data-label") == "category"){
		
		var id = $(element).attr("data-id");
		var category = $(element).attr("data-category");
		
		$("#edit_category_modal").find("#save_category").attr("data-id", id);
		$("#edit_category_modal").find(".category").val(category);
		
	}else{
	
		var id = $(element).attr("data-id");
		var name = $(element).attr("data-first_name");
		var surname = $(element).attr("data-surname");
		var category = $(element).attr("data-category");
		
		$("#edit_candidate_modal").find("#save_candidate").attr("data-id", id);
		$("#edit_candidate_modal").find(".first_name").val(name);
		$("#edit_candidate_modal").find(".last_name").val(surname);
		$("#edit_candidate_modal").find("#" + category).attr("selected", true)
		;
	
	}
};
// edit candidate and category