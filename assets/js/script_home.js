var rel1 = new Chart(document.getElementById("rel1"), {
	type:'line',
	data:{
		labels:days_list,
		datasets:[{
			label:'Venda',
			data:[5, 6, 9, 3],
			fill:false,
			backgroundColor:'#0000FF',
			borderColor:'#0000FF'
		},
		{
			label:'Compra',
			data:[4, 7, 4, 8],
			fill:false,
			backgroundColor:'#FF0000',
			borderColor:'#FF0000'
		}]
	}
});

var rel2 = new Chart(document.getElementById("rel2"), {
	type:'pie',
	data:{
		labels:['Pago', 'Cancelado', 'Aguardando Pgto'],
		datasets:[{
			data:[7, 2, 4],
			backgroundColor:['#36A2EB', '#FFCE56', '#FF6384']
		}]
	}
});