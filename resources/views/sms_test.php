<?php 

    echo 'Hello..! Works Perfect';
?>

<script language="JavaScript" type="text/JavaScript" >
    function send_with_ajax( the_url ){
        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() { alertContents(httpRequest); };  
        httpRequest.open("GET", the_url, true);
        httpRequest.send(null);
    }
</script>

<script language="javascript" type="text/javascript">   
    alert ('sent')
    // send_with_ajax('https://apps.mnotify.net/smsapi?key=uMl30OFBEGRUJXApCnmkgV9mb&to=0247873637&msg=Just Testing&sender_id=MASLOC');
    // send_with_ajax('https://apps.mnotify.net/smsapi?key=<KeyIDSession>&to=<?php echo $mobileno; ?>&sender_id=JOE&msg=Dear Joe, Message string here!1.');
</script>