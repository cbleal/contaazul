// função jquery
$(function(){
	// função ao clicar no elemento tabitem
	$('.tabitem').on('click', function() {
		// 1o. remove as propriedades da classe activetab da tabitem que a possui
		$('.activetab').removeClass('activetab');
		// 2o. a tabitem clicada recebe as propriedades da classe activetab
		$(this).addClass('activetab');

		// variavel recebe o índice da tabitem que tem activetab		
		var item = $('.activetab').index();
		// 1o. conteúdo da classe tabbody é escondido
		$('.tabbody').hide();
		// 2o. conteúdo da classe tabbody é mostrado baseado no índice da tabitem
		$('.tabbody').eq(item).show();
	});
	// função para o campo busca ao receber o foco
	$('#busca').on('focus', function() {
		// aumenta o tamanho do campo de forma animada
		$(this).animate({
			width:'250px'
		}, 'fast');
	});
	// função para o campo busca ao perder o foco
	$('#busca').on('blur', function() {
		// diminui o tamanho do campo de forma animada
		if ($(this).val() == '') { // se o campo estiver vazio
			$(this).animate({
				width:'100px'
			}, 'fast');
		}
		setTimeout(function() {
			$('.searchresults').hide();
		}, 500);
	});
	// função para busca ao digitar no campo
	$('#busca').on('keyup', function() {
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
						$('#busca').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#busca').offset().left+'px');
					$('.searchresults').css('top', $('#busca').offset().top+$('#busca').height()+3+'px');
					
					var html = '';

					for (var i in json) {
						html += '<div class="si"><a href="'+json[i].link+'">'+json[i].name+'</div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}				
			});			
		}
	});

});