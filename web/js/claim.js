$("#claim-status").change(function(){
    
    let change = $(this).val();

    if(change==0)
    {
    	$("#photo-field").css('display','none');

    	$("#photo-block").css('display','block');

    	$("#cause-field").css('display','none');
    }
    else if(change==1)
    {
    	$("#photo-field").css('display','block');
    	
    	$("#cause-field").css('display','none');

    	$("#photo-block").css('display','none');
    } 
    else if (change==2)
    {
    	$("#photo-field").css('display','none');
    	
    	$("#cause-field").css('display','block');

    	$("#photo-block").css('display','block');
    }
});
