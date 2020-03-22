// função jquery
$(function() {

	// máscara no campo preço	
	$('input[name=total_price]').mask('#.##0,00', {reverse:true, placeholder:'R$ 0,00'});

	// função para adicionar um cliente (id, name)
	$('.provider_add_button').on('click', function(e) {
		e.preventDefault();
		var name = $('#provider_name').val();		
		if (name != '' && name.length >= 4) {
			if (confirm('Você deseja realmente adicionar o fornecedor '+name+' ?')) {
				$.ajax({
					url:BASE_URL+'ajax/add_provider',
					type:'POST',
					data:{name:name},
					dataType:'json',
					success:function(json) {
						$('.searchresults').hide();	
						// id					
						$('input[name=provider_id]').val(json.id);
					}
				});
				return false;
			}
		}
	});

	// função para busca ao digitar no campo
	$('#provider_name').on('keyup', function() {
		var datatype = $(this).attr('data-type');
		var q = $(this).val();
		if (datatype != '') {			
			$.ajax({
				url:BASE_URL+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json) {

					if ( $('.searchresults').length == 0 ) {
						$('#provider_name').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#provider_name').offset().left+'px');
					$('.searchresults').css('top', $('#provider_name').offset().top+$('#provider_name').height()+3+'px');
					
					var html = '';

					for (var i in json) {
						html += '<div class="si"><a href="javascript:;" onclick="selectProvider(this)" data-id="'+json[i].id+'">'+json[i].name+'</div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}				
			});			
		}
	});	
	// função para busca ao digitar no campo
	$('#add_prod').on('keyup', function() {
		var datatype = $(this).attr('data-type');
		var q = $(this).val();
		if (datatype != '') {			
			$.ajax({
				url:BASE_URL+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json) {

					if ( $('.searchresults').length == 0 ) {
						$('#add_prod').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#add_prod').offset().left+'px');
					$('.searchresults').css('top', $('#add_prod').offset().top+$('#add_prod').height()+3+'px');
					
					var html = '';

					for (var i in json) {						
						html += '<div class="si"><a href="javascript:;" onclick="addProd(this)" data-id="'+json[i].id+'" data-price="'+json[i].price+'" data-name="'+json[i].name+'">'+json[i].name+' - '+formatNumber(json[i].price)+'</div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}				
			});			
		}
	});	
	
});
// função para selecionar fornecedor
function selectProvider(obj)
{
	var id = $(obj).attr('data-id');
	var name = $(obj).html();
	$('.searchresults').hide();
	$('#provider_name').val(name);
	$('input[name=provider_id]').val(id);
}
// função para adicionar produtos
function addProd(obj)
{
	// limpa o campo
	$('#add_prod').val('');

	var id    = $(obj).attr('data-id');
	var name  = $(obj).attr('data-name');
	var price = $(obj).attr('data-price');
	

	$('.searchresults').hide();

	// verifica se o campo já está na tabela
	if ($('input[name="quant['+id+']"]').length == 0) {
		var tr = 
		'<tr>'+
			'<td>'+name+'</td>'+
			'<td><input type="number" name="quant['+id+']" class="p_quant" value="1" onchange="updateSubTotal(this)" data-price="'+price+'" /></td>'+
			'<td>'+formatNumber(price)+'</td>'+
			'<td class="subtotal">'+formatNumber(price)+'</td>'+
			'<td><a href="javascript:;" onclick="excluirProd(this)">Excluir</a></td>'+			
		'</tr>';
		
		$('#product_table').append(tr);
	}

	updateTotal();
}
function excluirProd(obj)
{
	$(obj).closest('tr').remove();
	updateTotal();
}
function updateSubTotal(obj)
{
	var quant = $(obj).val();
	if (quant <= 0) {
		$(obj).val(1);
		quant = 1;
	}
	var price = $(obj).attr('data-price');
	var subtotal = price * quant;
	$(obj).closest('tr').find('.subtotal').html(formatNumber(subtotal));

	updateTotal();
}
function updateTotal()
{
	var total = 0;
	for (var q = 0; q < $('.p_quant').length; q++) {
		// selecionar o campo
		var quant = $('.p_quant').eq(q);
		var price = quant.attr('data-price');		
		var subtotal = price * parseInt(quant.val());
		total += subtotal;
	}

	$('input[name=total_price]').val(formatNumber(total));
}
function formatNumber(n)
{
	return Number(n).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}