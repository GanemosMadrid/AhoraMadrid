$(function() {
	jQuery("h1").fitText(0.7);
	aaa= 10;

	


	$("#ahoramadrid_microcreditosbundle_credito_importe input:radio").change(function () {
			$('#ahoramadrid_microcreditosbundle_credito_importe').find('div').removeClass('active');	
			//$('#step-distritos').show();
			/*$('.nicEdit-panelContain').parent().width('100%');
			$('.nicEdit-panelContain').parent().next().width('98%');
			$('.nicEdit-main').width('100%');
			$('.nicEdit-main').css('min-height','10em');*/
			if($(this).is(':checked')){
				$(this).parent().parent().addClass('active');
			}
			optionIsSelected=true;
			
		});

	$(".checkbox_acepto input").change(function () {
		console.log("tiriri")
		if( $('.acepto1 input').is(':checked') && $('.acepto2 input').is(':checked') ){
			$('#send-dummy').hide();
			$('#ahoramadrid_microcreditosbundle_credito_Enviar').fadeIn();
		}
		else{
			$('#send-dummy').fadeIn();
			$('#ahoramadrid_microcreditosbundle_credito_Enviar').hide();
		}
	});
	//var ctx = $("#chart1").get(0).getContext("2d");
	//var myDoughnutChart = new Chart(ctx).Pie(data,options);

});

var data = [
   {
        value: 10,
        color: "#00A48C",
        highlight: "#5AD3D1",
        label: "Green"
    },
    {
        value: 90,
        color:"#4A4A4A",
        highlight: "#9A9A9A",
        label: "Red"
    },
 

]
var options={
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke : true,
}