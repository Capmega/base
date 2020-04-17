$('#blogs_id').change(function(){
    let element = $(this);
    var url = element.data('url').replace("default", element.val());
    window.location.replace(url);
});
