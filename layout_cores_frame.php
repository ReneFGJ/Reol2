
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Códigos de Cores HTML</title>
	<meta name="description" content="O website Códigos de Cores HTML fornece ferramentas de cor grátis para encontrar cores HTML para o seu website. As grandes ferramentas Gráfico de cores HTML e Escolha de Cores HTML vão tornar isto simples como dar uma volta no parque." />
	<META NAME="keywords" content="html, color, codes, chart, picker, hex">
	<link rel="shortcut icon" href="http://c632769.r69.cf2.rackcdn.com/favicon.ico" type="image/x-icon" />

</head>
<body>

<style>
#colorchart{border:0;padding:0;border-collapse:collapse;}#colorchart td{width:23px;height:23px;}.wrapper{height:100px;}.holder{width:68px;height:68px;float:left;margin-right:1px;}.wrapper div div{height:68px;float:left;}.wrapper div div div{width:38px;height:38px;margin:15px;}
	.off{background-image:url('http://c632769.r69.cf2.rackcdn.com/onoff_001.png');background-position:0 -68px;}
	.on{background-image:url('http://c632769.r69.cf2.rackcdn.com/onoff_001.png');background-position:-68px -136px;}.htmlcode{border:1px solid gray;background-color:gray;color:white;padding:5px;}.yui-picker-hue-thumb{cursor:default;width:18px;height:18px;top:-8px;left:-2px;z-index:9;position:absolute;}.yui-picker-hue-bg{-moz-outline:none;outline:0 none;position:absolute;left:375px;height:366px;width:28px;background:url(http://c632769.r69.cf2.rackcdn.com/hue_bg.png) no-repeat;top:4px;}.yui-picker-bg{-moz-outline:none;outline:0 none;position:absolute;top:4px;left:4px;height:364px;width:364px;background-color:#F00;background-image:url(http://c632769.r69.cf2.rackcdn.com/picker_mask_001.png);}*html .yui-picker-bg{background-image:none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='http://c632769.r69.cf2.rackcdn.com/picker_mask_001.png',sizingMethod='scale');}.yui-picker-thumb{cursor:default;width:11px;height:11px;z-index:9;position:absolute;top:-4px;left:-4px;}.yui-picker-swatch{position:absolute;left:415px;top:10px;height:155px;width:195px;border:2px solid #7c7c7c;}.yui-picker-controls{position:absolute;top:180px;left:415px;font:1.6em monospace;}.yui-picker-controls .hd{background:transparent;border-width:0!important;}.yui-picker-controls .bd{height:100px;border-width:0!important;}.yui-picker-controls ul{float:left;padding:0 2px 0 0;margin:0;}.yui-picker-controls li{padding:2px;list-style:none;margin:0;}.yui-picker-controls input{font-size:20px;width:2.4em;}.yui-picker-hex-controls{clear:both;padding:20px 0 0 0;font:2em monospace;}.yui-picker-hex-controls input{width:160px;font:40px monospace;margin-left:-20px;}.yui-picker-controls a{font:20px arial,helvetica,clean,sans-serif;display:block;*display:inline-block;padding:0;color:#000;}#container{background-color:#eee;height:380px;width:625px;position:relative;}#insertcolor{background-color:#EEE;width:615px;font-size:20px;position:relative;text-align:right;padding:5px;margin:5px 0;}input#startcolor{font-size:16px;width:90px;}button#newcolor{font-size:16px;}-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;
</style>


<div id="insertcolor">
Insira o seu código de cor:
<input type="text" maxlength="7" value="FFFFFF" id="startcolor" name="startcolor">
<button id="newcolor">GO</button>
</div>
<div id="container"></div>
<!-- javaskripti -->
<script type="text/javascript" src="http://c632769.r69.cf2.rackcdn.com/cpcc_002.js"></script>
<script type="text/javascript" language="javascript">
(function() {
 var Event = YAHOO.util.Event, picker, hexcolor;

 Event.onDOMReady(function() {
 picker = new YAHOO.widget.ColorPicker("container", {
 showhsvcontrols: true,
 showhexcontrols: true,
 showwebsafe: false });
			picker.skipAnim=true;	
			var onRgbChange = function(o) {				setTimeout ("document.getElementById('yui-picker-hex').select()", 50);			}
			picker.on("rgbChange", onRgbChange);
			Event.on("newcolor", "click", function(e) {
				hexcolor = cc(document.getElementById('startcolor').value);
				picker.setValue([HexToR(hexcolor), HexToG(hexcolor), HexToB(hexcolor)], false); 
			});
 });
})();
</script>
<div id="insertcolor">
Cloque para por a cor na lista em baixo:
<button id="newcolor" onclick="CPklik()">Click</button>
</div>
<div ID="CP" class="wrapper"></div>

</body>
</html>