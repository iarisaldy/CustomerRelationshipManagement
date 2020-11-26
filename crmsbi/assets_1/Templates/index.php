<OBJECT id="closes" type="application/x-oleobject"classid="clsid:adb880a6-d8ff-11cf-9377-00aa003b7a11">
<PARAM NAME="Command" VALUE="Close">
</OBJECT>

<script language="JavaScript">
//window.open("index.asp","MainWindows","type=fullWindow,fullscreen,scrollbars=yes"); 
//window.open("index.asp","MainWindows","scrollbars=1,location=0,status=0,width=maximum,height=maximum"); 
f_open_window_max("../login.php","MainWindows") 
//window.opener = top;
//window.opener = top;window.close();
window.opener=top;
window.close()


function f_open_window_max( aURL, aWinName )
{
var wOpen;
var sOptions;

sOptions = 'status=no,menubar=no,scrollbars=yes,resizable=no,toolbar=no';
sOptions = sOptions + ',width=' + (screen.availWidth - 10).toString();
sOptions = sOptions + ',height=' + (screen.availHeight - 122).toString();
sOptions = sOptions + ',screenX=0,screenY=0,left=0,top=0';

wOpen = window.open( '', aWinName, sOptions );
wOpen.location = aURL;
wOpen.focus();
wOpen.moveTo( 0, 0 );
wOpen.resizeTo( screen.availWidth, screen.availHeight );
return wOpen;
}

</script>                                                            