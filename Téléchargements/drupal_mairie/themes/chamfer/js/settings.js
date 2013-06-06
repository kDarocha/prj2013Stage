// JavaScript Document
$(document).ready(function(){
//define the possible colors here for modding
//primary, secondary, header1, header2, text, link, blocks, foottext, footlink
var color_templates = [];
color_templates['default'] = ['','','', '','','','','',''];

color_templates['mudbrown'] = ['815838','3e2419','815838', 'cebfac','666666','0099FF','E7E7E7','FFFFFF','00CCFF'];

color_templates['silver'] = ['a6a6a6','e7e7e7','0099FF', '00CCFF','666666','0099FF','E7E7E7','666666','464646'];

color_templates['formalgreen'] = ['BAB966','6d6d6d','bab966', 'edec82','666666','0099FF','E7E7E7','FFFFFF','FFFFFF'];

color_templates['black'] = ['000000','000000','00CCFF', '00CCFF','666666','0099FF','E7E7E7','ffffff','ff0000'];

color_templates['space'] = ['000000','000000','00CCFF', '00CCFF','48ff00','0099FF','ff2b2b','ff00ff','ff0000'];

//toggle default schemes
  $("#edit-chamfer-color-template").change(function(){
    if ($("#edit-chamfer-color-template").val() != 'custom') {
    $("#edit-chamfer-color-primary").val(color_templates[$("#edit-chamfer-color-template").val()][0]).keyup();
	$("#edit-chamfer-color-secondary").val(color_templates[$("#edit-chamfer-color-template").val()][1]).keyup();
	$("#edit-chamfer-color-header1").val(color_templates[$("#edit-chamfer-color-template").val()][2]).keyup();
	$("#edit-chamfer-color-header2").val(color_templates[$("#edit-chamfer-color-template").val()][3]).keyup();
	$("#edit-chamfer-color-text").val(color_templates[$("#edit-chamfer-color-template").val()][4]).keyup();
	$("#edit-chamfer-color-link").val(color_templates[$("#edit-chamfer-color-template").val()][5]).keyup();
	$("#edit-chamfer-color-blocks").val(color_templates[$("#edit-chamfer-color-template").val()][6]).keyup();
	$("#edit-chamfer-color-footer-text").val(color_templates[$("#edit-chamfer-color-template").val()][7]).keyup();
	$("#edit-chamfer-color-footer-links").val(color_templates[$("#edit-chamfer-color-template").val()][8]).keyup();
	}
  });

//trigger to make sure we set the menu to custom if any cells below are changed, also trap for non-hex values
$("#edit-chamfer-color-primary,#edit-chamfer-color-secondary,#edit-chamfer-color-header1,#edit-chamfer-color-header2,#edit-chamfer-color-text,#edit-chamfer-color-link,#edit-chamfer-color-blocks,#edit-chamfer-color-footer-text,#edit-chamfer-color-footer-links").keydown(function(event){
  var key = event.keyCode;
  if (key >= 48 && key <=58 || key == 8 || key >=65 && key <= 70) {
    $("#edit-chamfer-color-template").val('custom');
  }
  else {
	return false;	
  }
});
//toggle borders
  $("#edit-chamfer-borders").change(function(){
    if ($('#border_wrapper').hasClass('main-border-10')) {
		$('#border_wrapper, .footer').addClass('main-border-0').removeClass('main-border-10');
	}else {
		$('#border_wrapper, .footer').addClass('main-border-10').removeClass('main-border-0');
	}
  });
//toggle background image  
$("#edit-chamfer-bgimage").change(function(){
    if ($('body').hasClass('bg-image')) {
		$('body').removeClass('bg-image');
	}else {
		$('body').addClass('bg-image');
	}
  });
//toggle top logo
  $("#edit-chamfer-top-logo").change(function(){
    if ($("#edit-chamfer-top-logo").val() == 0) {
	  $("#top_logo").css('display','none');
	}
	else {
	  $("#top_logo").css('display','block');
	  if ($("#edit-chamfer-top-logo").val() == 1) {
	    $("#top_logo").attr('src',$("#top_logo").attr('src').replace('logo_02.png','logo_01.png'));
	  }
	  else {
        $("#top_logo").attr('src',$("#top_logo").attr('src').replace('logo_01.png','logo_02.png'));
	  }
	}
  });
//toggle bottom logo
  $("#edit-chamfer-bottom-logo").change(function(){
	if ($("#edit-chamfer-bottom-logo").val() == 0) {
	  $("#bottom_logo").css('display','none');
	}
	else {
	  $("#bottom_logo").css('display','inline');
	  if ($("#edit-chamfer-bottom-logo").val() == 1) {
	    $("#bottom_logo").attr('src',$("#bottom_logo").attr('src').replace('logo_02.png','logo_01.png'));
	  }
	  else {
        $("#bottom_logo").attr('src',$("#bottom_logo").attr('src').replace('logo_01.png','logo_02.png'));
	  }
	}
  });
//toggle primary colors
  $("#edit-chamfer-color-primary").keyup(function(){
    $(".primary-color").css('backgroundColor',chamfer_verifyhex('#edit-chamfer-color-primary'));
  });
//toggle secondary colors
  $("#edit-chamfer-color-secondary").keyup(function(){
	var color = chamfer_verifyhex('#edit-chamfer-color-secondary');
    $(".secondary-color").css('backgroundColor',color);
    $(".main-border-color").css('borderTopColor',color);
	$(".main-border-color").css('borderBottomColor',color);
	$(".main-border-color").css('borderLeftColor',color);
	$(".main-border-color").css('borderRightColor',color);
  });
//toggle text color
  $("#edit-chamfer-color-text").keyup(function(){
      $("p, h2").css('color',chamfer_verifyhex('#edit-chamfer-color-text'));
  });
//toggle block color
  $("#edit-chamfer-color-blocks").keyup(function(){
      $(".left-col-2 div.block, .left-col-3 div.block, .right-col-3 div.block, .right-col-2 div.block").css('backgroundColor',chamfer_verifyhex('#edit-chamfer-color-blocks'));
  });
//toggle special blocks link color
  $("#edit-chamfer-color-blockstyle-link").keyup(function(){
    $(".block-minimal-menu a").css('color',chamfer_verifyhex('#edit-chamfer-color-blockstyle-link'));
  });
//toggle link color 
  $("#edit-chamfer-color-link").keyup(function(){
    $(".center-col-1 a, .center-col-2 a, .center-col-3 a, .left-col-2 a, .left-col-3 a, .right-col-2 a, .right-col-3 a").css('color',chamfer_verifyhex('#edit-chamfer-color-link'));
  });
//toggle Site title
  $("#edit-chamfer-color-header1").keyup(function(){
    $("h2.title a").css('color',chamfer_verifyhex('#edit-chamfer-color-header1'));
  });
//toggle Site slogan
  $("#edit-chamfer-color-header2").keyup(function(){
    $("h2.sub-title a").css('color',chamfer_verifyhex('#edit-chamfer-color-header2'));
  });
//toggle footer text
  $("#edit-chamfer-color-footer-text").keyup(function(){
    $(".footer").css('color',chamfer_verifyhex('#edit-chamfer-color-footer-text'));
  });
//toggle footer links
  $("#edit-chamfer-color-footer-links").keyup(function(){
    $(".footer a").css('color',chamfer_verifyhex('#edit-chamfer-color-footer-links'));
  });
//popup that will help in creation of new templates
//primary, secondary, header1, header2, text, link, blocks, foottext, footlink
  $("#edit-preset-generate").click(function(){
		var templatename = prompt('What name do you want for this template?');
		alert("color_templates['"+ templatename +"'] = ['"+ chamfer_verifyhex('#edit-chamfer-color-primary').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-secondary').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-header1').replace('#','') +"', '"+ chamfer_verifyhex('#edit-chamfer-color-header2').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-text').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-link').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-blocks').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-footer-text').replace('#','') +"','"+ chamfer_verifyhex('#edit-chamfer-color-footer-links').replace('#','') +"'];");
		return false;
	});
  //initialize colors /*$("#edit-chamfer-color-primary,#edit-chamfer-color-secondary,#edit-chamfer-color-header1,#edit-chamfer-color-header2,#edit-chamfer-color-text,#edit-chamfer-color-link,#edit-chamfer-color-blocks,#edit-chamfer-color-footer-text,#edit-chamfer-color-footer-links").keyup();*/
});

function chamfer_verifyhex(id){
  var input = $(id).val();
  if (input.length == 6 || input.length == 3) {
	  $(id).css('backgroundColor','#' + input);
	  return '#' + input;
  } else {
	$(id).css('backgroundColor','');
    return '';
  }
}