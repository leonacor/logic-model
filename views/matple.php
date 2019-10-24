<?php
session_start();
if(!isset($_SESSION['lgn']))
{
    header('Location: https://www.caransoluciones.com.mx/');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>CARAN PLEV</title>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="../images/favicon.png" rel="icon" />
<link href="../styles/cssW3.css" rel="stylesheet" />
<link href="../styles/cssTemplate.css" rel="stylesheet" />
</head>
<body>
<script src="../scripts/jquery.min.js"></script>
<script src="../scripts/jsResources.js"></script>
<script src="../scripts/jsFa.min.js"></script>
<script>
    var objResources = null;
    $(document).ready(function(){
            objResources = new jsResources();
            
            
            var span = document.getElementsByClassName("close")[0];
            var modal = document.getElementById('myModal');
            span.onclick = function() {
                
                modal.style.display = "none";
            };
            window.onclick = function(event) {
                
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
            
            
            objResources.setHTML('<?php echo($_SESSION['spr']); ?>','<?php echo($_GET['token']); ?>','<?php echo($_SESSION['nme']); ?>',$('#divHeader'),$('#divFooter'), $('#divBreadcrumbs'), JSON.stringify([{'s':'home.php', 'n': 'inicio'},{'s':'#', 'n': 'involucrados'}, {'s':'#', 'n': 'matríz de involucrados'}]));
            getProjects();
        });
    
    function getProjects()
    {
        $.post('../business/bsnsTrees.php',{iC:1},function(f){
                objResources.ComboPopulate($('#cobProj'),f);
            });
                
    }
    
    function getDataPeople(id)
    {
        $.post('../business/bsnsPeople.php',{iC:3, arg1:id},function(f){
            $('#lblPeople').text(f);
             $.post('../business/bsnsPeople.php',{iC:6, arg1:id},function(g){
                    $.each(jQuery.parseJSON(g), function() {
                        $('#lbl'+this.L2+''+this.L3).text(this.L1).toggleClass('w3-text-white',false);
                    });
                });
        });
    }
    
    function EditModule(id, people, group, dom)
    {
        //alert(dom.substring(dom.length-1) + '-'+id+'-'+people+'-'+group);
       $.post('../business/bsnsPeople.php',{iC:4, arg1: id, arg2:people, arg3:group, arg4:dom.substring(dom.length-1)},function(){
                var modal = document.getElementById('myModal');
                modal.style.display = "none";
                $('#'+dom).text('CARAN SC').toggleClass('w3-text-white',true);
            });
    }
    
   function SaveModule(id, people, group, dom)
    {
        $.post('../business/bsnsPeople.php',{iC:5, arg1: id, arg2:people, arg3:group, arg4:dom.substring(dom.length-1)},function(){
                var modal = document.getElementById('myModal');
                modal.style.display = "none";
                $('#'+dom).text(people).toggleClass('w3-text-white',false);
            });
    }
    
    
    
function myModalCall(id, group, color, cat)
    {
        if($('#cobProj').val() !== '0' && $('#cobProj').val() !== null)
        {
            var modal = document.getElementById('myModal');
            modal.style.display = "block";
            $('#lblHeader').text(cat).css('background-color','#'+color);
            objResources.ComboPopulatePeople($('#cobPeople'),$('#lblPeople').text());
            $('#txtDOM').text(id);
            $('#txtCode').text(group);
            $('#cobPeople').val(($('#'+id).text() == 'CARAN SC'?0:$('#'+id).text()));
        }
        else
        {
            alert('Elige un proyecto...');
        }
    }
</script>
<header class="w3-top">
    <div id="divHeader"></div>
</header>
<section class="w3-container" style="height: 100px;">
    <div id="myModal" class="modal">
    <div class="modal-content">
       
        <div class="modal-header">
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Selecciona que actores y como intervienen en tu proyecto.</p>
            <div class="w3-container">
                <h4 id="txtCode" class="w3-hide"></h4>
                <h4 id="txtDOM" class="w3-hide"></h4>
                <div class="w3-container">
                    <h3 id="lblHeader" class="w3-text-white w3-padding w3-center"></h3>
                    <select id="cobPeople" class="w3-select"></select>
                </div>
                
            </div>
        </div>
        <br>
        <div class="modal-footer">
          <button onclick="SaveModule($('#cobProj').val(),$('#cobPeople').val(), $('#lblHeader').text(),$('#txtDOM').text());"  class="w3-button w3-indigo">Guardar...</button>
          <button onclick="EditModule($('#cobProj').val(),$('#cobPeople').val(),$('#txtCode').text(),$('#txtDOM').text());"  class="w3-button w3-green">Borrar...</button>
        </div>
        
    </div>
    </div>
</section>
<section class="w3-center">
    <select id="cobProj" class="w3-select" style="width: 60%;" onchange="getDataPeople(this.value);" name="option"></select> 
    <br>
    <br>
    <label id="lblProj" class="w3-large">Matríz de involucrados</label>
    <p id="lblPeople" class="w3-hide"></p>
</section>
<br>
<section class="w3-container w3-center">
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <!--<div class="w3-quarter"><img src="../images/_act_5.png" alt="matríz" /></div>-->
        <div class="w3-quarter caran-azul-light-xxh"><h5>Alta importancia / Bajo interés</h5></div>
        <div class="w3-quarter caran-azul-light-xh"><h5>Alta importancia / Alto interés</h5></div>
        <!--<div class="w3-quarter"><img src="../images/_act_6.png" alt="matríz" /></div>-->
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
     <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
      <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblAltaBajo6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaBajo', '00838F', 'Alta importancia / Bajo interés');">CARAN SC</div>
        <div id="lblAltaAlto6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'AltaAlto', '0097A7', 'Alta importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div> 
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <!--<div class="w3-quarter"><img src="../images/_act_1.png" alt="matríz" /></div>-->
        <div class="w3-quarter caran-azul-light-h"><h5>Baja importancia / Bajo interés</h5></div>
        <div class="w3-quarter caran-azul-light-m"><h5>Baja importancia / Alto interés</h5></div>
        <!--<div class="w3-quarter"><img src="../images/_act_2.png" alt="matríz" /></div>-->
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto1" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto2" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto3" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
    <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto4" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
     <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto5" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
     <div class="w3-row-padding">
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
        <div id="lblBajaBajo6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaBajo', '00ACC1', 'Baja importancia / Bajo interés');">CARAN SC</div>
        <div id="lblBajaAlto6" class="w3-quarter w3-border w3-large w3-text-white" onclick="myModalCall(this.id, 'BajaAlto', '00BCD4', 'Baja importancia / Alto interés');">CARAN SC</div>
        <div class="w3-quarter w3-large w3-text-white">CARAN SC</div>
    </div>
     <br><br>
    <div class="w3-row-padding">
        <div class="w3-third"><img src="../images/_act_5.png" alt="matríz" /></div>
        <div class="w3-third"><img src="../images/_act_6.png" alt="matríz" /></div>
        <div class="w3-third"><img src="../images/_act_7.png" alt="matríz" /></div>
    </div>
</section>
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
    <div id="divBreadcrumbs"></div>
    <div id="divFooter"></div>
</footer>
</body>
</html>
