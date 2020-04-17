import Swal from 'sweetalert2'

/**
*
* @param  {[type]} event [description]
* @return {[type]}       [description]
*/
$(document).on('click', '.question', function verifyCallback(event){
    if ($(this).data('question-accept') != 'true') {
        event.stopPropagation();
        event.preventDefault();

        let observation = $(this).data('observation');
        let this_object = this;

        if (observation) {
            Swal.fire({
                title: $(this).data('question-title'),
                html: `${$(this).data('question-text')} <br> <strong>Puedes añadir observaciones</strong>`,
                input: 'textarea',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: $(this).data('question-continue'),
                cancelButtonText: $(this).data('question-cancel')
            }).then((result) => {
                console.log(result);
                    $('#data-observation').val(result.value);
                    $(this_object).data('question-accept', 'true');
                    $(this_object).trigger(event);
                    $(this_object).unbind('click').click();
            })
        }else{
            Swal.fire({
                title: $(this).data('question-title'),
                text: $(this).data('question-text'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: $(this).data('question-continue'),
                cancelButtonText: $(this).data('question-cancel')
            }).then((result) => {
                if (result.value) {
                    // event.isDefaultPrevented = function(){ return false; }
                    // event.returnValue = true;
                    $(this_object).data('question-accept', 'true');
                    $(this_object).trigger(event);
                    $(this_object).unbind('click').click();

                }
                // event.preventDefault();
                // $(this_object).one('click', verifyCallback);
            })
        }
    }
});



/**
 * [description]
 * @return {[type]} [description]
 */
$(document).on('change', '.check-enabled', function (){
    checked_elements($(this).data('check-target'), $(this).is(':checked'), $(this).data('check-class'));
});

function check_enabled_init(){
    let avalaible_checks = [];
    let avalaible_checks_class = [];
    $('.check-enabled').each(function() {
        if ($(this).data('check-class')) {
            if (!avalaible_checks_class.includes($(this).data('check-class'))) {
                avalaible_checks_class.push($(this).data('check-class'));
                avalaible_checks.push($(this));
            }
        }
    });

    avalaible_checks.forEach(function(element) {
        checked_elements(element.data('check-target'), true ,element.data('check-class'));
    });
}

check_enabled_init();

function checked_elements(target, is_checked ,selector){
    let enable = true;

    if (is_checked) {
        $('input[data-check-class="'+selector+'"]').each(function() {
            if (!($(this).is(':checked'))) {
                enable = false;
                return;
            }
        });
    }else{
        enable = false;
    }

    let targets = getObjects(target);

    targets.forEach(function(element) {
        element.prop("disabled", !enable);
    });
}



/**
 * [getObjects description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function getObjects(data){
    data = data.split(',');
    let data_objet = [];
    data.forEach(function(element) {
        data_objet.push($(element));
    });
    return data_objet;
}



/**
 * [description]
 * @return {[type]} [description]
 */
$(document).on('click', '.send-to-server', function(){
    let href = $(this).data('send-href');
    let verified = $(this).is(':checked');
    fetch(href, {
        method: 'POST',
        body: JSON.stringify({verified: verified}),
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).then(res => res.json())
    .catch(error => console.error('Error:', error))
    .then(response => console.log('Success:', response));
});



/**
 * [description]
 * @return {[type]} [description]
 */
$(document).on('click', '.show-element', function(){
    let action = $(this).data('show-action');
    let target = $(this).data('show-target');
    switch (action) {
        case 'show':
            $("[data-show-target*='"+target+"'][data-show-action*='hide']").show();
            $(this).hide();
            $(target).show();

            break;
        case 'hide':
            $("[data-show-target*='"+target+"'][data-show-action*='show']").show();
            $(this).hide();
            $(target).hide();

            break;
    }
});

$(document).on('click', '.condition', function(){
    let target = $(this).data('condition_element');
    target = target.split(',');
    for (var i = 0; i < target.length; i++) {
        target[i] = $(target[i]);
    }

    if ($(this).is(':checkbox')) {
        if ($(this).is(":checked")) {
             for (var i = 0; i < target.length; i++) {
                 target[i].show();
             }
        }else{
             for (var i = 0; i < target.length; i++) {
                 target[i].hide();
             }
        }
    }else{

    }
});
