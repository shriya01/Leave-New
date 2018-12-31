$(document).on('click', '.deleteDetail', function () {
    var id = $(this).data('id');
    var parentClass = $(this).parent().parent().parent();
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this entry!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: base_url + '/deleteUser',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                },
                data: {
                    id: id
                },
                success: function (response) {
                    if (response == 1) {
                        parentClass.remove();
                        swal("Deleted!", "Your entry has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Something want wrong, Please try again later", "error");
                    }
                },
                error:function(xhr)
                {
                    console.log(xhr);
                }
            });
        } else {
            swal("Cancelled", "Your entry is safe :)", "error");
        }
    });
});
