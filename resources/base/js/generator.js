let view       = $('#view');
let name_space = $('#name_space');
let route      = $('#route');
let translate  = $('#translate');

$('#resource').keyup(function(event) {
    view.val($(this).val());
    route.val($(this).val());
    translate.val('attributes.' + $(this).val());
    let name = $(this).val().charAt(0).toUpperCase() + $(this).val().slice(1);
    name_space.val('App\\Http\\Controllers\\' + name + 'Controller');
});
