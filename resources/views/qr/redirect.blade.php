<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function (){
        if(navigator.userAgent.toLowerCase().indexOf("android") > -1){
            window.location.href = 'https://play.google.com/store/apps/details?id=com.alahram.suiiz';
        }
        if(navigator.userAgent.toLowerCase().indexOf("iphone") > -1){
            window.location.href = 'https://apps.apple.com/eg/app/suiiz/id1586166664';
        }
        window.location.href = 'https://suiiz.com';
    });
</script>
