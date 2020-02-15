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
});