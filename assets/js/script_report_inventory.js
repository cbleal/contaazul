function openPopUp(obj)
{	
	// var data = $(obj).serialize(); // pega todos os campos do formulario
	// var url = BASE_URL+"reports/inventory_pdf?"+data;
	var url = BASE_URL+"reports/inventory_pdf";
	window.open(url, "report", "width=700,height=500");
	return false;
}