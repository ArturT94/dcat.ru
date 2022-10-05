$(document).ready(function () {
    $('.ratingLabel').on('click', function () {
        var val = Number($(this).prev().val());
        var id = $(this).data('id');
        var i;
        $(this).parent().parent().find('.ratingItem').removeClass('active');
        for(i=1;i<=val;i++){
            $('#ratingItem'+id+'_'+i).addClass('active');
        }
    });
	
	$('#reviewFile').change(function(){
		$('#reviewFile').each(function(){
			var name = this.value;
			reWin = /.*\\(.*)/;
			var fileTitle = name.replace(reWin, "$1");
			reUnix = /.*\/(.*)/;
			fileTitle = fileTitle.replace(reUnix, "$1");
			$('.reviewFileContent .file-text').removeClass('novalue').html(fileTitle);
		});
	});
})
