function success(){
	$("#action_alert").addClass("alert-success");
	$("#action_alert").find(".fas").addClass("fa-check");
	$("#action_alert").find(".alert-content").text("Action Success");
	$("#action_alert").show("slow");
	$("#action_alert").delay(1500).hide("slow");
};

function failed(){
	$("#action_alert").addClass("alert-danger");
	$("#action_alert").find(".fas").addClass("fa-times");
	$("#action_alert").find(".alert-content").text("Action Fialed");
	$("#action_alert").show("slow");
	$("#action_alert").delay(1500).hide("slow");
};

function print_result(element) {
	
	var id = $(element).attr("data-id");
	
    var printWindow = window.open("result_print.php?id=" + id, "_blank", "toolbar=0,location=0,menubar=0");
    printWindow.print();
	
};