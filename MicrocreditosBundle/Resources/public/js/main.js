$(function() {
	jQuery("h1").fitText(0.7);
	jQuery(".btn-pdf").fitText(0.7);
	enviar_form=false;

	$("#form0").submit(function() {
	  return enviar_form;
	});


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
			enviar_form=true;
		}
		else{
			$('#send-dummy').fadeIn();
			$('#ahoramadrid_microcreditosbundle_credito_Enviar').hide();
			enviar_form=false;
		}
	});
	//sizeContent();
	//$(window).resize(sizeContent);
	
	//var ctx = $("#chart1").get(0).getContext("2d");
	//var myDoughnutChart = new Chart(ctx).Pie(data,options);

});
function sizeContent() {
	var newHeight = $(window).height() + 'px';
    $("#page1").css("height", newHeight);
}


var options={
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke : true,
    animationEasing: "easeOutQuart",
}