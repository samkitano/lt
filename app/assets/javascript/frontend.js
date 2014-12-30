/**
 * Created by João on 29/11/2014.
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

function addslashes( str ) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function editPost(pID, url, aa)
{
    var $post_container = $('#post_'+ pID);
    var $post_content = $post_container.find('.post-content');
    var content = $post_content.text();
    aa.hide();

    // saber se o post tem imagens

    // Editar
    $post_content
        .empty()
        .append('<form id="nw_pst">' +
                    '<textarea name="content" id="ta_' + pID + '">'+ content.trim() +
                    '</textarea>' +
                    '<input type="hidden" value="PATCH" name="_method">'+
                '</form>')
        .append('<button style="margin-top:5px;" id="p_submit" class="btn btn-primary btn-sm pull-right">Gravar</button>');

    var $this_ta = $('#ta_' + pID);
    $this_ta.focus();
    // Fazer miniatura da img, e marcar p eliminação

    // grava ou cancela
    $('#p_submit').on('click', function(){
        var new_content = $this_ta.val();
        $.ajax({
            type:           'PATCH',
            url:            url,
            data:           $('#nw_pst').serialize(),
            dataType:       'json',
            success:        function(response)
            {
                $post_content
                    .empty()
                    .append(new_content);
                aa.show();
            }
        })
    });

    $this_ta.keyup(function(e) {
        if (e.keyCode == 27){
            $post_content
                .empty()
                .append(content);
            aa.show();
            return false;
        }
    });

    return false;
}

function deletePost(pID, url)
{
    var $post_container = $('#post_'+ pID);
    var $post_content = $post_container.find('.post-content');

    $post_content
        .append(
        '<button style="margin-top:5px;" id="p_del" class="btn btn-danger btn-sm pull-right">Eliminar</button>');

    var form = $('#del_pst');

    $('#p_del').on('click', function() {
        $.ajax({
            type:           'DELETE',
            url:            url,
            data:           {_method: 'delete'},
            dataType:       'json',
            success:        function(response)
            {
                $post_container.slideUp('slow').remove();
            }
        });
    });
}