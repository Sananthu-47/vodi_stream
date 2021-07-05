$(document).ready(function() {
    let search = window.location.search;
    if(search == '')
    {
        search = '?payment=user-list';
    }

    let video_index = checkCurrentTabVideos(search);
    $('#sub-nav').children().children()[video_index].classList.add('active-background');

});

function checkCurrentTabVideos(search){
    const payment_array = ['user-list','update'];
    let data='';
    payment_array.forEach(function(ele,i){
        if(search == '?payment='+ele)
            {
                data =  i;
            }
    });
    return data;
}

// Add webseries to db
$(document).on('click','#update-payment',function(e){
    e.preventDefault();
    let action = 'update-payment';
    let id = 0;
    let monthly = $("#monthly").val();
    let quarterly = $("#quarterly").val();
    let half_yearly = $("#half-yearly").val();
    let annually = $("#annually").val();

    if(monthly != '' && quarterly != '' && half_yearly != '' && annually != ''){
        $.ajax({
            url : "../proccess/make-action.php",
            type : "POST",
            data : {action,id,monthly,quarterly,half_yearly,annually},
            success : function(data)
            {
                alert("Successfully updated");
            }
        });
    }else{
        alert("Please enter a value to procced");
    }
});