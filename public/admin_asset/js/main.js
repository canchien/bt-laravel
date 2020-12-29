var state= false;
    function showPassword(id){
        if(!state){
            document.getElementById(id).type= "text";
            state = true;
        }else{
            document.getElementById(id).type= "password";
                state = false;
        }
    }


function showPreview(event){
    if(event.target.files.length > 0){
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("avatar-info");
        preview.src = src;
        preview.style.display = "block";
        }
}
function deleteAvt(){
    document.getElementById("avatar-info").src= "https://htmlstream.com/front-dashboard/assets/img/160x160/img1.jpg";
    document.getElementById("avt-info").value = "";
    document.getElementById("getImg").value = "";
}

$(document).ready(function(){
    CountSelectedCB = [];
    $("input:checkbox").change(function() {
        selectedCB = [];
        notSelectedCB = [];

        CountSelectedCB.length = 0; // clear selected cb count
        $("input[name=check]").each(function() {
            if ($(this).is(":checked")) {
                CountSelectedCB.push($(this).attr("value"));
            }
        });

        $('input[name=selectedCB]').val(CountSelectedCB);

    });
});


$("#select-all").click(function(){
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
});

// $('.my-select').SumoSelect({
// 	placeholder: "nothing selected",
//     csvDispCount: 4,
// });
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $("#bulkActions").on("submit", function(){
        var action = document.getElementById('actions').value;
        if(action == "none"){
            alert('You need to choose an action');
            return false
        }else{
            return confirm('Are you sure?');
        }
    });
});

function removeItem(){
    return confirm('Are you sure you want to delete this item?');
}
function errorRole(){
    alert('you don\'t have the permission to access this.');
    return false;
}


$(document).ready(function(){
    $('.mul-select').select2({
        placeholder: "select tags",
        tags: true,
    });
});



