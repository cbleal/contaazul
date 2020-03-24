function openPopUp(obj)
{
	// pegar os campos do formulario
	var data = $(obj).serialize();
	// definir a url para ser aberta na janela
	var url = BASE_URL+"reports/purchases_pdf?"+data;
	// cria janela
	window.open(url, "report", "width=700, height=500");

	return false;
}