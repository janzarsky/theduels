$('.images').on('click', '.images__option', function () {
	var t = $(this);
	t.addClass('images__option--selected');
	t.siblings().removeClass('images__option--selected');
	
	$('#avatar__select').val(t.attr('value'));
});