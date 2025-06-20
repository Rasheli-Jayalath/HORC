// JavaScript Document
$(document).ready(function() {
    //Hide Loading Image
    function Hide_Load() {
        $("#loading").fadeOut('slow');
    };
    //Default Starting Page Results
    $("#pagination li").css({'border' : 'solid #dddddd 1px'}).css({'color' : '#0063DC'}).css({'padding' : '4px 8px '}).css({'font-size' : '12px'}).css({'font-weight' : '400'});
    $("#pagination li").css({'display' : 'none'});
    $("#pagination li:first").css({'color' : '#031b8f'}).css({'border' : 'none'}).css({'box-shadow' : '5px 5px 5px #506dfb'}).css({'display' : 'block'}).css({'font-size' : '12px'}).css({'font-weight' : '700'});
    var pageNum ;
    if(pageNum != 1){
        $("#pagination li:nth-child(2)").css({'display' : 'block'});
        $("#pagination li:nth-child(3)").css({'display' : 'block'});
        
    }
    
    $("#pagination li:last").css({'display' : 'block'}).css({'border' : 'solid #a3a5b5 1px'}).css({'color' : '#031b8f'});
    if(totalPages>75){
        count=75;
        while(count<=totalPages){
            $("#pagination li:nth-child("+count+")").css({'display' : 'block'}).css({'color' : '#031b8f'}).css({'border' : 'solid #a3a5b5 1px'});
            count = count + 75;
        }
    
    }
    if(pcd>0){
        $("#content").load("pagination_data.php?pcd=" + pcd+"&page=1", Hide_Load());
    }else{
        $("#content").load("pagination_data.php?page=1", Hide_Load());
    }
    
    //Pagination Click
    $("#pagination li").click(function(){
        //CSS Styles
        $("#pagination li").css({'border' : 'solid #dddddd 1px'}).css({'color' : '#0063DC'}).css({'box-shadow' : 'none'}).css({'font-size' : '12px'}).css({'font-weight' : '400'});
        $(this).css({'color' : '#031b8f'}).css({'border' : 'none'}).css({'box-shadow' : '5px 5px 5px #506dfb'}).css({'font-size' : '14px'}).css({'font-weight' : '700'});
        //Loading Data
        pageNum = this.id;
    
            var naxtPage =  parseInt(pageNum)+2;
            var prePage =  parseInt(pageNum)-2;
    
    
        $("#pagination li").css({'display' : 'none'});
        $("#pagination li:first").css({'display' : 'block'});
        for(i=pageNum; i<=naxtPage; i++)
        {
            if(pageNum==1){
                $("#pagination li:nth-child(" + i + ")").css({'display' : 'block'});
                $("#pagination li:nth-child(2)").css({'display' : 'block'});
                $("#pagination li:nth-child(3)").css({'display' : 'block'});
            }else{
                $("#pagination li:nth-child(" + i + ")").css({'display' : 'block'});
                $("#pagination li:first").css({'color' : '#031b8f'}).css({'border' : 'solid #a3a5b5 1px'});
            }
    
        }
        for(i=pageNum; i>=prePage; i--)
        {
            $("#pagination li:nth-child(" + i + ")").css({'display' : 'block'});
        }
    
        $("#pagination li:last").css({'display' : 'block'});
        $("#content").load("pagination_data.php?page=" + pageNum, Hide_Load());
    
    
        if(totalPages>75){
            count=75;
            while(count<=totalPages){
                $("#pagination li:nth-child("+count+")").css({'display' : 'block'}).css({'color' : '#031b8f'}).css({'border' : 'solid #a3a5b5 1px'});
                count = count + 75;
            }
        
        }
            
            $("#pagination li:last").css({'display' : 'block'}).css({'color' : '#031b8f'}).css({'border' : 'solid #a3a5b5 1px'});
            $(this).css({'color' : '#031b8f'}).css({'border' : 'none'}).css({'box-shadow' : '5px 5px 5px #506dfb'});
    
        if(pcd>0){
            $("#content").load("pagination_data.php?pcd=" + pcd+"&page=" + pageNum, Hide_Load());
            
        }else{
            $("#content").load("pagination_data.php?page=" + pageNum, Hide_Load());
        }
    });
    });