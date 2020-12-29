
$(document).ready(function(){
    $(".nav-item").on("click", function(){
        $(".navbar").find(".active").removeClass("active");
        $(this).addClass("active");
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('#close-modal').click(function(){
        $(".errorMessage").css("display","none");
    });
    $("#form_create_post").submit(function(e){
        e.preventDefault();
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
        }
        var formData = new FormData($("#form_create_post")[0]);
        var url = $('#button_insert').data('url');
        console.log(formData);
        $.ajax({
            url:url,
            dataType:'json',
            method:'POST',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status==0){
                    $(".errorMessage").css("display","none");
                    $.each( response.errors, function( key, value ) {
                        if(key == "title"){
                            $("#titleError").css('display','block');
                            $("#titleError").html(value);
                        }
                        if(key == "img"){
                            $("#imgError").css('display','block');
                            $("#imgError").html(value);
                        }
                        if(key == "content"){
                            $("#contentError").css('display','block');
                            $("#contentError").html(value);
                        }
                    });
                }else{
                    location.href = response.url;
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    });

    $('#btn-verify').click(function(){
        $('.toast-verify').toast({delay: 3000});
        $('.toast-verify').toast('show');
    });

    // $.ajaxSetup({
    //     headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    // });
    // function fetch_vote(){

    //     $.ajax({
    //             url:"http://localhost/bt-laravel/public/vote-count",
    //             method:"GET",
    //             success:function(response){
    //             var data = JSON.parse(response);
    //               console.log(data);
    //               $.each( data.data, function( key, value ) {
    //                 console.log('hmm'+ value);
    //             });
    //             }
    //         });
    // }
    // fetch_vote();


    // $("#upvote").click(function(e){
    //         $postId= $('#upvote').attr('id');
    //         console.log(postId);
    //         var url = "{{route('up_vote')}}";
    //         $.ajax({
    //             url:url,
    //             dataType:'json',
    //             method:'POST',
    //             data:{postId=postId},
    //             cache:false,
    //             contentType: false,
    //             processData: false,
    //             success:function(response){
    //                fetch_vote();
    //             },
    //             error:function(error){
    //                 console.log(error);
    //             }
    //         });
    // });
});
window.onscroll = function() {myFunction()};

//var navbar = document.getElementById("navbar");
var mybutton = document.getElementById("myBtn");
//var sticky = 400;

function myFunction() {
//   if (window.pageYOffset >= sticky) {
//     navbar.classList.add("sticky")
//   } else {
//     navbar.classList.remove("sticky");
//   }
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
function topFunction() {
  $('html,body').animate({scrollTop: 0},'slow');
}

function xClick() {
    var menu = document.getElementById('menu');
    var x = document.getElementById('xclick');
    x.classList.toggle("change");

    if (menu.className === "navbar-mobile") {
        menu.className += " menudisplay";
    } else {
        menu.className = "navbar-mobile";
    }
}
$(".closeCollapse").click(function (event) {
    $('.navbar-collapse').collapse('hide');
});

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
}
