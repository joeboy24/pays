<html>
    <header></header>
    <body>

        @include('inc.messages')
        <h1>{{$msg}}</h1>
        <p>{{session('smss')}}</p>
        <h3>{{$sms_det->sent_to}}</h3>
        
        @if (session('send01') == 1)
            @foreach (session('smss') as $item)
            <script language="JavaScript" type="text/JavaScript" >
                function send_with_ajax( the_url ){
                    var httpRequest = new XMLHttpRequest();
                    httpRequest.onreadystatechange = function() { alertContents(httpRequest); };  
                    httpRequest.open("GET", the_url, true);
                    httpRequest.send(null);
                }
            </script>

            <script language="javascript" type="text/javascript">   
                // alert ('sent')
                send_with_ajax("https://apps.mnotify.net/smsapi?key=EDjbRLUSSIfwfGV9gar4kmi8n&to=<?php echo $item->contact; ?>&msg=Dear <?php echo $item->employee->fname.' '.$item->employee->sname; ?>, <?php echo $msg; ?>&sender_id=MASLOC-GH");
            </script>
            @endforeach
        @endif

    </body>
</html>