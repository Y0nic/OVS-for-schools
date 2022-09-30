$(document).ready(function(){
	
	//Add User
	$("#access").change(function() {
		
		var track = $(this).parent().prev();
		
		if($("#access").val() == "admin"){
		
			track.find("label").text("Password");
			track.find("input").attr("type","password")
			track.find("input").attr("name","pass");
			track.find("input").addClass("pass");
			
		}else{
		
			track.find("label").text("LRN Number");
			track.find("input").attr("type","number")
			track.find("input").removeClass("pass");
			track.find("input").addClass("LRN");
			
		}
	});
	
	$("input").keyup(function(){
	
		if($(this).val().length < 1 || $(this).attr("name") == "LRN"){
		
			if($(this).val().length < 1 && $(this).attr("name") !== "LRN" && $(this).attr("name") !== "pass"){
			
				$(this).next().show();
				
			}else if($(this).attr("name") == "LRN"){
			
				$(this).next().show();
				
				if($(this).val().length == 0){
			
					$(this).next().text("Please enter LRN");
					
				}else if($(this).val().length !== 12){
				
					$(this).next().text("Must be 12 digits");
				
				}else{
				
					$(this).next().hide();
					
				}
				
			}else if($(this).attr("name") == "pass"){
			
				$(this).next().show();
				
				if($(this).val().length == 0){
			
					$(this).next().text("Please enter password");
					
				}else if($(this).val().length < 7){
				
					$(this).next().text("Must be at least 8 characters");
					
				}else{
				
					$(this).next().hide();
				}
				
				
				
			}else{
			
				$(this).next().hide();
				
			}
			
		}else{
		
			$(this).next().hide();
			
		}
		
	});
	
	$("#add_user").click(function(){
		
		var name = $("#add_user_container").find(".first_name").val().replaceAll(" ", "_");
		var surname = $("#add_user_container").find(".last_name").val().replaceAll(" ", "_");
		var access = $("#add_user_container").find("#access").val();
		
		if(access == "admin"){
			
			var pass = $("#add_user_container").find(".pass").val().replaceAll(" ", "_");
			
			if($.post("ajax.php", {action: "add_user", first_name: name, last_name: surname, access: access, pass: pass, LRN: "none"})){
					
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader,script");

					setTimeout(function(){

						table();

					},1000);

					$("#add_user_container").find(".first_name").val("");
					$("#add_user_container").find(".last_name").val("");
					$("#add_user_container").find(".pass").val("");
					$("#add_user_container").find("#user").val("selected", true);
					
					$("#add_user_container").find(".pass").prev().text("LRN Number");
					$("#add_user_container").find(".pass").attr("type","number");
					$("#add_user_container").find("pass").addClass("LRN");
					$("#add_user_container").find(".pass").removeClass("pass");
					
				},1500);

			} else{
				
				failed();
				
			}
			
		}else{
			
			var LRN = $("#add_user_container").find(".LRN").val();
			
			if($.post("ajax.php", {action: "add_user", first_name: name, last_name: surname, access: access, pass: "none", LRN: LRN})){
					
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");
					
					setTimeout(function(){

						table();

					},1000);
					
					$("#add_user_container").find(".first_name").val("");
					$("#add_user_container").find(".last_name").val("");
					$("#add_user_container").find(".LRN").val("");
					
					
				},1500);
				
			} else{
				
				failed();
				
			}
			
		}
		
	});
	//Add user
	
	//Edit User
	$(".edit").click(function(){
	
		var id = $(this).attr("data-id");
		var name = $(this).attr("data-first_name");
		var surname = $(this).attr("data-surname");
		var LRN = $(this).attr("data-LRN");
		var access = $(this).attr("data-access");
		var pass = $(this).attr("data-pass");
		
		
		
		$("#edit_user_modal").find(".id").val(id);
		$("#edit_user_modal").find(".first_name").val(name);
		$("#edit_user_modal").find(".last_name").val(surname);
		$("#edit_user_modal").find(".edit_lrn").val(LRN);
		$("#edit_user_modal").find(".password").val(pass);
		
		if(access == "admin"){
		
			$("#edit_user_modal").find("#admin").attr("selected", true);
			
			$("#edit_user_modal").find(".none").show();
			$("#edit_user_modal").find(".lrn").hide();
			
		}else{
		
			$("#edit_user_modal").find("#user").attr("selected", true);
		
			$("#edit_user_modal").find(".none").hide();
			$("#edit_user_modal").find(".lrn").show();
		
		}
	})
	
	$("#edit_user_modal").find("select").change(function(){
		
		if($(this).val() == "admin"){
			
			$("#edit_user_modal").find(".none").show();
			$("#edit_user_modal").find(".lrn").hide();
			
		}else{
		
			$("#edit_user_modal").find(".none").hide();
			$("#edit_user_modal").find(".lrn").show();
		
		}
		
	});
	//Edit User
	
	//remove user
	$("#sure").click(function(){
	
		var id = $(this).attr("data-id");
		var label = $(this).attr("data-label");
		
		if(label == "remove"){
		
			if($.post("ajax.php", {action: "remove_user", id: id})){
						
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");

					setTimeout(function(){

						table();

					},1000);

				},1500);

			} else{
				
				failed();
				
			}
		}else{
			
			var voting_id = $(this).attr("data-voting_id");

			if($.post("ajax.php", {action: "reset_vote", id: id, voting_id: voting_id})){
						
				setTimeout(function(){
					
					success();
					$("#reloader").load(" #reloader");

					setTimeout(function(){

						table();

					},1000);

				},1500);

			} else{
				
				failed();
				
			}
			
		}

	})
	//remove user
	
	//alert modal for reset vote
	$(".revote").click(function(){
	
		var id = $(this).attr("data-id");
		var name = $(this).attr("data-first_name");
		var surname = $(this).attr("data-surname");
		
		$("#alert_modal").find(".modal-title").text("Reset Vote");
		$("#alert_modal").find(".modal-body").text("Are you sure you want to reset vote for " + name + " " + surname + ".");
		$("#alert_modal").find(".btn").addClass("btn-warning");
		$("#alert_modal").find(".btn").removeClass("btn-danger");

	})
	//alert modal reset vote
	
	//table pagenation
	table();
	//table pagenation
	
});

//alert modal for remove
function alert(element){
		
		var label = $(element).attr("data-label");
		var id = $(element).attr("data-id");
		var name = $(element).attr("data-fullname");
		
		if(label == "remove"){
			
			$("#alert_modal").find(".modal-title").text("Remove User");
			$("#alert_modal").find(".modal-body").text("Are you sure you want to remove " + name + " from the list.");
			$("#alert_modal").find("#sure").addClass("btn-danger");
			$("#alert_modal").find("#sure").removeClass("btn-warning");
			$("#alert_modal").find("#sure").attr("data-id", id);
			$("#alert_modal").find("#sure").attr("data-label", label);
			
		}else{
			
			$("#alert_modal").find(".modal-title").text("Reset Vote");
			$("#alert_modal").find(".modal-body").text("Are you sure you want to reset vote for " + name + ".");
			$("#alert_modal").find(".btn").addClass("btn-warning");
			$("#alert_modal").find(".btn").removeClass("btn-danger");
			$("#alert_modal").find("#sure").attr("data-id", id);
			$("#alert_modal").find("#sure").attr("data-label", label);
			
		}
};
//alert modal remove

//table pagenation
function table(){
	
	$("#user_table").DataTable();
	
}
//table pagenation