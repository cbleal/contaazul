// FUNÇÃO QUE PEGA OS DADOS (ENDEREÇO, CIDADE, ESTADO) BASEADOS NO CEP DIGITADO
$('input[name=address_zipcode]').on('blur', function() {
	// PEGA O VALOR DO CAMPO
	var value = $(this).val();
	// REMOVE TUDO O QUE NÃO FOR DÍGITOS (NÚMEROS) DA STRING JAVASCRIPT - MÁSCARA
	var cep = value.replace(/[^\d]+/g,'');
	
	$.ajax({
		url:'http://api.postmon.com.br/v1/cep/'+cep,
		type:'GET',
		dataType:'json',
		success:function(json){
			// console.log(json);
			if (typeof json.logradouro != 'undefined') {
				$('input[name=address]').val(json.logradouro);
				$('input[name=address_neighb]').val(json.bairro);
				$('input[name=address_city]').val(json.cidade);
				$('input[name=address_state]').val(json.estado);
				$('input[name=address_country]').val("Brasil");
				$('input[name=address_number]').focus();
			}
		}
	});
});
// FUNÇÃO QUE MONTA O SELECT DAS CIDADES BASEADO NO ESTADO SELECIONADO
function getCity(obj)
{
	var state = $(obj).val();

	$.ajax({
		url:BASE_URL+'ajax/getListCities',
		type:'GET',
		data:{state,state},
		dataType:'json',
		success:function(json) {
			var html = '';
			for (var i in json) {
				html += '<option value="'+json[i].CodigoMunicipio+'">'+json[i].Nome+'</option>';
			}
			$('#city').html(html);
		}

	});
}
